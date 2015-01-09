<?php
if(!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once(CONFIG_DIR."afip/conf_afip.php");
require_once("dal/AfipFacade.php");
require_once("be/TicketAcceso.php");
require_once("dal/LoteFacade.php");
require_once("dal/FacturaFacade.php");
require_once("dal/DetalleFacturaFacade.php");
require_once("dal/MediosMagneticosFacade.php");
require_once("dal/XmlFacade.php");
require_once ("HTML/Table.php");
require_once ("bc/ABMCtrl.php");

class AfipCtrl extends ABMCtrl  {
	
	function __construct() {
		$this->_facade = new LoteFacade();
		$this->_idName = "id_lote";
		$this->_order = "fecha";
		$this->_filtroEmpresa = "f.id_empresa = " . GLOBAL_EMPRESA;
	}
	
	public function muestraFacturasLote($idLote) {
		$ff = new FacturaFacade();
		
		$result = $ff->fectchFacturasPorLote($idLote);
		
		$attrs = array('width' => '100%', 'class' => 'tabla-abm');
		
		$attrsPares = array('class' => 'tabla-abm-fila-par');
		$attrsImpares = array('class' => 'tabla-abm-fila-impar');
		
		$table =& new HTML_Table($attrs);
		
		foreach($result as $row) {
			$a = array();
			$i=0;
			$id=0;
			
			foreach ($row as $key => $value) {
				$valueCol = $value;
				if ($key == 'id_factura') {				
					$id = $value;
					continue;
				}
				
				if (strtoupper($key) == "NUMERO") {
					$url = URL_ALTA_FACTURAS."&id=$id";
					$valueCol = "<a href='$url'>$value</a>";
				}
				
				$table->setHeaderContents(0, $i, Translator::getTrans($key));
				
				$a[] = $valueCol;
				$i++;
			}
			
			//Agrego columna de Rechazos
			$rechazos = $ff->fetchRechazos($id);
			
			$descriRechazos ="";
			foreach ($rechazos as $rechazo) {
				$descriRechazos .= "<tr><td>".$rechazo['descripcion']."</td></tr>";
			}
			
			if ($descriRechazos != "") {
				$table->setHeaderContents(0, $i, Translator::getTrans('Rechazos'));
				$a[] = "<table border=1 class='tabla-rechazos'>$descriRechazos</table>";
			}
			
			$table->addRow($a);
		}
		
		$table->altRowAttributes(1, $attrsImpares, $attrsPares, true);
		
		$volver = "<button onclick='document.location=\"".$this->armaHREF()."\";'>Volver</button>";
		$_SESSION['goback'] = $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];
		return $table->toHtml()."<br>".$volver;
		
	}
	
	public function getListaLote($pagina = null) {
				
		$result = $this->_facade->fetchList('fecha_lote desc', 'f.id_empresa = '.GLOBAL_EMPRESA, $pagina);
		
		
		$attrs = array('width' => '100%', 'class' => 'tabla-abm');
		
		$attrsPares = array('class' => 'tabla-abm-fila-par');
		$attrsImpares = array('class' => 'tabla-abm-fila-impar');
		
		$table =& new HTML_Table($attrs);
		
		foreach($result as $row) {
			$a = array();
			$i=0;
			$id=0;
			foreach ($row as $key => $value) {
				$valueCol = $value;
				
				if ($key == 'id_lote') {				
					$id = $value;
					$valueCol = "<a href='".$this->armaHREF('verFacturas', $id)."'>Ver Facturas</a>";
				}
				
				if ($key == 'mensaje_error') {
					$msgErr = $value;
					continue;
				}
				
				if ($key == 'id_estado_lote') {
					
					switch ($value) {
						case 1:
						$valueCol="<a href='".$this->armaHREF('obtenerCAE', $id)."'>Obtener CAE</a>";
						break;
						
						case 2:
						$valueCol = "<b style='color:green'>Lote Procesado</b>";
						break;
						
						case 3:
						$txterr = "<div id='err$id' style='display:none'>$msgErr</div>";
						$valueCol = $txterr."<b style='color:red'>Error en el proceso</b><br><a href='javascript:muestraMensajeDiv(\"err$id\");'>Mostrar Error</a><br><a href='".$this->armaHREF('obtenerCAE', $id)."'>Reprocesar</a>";
						break;
						
						case 4:
						$valueCol = "<b style='color:blue'>Lote Rechazado</b><br><a href='".$this->armaHREF('obtenerCAE', $id)."'>Reprocesar</a>";
						break;
						
						default:
						$valueCol = "";
						break;
					}
					
				}
				
				if ($key == 'id_estado_lote') {
					$table->setHeaderContents(0, $i, Translator::getTrans("Proceso"));
				}
				else {
					$table->setHeaderContents(0, $i, Translator::getTrans($key));
				}
				
				$a[] = $valueCol;
				$i++;
			}
			
			//Agrego columna de Download de Lote
			$valueCol = "<a href='".$this->armaHREF('exportarLote', $id)."'> <img src='css/emerald/images/icon_xml.gif' alt='Exportar' width=40 height=20 border=0 /img> </a>";
			$table->setHeaderContents(0, $i, Translator::getTrans('exportar_xml'));
			$a[] = $valueCol;
			
			$table->setHeaderContents(0, 0, "");
							
			$table->addRow($a, $rowAttrs);
		}
		
		$table->altRowAttributes(1, $attrsImpares, $attrsPares, true);
		return $this->navigator($pagina, false).$table->toHtml().$this->navigator($pagina, false);
	}

	private function getTicketAfip()
	{
		ini_set("soap.wsdl_cache_enabled", "0");
		$oAfipFacade = new AfipFacade();
		$CMS = $oAfipFacade->getTicket();
		$credentials=$oAfipFacade->callWSAA($CMS);
		
		return($credentials);
	}	


	private function getAuthorization($oTicketAcceso)
	{
		$oAfipFacade = new AfipFacade();
//		$oAfipFacade->test();
		
		$cae=$oAfipFacade->callWSFE($oTicketAcceso);
		return $cae;
	}	
	
	public function setCAE($idLote = null)
	{
		
		//$oTicketAcceso = new TicketAcceso();
		$oLoteFacade = new LoteFacade();
		$ff = new FacturaFacade();
		
		$cae = null;
		
		try {
			$credentials = $this->getTicketAfip();
		
			$cabecera['id_lote'] = $idLote;
			
			$lf = new LoteFacade();
			$cabecera['cant_reg'] = $lf->getCountFacturas("id_Lote = $idLote and activo = 'S'");
			
			$ef = new EmpresaFacade();
			$oEmpresa  = $ef->fetchRows(GLOBAL_EMPRESA);
			$cabecera['cuit'] = $oEmpresa['nro_documento'];
			$cabecera['presta_serv'] = $oEmpresa['presta_serv'];
					
			
		   	$detalles = $ff->fetchRowsByLote($idLote);
			
			//Invocar el Lote correspondientes y actualizar el campo cae con el valor recibido.
			
			
			/*
			$oLoteFacade->setCae($idLote, $cae);
			*/
			
		   	/*
		   	echo "<pre>";
			print_r($detalles);
			echo "</pre>";
		   	*/
		   	
			$oAfipFacade = new AfipFacade();
			$cae=$oAfipFacade->getCAE($credentials, $cabecera, $detalles);
			
			/*
			echo "<br><pre>";
			print_r($cae);
			echo "</pre>";
			*/
		}
		catch (Exception $e) {
			
			$oLoteFacade->agregaError($idLote, $e->getMessage());
			throw $e;
		}
		
		if ($cae->FEAutRequestResult->RError->percode != 0 ) {
			$msgError = "Error devuelto de AFIP: ".$cae->FEAutRequestResult->RError->percode."<BR>Descripcion: ".$cae->FEAutRequestResult->RError->perrmsg;
			
			$oLoteFacade->agregaError($idLote, $msgError);
			
			throw new Exception ($msgError);
		}
		
		
		if ($cae->FEAutRequestResult->FecResp->resultado == "R") {
			
			$oLoteFacade->rechazaLote($idLote);
			
			//grabar los motivos de rechazo para las facturas
			if ($cae->FEAutRequestResult->FecResp->cantidadreg == 1) {
				$this->grabaMotivosFactura($cae->FEAutRequestResult->FedResp->FEDetalleResponse);
			}
			else {
				foreach ($cae->FEAutRequestResult->FedResp->FEDetalleResponse as $response) {
					$this->grabaMotivosFactura($response);
				}
			}
			
			throw new Exception ("Lote Rechazado<br>Revise la lista de facturas para ver los motivos del rechazo");
		}
		
		//grabar el cae en la factura
		$resultado = true;
		
		if ($cae->FEAutRequestResult->FecResp->cantidadreg == 1) {
			$resultado = $this->grabaCAE($cae->FEAutRequestResult->FedResp->FEDetalleResponse);
		}
		else {
			foreach ($cae->FEAutRequestResult->FedResp->FEDetalleResponse as $response) {
				$resultado = $this->grabaCAE($response) && $resultado;
			}
		}
		
		if ($resultado) {
			$oLoteFacade->loteValido($idLote);
		}
		else {
			$oLoteFacade->rechazaLote($idLote);
			throw new Exception ("Lote con facturas rechazadas<br>Revise la lista de facturas para ver los motivos del rechazo");
		}
		//echo $cae;
	
	}	
	
	private function grabaCAE($response) {
		$ff = new FacturaFacade();
			
		$resultado=true;
		if ($response->resultado != "R") {
			
			for ($i = $response->cbt_desde; $i <= $response->cbt_hasta; $i++) {
				
				$ff->borraRechazo($response->punto_vta, $i);
				
				$ff->grabaCAE($response->cae, $response->punto_vta, $i);
				
			}
		}
		else {
			$this->grabaMotivosFactura($response);
			$resultado = false;
		}
		
		return $resultado;
	}
	
	private function grabaMotivosFactura($response) {
		$ff = new FacturaFacade();
		
		if ($response->resultado == "R") {
			
			$a = split(";", $response->motivo);
			
			
			for ($i = $response->cbt_desde; $i <= $response->cbt_hasta; $i++) {
				$ff->borraRechazo($response->punto_vta, $i);
		
				
				foreach ($a as $motivo) {
					$ff->grabaRechazo($motivo, $response->punto_vta, $i);
				}
			}
		}
	}
	
	public function exportarLote($idLote)
	{
		$oXmlFacade = new XmlFacade();
		//$oLote = $this->_facade->fetchList();
		
		$lf = new LoteFacade();
		
		$result = $lf->getLoteInterfazOut($idLote);

		$XmlLote = $oXmlFacade->generarXML ($result[0]);
		$oXmlFacade->Xml_Download($XmlLote);
		
	
	}
	
}

?>