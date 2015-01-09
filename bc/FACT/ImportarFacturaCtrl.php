<?php
require_once "bc/ABMCtrl.php";
require_once "HTTP/Upload.php";
require_once 'bc/BCUtils.php';
require_once ('dal/XmlFacade.php');
require_once ("bc/$modulo/AltaFacturaCtrl.php");
require_once ("bc/$modulo/AltaLoteCtrl.php");
require_once ("bc/$modulo/ABMClienteCtrl.php");

require_once 'bc/AFIP/AfipCtrl.php';

require_once 'dal/FacturaFacade.php';
require_once 'dal/EmpresaFacade.php';
require_once 'dal/ClienteFacade.php';

class ImportarFacturaCtrl extends ABMCtrl {

	private $archivo;
	
	private function uploadFile() {
		$upload = new HTTP_Upload("es");
		$file = $upload->getFiles("f");	
	
		if ($file->isValid()) {
			$this->archivo = $file->moveTo("import/");
			if (!PEAR::isError($this->archivo)) {
				//$resultado = "El archivo " . $file->getProp('name') . " ha sido importado correctamente.";
				$resultado = "";
			} else {
				$resultado = $this->archivo->getMessage();
			}
		} elseif ($file->isMissing()) {
			$resultado = "No ha seleccionado un archivo.";
		} elseif ($file->isError()) {
			$resultado = $file->errorMsg();
		}
		else {
			$resultado = "error en el archivo importado";
		}
		return ($resultado);
	}
	
	private function normalizarFactura ($factura) {
		$factura_normalizada[] =  $factura['CUITEMPRESA'];
		$factura_normalizada[] =  $factura['TIPOCOMPROBANTE'];
		$factura_normalizada[] =  $factura['FECFACTURA'];
		$factura_normalizada[] =  $factura['PUNTOVENTA'];
		$factura_normalizada[] =  $factura['NROFACTURA'];
		$factura_normalizada[] =  $factura['RAZONSOCIAL'];
		$factura_normalizada[] =  $factura['PRESTASERVICIO'];
		$factura_normalizada[] =  $factura['CUITCOMPRADOR'];
		$factura_normalizada[] =  $factura['TOTAL'];
		$factura_normalizada[] =  $factura['TOTALCONC'];
		$factura_normalizada[] =  $factura['IMPNETOGRAVADO'];
		$factura_normalizada[] =  $factura['IMPEXENTO'];
		$factura_normalizada[] =  $factura['IMPLIQUIDADO'];
		$factura_normalizada[] =  $factura['IMPLIQUIDADORNI'];
		$factura_normalizada[] =  $factura['FECVENC'];		
	}
	
	
	 
	private function getIdEmpresa($cuit) {
		$ef = new EmpresaFacade();
		
		$result = $ef->fetchAllRows(true, "id_tipo_documento = 1 and nro_documento = $cuit");
		
		if ($result == array()) {
			return null;
		}
		else {
			return $result[0]['id_empresa'];
		}
	}
	
	private function getNroFactura($ptoVta, $nroFactura) {
		$ff = new FacturaFacade();
		$result = $ff->getUltimoNumeroFactura();
		
		
		
		if (  	($ptoVta == null && $nroFactura == null) ||
				($result['pto_vta'] == $ptoVta && $result['nro_factura'] == $nroFactura)) {
			return $result;
		}
		else {
			return null;
		}
	}
	
	private function getCliente($factura) {
		$cf = new ClienteFacade();
		
		$nroDoc = $factura['cuitComprador'];
		$tipoDoc = $factura['TipoDocCliente'];
		
		$result = $cf->fetchAllRows(true, "id_tipo_documento = $tipoDoc and nro_documento = $nroDoc");
		
		if ($result == array()) {
			//agrego al cliente
			$cliente = array(
				'id_cliente' => null,
				'razon_social' => $factura['razonSocial'],
				'id_tipo_documento' => $tipoDoc,
				'nro_documento' => $nroDoc,
				'calle' => $factura['calle'],
				'numero' => $factura['numero'],
				'piso' => $factura['piso'],
				'departamento' => $factura['departamento'],
				'ciudad' => $factura['ciudad'],
				'id_provincia' => $factura['provincia'],
				'id_pais' => $factura['pais'],
				'telefono' => $factura['telefono']
			);
			
			if ($factura['provincia'] == null) {
				unset ($cliente['id_provincia']);
			}
			
			if ($factura['pais'] == null) {
				unset ($cliente['id_pais']);
			}
			
			$cc = new ABMClienteCtrl();
			
			return $cc->insert($cliente);
		}
		else {
			return $result[0]['id_cliente']; 
		}
	}
	
	private function grabarFacturas ($importaLote, $obtieneCAE) {
		$oXml = new XmlFacade();
		$facturas = $oXml->getFacturas($this->archivo);
		$afc = new AltaFacturaCtrl();
		
		$erroresFactura = array();
		$i = 0;
		
		$facturaDesde = $facturaHasta = "";
		
		foreach($facturas as $factura) {
			$i++;
			$erroresFactura[$i] = "";
			
			//obtener el codigo de empresa
			$idEmpresa = $this->getIdEmpresa($factura['cuitEmpresa']);
			
			if ($idEmpresa == null) {
				//agregar??
				$erroresFactura[$i] = "La empresa emisora no es valida";
				continue;
			}
			
			$nroFactura = $this->getNroFactura($factura['puntoVenta'], $factura['nroFactura']);
			
			if ($nroFactura == null) {
				$erroresFactura[$i] = "El numero de factura informado no corresponde al próximo disponible";
				continue;
			}
			
			
			
			$ptoVta = $nroFactura['pto_vta'];
			$nroFactura = $nroFactura['nro_factura'];
			
			try {
				$idCliente = $this->getCliente($factura);
			}
			catch (Exception $e) {
				$erroresFactura[$i] = $e->getMessage();
				continue;
			}
			
			//validar total
			$total = $factura['total'];
			$impNetoGravado = $factura['impNetoGravado'];
			$impExento = $factura['impExento'];
			$impLiquidado = $factura['impLiquidado'];
			$impLiquidadoRNI = $factura['impLiquidadoRNI'];
			
			if ($total != ($impNetoGravado + $impExento + $impLiquidado + $impLiquidadoRNI)) {
				$erroresFactura[$i] = "El total informado no coincide con los subtotales";
				continue;
			}
			
			//validar servicio
			if ($factura['prestaServ'] == 'S') {
				$prestaServ = "S";
				$fecServDesde = BCUtils::validaDateBD($factura['fecServDesde']);
				$fecServHasta = BCUtils::validaDateBD($factura['fecServHasta']);
				
				if ($fecServDesde == null) {
					$erroresFactura[$i] = "Fecha de Servicio Desde invalida";
					continue;
				}
				
				if ($fecServHasta== null) {
					$erroresFactura[$i] = "Fecha de Servicio Hasta invalida";
					continue;
				}
			}
			else {
				$prestaServ = "N";
				$fecServDesde = null;
				$fecServHasta = null;
			}
			
			//validar fecha vencimiento y factura
			$fecFactura = BCUtils::validaDateBD($factura['fecFactura']);
			
			
			$fechaVencPago = BCUtils::validaDateBD($factura['fecVenc']);
			
			if ($fecFactura == null) {
				$erroresFactura[$i] = "Fecha de Factura invalida";
				continue;
			}
			
			if ($fechaVencPago== null) {
				$erroresFactura[$i] = "Fecha de Vencimiento invalida";
				continue;
			}

			//armo la factura para agregar
			$nuevaFactura = array(
				'id_factura' => null,
				'id_empresa' => $idEmpresa,
				'id_cliente' => $idCliente,
				'id_tipo_comprobante' => $factura['tipoComprobante'],
				'pto_vta' => $ptoVta,
				'nro_factura' => $nroFactura,
				'importe_neto_gravado' => $impNetoGravado,
				'importe_ope_exentas' => $impExento,
				'impuesto_liquidado' => $impLiquidado,
				'impuesto_liquidado_rni' => $impLiquidadoRNI,
				'total' => $total,
				'presta_serv' => $prestaServ,
				'fec_serv_desde' => $fecServDesde,
				'fec_serv_hasta' => $fecServHasta,
				'fecha_venc_pago' => $fechaVencPago,
				'fec_cbte' => $fecFactura
			);
			
			try {
				$afc->addFactura($nuevaFactura);
			}
			catch (Exception $e) {
				$erroresFactura[$i] = $e->getMessage();
				continue;
			}
			
			if ($facturaDesde == "") {
				$facturaDesde ="$ptoVta-$nroFactura"; 
			}
			$facturaHasta ="$ptoVta-$nroFactura";
		}
		
		/* Ejemplo de XML de Salida
	 <comprobantes> 
	 <comprobante> 
	  <cuitEmpresa>3071037079</cuitEmpresa> 
	  <tipoComprobante>1</tipoComprobante> 
	  <fecFactura>20081111</fecFactura> 
	  <puntoVenta>0001</puntoVenta> 
	  <nroFactura>00000001</nroFactura> 
	  <razonSocial>CLIENTE PRUEBA S.A.</razonSocial> 
	  <prestaServicio>N</prestaServicio> 
	  <cuitComprador>11111111113</cuitComprador> 
	  <total>121.00</total> 
	  <totalConc>0.00</totalConc> 
	  <impNetoGravado>100.00</impNetoGravado> 
	  <impExento>0.00</impExento> 
	  <impLiquidado>21.00</impLiquidado> 
	  <impLiquidadoRNI>0.00</impLiquidadoRNI> 
	  <fecServDesde></fecServDesde> 
	  <fecServHasta></fecServHasta> 
	  <fecVenc>20081211</fecVenc> 
	  <calle></calle> 
	  <numero></numero> 
	  <piso></piso> 
	  <departamento></departamento> 
	  <ciudad></ciudad> 
	  <provincia></provincia> 
	  <pais></pais> 
	  <telefono></telefono> 
	 </comprobante> 
	</comprobantes>
	*/
	
		
/*		for ($facturas) {
			//Verificar empresa emisora
			$resultado = $this->validarEmpresaEmisora($facturas[i]);
			if (resultado != null)
			{
				die ('La empresa emisora de la factura ..... es invalida');
			}

			//Verificar Nro de Factura Correcto
			$resultado  = $this->validarNroFactura($facturas[i]);
			
			if (resultado != null)			
			{
				throw new Exception ('El numero de factura informado no corresponde al próximo disponible');
			}
			
			//Verificar existencia de cliente o crearlo en su defecto
			$resultado = $this->validarCliente($facturas[i]);
			
			if (resultado != null)			
			{
				throw new Exception ('El cliente informado es erróneo');
			}
			
			//Normalizar el array de factura con nombres válidos, Id de Empresa y Id de Cliente
			$resultado = $factura_normalizada = $this->normalizarFactura($facturas[i]);
			if (resultado != null)			
			{
				throw new Exception ('La factura ..... esta incorrectamente informada');
			}
			
			$oAltaFacturaCtrl = new AltaFacturaCtrl();
			$oAltaFacturaCtrl->addFactura($factura_normalizada);
		//}
*/	
		$idLote= null;
		 
		if ($importaLote) {
			
			if ($facturaDesde == "" || $facturaHasta == "") {
				$erroresFactura['lote'] = "No hay numero de factrura para el lote";
			}
			else {
				
				$alc = new AltaLoteCtrl();
				
				try {
					$idLote = $alc->addLote(array('descripcion_factura_desde' => $facturaDesde, 'descripcion_factura_hasta' => $facturaHasta));
				}
				catch (Exception $e) {
					$erroresFactura['lote'] = $e->getMessage();
				}
			}
		}
		
		if ($obtieneCAE && $idLote != null) {
			$ac = new AfipCtrl();
			
			try {
				$erroresFactura['cae'] = $ac->setCAE($idLote);
			}
			catch (Exception $e) {
				$erroresFactura['cae'] = $e->getMessage();
			}
		}
		
		return $erroresFactura;
	}
	
	public function importarFacturas($htmlFile, $importaLote, $obtieneCAE) {
		if ($htmlFile) {
			$res = $this->uploadFile();
			
			if ($res != "") throw new Exception($res);
		}
		
		return $this->grabarFacturas($importaLote, $obtieneCAE);
	}
}
?>