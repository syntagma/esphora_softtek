<?php
if(!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once(CONFIG_DIR."/afip/conf_afip.php");
require_once("be/TicketAcceso.php");
require_once("nusoap/nusoap.php");

class AfipFacade  {
	
	private $_cert;
	private $_privatekey;
	private $_wsaa_wsdl;
	private $_proxy_host;
	private $_proxy_port;
	private $_service;
	private $_wsaa_url;
	private $_wsfe_url;
	private $_wsfe_wsdl;
	
	private $_path_sign;
	
	private $_path_tickets;
	
	private $_client;
	
	private $_motivos = array(
				array(	"id" => 1, 
						"descri" => 'LA CUIT INFORMADA NO CORRESPONDE A UN RESPONSABLE INSCRIPTO EN EL IVA ACTIVO'),
				array(	"id" => 2, 
						"descri" => 'LA CUIT INFORMADA NO SE ENCUENTRA AUTORIZADA A EMITIR COMPROBANTES ELECTRONICOS ORIGINALES O EL PERIODO DE INICIO AUTORIZADO ES POSTERIOR AL DE LA GENERACION DE LA SOLICITUD'),
				array(	"id" => 3, 
						"descri" => 'LA CUIT INFORMADA REGISTRA INCONVENIENTES CON EL DOMICILIO FISCAL'),
				array(	"id" => 4, 
						"descri" => 'EL PUNTO DE VENTA INFORMADO NO SE ENCUENTRA DECLARADO PARA SER UTILIZADO EN EL PRESENTE REGIMEN'),
				array(	"id" => 5, 
						"descri" => 'LA FECHA DEL COMPROBANTE INDICADA NO PUEDE SER ANTERIOR EN MAS DE CINCO DIAS, SI SE TRATA DE UNA VENTA, O ANTERIOR O POSTERIOR EN MAS DE DIEZ DIAS, SI SE TRATA DE UNA PRESTACION DE SERVICIOS, CONSECUTIVOS DE LA FECHA DE REMISION DEL ARCHIVO'),
				array(	"id" => 6, 
						"descri" => 'LA CUIT INFORMADA NO SE ENCUENTRA AUTORIZADA A EMITIR COMPROBANTES CLASE "A"'),
				array(	"id" => 7, 
						"descri" => 'ARA LA CLASE DE COMPROBANTE SOLICITADO -COMPROBANTE CLASE A- DEBERA CONSIGNAR EN EL CAMPO CODIGO DE DOCUMENTO IDENTIFICATORIO DEL COMPRADOR EL CODIGO "80"'),
				array(	"id" => 8, 
						"descri" => 'LA CUIT INDICADA EN EL CAMPO Nro DE IDENTIFICACION DEL COMPRADOR ES INVALIDA'),
				array(	"id" => 9, 
						"descri" => 'LA CUIT INDICADA EN EL CAMPO Nro DE IDENTIFICACION DEL COMPRADOR NO EXISTE EN EL PADRON UNICO DE CONTRIBUYENTES'),
				array(	"id" => 10, 
						"descri" => 'LA CUIT INDICADA EN EL CAMPO Nro DE IDENTIFICACION DEL COMPRADOR NO CORRESPONDE A UN RESPONSABLE INSCRIPTO EN EL IVA ACTIVO'),
				array(	"id" => 11, 
						"descri" => 'EL Nro DE COMPROBANTE DESDE INFORMADO NO ES CORRELATIVO AL ULTIMO Nro DE COMPROBANTE REGISTRADO/HASTA SOLICITADO PARA ESE TIPO DE COMPROBANTE Y PUNTO DE VENTA'),
				array(	"id" => 12,
						"descri" => 'EL RANGO INFORMADO SE ENCUENTRA AUTORIZADO CON ANTERIORIDAD PARA LA MISMA CUIT, TIPO DE COMPROBANTE Y PUNTO DE VENTA'),
				array(	"id" => 13, 
						"descri" => 'LA CUIT INDICADA SE ENCUENTRA COMPRENDIDA EN EL REGIMEN ESTABLECIDO POR LA RESOLUCION GENERAL Nro 2177 Y/O EN EL TITULO I DE LA RESOLUCION GENERAL Nro 1361 ART. 24 DE LA RG Nro 2177'),
	);
	
	/*
	define (TA, "TA.xml");          # The TA as obtained from WSAA
	//TODO: Obtener Cuit de la Empresa segun el rol seleccionado.
	define (CUIT, 30710370792);     # CUIT del emisor de las facturas
	*/

	function __construct() {
		$oConf = new conf_afip();
		
		$this->_cert=$oConf->get_cert(); 
		$this->_privatekey=$oConf->get_privatekey(); 
		$this->_wsaa_wsdl=$oConf->get_wsaa_wsdl(); 
		$this->_wsfe_wsdl=$oConf->get_wsfe_wsdl(); 
		$this->_proxy_host=$oConf->get_proxy_host(); 
		$this->_proxy_port=$oConf->get_proxy_port(); 
		$this->_service=$oConf->get_service();
		$this->_wsaa_url=$oConf->get_wsaa_url();
		$this->_wsfe_url=$oConf->get_wsfe_url();
		$this->_path_sign = $oConf->get_path_sign();
		$this->_path_tickets = $oConf->get_path_tickets();
   	}

		
	
	public function createTicketRequest()
	{
	  $oTicketRequest = new SimpleXMLElement(
								"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" .
								'<loginTicketRequest version="1.0">'.
								'</loginTicketRequest>');
	  $oTicketRequest->addChild('header');
	  $oTicketRequest->header->addChild('uniqueId',date('U'));
	  $oTicketRequest->header->addChild('generationTime',date('c',date('U')-3600));
	  $oTicketRequest->header->addChild('expirationTime',date('c',date('U')+3600));
	  $oTicketRequest->addChild('service',$this->_service);
//	  $TRA->asXML('TRA.xml');
	  return $oTicketRequest;
	}
	
	public function createTicketFactura($credentials, $cabecera, $detalles)
	{ /*
	  $oTicketRequest = new SimpleXMLElement(
								'<?xml version="1.0" encoding="UTF-8"?>' .
								'<loginTicketRequest version="1.0">'.
								'</loginTicketRequest>');
	  
	  $oTicketRequest->addChild('argAuth');
	  $oTicketRequest->argAuth->addChild('Token',$credentials["token"]);
	  $oTicketRequest->argAuth->addChild('Sign',$credentials["sign"]);
	  $oTicketRequest->argAuth->addChild('cuit',"30710370792");//$cabecera['cuit']);
	  $oTicketRequest->argAuth->addChild('Fer');
	  $oTicketRequest->argAuth->Fer->addChild('Fecr');
	  
	 $oTicketRequest->argAuth->Fer->Fecr->addChild('id',$cabecera['id_lote']);
	 $oTicketRequest->argAuth->Fer->Fecr->addChild('cantidadreg',$cabecera['cant_reg']);
	 $oTicketRequest->argAuth->Fer->Fecr->addChild('presta_serv', 0);//$cabecera['cant_reg']);
	  
	  $oTicketRequest->argAuth->Fer->addChild('Fedr');
	  
	  foreach ($detalles as $detalle )
	  {
	  	$oTicketRequest->argAuth->Fer->Fedr->addChild('FEDetalleRequest');
	  	$oTicketRequest->argAuth->Fer->Fedr->FEDetalleRequest->addChild('tipo_doc',$detalle['tipo_doc']);
	  	$oTicketRequest->argAuth->Fer->Fedr->FEDetalleRequest->addChild('nro_doc',$detalle['nro_doc']);
  	  	$oTicketRequest->argAuth->Fer->Fedr->FEDetalleRequest->addChild('tipo_cbte',$detalle['tipo_cbte']);
  	  	$oTicketRequest->argAuth->Fer->Fedr->FEDetalleRequest->addChild('punto_vta',$detalle['punto_vta']);
  	  	$oTicketRequest->argAuth->Fer->Fedr->FEDetalleRequest->addChild('cbt_desde',$detalle['cbt_desde']);
  	  	$oTicketRequest->argAuth->Fer->Fedr->FEDetalleRequest->addChild('cbt_hasta',$detalle['cbt_hasta']);
  	  	$oTicketRequest->argAuth->Fer->Fedr->FEDetalleRequest->addChild('imp_total',$detalle['imp_total']);
  	  	$oTicketRequest->argAuth->Fer->Fedr->FEDetalleRequest->addChild('imp_tot_conc',0);//$detalle['imp_tot_conc']);
  	  	$oTicketRequest->argAuth->Fer->Fedr->FEDetalleRequest->addChild('imp_neto',$detalle['imp_neto']);
   	  	$oTicketRequest->argAuth->Fer->Fedr->FEDetalleRequest->addChild('impto_liq',$detalle['impto_liq']);
   	  	$oTicketRequest->argAuth->Fer->Fedr->FEDetalleRequest->addChild('impto_liq_rni',$detalle['impto_liq_rni']);
   	  	$oTicketRequest->argAuth->Fer->Fedr->FEDetalleRequest->addChild('imp_op_ex',$detalle['imp_op_ex']);
  	  	$oTicketRequest->argAuth->Fer->Fedr->FEDetalleRequest->addChild('fecha_cbte',date("Ymd",strtotime($detalle['fecha_cbte'])));
   	  	$oTicketRequest->argAuth->Fer->Fedr->FEDetalleRequest->addChild('fecha_venc_pago',date("Ymd",strtotime($detalle['fecha_venc_pago'])));
	  }
	  */

	foreach ($detalles as $i => $detalle) {
		$detalles[$i]['fecha_cbte'] = date("Ymd",strtotime($detalle['fecha_cbte']));
		$detalles[$i]['fecha_venc_pago'] = date("Ymd",strtotime($detalle['fecha_venc_pago']));
		$detalles[$i]['nro_doc'] = (float)$detalles[$i]['nro_doc'];
		
		//harcodeado temporalmente
		$detalles[$i]['imp_tot_conc'] = 0;
	}
		
	$results=
		array('argAuth' => array(
				 'Token' => $credentials["token"],
				 'Sign'  => $credentials["sign"],
				 'cuit'  => (float)$cabecera['cuit']),
			  
				 'Fer' => array(
				 	'Fecr' => array(
						'id' => $cabecera['id_lote'], 
						'cantidadreg' => $cabecera['cant_reg'], 
						'presta_serv' => 0),
				 	'Fedr' => $detalles		
				 )
			);
	  
	  /*
	  foreach ($detalles as $detalle )
	  {
	  	$results['Fer']['Fedr'][]=	array(
					   'tipo_doc' =>  $detalle['tipo_doc'],
					   'nro_doc' =>   $detalle['nro_doc'],
					   'tipo_cbte' => $detalle['tipo_cbte'],
					   'punto_vta' => $detalle['punto_vta'],
					   'cbt_desde' => $detalle['cbt_desde'],
					   'cbt_hasta' => $detalle['cbt_hasta'],
					   'imp_total' => abs($detalle['imp_total']),
					   'imp_tot_conc' => 0.00,
					   'imp_neto' =>  abs($detalle['imp_neto']),
					   'impto_liq' => abs($detalle['impto_liq']),
					   'impto_liq_rni' => abs($detalle['impto_liq_rni']),
					   'imp_op_ex' => abs($detalle['imp_op_ex']),
					   'fecha_cbte' => date("Ymd",strtotime($detalle['fecha_cbte'])),
					   'fecha_venc_pago' => date("Ymd",strtotime($detalle['fecha_venc_pago'])));
	  }
	  */
	/*		
	  echo "<pre>";
	  print_r ($results);
	  echo "</pre>";
	*/  
	  return $results;		
	}
	
	private function getCuitEmpresaFromGlobal() {
		$ef = new EmpresaFacade();
		$oEmpresa  = $ef->fetchRows(GLOBAL_EMPRESA);
		return $oEmpresa['nro_documento'];
	}
	
	public function signTRA($oTicketRequest, $cuit = null)
	{
	#==============================================================================
	# This functions makes the PKCS#7 signature using TRA as input file, CERT and
	# PRIVATEKEY to sign. Generates an intermediate file and finally trims the 
	# MIME heading leaving the final CMS required by WSAA.

	$oTicketRequest->asXML($this->_path_sign."TRA.xml");
	
	
	if ($cuit == null) {
		$cuit = $this->getCuitEmpresaFromGlobal();	
	}
	
	$STATUS=openssl_pkcs7_sign(	$this->_path_sign."TRA.xml", 
								$this->_path_sign."TRA.tmp", 
								"file://".$this->_path_sign.$cuit.".crt",
								array("file://".$this->_path_sign.$cuit.".privada", ""),
								array(),
								!PKCS7_DETACHED
	);
	
	if (!$STATUS) {throw new Exception("ERROR generating PKCS#7 signature\n");}
	
	$inf=fopen($this->_path_sign."TRA.tmp", "r");
	$i=0;
	$CMS="";
	
	while (!feof($inf)) 
		{ 
		  $buffer=fgets($inf);
		  if ( $i++ >= 4 ) {$CMS.=$buffer;}
		}
	fclose($inf);
	unlink($this->_path_sign."TRA.xml");
	unlink($this->_path_sign."TRA.tmp");
	return $CMS;
	}
	
	private function getTicketFilename($cuit) {
		return $this->_path_tickets.$cuit."_request.xml";
	}
	
	private function getTokenFilename($cuit) {
		return $this->_path_tickets.$cuit.".token";
	}
	
	private function getSignFilename($cuit) {
		return $this->_path_tickets.$cuit.".sign";
	}
	
	private function readTicket($cuit) {
		$oTicketRequest = null;
		$filename = $this->getTicketFilename($cuit);
		if(file_exists($filename)) {
			$oTicketRequest = simplexml_load_file($filename);
		}
		return $oTicketRequest;
	}
	
	private function isValid($oTicketRequest) {
		$valid = false;
		if ($oTicketRequest) {
			if (strtotime($oTicketRequest->header->expirationTime) > strtotime(date('c'))) {
				$valid = true;
			}
		}
		
		return $valid;
	}
	
	private function saveTicket($cuit, $oTicketRequest, $credentials) {
		$this->saveToFile($this->getTicketFilename($cuit), $oTicketRequest);
		$this->saveToFile($this->getTokenFilename($cuit), $credentials['token']);
		$this->saveToFile($this->getSignFilename($cuit), $credentials['sign']);
	}
	
	private function saveToFile($filename, $xmlObj) {
		if (file_exists($filename)) {
			unlink($filename);
		}
		$xmlObj->saveXML($filename);
	}
	
	private function readCredentialsFromDisk($cuit) {
		return array (
			'token' => simplexml_load_file($this->getTokenFileName($cuit)), 
			'sign' => simplexml_load_file($this->getSignFileName($cuit))
		);
	}

	public function getTicket($cuit = null) {
		$credentials = null;
		
		if ($cuit == null) {
			$cuit = $this->getCuitEmpresaFromGlobal();
		}
		$oTicketRequest = $this->readTicket($cuit);
		if (!$this->isValid($oTicketRequest)) {
			$oTicketRequest = $this->createTicketRequest();
			$CMS = $this->signTRA($oTicketRequest, $cuit);
			$credentials=$this->callWSAA($CMS);
			$this->saveTicket($cuit, $oTicketRequest, $credentials);
		}
		else {
			$credentials = $this->readCredentialsFromDisk($cuit);
		}
		
		return $credentials;
	}
	
	public function getTicketAfip($cuit = null)
	{
		ini_set("soap.wsdl_cache_enabled", "0");
		$credentials = $this->getTicket($cuit);
		return $credentials;
	}
	
	public function callWSAA($CMS)
	{
	  $client=new SoapClient(CONFIG_DIR."/afip/".$this->_wsaa_wsdl, 
							  array(
									  'soap_version'   => SOAP_1_2,
									  'location'       => $this->_wsaa_url,
							#          'proxy_host'     => this->_proxy_host,
							#          'proxy_port'     => this->_proxy_port,
									  'exceptions'     => 0
									  )); 
	  $results=$client->loginCms(array('in0'=>$CMS));
	  if (is_soap_fault($results)) 
		{throw  new Exception("SOAP Fault: ".$results->faultcode."<br>".$results->faultstring."\n");}
		
		$oTicketAcceso = simplexml_load_string($results->loginCmsReturn);
	    //echo ('Token: ' . $oTicketAcceso->credentials[0]->token[0]);
		
		$credentials = array (
			'token' => $oTicketAcceso->credentials[0]->token[0],
			'sign' => $oTicketAcceso->credentials[0]->sign[0]
		);

		return $credentials;
	}


	function getQuantity ($client, $token, $sign, $cuit)
	{
	  $results=$client->FERecuperaQTYRequest(
		array('argAuth'=>array('Token' => $token,
								'Sign' => $sign,
								'cuit' => $cuit)));
	  if ( $results->FERecuperaQTYRequestResult->RError->percode != 0 )
		{
		  throw new Exception ("Error devuelto de AFIP: ".$results->FERecuperaQTYRequestResult->RError->percode."<BR>Descripcion: ".$results->FERecuperaQTYRequestResult->RError->perrmsg);
		}
	  return $results->FERecuperaQTYRequestResult->qty->value;
	}

	
	public function getLastInvoiceNumber ($client, $token, $sign, $cuit)
	{
	  $results=$client->FEUltNroRequest(
		array('argAuth'=>array('Token' => $token,
								'Sign' => $sign,
								'cuit' => $cuit)));
	  if ( $results->FEUltNroRequestResult->RError->percode != 0 )
		{
		  throw new Exception ("Error devuelto de AFIP: ".$results->FEUltNroRequestResult->RError->percode."<BR>Descripcion: ".$results->FEUltNroRequestResult->RError->perrmsg);
		}
	  return $results;
	}
	
	public function getLastCMP ($cuit, $ptovta, $tipocbte) {
		$client=new SoapClient(CONFIG_DIR."afip/".$this->_wsfe_wsdl,
		  array('soap_version' => SOAP_1_2,
			'location'     =>  $this->_wsfe_url,
	#       'proxy_host'   => "proxy",
	#       'proxy_port'   => 80,
			'exceptions'   => 0,
			'trace'        => 1)); # needed by getLastRequestHeaders and others	
			
		
		$credentials = $this->getTicketAfip($cuit);
		
		
		$result = $this->RecuperaLastCMP($client, $credentials['token'], $credentials['sign'], (float)$cuit, (float)$ptovta, (float)$tipocbte);
		
		/*
		echo "<pre>";
		print_r($result);
		echo "</pre>";
		*/
		
		return $result->FERecuperaLastCMPRequestResult->cbte_nro;
	}
	
	public function RecuperaLastCMP ($client, $token, $sign, $cuit, $ptovta, $tipocbte)
	{
	  $results=$client->FERecuperaLastCMPRequest(
		array('argAuth' =>  array('Token'    => $token,
								  'Sign'     => $sign,
								  'cuit'     => $cuit),
			   'argTCMP' => array('PtoVta'   => $ptovta,
								  'TipoCbte' => $tipocbte)));
		if ( $results->FERecuperaLastCMPRequestResult->RError->percode != 0 )
		{
		  throw new Exception ("Percode: ".$results->FERecuperaLastCMPRequestResult->RError->percode."<BR>Descripcion: ".$results->FERecuperaLastCMPRequestResult->RError->perrmsg);
		}
		
		/*
		echo "<pre>";
		print_r($result);
		echo "</pre>";
		*/
		
		return $results;
	}
	
	public function consultaEstructura($idAfip, $cuit) {
		$cabecera = array('id_lote' => (float)$idAfip, 'cant_reg' => 1, 'cuit' => $cuit);
		
		$result = $this->getCAE ($this->getTicketAfip($cuit), $cabecera, array());
		
		return $result;
	}
	
	public function validaCAE($cuit, $detalle) {
		$client=new SoapClient(CONFIG_DIR."afip/".$this->_wsfe_wsdl,
		  array('soap_version' => SOAP_1_2,
			'location'     =>  $this->_wsfe_url,
	#       'proxy_host'   => "proxy",
	#       'proxy_port'   => 80,
			'exceptions'   => 0,
			'trace'        => 1)); # needed by getLastRequestHeaders and others	
			
		$credentials = $this->getTicketAfip($cuit);
		$credentials['cuit'] = $cuit;
		
		$result = $client->FEConsultaCAERequest(
			array (
				'argAuth'		=> 	$credentials,
				'argCAERequest'	=>	$detalle
			)
		);
		
		if ($result->FEConsultaCAEestResult->RError->percode != 0) {
			$msgError = "Error devuelto de AFIP:".$result->FEConsultaCAEestResult->RError->percode."<br>Descripcion: ".$result->FEConsultaCAEestResult->RError->perrmsg;
			throw new Exception ($msgError);
		}
		
		return $result->FEConsultaCAEestResult->Resultado;
	}
	
	public function obtieneCAE($cabecera, $detalle) {
		$result = $this->getCAE ($this->getTicketAfip(), $cabecera, $detalle);
		
		if ($result->FEAutRequestResult->RError->percode != 0 ) {
			$msgError = "Error devuelto de AFIP: ".$result->FEAutRequestResult->RError->percode."<BR>Descripcion: ".$result->FEAutRequestResult->RError->perrmsg;
			throw new Exception($msgError);
		}

		$motivos = null;
		
		if ($result->FEAutRequestResult->FecResp->resultado == 'R') {
			if ($result->FEAutRequestResult->FecResp->motivo == '00') {
				if ($result->FEAutRequestResult->FedResp->FEDetalleResponse->resultado == 'R') {
					if ($result->FEAutRequestResult->FedResp->FEDetalleResponse->motivo != '00') {
						$motivos = split(";", $result->FEAutRequestResult->FedResp->FEDetalleResponse->motivo);
					}
				}
			}
			else {
				$motivos = $result->FEAutRequestResult->FecResp->motivo;
			}
		}
		
		if ($motivos != null) {
			if ($result->FEAutRequestResult->FecResp->reproceso == 'S') {
				return "MARK";
			}
			else {
				foreach($motivos as $motivoRechazo) {
					foreach($this->_motivos as $motivo) {
						if ($motivoRechazo == $motivo["id"]) {											
							$mensaje .= $motivo['descri']."<br>";
							break;
						}
					}
				}
				throw new Exception($mensaje);
			}
		}
		
				
		if ($result->FEAutRequestResult->FedResp->FEDetalleResponse->cae == 'NULL') {
			throw new Exception("No se pudo obtener el CAE");
		}
		else {
			return $result->FEAutRequestResult->FedResp->FEDetalleResponse->cae;
		}
	}

	public function getCAE ($credentials, $cabecera, $detalles)
	{
 
	  $client=new SoapClient(CONFIG_DIR."afip/".$this->_wsfe_wsdl,
	 // $client=new nusoap_client(CONFIG_DIR."afip/".$this->_wsfe_wsdl,
	  array('soap_version' => SOAP_1_2,
			'location'     =>  $this->_wsfe_url,
	#       'proxy_host'   => "proxy",
	#       'proxy_port'   => 80,
			'exceptions'   => 0,
			'trace'        => 1)); # needed by getLastRequestHeaders and others
	  /*$err = $client->getError();
	  
	  if ($err) {
	    throw new Exception ('<h2>Constructor error</h2><pre>' . $err . '</pre>');
	  }
	  */
	  
	  	
	  $oTicket = $this->createTicketFactura($credentials,$cabecera,$detalles);
	  
	  $results=$client->FEAutRequest($oTicket);
	  
	  /*
	  echo "<pre>";
	  print_r($this->RecuperaLastCMP($client, $credentials['token'], $credentials['sign'], (float)$cabecera['cuit'], $detalles[0]['tipo_cbte'], $detalles[0]['punto_vta']));
	  print_r($this->getLastInvoiceNumber($client, $credentials['token'], $credentials['sign'], (float)$cabecera['cuit']));
	  echo "</pre>";
	  
	  
	  throw new Exception("OK");
	  */

	  /*
	  echo "<pre>";
	  print_r($results);
	  echo "</pre>";
	  */
	  
	  //$results=$client->call("FEAutRequest", array('parameters' => $oTicket),'','',false,true);

	  /*
	if ($client->fault) {
	echo '<h2>Error</h2><pre>';
	print_r($results);
	echo '</pre>';
	}  else {
		// Display the result
		echo '<h2>Result</h2><pre>';
		print_r($results);
		echo '</pre>';
	}
	*/

		
	# printf ("HEADERs:\n%s\n", $client->__getLastRequestHeaders());
	# printf ("REQUEST:\n%s\n", $client->__getLastRequest());
	#  file_put_contents("FE.xml",$client->__getLastResponse());
	  
		if (is_soap_fault($results)) 
	   { 
	   		throw new Exception("Error devuelto de AFIP (SOAP Fault): ".$results->faultcode."<br>FaultString: ".$results->faultstring); 
	   }
	  
	  return $results;
	  
	}


	function test ()
	{
	  $client=new SoapClient(CONFIG_DIR."/afip/".$this->_wsfe_wsdl,
	  array('soap_version' => SOAP_1_2,
			'location'     =>  $this->_wsfe_url,
	#       'proxy_host'   => "proxy",
	#       'proxy_port'   => 80,
			'exceptions'   => 0,
			'trace'        => 1)); # needed by getLastRequestHeaders and others
	  $results=$client->FEDummy();
	
	  if (is_soap_fault($results)) 
	   { 
	   		throw new Exception("Error devuelto de AFIP: ".$results->faultcode."<br>FaultString: ".$results->faultstring); 
	   }
	  return $results;
	}
}
?>