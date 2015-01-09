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
require_once ("dal/DetallePercepcionFacturaFacade.php");
require_once ("dal/RetencionFacade.php");
require_once ("HTML/Table.php");
require_once 'File/Archive.php';
require_once ("bc/ABMCtrl.php");
require_once ("dal/CondicionIvaFacade.php");
require_once ("dal/PuntoVentaFacade.php");
require_once ("dal/PeriodoFacade.php");
require_once ("dal/MonedaFacade.php");
require_once ("dal/CompraFacade.php");
require_once ("dal/AlicuotaIvaFacade.php");
require_once ("dal/UnidadMedidaFacade.php");
require_once ("dal/ZipfileFacade.php");

class MediosMagneticosCtrl extends ABMCtrl  {
	function __construct() {
		$this->_order = "fecha_fin desc";
		$this->_facade = new PeriodoFacade();
		$this->_filtroEmpresa = "PERIODO.id_empresa = " . GLOBAL_EMPRESA;
	}
	
	public function getLista ($pagina=null, $inactivos = null, $order = null, $busqueda = null) {
		if ($pagina == null) $pagina = 1;
		
		if ($inactivos == 1) {
			$filtro = $this->_filtroValido;
		}
		else {
			$filtro = null;
		}
		
		if ($busqueda != null) {
			if ($filtro != null) $filtro .= " and ";
			$filtro .= $this->_filtroBusqueda." like '%$busqueda%'";
		}
		
		if ($order == null) {
			$order = $this->_order;
		}
		
		if ($this->_filtroEmpresa != null) {
			if ($filtro != null) $filtro .= " and ";
			$filtro .= $this->_filtroEmpresa;
		}
		
		if ($order == null) {
			$order = $this->_order;
		}
		
		
		$result = $this->_facade->fetchListCD($order, $pagina, $filtro);
		
		if ($result == array()) return "<br><br>No existen periodos cerrados<br><br>";
		
		$attrs = array('width' => '100%', 'class' => 'tabla-abm');
		
		$attrsPares = array('class' => 'tabla-abm-fila-par');
		$attrsImpares = array('class' => 'tabla-abm-fila-impar');
		
		
		$table =& new HTML_Table($attrs);
		
		
		//$table->setCaption('Tipos de Documento');
		
		foreach($result as $row) {
			$a = array();
			$i=0;
			$id = 0;
			foreach ($row as $key => $value) {
				
				if ($key == "id_periodo") {
					$id = $value;
					continue; 
				}
				else {
					$colHeader = "<a href='".$this->armaHREF(null, null, null, null, $key)."'>".Translator::getTrans($key)."</a>";
					$colValue = $value;
				}
				$table->setHeaderContents(0, $i, $colHeader);
				$a[] = $colValue;
				$i++;
			}
			//agrego una columna mas para la accion
			$table->setHeaderContents(0, $i, "");
			$href = $this->armaHREF('generarCD', $id);//$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']."&action=generarCD&id=$id";
			$a[] = "<a href='$href' onClick='muestraWait($(\"div_wait\"));'>Generar ZIP</a>";
			
			$table->addRow($a);
		}
		
		
		$table->altRowAttributes(1,$attrsImpares, $attrsPares, true);
		return $this->navigator($pagina, false, "PERIODO.estado = 'C' and PERIODO.activo = 'S'").$table->toHtml().$this->navigator($pagina, false, "PERIODO.estado = 'C' and PERIODO.activo = 'S'").$this->agregaWait("Generando Archivos para AFIP");
	}
	
	private function getFacturasPeriodo ($periodo) {
		//Funcion que devuelve las facturas de un per’odo
		$ff = new FacturaFacade();
		$facturas =  $ff->fetchAllRows(true," id_empresa = " . GLOBAL_EMPRESA ." and fec_cbte >= '" . $periodo["fecha_inicio"] ."' and fec_cbte <= '" . $periodo["fecha_fin"] . "'","fec_cbte,id_tipo_comprobante, id_punto_venta, nro_factura");
		return ($facturas);
	}

	private function getComprasPeriodo ($periodo) {
		//Funcion que devuelve las compras de un per’odo
		$cf = new CompraFacade();
		$compras =  $cf->fetchAllRows(true," id_empresa = " . GLOBAL_EMPRESA ." and fec_cbte >= '" . $periodo["fecha_inicio"] ."' and fec_cbte <= '" . $periodo["fecha_fin"] . "'","fec_cbte, id_tipo_comprobante, punto_venta, nro_factura");
		return ($compras);
	}
		
	private function  concatenarLineaCabeceraFacturaTipo1($factura,$cliente,$puntoVenta,$moneda, $tipoComprobante, $detalle, $conTotal, $count, $detallePercepciones, &$otros_conceptos)
	{
		if ($factura["cotizacion"] == 0 or $factura["cotizacion"] == null) $cotizacion = 1;
		else $cotizacion = $factura["cotizacion"];
		
 		$linea="1";
		$linea.=date("Ymd",strtotime($factura["fec_cbte"])); //yyyymmdd
		$linea.=str_pad($tipoComprobante["cod_comprobante"],2,"0",STR_PAD_LEFT); //00
		$linea.=str_pad(" ",1," ",STR_PAD_RIGHT); //" "
		$linea.=str_pad($puntoVenta["numero"],4,"0",STR_PAD_LEFT); //0000
		$linea.=str_pad($factura["nro_factura"],8,"0",STR_PAD_LEFT); //00000000
		$linea.=str_pad($factura["nro_factura"],8,"0",STR_PAD_LEFT); //00000000
		$linea.=str_pad("001",2,"0",STR_PAD_LEFT); //000
		$linea.=str_pad($cliente["tipo_documento"],2,"0",STR_PAD_LEFT); //00
		$linea.=str_pad($cliente["nro_documento"],11,"0",STR_PAD_LEFT); //00000000000
		$linea.=str_pad(substr($cliente["razon_social"],0,30),30," ",STR_PAD_RIGHT);
		
		//segun el tipo de iva
		switch($detalle['tipo_iva']) {
			case 'G': //gravado
				$total = round(abs($detalle["neto_gravado"] + $detalle["impuesto_liquidado"]) * $cotizacion, 2) * 100;
				$neto_gravado = round(abs($detalle["neto_gravado"]) * $cotizacion, 2) * 100;
				$otros_conceptos = 0;
				$imp_ope_exentas = 0;
				$impuesto_liquidado = round(abs($detalle["impuesto_liquidado"]) * $cotizacion, 2)  * 100;
				break;
			case 'E': //exento
				$total = round(abs($detalle["neto_gravado"]) * $cotizacion, 2) * 100;
				$neto_gravado = 0;
				$otros_conceptos = 0;
				$imp_ope_exentas = $total;
				$impuesto_liquidado = 0;
				break;
			case 'N': //no gravado
				$total = round(abs($detalle["neto_gravado"]) * $cotizacion, 2)*100;
				$neto_gravado = 0;
				$otros_conceptos = $total;
				$imp_ope_exentas = 0;
				$impuesto_liquidado = 0;
				break;
		}

		
		if ($conTotal) {
			$impuesto_liquidado_rni = round(abs($factura["impuesto_liquidado_rni"]) * $cotizacion, 2)*100;
			
			$percepcionesNacionales=round(abs($detallePercepciones['percepciones_nacionales']) * $cotizacion, 2)*100;
			$percepcionesProvinciales=round(abs($detallePercepciones['percepciones_provinciales']) * $cotizacion, 2)*100;
			$percepcionesMunicipales=round(abs($detallePercepciones['percepciones_municipales']) * $cotizacion, 2)*100;
			$percepcionesInternas=round(abs($detallePercepciones['percepciones_internas']) * $cotizacion, 2)*100;
			
			$total += $impuesto_liquidado_rni + $percepcionesInternas + $percepcionesMunicipales + $percepcionesProvinciales + $percepcionesNacionales; 
		}
		else {
			$impuesto_liquidado_rni = 0;
			$percepcionesNacionales=0;
			$percepcionesProvinciales=0;
			$percepcionesMunicipales=0;
			$percepcionesInternas=0;
		}
		
		//campo 11: importe total
		$linea.=str_pad($total,15,"0",STR_PAD_LEFT); //000000000000000		
		
		//campo 12: importe total de conceptos que no integran el neto gravado
		$linea.=str_pad($otros_conceptos,15,"0",STR_PAD_LEFT); //000000000000000
		
		//campo 13: importe neto gravado	
		$linea.=str_pad($neto_gravado,15,"0",STR_PAD_LEFT); //000000000000000
		
		//Campo 15: Impuesto Liquidado
		$linea.=str_pad($impuesto_liquidado,15,"0",STR_PAD_LEFT); //000000000000000	
		
		//Campo 16: Impuesto Liquidado RNI
		$linea.=str_pad($impuesto_liquidado_rni,15,"0",STR_PAD_LEFT); //000000000000000	
		
		//Campo 17: Importe operaciones exentas
		$linea.=str_pad($imp_ope_exentas,15,"0",STR_PAD_LEFT); //000000000000000			
		
		
		$linea.=str_pad($percepcionesNacionales,15,"0",STR_PAD_LEFT); //Importe de percepciones o pagos a cuenta sobre impuestos nacionales
		$linea.=str_pad($percepcionesProvinciales,15,"0",STR_PAD_LEFT); //Importe de percepci—n de Ingresos Brutos
		$linea.=str_pad($percepcionesMunicipales,15,"0",STR_PAD_LEFT); //Importe de percepci—n por Impuestos Municipales
		$linea.=str_pad($percepcionesInternas,15,"0",STR_PAD_LEFT); //Importe de Impuestos Internos
				
		$linea.=str_pad(0,15,"0",STR_PAD_LEFT); //TRANSPORTE
		
		
		$linea.=str_pad($cliente["condicion_iva"],2,"0",STR_PAD_LEFT); //Tipo de responsable
		$linea.=str_pad($moneda["codigo_moneda_afip"],3,"0",STR_PAD_LEFT); //C—digos de moneda
		$linea.=str_pad(($cotizacion*1000000),10,"0",STR_PAD_LEFT); //Tipo de cambio
		$linea.=str_pad($count,1," ",STR_PAD_RIGHT); //Cantidad de al’cuotas de IVA
		
		
		$codop = $detalle['tipo_iva'];
		if ($codop == "G") $codop = " ";
		$linea.=str_pad($codop,1," ",STR_PAD_RIGHT); //C—digo de operaci—n 
		
		$linea.=str_pad(substr($factura["cae"],0,14),14," ",STR_PAD_RIGHT); //CAI
		$linea.=str_pad(date("Ymd",strtotime($factura["fecha_venc_pago"])),8," ",STR_PAD_RIGHT); //Fecha de Vencimiento
		
		if ($factura["fec_anul"] == null) $fec_anul = "        ";
		else $fec_anul = date("Ymd",strtotime($factura["fec_anul"])); 
		$linea.=$fec_anul; //Fecha de anulaci—n del comprobante
		
		//$linea.=str_pad(" ",75," ",STR_PAD_RIGHT); //Fecha de anulaci—n del comprobante
		return $linea;
	}

	private function  concatenarLineaCabeceraFacturaTipo2($periodo, $i, $empresa, $totalAcumulado, $retenciones_nacionales, $retenciones_provinciales, $retenciones_municipales, $retenciones_internas, $impuestoLiquidadoRNIAcumulado, $impuestoLiquidadoAcumulado, $netoGravadoAcumulado, $otrosConceptosAcumulado, $importeOpeExentasAcumulado)
	{
		$linea="2";
		$linea.=str_pad(date("Ym",strtotime($periodo["fecha_inicio"])),6," ",STR_PAD_RIGHT); //00
		$linea.=str_pad($i,21,"0",STR_PAD_LEFT); //00000000
		$linea.=str_pad(" ",17," ",STR_PAD_RIGHT); //" "
		$linea.=str_pad($empresa["nro_documento"],11,"0",STR_PAD_LEFT); //00000000
		$linea.=str_pad(" ",22," ",STR_PAD_RIGHT); //" "
		$linea.=$this->formatoTotales($totalAcumulado); //000000000000000		
		$linea.=$this->formatoTotales($otrosConceptosAcumulado); //000000000000000	
		$linea.=$this->formatoTotales($netoGravadoAcumulado); //000000000000000	
		$linea.=$this->formatoTotales($impuestoLiquidadoAcumulado); //000000000000000	
		$linea.=$this->formatoTotales($impuestoLiquidadoRNIAcumulado); //000000000000000	
		$linea.=$this->formatoTotales($importeOpeExentasAcumulado); //000000000000000			
		$linea.=$this->formatoTotales($retenciones_nacionales); //Importe de percepciones o pagos a cuenta sobre impuestos nacionales
		$linea.=$this->formatoTotales($retenciones_provinciales); //Importe de percepci—n de Ingresos Brutos
		$linea.=$this->formatoTotales($retenciones_municipales); //Importe de percepci—n por Impuestos Municipales
		$linea.=$this->formatoTotales($retenciones_internas); //Importe de Impuestos Internos
		$linea.=str_pad(" ",62," ",STR_PAD_RIGHT); //" "
		//$linea.="\x0D" . "\x0A";

		return $linea;
	}
	
	private function formatoTotales($theTotal) {
		$ret = "";
		$signo="";
		$padding=15;
		
		if ($theTotal < 0) {
			$signo = "-";
			$padding = 14;
		}
		
		$ret = str_pad(abs($theTotal*100),$padding,"0",STR_PAD_LEFT);
		return $signo.$ret;
	}
	
	
	private function  concatenarLineaDetalleFactura($factura, $detalleFactura, $puntoVenta,$tipoComprobante,$unidadMedida,$alicuotaIVA)
	{
		if ($factura["cotizacion"] == 0 or $factura["cotizacion"] == null) $cotizacion = 1;
		else $cotizacion = $factura["cotizacion"];

		
		$linea.=str_pad($tipoComprobante["cod_comprobante"],2,"0",STR_PAD_LEFT); //00
		$linea.=str_pad(" ",1," ",STR_PAD_RIGHT); //" "
		$linea.=date("Ymd",strtotime($factura["fec_cbte"])); //yyyymmdd
		$linea.=str_pad($puntoVenta["numero"],4,"0",STR_PAD_LEFT); //0000
		$linea.=str_pad($factura["nro_factura"],8,"0",STR_PAD_LEFT); //00000000
		$linea.=str_pad($factura["nro_factura"],8,"0",STR_PAD_LEFT); //00000000
		$linea.=str_pad(abs($detalleFactura["cantidad"])*100000,12,"0",STR_PAD_LEFT); //" "
		$linea.=str_pad($unidadMedida["codigo_unidad_medida_afip"],2,"0",STR_PAD_LEFT); //" "
		$linea.=str_pad(abs($detalleFactura["precio_unitario"]*$cotizacion)*1000,16,"0",STR_PAD_LEFT); //" "
		$linea.=str_pad(abs($detalleFactura["bonificacion"]*$cotizacion)*100,15,"0",STR_PAD_LEFT); //No esxiste aun
		$linea.=str_pad(abs($detalleFactura["importe_ajuste"]*$cotizacion)*1000,16,"0",STR_PAD_LEFT); //No existe aun
		$linea.=str_pad(abs($detalleFactura["cantidad"])*abs($detalleFactura["precio_unitario"])*10000,16,"0",STR_PAD_LEFT); //" "
		$linea.=str_pad(abs($alicuotaIVA["porcentaje"])*10000,4,"0",STR_PAD_LEFT);
		$linea.=str_pad($alicuotaIVA["tipo_iva"],1," ",STR_PAD_LEFT); 
		
		/*
		if ($alicuotaIVA["descripcion"] == "IVA EXENTO")
		{
			$linea.=str_pad("E",1," ",STR_PAD_LEFT);
		} elseif ($alicuotaIVA["descripcion"] == "IVA NO GRAVADO")
		{
			$linea.=str_pad("N",1," ",STR_PAD_LEFT);
		} else 
		{
			$linea.=str_pad("G",1," ",STR_PAD_LEFT);
		}
		*/
		$linea.=" "; //anuklacion
		$linea.= substr(str_pad(str_replace(array(chr(13),chr(10)),"",$detalleFactura["concepto"]),75," ",STR_PAD_RIGHT),0,75); 
		//$linea.="\x0D" . "\x0A";
		
		return $linea;
	}

	private function  concatenarLineaVentasTipo1($factura,$cliente,$puntoVenta,$moneda, $tipoComprobante, $detalle, $conTotal, $count, $detallePercepciones, &$otros_conceptos, &$devolucion)
	{
		if ($factura["cotizacion"] == 0 or $factura["cotizacion"] == null) $cotizacion = 1;
		else $cotizacion = $factura["cotizacion"];
	
		$linea="1";
		$linea.=date("Ymd",strtotime($factura["fec_cbte"])); //yyyymmdd
		$linea.=str_pad($tipoComprobante["cod_comprobante"],2,"0",STR_PAD_LEFT); //00
		$linea.=str_pad(" ",1," ",STR_PAD_RIGHT); //" "
		$linea.=str_pad($puntoVenta["numero"],4,"0",STR_PAD_LEFT); //0000
		$linea.=str_pad($factura["nro_factura"],20,"0",STR_PAD_LEFT); //00000000
		$linea.=str_pad($factura["nro_factura"],20,"0",STR_PAD_LEFT); //00000000
		$linea.=str_pad($cliente["tipo_documento"],2,"0",STR_PAD_LEFT); //00
		$linea.=str_pad($cliente["nro_documento"],11,"0",STR_PAD_LEFT); //00000000000
		$linea.= str_pad(substr($cliente["razon_social"], 0, 30),30," ",STR_PAD_RIGHT);
		
		
		//segun el tipo de iva
		switch($detalle['tipo_iva']) {
			case 'G': //gravado
				
				
				$total = round(abs($detalle["neto_gravado"] + $detalle["impuesto_liquidado"]) * $cotizacion, 2) * 100;
				$neto_gravado = round(abs($detalle["neto_gravado"]) * $cotizacion, 2) * 100;
				$otros_conceptos = 0;
				$imp_ope_exentas = 0;
				$impuesto_liquidado = round(abs($detalle["impuesto_liquidado"]) * $cotizacion, 2)  * 100;
				break;
			case 'E': //exento
				$total = round(abs($detalle["neto_gravado"]) * $cotizacion, 2) * 100;
				$neto_gravado = 0;
				$otros_conceptos = 0;
				$imp_ope_exentas = $total;
				$impuesto_liquidado = 0;
				break;
			case 'N': //no gravado
				$total = round(abs($detalle["neto_gravado"]) * $cotizacion, 2)*100;
				$neto_gravado = 0;
				$otros_conceptos = $total;
				$imp_ope_exentas = 0;
				$impuesto_liquidado = 0;
				break;
		}
		
		if ($conTotal) {
			$impuesto_liquidado_rni = round(abs($factura["impuesto_liquidado_rni"]) * $cotizacion, 2)*100;
			
			$percepcionesNacionales=round(abs($detallePercepciones['percepciones_nacionales']) * $cotizacion, 2)*100;
			$percepcionesProvinciales=round(abs($detallePercepciones['percepciones_provinciales']) * $cotizacion, 2)*100;
			$percepcionesMunicipales=round(abs($detallePercepciones['percepciones_municipales']) * $cotizacion, 2)*100;
			$percepcionesInternas=round(abs($detallePercepciones['percepciones_internas']) * $cotizacion, 2)*100;
			
			$total += $impuesto_liquidado_rni + $percepcionesInternas + $percepcionesMunicipales + $percepcionesProvinciales + $percepcionesNacionales; 
		}
		else {
			$impuesto_liquidado_rni = 0;
			$percepcionesNacionales=0;
			$percepcionesProvinciales=0;
			$percepcionesMunicipales=0;
			$percepcionesInternas=0;
		}
		
		//campo 11: importe total
		$linea.=str_pad($total,15,"0",STR_PAD_LEFT); //000000000000000		
		$devolucion["total"] = $total;
		
		//campo 12: importe total de conceptos que no integran el neto gravado
		$linea.=str_pad($otros_conceptos,15,"0",STR_PAD_LEFT); //000000000000000
		$devolucion["otros_conceptos"] = $otros_conceptos;

		//campo 13: importe neto gravado	
		$linea.=str_pad($neto_gravado,15,"0",STR_PAD_LEFT); //000000000000000
		$devolucion["importe_neto_gravado"] = $neto_gravado;

		//campo 14: Alicuota IVA
		/*
		 * Se deberá completar con la alícuota de IVA correspondiente, conforme la tabla indicada en el Anexo II Apartado E) punto 6). En
		 * los casos en que se deba informar más de una alícuota para el mismo comprobante, se procederá a grabar tantos registros de
		 * tipo "1" como alícuotas se deban declarar.
		 * Los campos 1 a 10 y 22 a 30 se grabarán con la misma información en todos los registros de tipo "1", los restantes campos se
		 * completarán con los datos que correspondan a cada alícuota de impuesto.
		 * La alícuota podrá ser cero en caso de operaciones de exportación, exentas y no gravadas, procediéndose a completar el código
		 * de operación (campo 26) respectivo, o en el supuesto de tratarse de un comprobante anulado.
		 */
		$linea.=str_pad(abs($detalle["porcentaje"])*100,4,"0",STR_PAD_LEFT); 
		
		//Campo 15: Impuesto Liquidado
		$linea.=str_pad($impuesto_liquidado,15,"0",STR_PAD_LEFT); //000000000000000	
		$devolucion["impuesto_liquidado"] = $impuesto_liquidado;

		//Campo 16: Impuesto Liquidado RNI
		$linea.=str_pad($impuesto_liquidado_rni,15,"0",STR_PAD_LEFT); //000000000000000	
		$devolucion["impuesto_liquidado_rni"] = $impuesto_liquidado_rni;

		//Campo 17: Importe operaciones exentas
		$linea.=str_pad($imp_ope_exentas,15,"0",STR_PAD_LEFT); //000000000000000			
		$devolucion["importe_ope_exentas"] = $imp_ope_exentas;
		
		$linea.=str_pad($percepcionesNacionales,15,"0",STR_PAD_LEFT); //Importe de percepciones o pagos a cuenta sobre impuestos nacionales
		$linea.=str_pad($percepcionesProvinciales,15,"0",STR_PAD_LEFT); //Importe de percepci—n de Ingresos Brutos
		$linea.=str_pad($percepcionesMunicipales,15,"0",STR_PAD_LEFT); //Importe de percepci—n por Impuestos Municipales
		$linea.=str_pad($percepcionesInternas,15,"0",STR_PAD_LEFT); //Importe de Impuestos Internos
		
		$devolucion['percepciones_nacionales'] = $percepcionesNacionales;
		$devolucion['percepciones_provinciales'] = $percepcionesProvinciales;
		$devolucion['percepciones_municipales'] = $percepcionesMunicipales;
		$devolucion['percepciones_internas'] = $percepcionesInternas;
		
		$linea.=str_pad($cliente["condicion_iva"],2,"0",STR_PAD_LEFT); //Tipo de responsable
		$linea.=str_pad($moneda["codigo_moneda_afip"],3,"0",STR_PAD_LEFT); //C—digos de moneda
		$linea.=str_pad(($cotizacion*1000000),10,"0",STR_PAD_LEFT); //Tipo de cambio
		$linea.=str_pad($count,1," ",STR_PAD_RIGHT); /*Todo: hacer funcion*/; //Cantidad de al’cuotas de IVA
		
		
		$codop = $detalle['tipo_iva'];
		if ($codop == "G") $codop = " ";
		$linea.=str_pad($codop,1," ",STR_PAD_RIGHT); //C—digo de operaci—n 
		/**
		****** Todo: Agregar a la cabecera de factura:
		Z- Exportaciones a la zona franca. 
		X- Exportaciones al Exterior. 
		E- Operaciones Exentas. 
		N- No Gravado 
		************************************/
		$linea.=str_pad(substr($factura["cae"],0,14),14," ",STR_PAD_RIGHT); //CAI
		$linea.=str_pad(date("Ymd",strtotime($factura["fecha_venc_pago"])),8," ",STR_PAD_RIGHT); //Fecha de Vencimiento
		
		if ($factura["fec_anul"] == null) $fec_anul = "00000000";
		else $fec_anul = date("Ymd",strtotime($factura["fec_anul"])); 
		$linea.=$fec_anul; //Fecha de anulaci—n del comprobante
		
		$linea.=str_pad(" ",75," ",STR_PAD_RIGHT); //Fecha de anulaci—n del comprobante
	
		
		return $linea;
	}

	private function  concatenarLineaVentasTipo2($periodo, $i, $empresa, $totalAcumulado, $percepcionesNacionales, $percepcionesProvinciales, $percepcionesMunicipales, $percepcionesInternas, $impuestoLiquidadoRNIAcumulado, $impuestoLiquidadoAcumulado, $netoGravadoAcumulado, $otrosConceptosAcumulado, $importeOpeExentasAcumulado)
	{
		$linea="2";
		$linea.=str_pad(date("Ym",strtotime($periodo["fecha_inicio"])),6," ",STR_PAD_RIGHT); //00
		//$linea.=str_pad(" ",8," ",STR_PAD_RIGHT); //" "
		$linea.=str_pad($i,41,"0",STR_PAD_LEFT); //00000000
		$linea.=str_pad(" ",10," ",STR_PAD_RIGHT); //" "
		$linea.=str_pad($empresa["nro_documento"],11,"0",STR_PAD_LEFT); //00000000
		$linea.=str_pad(" ",30," ",STR_PAD_RIGHT); //" "
		$linea.=$this->formatoTotales($totalAcumulado); //000000000000000		
		$linea.=$this->formatoTotales($otrosConceptosAcumulado); //000000000000000	
		$linea.=$this->formatoTotales($netoGravadoAcumulado); //000000000000000	
		$linea.=str_pad(" ",4," ",STR_PAD_LEFT);
		$linea.=$this->formatoTotales($impuestoLiquidadoAcumulado); //000000000000000	
		$linea.=$this->formatoTotales($impuestoLiquidadoRNIAcumulado); //000000000000000	
		$linea.=$this->formatoTotales($importeOpeExentasAcumulado); //000000000000000			
		$linea.=$this->formatoTotales($percepcionesNacionales); //Importe de percepciones o pagos a cuenta sobre impuestos nacionales
		$linea.=$this->formatoTotales($percepcionesProvinciales); //Importe de percepci—n de Ingresos Brutos
		$linea.=$this->formatoTotales($percepcionesMunicipales); //Importe de percepci—n por Impuestos Municipales
		$linea.=$this->formatoTotales($percepcionesInternas); //Importe de Impuestos Internos
		$linea.=str_pad(" ",62," ",STR_PAD_RIGHT); //" "
		//$linea.="\x0D" . "\x0A";

		return $linea;
	}	

	private function  concatenarLineaComprasTipo1($compra,$proveedor,$moneda, $tipoComprobante)
	{
		
		
		$linea="1";
		$linea.=date("Ymd",strtotime($compra["fec_cbte"])); //yyyymmdd
		$linea.=str_pad($tipoComprobante["cod_comprobante"],2,"0",STR_PAD_LEFT); //00
		$linea.=str_pad(" ",1," ",STR_PAD_RIGHT); //" "
		$linea.=str_pad($compra["punto_venta"],4,"0",STR_PAD_LEFT); //0000
		$linea.=str_pad($compra["nro_factura"],20,"0",STR_PAD_LEFT); //00000000
		
		$linea.=date("Ymd",strtotime($compra["fec_registro_contable"])); //yyyymmdd
		
		$linea.="000"; //codigo de aduana
		$linea.="    "; //codigo de destinacion
		$linea.="000000"; //codigo de despacho
		$linea.=" "; //digito verificador del codigo de despacho
		
		$linea.=str_pad($proveedor["tipo_documento"],2,"0",STR_PAD_LEFT); //00
		$linea.=str_pad($proveedor["nro_documento"],11,"0",STR_PAD_LEFT); //00000000000
		$linea.=substr(str_pad($proveedor["razon_social"],30," ",STR_PAD_RIGHT), 0, 30); //30 caracteres
		
		$linea.=str_pad(abs(($compra["total"]*100)),15,"0",STR_PAD_LEFT); //000000000000000		
		$linea.=str_pad("0",15,"0",STR_PAD_LEFT); //000000000000000	
		$linea.=str_pad(abs(($compra["importe_neto_gravado"]*100)),15,"0",STR_PAD_LEFT); //000000000000000
		
		//alicuota IVA
		if ($compra["importe_neto_gravado"] == 0) $IVA = 0;
		else $IVA = round($compra["impuesto_liquidado"] / $compra["importe_neto_gravado"], 4) * 100;
		 
		if ($IVA > 20 and $IVA < 22) $IVA = 21;
		if ($IVA > 10 and $IVA < 11) $IVA = 10.5;
		
		$linea.=str_pad($IVA * 100,4,"0",STR_PAD_LEFT); //000000000000000
		
		$linea.=str_pad(abs(($compra["impuesto_liquidado"]*100)),15,"0",STR_PAD_LEFT); //000000000000000	
		$linea.=str_pad(abs(($compra["importe_ope_exentas"]*100)),15,"0",STR_PAD_LEFT); //000000000000000	
		$linea.=str_pad(abs(($compra["perc_iva"]*100)),15,"0",STR_PAD_LEFT); //000000000000000			
		
		$linea.=str_pad(abs($compra["perc_impuestos_nacionales"]*100),15,"0",STR_PAD_LEFT); //Importe de percepciones o pagos a cuenta sobre impuestos nacionales
		$linea.=str_pad(abs($compra["perc_iibb"]*100),15,"0",STR_PAD_LEFT); //Importe de percepci—n de Ingresos Brutos
		$linea.=str_pad(abs($compra["perc_impuestos_municipales"]*100),15,"0",STR_PAD_LEFT); //Importe de percepci—n por Impuestos Municipales
		$linea.=str_pad(abs($compra["perc_impuestos_internos"]*100),15,"0",STR_PAD_LEFT); //Importe de Impuestos Internos
		
		$linea.=str_pad($proveedor["condicion_iva"],2,"0",STR_PAD_LEFT); //Tipo de responsable
		$linea.=str_pad($moneda["codigo_moneda_afip"],3,"0",STR_PAD_LEFT); //C—digos de moneda
		$linea.=str_pad(($compra["cotizacion"]*1000000),10,"0",STR_PAD_LEFT); //Tipo de cambio
		$linea.=str_pad("1",1," ",STR_PAD_RIGHT); /*Todo: hacer funcion*/; //Cantidad de al’cuotas de IVA
		$linea.=str_pad(" ",1," ",STR_PAD_RIGHT); //C—digo de operaci—n 
		/**
		****** Todo: Agregar a la cabecera de factura:
		Z- Exportaciones a la zona franca. 
		X- Exportaciones al Exterior. 
		E- Operaciones Exentas. 
		N- No Gravado 
		************************************/
		$linea.=str_pad($compra["cae"],14," ",STR_PAD_RIGHT); //CAI
		$linea.="00000000";//str_pad(date("Ymd",strtotime($compra["fec_venc"])),8," ",STR_PAD_RIGHT); //Fecha de Vencimiento
		
		$linea.=str_pad(" ", 75, " ", STR_PAD_LEFT);

		return $linea;
	}

	private function  concatenarLineaComprasTipo2($periodo, $i, $empresa, $totalAcumulado, $retenciones_iva,$retenciones_nacionales, $retenciones_provinciales, $retenciones_municipales, $retenciones_internas, $otrosConceptosAcumulado, $importeNetoGravadoAcumulado, $impuestoLiquidadoAcumulado, $operacionesExentasAcumulado)
	{
		$linea="2";
		$linea.=str_pad(date("Ym",strtotime($periodo["fecha_inicio"])),6," ",STR_PAD_RIGHT); //00
		$linea.=str_pad(" ",10," ",STR_PAD_RIGHT); //" "
		$linea.=str_pad($i,12,"0",STR_PAD_LEFT); //00000000
		$linea.=str_pad(" ",31," ",STR_PAD_RIGHT); //" "
		$linea.=str_pad($empresa["nro_documento"],11,"0",STR_PAD_LEFT); //00000000
		$linea.=str_pad(" ",30," ",STR_PAD_RIGHT); //" "
		
		$linea.=str_pad(abs($totalAcumulado*100),15,"0",STR_PAD_LEFT); //000000000000000	
		$linea.=str_pad(abs($otrosConceptosAcumulado)*100 ,15,"0",STR_PAD_LEFT); //000000000000000	
		$linea.=str_pad(abs($importeNetoGravadoAcumulado*100),15,"0",STR_PAD_LEFT); //000000000000000	
		$linea.=str_pad(" ",4," ",STR_PAD_RIGHT); //" "
		$linea.=str_pad(abs($impuestoLiquidadoAcumulado*100),15,"0",STR_PAD_LEFT); //000000000000000		
		$linea.=str_pad(abs($operacionesExentasAcumulado * 100),15,"0",STR_PAD_LEFT); //000000000000000			
		$linea.=str_pad(abs($retenciones_iva*100),15,"0",STR_PAD_LEFT); //Importe de percepciones o pagos a cuenta sobre impuestos nacionales
		$linea.=str_pad(abs($retenciones_nacionales*100),15,"0",STR_PAD_LEFT); //Importe de percepciones o pagos a cuenta sobre impuestos nacionales
		$linea.=str_pad(abs($retenciones_provinciales*100),15,"0",STR_PAD_LEFT); //Importe de percepci—n de Ingresos Brutos
		$linea.=str_pad(abs($retenciones_municipales*100),15,"0",STR_PAD_LEFT); //Importe de percepci—n por Impuestos Municipales
		$linea.=str_pad(abs($retenciones_internas*100),15,"0",STR_PAD_LEFT); //Importe de Impuestos Internos
		$linea.=str_pad(" ",114," ",STR_PAD_RIGHT); //" "
		//$linea.="\x0D" . "\x0A";

		return $linea;
	}
			
	private function  concatenarLineaPercepciones($factura,$puntoVenta, $tipoComprobante, $percepcion, $tipo, $importe)
	{
		$linea="";
		$linea.=date("Ymd",strtotime($factura["fec_cbte"])); //yyyymmdd
		$linea.=str_pad($tipoComprobante["cod_comprobante"],2,"0",STR_PAD_LEFT); //00
		$linea.=str_pad($puntoVenta["numero"],4,"0",STR_PAD_LEFT); //0000
		$linea.=str_pad($factura["nro_factura"],8,"0",STR_PAD_LEFT); //00000000
		
		$pf = new ProvinciaFacade();
		
		$jurisdiccionIIBB = str_pad(" ", 2, " ", STR_PAD_LEFT);
		$jurisdiccionMuni = str_pad(" ", 40, " ", STR_PAD_LEFT);
		$importeMuni = 0;
		$importeIIBB = 0;
		
		switch($tipo) {
			case 'P':
				$result = $pf->fetchRows($percepcion['id_provincia']);
				$jurisdiccionIIBB = str_pad($result['cod_afip'], 2, " ", STR_PAD_LEFT);
				$importeIIBB = round(abs($importe), 2);
				break;
			case 'M':
				$jurisdiccionMuni = str_pad($percepcion['detalle'], 40, " ", STR_PAD_RIGHT);
				$importeMuni = round(abs($importe), 2);
				break;
		}
		
		$linea .= $jurisdiccionIIBB;
		$linea .= str_pad($importeIIBB * 100, 15, "0", STR_PAD_LEFT);
		
		$linea .= $jurisdiccionMuni;
		$linea .= str_pad($importeMuni * 100, 15, "0", STR_PAD_LEFT);
		
		return $linea;
	}
	
	private function eliminarCaracteresExtendidos ($texto) 
	{
		//Funcion que elimina caracteres ascii extendidos del string dejandolo sin acentos o –
		
		return $texto;
	}
	
	private function getCliente ($id_cliente) {
		//Funcion que devuelve las facturas de un per’odo
		$cf = new ClienteFacade();
		$cliente =  $cf->fetchRows($id_cliente);
		
		$td = new TipoDocumentoFacade();
		$tipoDocumento = $td->fetchRows($cliente["id_tipo_documento"]);
		$cliente["tipo_documento"] = $tipoDocumento["cod_doc_afip"];
		
		$ci = new CondicionIvaFacade();
		$condicionIva = $ci->fetchRows($cliente["id_condicion_iva"]);
		$cliente["condicion_iva"] = $condicionIva["codigo_afip"];
		
		//$cliente["razon_social"] = eliminarCaracteresExtendidos ($cliente["razon_social"]);
		return ($cliente);
	}

	private function getProveedor ($idProveedor) {
		//Funcion que devuelve el proveedor y sus datos
		$cf = new ProveedorFacade();
		$proveedor =  $cf->fetchRows($idProveedor);
		
		$td = new TipoDocumentoFacade();
		$tipoDocumento = $td->fetchRows($proveedor["id_tipo_documento"]);
		$proveedor["tipo_documento"] = $tipoDocumento["cod_doc_afip"];
		
		$ci = new CondicionIvaFacade();
		$condicionIva = $ci->fetchRows($proveedor["id_condicion_iva"]);
		$proveedor["condicion_iva"] = $condicionIva["codigo_afip"];
		
		return ($proveedor);
	}	
	
	private function getPuntoVenta ($id_punto_venta) {
		//Funcion que devuelve las facturas de un per’odo
		$pvf = new PuntoVentaFacade();
		$puntoVenta =  $pvf->fetchRows($id_punto_venta);
		
		return ($puntoVenta);
	}	

	private function getMoneda ($id_moneda) {
		//Funcion que devuelve las facturas de un per’odo
		$mf = new MonedaFacade();
		$moneda =  $mf->fetchRows($id_moneda);
		
		return ($moneda);
	}	

	private function getTipoComprobante ($id_tipo_comprobante) {
		//Funcion que devuelve las facturas de un per’odo
		$tcf = new TipoComprobanteFacade();
		$tipoComprobante =  $tcf->fetchRows($id_tipo_comprobante);
		
		return ($tipoComprobante);
	}	

	private function getTipoDocumento ($id_tipo_documento) {
		//Funcion que devuelve el tipo de documento del cliente
		$tdf = new TipoDocumentoFacade();
		$tipoDocumento =  $tdf->fetchRows($id_tipo_documento);
		return ($tipoDocumento);
	}	

	private function getCodicionIva ($id_condicion_iva) {
		//Funcion que devuelve el tipo de responsable del cliente
		$cif = new CondicionIvaFacade();
		$condicionIva=  $cif->fetchRows($id_condicion_iva);
		return ($condicionIva);
	}	
	/****************
	private function getRetenciones ($id_factura) {
		//Funcion que devuelve las facturas de un per’odo
		$rf = new RetencionFacade();
		$retenciones =  $rf->fetchRetenciones($id_factura);
		
		return ($retenciones);
	}
	*******************/
	
	private function getPeriodo ($idPeriodo) {
		//Funcion que devuelve el tipo de responsable del cliente
		$pf = new PeriodoFacade();
		$periodo=  $pf->fetchRows($idPeriodo);
		return ($periodo);
	}	

	private function getUnidadMedida ($idUnidadMedida) {
		//Funcion que devuelve la unidad de medida de la linea
		$umf = new UnidadMedidaFacade();
		$unidadMedida=  $umf->fetchRows($idUnidadMedida);
		return ($unidadMedida);
	}	

	private function getAlicuotaIVA ($idAlicuotaIVA) {
		//Funcion que devuelve la unidad de medida de la linea
		$aif = new AlicuotaIvaFacade();
		$alicuotaIVA=  $aif->fetchRows($idAlicuotaIVA);
		return ($alicuotaIVA);
	}	

	private function getEmpresa ($idEmpresa) {
		//Funcion que devuelve la Empresa emisora
		$ef = new EmpresaFacade();
		$empresa=  $ef->fetchRows($idEmpresa);
		return ($empresa);
	}	
		
	private function getDetallesFactura ($idFactura) {
		//Funcion que devuelve las l’neas de detalle de una factura
		$dff = new DetalleFacturaFacade();
		$detallesFactura=  $dff->fetchAllRows(true,"id_factura = $idFactura","id_detalle_factura");
		return ($detallesFactura);
	}	

	private function getDetalleVentasFactura ($idFactura) {
		//Funcion que devuelve las l’neas de detalle de una factura
		$dff = new DetalleFacturaFacade();
		$detalleVentasFactura=  $dff->fetchDetalleVentas($idFactura); 
		return ($detalleVentasFactura);
	}	
		
	private function getPercepcionesFactura ($idFactura) {
		//Funcion que devuelve las l’neas de detalle de una factura
		$dpf = new DetallePercepcionesFacturaFacade();
		$percepcionesFactura=  $dpf->fetchAllRows(true,"id_factura = $idFactura");
		
		return ($percepcionesFactura);
	}	


	private function generarVentas (&$pCabecera, &$pDetalle, &$pVentas, $periodo, $mmf, &$ivaAPagar)
	{
		$rf = new RetencionFacade();
		$i = 0;
		$acumPercepcionesNacionales=0;
		$acumPercepcionesProvinciales=0;
		$acumPercepcionesMunicipales=0;
		$acumPercepcionesInternas=0;
		$totalAcumulado = 0;
		
		$impuestoLiquidadoAcumuladoRNI = 0;
		$impuestoLiquidadoAcumulado = 0;
		$netoGravadoAcumulado = 0;
		
		$otrosConceptosAcumulado = 0;
		$operacioesExentasAcumulado = 0;
		
		$facturas = $this->getFacturasPeriodo($periodo);
		
		foreach ($facturas as $factura)
		{
			
			//se resetean las percepciones
			$percepcionesInternas 		= 0;
			$percepcionesMunicipales 	= 0;
			$percepcionesNacionales 	= 0;
			$percepcionesProvinciales 	= 0;
			
			$cliente = $this->getCliente($factura["id_cliente"]);
			$puntoVenta = $this->getPuntoVenta( $factura["id_punto_venta"]);
			$moneda = $this->getMoneda( $factura["id_moneda"]);
			$tipoComprobante = $this->getTipoComprobante($factura["id_tipo_comprobante"]);
			$empresa = $this->getEmpresa($factura["id_empresa"]);
			$detalleVentas = $this->getDetalleVentasFactura($factura["id_factura"]);
			//$retencion = $this->getRetenciones ($factura["id_factura"]);	
			$detallesFactura = $this->getDetallesFactura($factura["id_factura"]);
			$percepciones = $this->getPercepcionesFactura($factura["id_factura"]);
			
	
			//tratamiento de moneda extranjera, si no tiene cotizacion se asume pesos
			if ($factura["cotizacion"] == 0 or $factura["cotizacion"] == null) $cotizacion = 1;
			else $cotizacion = round($factura["cotizacion"],2);

			if ($factura["id_tipo_comprobante"] == 3 || $factura["id_tipo_comprobante"] == 8 || $factura["id_tipo_comprobante"] == 13) $cotizacion = $cotizacion * -1;
			
			
			foreach ($detallesFactura as $detalle)
			{
				$unidadMedida = $this->getUnidadMedida($detalle["id_unidad_medida"]);
				$alicuotaIVA = $this->getAlicuotaIVA($detalle["id_alicuota_iva"]);
				if ($detalle['tipo_retencion'] != 'P' || $detalle['tipo_retencion'] != 'M') 
					$pDetalle[] = $this->concatenarLineaDetalleFactura($factura, $detalle, $puntoVenta,$tipoComprobante,$unidadMedida,$alicuotaIVA);
			}


			foreach ($percepciones as $percepcion) {
				$tipo = $rf->fetchRows($percepcion['id_retencion']);

				switch ($tipo["tipo_retencion"]) {
					case 'N': //nacional;
						$percepcionesNacionales += $percepcion['base_imponible']*$percepcion['alicuota']/100;
						break;
					case 'P': //provincial
						$percepcionesProvinciales += $percepcion['base_imponible']*$percepcion['alicuota']/100;
						$vPercepciones[] = $this->concatenarLineaPercepciones($factura, $puntoVenta,$tipoComprobante, $percepcion, $tipo["tipo_retencion"],$percepcionesProvinciales);
						break;
					case 'M': //municipales
						$percepcionesMunicipales += $percepcion['base_imponible']*$percepcion['alicuota']/100;
						$vPercepciones[] = $this->concatenarLineaPercepciones($factura, $puntoVenta,$tipoComprobante, $percepcion, $tipo["tipo_retencion"],$percepcionesMunicipales);
						break;
					case 'I': //impuestos internos
						$percepcionesInternas += $percepcion['base_imponible']*$percepcion['alicuota']/100;
						break;
				}
			}
			
			$percepcionesInternas 		= round($percepcionesInternas, 2);
			$percepcionesMunicipales 	= round($percepcionesMunicipales, 2);
			$percepcionesNacionales 	= round($percepcionesNacionales, 2);
			$percepcionesProvinciales 	= round($percepcionesProvinciales, 2);
			
			$detallePercepciones = array(
				'percepciones_internas' 		=> $percepcionesInternas,
				'percepciones_municipales' 	=> $percepcionesMunicipales,
				'percepciones_nacionales' 	=> $percepcionesNacionales,
				'percepciones_provinciales' 	=> $percepcionesProvinciales,
				'total_percepciones'	=> $percepcionesInternas+$percepcionesMunicipales+$percepcionesNacionales+$percepcionesProvinciales,
			);			
			
			//si detalle viene vacio es porque no hay detalles... inventemos uno caracho!!!
			if ($detalleVentas == array()) {
				$detalleVentas = array(array(
					'descripcion'			=> "",
					'porcentaje'			=> 100 * $factura['impuesto_liquidado'] / $factura['importe_neto_gravado'],
					'neto_gravado'			=> $factura['importe_neto_gravado']*$cotizacion,
					'impuesto_liquidado'	=> $factura['impuesto_liquidado']*$cotizacion,
					'tipo_iva'				=> ""
				));
				
				if ($detalleVentas['impuesto_liquidado'] == 0) {
					if ($factura['importe_ope_exentas'] != 0) {
						$detalleVentas['tipo_iva'] = 'E';
						$detalleVentas['neto_gravado'] = $factura['importe_ope_exentas']*$cotizacion;
					}
					else {
						$detalleVentas['tipo_iva'] = 'N';
						$detalleVentas['neto_gravado'] = $factura['otros_conceptos']*$cotizacion - $percepcionesInternas - $percepcionesMunicipales - $percepcionesNacionales - $percepcionesProvinciales;
					}
				}
				else {
					$detalleVentas['tipo_iva'] = 'G';
				}
			}
			
			
			$cantidadDetalles = count($detalleVentas);
			$j = 0;
			
			$factor = 1;
			if ($factura["id_tipo_comprobante"] == 3 || $factura["id_tipo_comprobante"] == 8 || $factura["id_tipo_comprobante"] == 13) {
				$factor = -1;
			}

			foreach ($detalleVentas as $detalleV)
			{
				$i++;
				$otros_conceptos = 0;
				$devolucion = array();
				$conTotal = $cantidadDetalles == ++$j;
				$pVentas[] = $this->concatenarLineaVentasTipo1($factura,$cliente,$puntoVenta,$moneda,$tipoComprobante, $detalleV, $conTotal, $cantidadDetalles, $detallePercepciones, $otros_conceptos, $devolucion);	
				$pCabecera[] = $this->concatenarLineaCabeceraFacturaTipo1($factura,$cliente,$puntoVenta,$moneda,$tipoComprobante, $detalleV, $conTotal, $cantidadDetalles, $detallePercepciones, $otros_conceptos);
				$otrosConceptosAcumulado += $otros_conceptos;

				

				//los divido todos por 100
				foreach($devolucion as $devolucionkey => $devolucionvalue) {
					$devolucion[$devolucionkey] = $devolucionvalue / 100;
				}

				$totalAcumulado 		+= $devolucion["total"] * $factor;

				$impuestoLiquidadoAcumuladoRNI 	+= $devolucion['impuesto_liquidado_rni'] * $factor;
				$impuestoLiquidadoAcumulado 	+= $devolucion['impuesto_liquidado'] * $factor;
				$netoGravadoAcumulado 		+= $devolucion['importe_neto_gravado'] * $factor;
			
				$operacioesExentasAcumulado 	+= $devolucion['importe_ope_exentas'] * $factor;

				$acumPercepcionesNacionales 	+= $devolucion['percepciones_nacionales'] * $factor;
				$acumPercepcionesProvinciales 	+= $devolucion['percepciones_provinciales'] * $factor;
				$acumPercepcionesMunicipales 	+= $devolucion['percepciones_municipales'] * $factor;
				$acumPercepcionesInternas 	+= $devolucion['percepciones_internas'] * $factor;
			}

			
/*
			$totalAcumulado += round($factura["total"]*$cotizacion,2);
			//echo $totalAcumulado . "  " . $factura["total"] . "<br>";
			$impuestoLiquidadoAcumuladoRNI += round($factura['impuesto_liquidado_rni']*$cotizacion,2);
			$impuestoLiquidadoAcumulado += round($factura['impuesto_liquidado']*$cotizacion,2);
			$netoGravadoAcumulado += round($factura['importe_neto_gravad']*$cotizacion,2);
			
			$operacioesExentasAcumulado += round($factura['importe_ope_exentas']*$cotizacion,2);

			
			$acumPercepcionesNacionales += round($percepcionesNacionales*$cotizacion,2);
			$acumPercepcionesProvinciales += round($percepcionesProvinciales*$cotizacion,2);
			$acumPercepcionesMunicipales += round($percepcionesMunicipales*$cotizacion,2);
			$acumPercepcionesInternas += round($percepcionesInternas*$cotizacion,2);
*/			
		}	
		
		$pVentas[] = $this->concatenarLineaVentasTipo2($periodo, $i, $empresa, $totalAcumulado, $acumPercepcionesNacionales, $acumPercepcionesProvinciales, $acumPercepcionesMunicipales, $acumPercepcionesInternas, $impuestoLiquidadoAcumuladoRNI, $impuestoLiquidadoAcumulado, $netoGravadoAcumulado, $otrosConceptosAcumulado, $operacioesExentasAcumulado);
		$pCabecera[] = $this->concatenarLineaCabeceraFacturaTipo2($periodo, $i, $empresa, $totalAcumulado, $acumPercepcionesNacionales, $acumPercepcionesProvinciales, $acumPercepcionesMunicipales, $acumPercepcionesInternas, $impuestoLiquidadoAcumuladoRNI, $impuestoLiquidadoAcumulado, $netoGravadoAcumulado, $otrosConceptosAcumulado, $operacioesExentasAcumulado);
		
		
		$ivaAPagar = $impuestoLiquidadoAcumulado;
		$mmf->grabarArchivo("VENTAS_" . date("Ym",strtotime($periodo["fecha_inicio"])), $pVentas);
		$mmf->grabarArchivo("DETALLE_" . date("Ym",strtotime($periodo["fecha_inicio"])), $pDetalle);
		$mmf->grabarArchivo("CABECERA_" . date("Ym",strtotime($periodo["fecha_inicio"])), $pCabecera);
		$mmf->grabarArchivo("OTRAS_PERCEP_" . date("Ym",strtotime($periodo["fecha_inicio"])), $vPercepciones);
		
		return (true);
	}

	private function generarCompras (&$pCompras, $periodo, $mmf )
	{
		$i = 0;
		$retenciones_nacionales=0;
		$retenciones_provinciales=0;
		$retenciones_municipales=0;
		$retenciones_internas=0;
		$retenciones_iva = 0;
		
		$totalAcumulado = 0;
		
		$otrosConceptosAcumulado =0;
		$importeNetoGravadoAcumulado=0;
		$impuestoLiquidadoAcumulado=0;
		$operacionesExentasAcumulado=0;
		
		$compras = $this->getComprasPeriodo($periodo);
		$empresa = $this->getEmpresa(GLOBAL_EMPRESA);
		foreach ($compras as $compra)
		{
			$i++;
			$proveedor = $this->getProveedor($compra["id_proveedor"]);
			$moneda = $this->getMoneda( $compra["id_moneda"]);
			$tipoComprobante = $this->getTipoComprobante($compra["id_tipo_comprobante"]);
			
			//$retencion = getRetenciones ($factura["id_factura"]);	
			
			$pCompras[] = $this->concatenarLineaComprasTipo1($compra,$proveedor,$moneda,$tipoComprobante);
			
			$totalAcumulado += $compra["total"]*$compra["cotizacion"];
			$otrosConceptosAcumulado +=  0;
			$importeNetoGravadoAcumulado +=  $compra["importe_neto_gravado"]*$compra["cotizacion"];
			$impuestoLiquidadoAcumulado +=  $compra["impuesto_liquidado"]*$compra["cotizacion"];
			$operacionesExentasAcumulado +=  $compra["importe_ope_exentas"]*$compra["cotizacion"];
			$retenciones_iva +=  $compra["perc_iva"]*$compra["cotizacion"];
			$retenciones_nacionales +=  $compra["perc_impuestos_nacionales"]*$compra["cotizacion"];
			$retenciones_provinciales +=  $compra["perc_iibb"]*$compra["cotizacion"];
			$retenciones_municipales +=  $compra["perc_impuestos_municipales"]*$compra["cotizacion"];
			$retenciones_internas +=  $compra["impuestos_internos"]*$compra["cotizacion"];
		}	
		
		$pCompras[] = $this->concatenarLineaComprasTipo2($periodo, $i, $empresa, $totalAcumulado, $retenciones_iva,$retenciones_nacionales, $retenciones_provinciales, $retenciones_municipales, $retenciones_internas, $otrosConceptosAcumulado, $importeNetoGravadoAcumulado, $impuestoLiquidadoAcumulado, $operacionesExentasAcumulado);
		
		$mmf->grabarArchivo("COMPRAS_" . date("Ym",strtotime($periodo["fecha_inicio"])), $pCompras);
		return (true);
	}

	private function generarCodigoSeguridad ($nomarch, $cabecera, $detalle, $ventas, $compras, $cuit, $periodo, $ivaAPagar )
	{
		$str_ventas = "";
		foreach($ventas as $lineaVentas) {
			$str_ventas .= $lineaVentas . "\x0D\x0A";
		}
		
		$str_compras = "";
		foreach($compras as $lineaCompras) {
			$str_compras .= $lineaCompras . "\x0D\x0A";
		}
		
		$str_detalle = "";
		foreach($detalle as $lineaDetalle) {
			$str_detalle .= $lineaDetalle . "\x0D\x0A";
		}
		
		$str_cabecera = "";
		foreach($cabecera as $lineaCabecera) {
			$str_cabecera .= $lineaCabecera . "\x0D\x0A";
		}
		
		$hashvtas = md5($str_ventas);
		$hashcpras = md5($str_compras . $hashvtas);
		$hashdet = md5($str_detalle.$hashcpras);
		$hash1 = md5($str_cabecera.$hashdet);
		
		$hashvtas = $ventas;
		$hashcpras = $hashvtas . $compras;
		$hashdet = $hashcpras . $detalle;
		$hash1 = md5($hashdet . $cabecera);
		
		
		$codigoSeguridad = $cuit . $periodo . str_pad($ivaAPagar*100,15,"0",STR_PAD_LEFT) . $hash1 . str_pad($ivaAPagar*100,15,"0",STR_PAD_LEFT) .$cuit . $periodo ;
		
		File::write($nomarch, $codigoSeguridad, FILE_MODE_WRITE);
		File::close($nomarch, FILE_MODE_WRITE);
		
	}		
	
	public function generarCD($idPeriodo)
	{
	/*
	 * Funcion que obtiene todos los arrays para cada archivo y genera los files de salida para el CD.
	 * 
	 * a) Archivo de cabecera de facturas conteniendo:
	 * Registros de tipo 1 del archivo de cabecera de facturas emitidas.
	 * Registro de tipo 2 del archivo de cabecera de facturas emitidas.
	 * b) Archivo de detalle de facturas emitidas.
	 * c) Archivo de ventas conteniendo:
	 * Registros de tipo 1 del archivo de registro de ventas.
	 * Registro de tipo 2 del archivo de registro de ventas.
	 * d) Archivo de compras conteniendo:
	 * Registros de tipo 1 del archivo de registro de compras.
	 * Registro de tipo 2 del archivo de registro de compras.
	 * e) Archivo de Percepciones.
	 * f) Archivo conteniendo el C?digo de Seguridad obtenido sobre los archivos enumerados precedentemente, excepto el indicado en el punto e).
	 * 
	 */		
		
		$periodo = $this->getPeriodo($idPeriodo);
		$strPeriodo = date("Ym",strtotime($periodo["fecha_inicio"]));
		$mmf = new MediosMagneticosFacade();
		$ivaAPagar = 0;
		$cabecera = "";
		$detalle = "";
		$ventas = "";
		$compras = "";

		
		$result = $this->generarVentas ($cabecera, $detalle, $ventas,$periodo,$mmf, $ivaAPagar);
		if ($result == false){
			throw new Exception ("Error al generar los archivos de Ventas");	
		}
			
		$result = $this->generarCompras ($compras,$periodo,$mmf);
		if ($result == false){
			throw new Exception ("Error al generar los archivos de Compras");
					
		//tratar error	
		}		
		
		$ef = new EmpresaFacade();
		$emp = $ef->fetchRows(GLOBAL_EMPRESA);
		$cuit = $emp['nro_documento'];
		
		$nomarch = "import/CS_".$strPeriodo."_".$cuit."_00";
		$this->generarCodigoSeguridad($nomarch, $cabecera, $detalle, $ventas, $compras, $cuit, $strPeriodo, $ivaAPagar);
		
		$leeme = "import/Leerme_$strPeriodo.txt";
		File::writeLine($leeme,"Este es un archivo generado al ".date("Y-m-d H:i:s"), FILE_MODE_WRITE);
		File::close($leeme, FILE_MODE_WRITE);
		
		$zipname = "import/$strPeriodo.zip";
		$zipfiles = "import/*_$strPeriodo*";
		
		$res = File_Archive::extract(
		    File_Archive::read($zipfiles),
		    File_Archive::toArchive($zipname,
		    	File_Archive::toFiles() 
		    )
		);

		if (PEAR::isError($res)) {
			return "";
		}
		return $zipname;
	}
	
}
?>
