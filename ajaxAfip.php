<?php
define("ESPHORA", true);
require_once 'config/globals.php';
require_once 'dal/AfipFacade.php';
require_once 'dal/FacturaFacade.php';
require_once 'dal/EmpresaFacade.php';
require_once 'dal/PuntoVentaFacade.php';
require_once 'dal/TipoComprobanteFacade.php';
require_once 'dal/TipoDocumentoFacade.php';
require_once 'dal/LoteFacade.php';
require_once 'bc/BCUtils.php';

set_time_limit(120);

$action = $_GET['action'];
$cuit = obtieneCUIT();
$tipocbte = obtieneTipoAfip($_GET['tipoComprobante']);

switch ($action) {
	case 'valida':
		$detalle = $_GET;
		unset($detalle['action']);
		unset($detalle['tipoComprobante']);
		$detalle['tipo_cbte'] = $tipocbte;
		$detalle['cuit_emisor'] = $cuit;
		
		try {
			$af = new AfipFacade();
			$result = $af->validaCAE($detalle, $cuit);
			if ($result == 0) echo 'El CAE es invalido';
			else echo $result;
		}
		catch (Exception $ex) {
			echo "Error al validar el CAE<br>".$ex->getMessage();
		}
		break;
	
	case 'ficha':
		$ff = new FacturaFacade();
		$factura = $ff->fetchRows($_GET['id']);
		$af = new AfipFacade();
		$result = $af->consultaEstructura($factura['id_afip'], $cuit);
		//$result = $af->consultaEstructura('10002000080780', $cuit);
		print_r($result);
		break;
		
	case 'comprobante':
		$ptovta = $_GET['puntoVenta'];
		
		try {
			echo obtieneSiguienteCbte((float)$cuit, $tipocbte, $ptovta);
		}
		catch (Exception $e) {
			echo "Error al obtener el numero de comprobante AFIP<br>".$e->getMessage();
		}
		break;
	
	case 'comprobanteBD':
		$ptovta = $_GET['puntoVenta'];
		
		try {
			echo obtieneSiguienteCbteBD($_GET['tipoComprobante'], $ptovta);
		}
		catch (Exception $e) {
			echo "Error al obtener el numero de comprobante BD<br>".$e->getMessage();
		}
		break;
		
	case 'cai':
		$ptovta = $_GET['puntoVenta'];
		
		try {
			echo obtieneCAI($ptovta);
		}
		catch (Exception $e) {
			echo "Error al obtener el CAI<br>".$e->getMessage();
		}
		break;
	
	case 'cae':
		$detalle = $_GET;
		unset($detalle['action']);
		unset($detalle['tipoComprobante']);
		
		$detalle['tipo_cbte'] = $tipocbte;
		
		$detalle['cbt_desde'] = $detalle['cbte'];
		$detalle['cbt_hasta'] = $detalle['cbte'];
		unset($detalle['cbte']);
		
		$a = obtieneDocCliente($detalle['idcliente']);
		$detalle['tipo_doc'] = $a['tipo'];
		$detalle['nro_doc'] = $a['nro'];
		unset($detalle['idcliente']);
		
		$detalle['fecha_cbte'] = BCUtils::formatDate($detalle['fecha_cbte']);
		$detalle['fecha_venc_pago'] = BCUtils::formatDate($detalle['fecha_venc_pago']);
		
		//$lf = new LoteFacade();
		$seq = 0;
		$idLote = (float)($tipocbte.$detalle['punto_vta'].$detalle['cbt_desde'].$seq);
		setcookie("esphora_idlote", $idLote);
		$cabecera['id_lote'] = $idLote;		
			
		$cabecera['cant_reg'] = 1;
		
		$cabecera['cuit'] = $cuit;
		
		if ($detalle['presta_serv'] == "S") {
			$cabecera['presta_serv'] = 1;
			$detalle['fecha_serv_desde'] = BCUtils::formatDate($detalle['fecha_serv_desde']);
			$detalle['fecha_serv_hasta'] = BCUtils::formatDate($detalle['fecha_serv_hasta']);			
		}
		else {
			$cabecera['presta_serv'] = 0;
			unset($detalle['fecha_serv_desde']);
			unset($detalle['fecha_serv_hasta']);
		}
		unset($detalle['presta_serv']);
		
		esphora_log($cabecera, "Cabecera Factura");
		esphora_log($detalle, "Detalle Factura");
		
		try {
			$cae = obtieneCAE($cabecera, $detalle);
			while($cae == "MARK") {
				$idLote = (float)($tipocbte.$detalle['punto_vta'].$detalle['cbt_desde'].++$seq);
				setcookie("esphora_idlote", $idLote);
				$cabecera['id_lote'] = $idLote;
				
				if ($seq == 10) {
					throw new Exception ("Se ha llegado al limite de reprocesos... consulte con su supervisor");
				}
				$cae = obtieneCAE($cabecera, $detalle);
			}
			echo $cae;
		}
		catch (Exception $e) {
			echo "Error al obtener el CAE<br>".$e->getMessage();
		}
		
		break;
			
	default:
		echo "Error: Accion Invalida";
		break;
}

function obtieneCAE($cabecera, $detalle) {
	$af = new AfipFacade();
	
	/*
	echo "<pre>";
	print_r($af->obtieneCAE($cabecera, array($detalle)));
	echo "</pre>";
	*/
	
	return $af->obtieneCAE($cabecera, array($detalle));
	
}



function obtieneSiguienteCbte($cuit, $tipocbte, $ptovta) {
	$af = new AfipFacade();
	//echo "<br>CUIT: $cuit<br>TIPOCBTE: $tipocbte<br>PTOVTA: $ptovta<br>";
	return $af->getLastCMP($cuit, $ptovta, $tipocbte) + 1;
}

function obtieneCAI($ptovta) {
	$pvf = new PuntoVentaFacade();
	
	$result = $pvf->fetchRows($ptovta);
	return $result['cai'];
}

function obtieneSiguienteCbteBD($tipocbte, $ptovta) {
	$ff = new FacturaFacade();
	
	return $ff->getUltimoNumeroFactura($tipocbte, $ptovta);
}	

function obtieneCUIT() {
	$ef = new EmpresaFacade();
	$result = $ef->fetchRows(GLOBAL_EMPRESA);
	return $result['nro_documento'];
}

function obtieneTipoAfip($id_tipo) {
	if ($id_tipo == null) return null;
	$tcf = new TipoComprobanteFacade();
	$result = $tcf->fetchRows($id_tipo);
	return $result['cod_comprobante'];
}

function obtieneDocCliente($idcliente) {
	$cf = new ClienteFacade();
	$result = $cf->fetchRows($idcliente);
	
	$tdf = new TipoDocumentoFacade();
	$result2 = $tdf->fetchRows($result['id_tipo_documento']);
	
	return array('tipo' => $result2['cod_doc_afip'], 'nro' => $result['nro_documento']);
}
?>