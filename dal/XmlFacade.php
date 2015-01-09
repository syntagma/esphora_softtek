<?php
if(!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/LoteFacade.php');
require_once ('be/Lote.php');
require_once ('HTTP/Download.php');
require_once 'XML/Parser.php';
require_once ('be/Factura.php');


class XmlFacade extends XML_Parser {
	
	public function getLote($id) {
	//Funcion para Obtener el Lote a Exportar
		$oLoteFacade = new LoteFacade();
		$oLote = $oLoteFacade->fetchRows($id);
		return ($oLote);
	}
	
		
	public function generarXML($lote) {
	//Funcion que genera el XML segun el Lote a Exportar
		$XmlLote = new SimpleXMLElement(
									'<?xml version="1.0" encoding="UTF-8"?>' .
									'<respuesta version="1.0">'.
									'</respuesta>');
		$XmlLote ->addChild('resultado');
		$XmlLote ->resultado->addChild('cuitEmpresa',$lote["cuit_empresa"]);
		$XmlLote ->resultado->addChild('tipoDocCliente',$lote["tipo_doc_cliente"]);
		$XmlLote ->resultado->addChild('nroDocCliente',$lote["nro_doc_cliente"]);
		$XmlLote ->resultado->addChild('puntoVenta',$lote["pto_vta"]);
		$XmlLote ->resultado->addChild('nroFactDesde',$lote["factura_desde"]);
		$XmlLote ->resultado->addChild('nroFactHasta',$lote["factura_hasta"]);
		$XmlLote ->resultado->addChild('total',$lote["total"]);
		$XmlLote ->resultado->addChild('cae',$lote["cae"]);
		$XmlLote ->resultado->addChild('observacion',"");
		$XmlLote ->addChild('error');
		$XmlLote ->error->addChild('codigo',"");
		$XmlLote ->error->addChild('descripcion',"");
		return ($XmlLote->asXML());
	

	}
	
	
	
	public function Xml_Download($XmlLote) {
		$dl = &new HTTP_Download();
		$dl->setData($XmlLote);
		$dl->setLastModified($unix_timestamp);
		$dl->setContentType('application/xml');
		$dl->setCache(false);
		$dl->setContentDisposition(HTTP_DOWNLOAD_ATTACHMENT, 'lote.xml');
		$dl->send();
	}
	
	
  var $facturas = array();
  var $currentFactura;
  var $currentTag;




 
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

  public function startHandler($parser, $name, $attribs)
  {
  //printf('handle start tag: %s<br />', $name);
  
    switch ($name) {
      case 'comprobante':
        $this->currentFactura = $attribs['nroFactura'];
        $this->facturas[$this->currentFactura] = array();
        break;
      case 'comprobantes':
        break;      
	 default:
        $this->currentTag = $name;
    }
  }

  public function endHandler($parser, $name)
  {
     //printf('handle end tag: %s<br />', $name);

	$this->currentTag = null;
  }

  public function cdataHandler($parser, $data)
  {
    //printf('cData: %s<br />', $data);
	
	$data = trim($data);
    if (empty($data)) {
        return true;
    }
    $this->facturas[$this->currentFactura][$this->currentTag] = $data;
	
  }

  public function getFacturas($archivo)
  {
  	
  	$conf = new Config;
	$root =& $conf->parseConfig("import/$archivo", 'XML');

	if (PEAR::isError($root)) {

   		throw new Exception('Error al interpretar el archivo XML: ' . $root->getMessage());
	}

	$a=$root->toArray();
	$this->facturas = $a['root']['comprobantes']['comprobante'];
	
	
	/*
	$this->setInputFile('import/'.$archivo);
	$success = $this->parse();
	if (PEAR::isError($success)) {
	  throw new Exception('Error al interpretar el archivo XML:' . $success->getMessage());
	}
	*/
	//print_r($this->facturas);
    return $this->facturas;
  }
}
	


?>