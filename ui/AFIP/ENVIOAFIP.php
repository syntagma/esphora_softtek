<?php
require_once "bc/$modulo/AfipCtrl.php";

$afipController = new AfipCtrl();

//inserto la lista
PantallaSingleton::agregaTituloFuncion($funcion);

if ($_GET['action']=="obtenerCAE") {
	
	$id = $_GET['id'];
	//proceso de obtener cae
	try {
		$afipController->setCAE($id);
	}
	catch(Exception $e) {
		//mostrar mensaje con func estandar
		PantallaSingleton::muestraError($e->getMessage());
	}
}


if ($_GET['action']=="exportarLote") {
	
	$id = $_GET['id'];
	//proceso de Generar el Lote en XML
	try {
		$afipController->exportarLote($id);
	}
	catch(Exception $e) {
		//mostrar mensaje con func estandar
		PantallaSingleton::muestraError($e->getMessage());
	}
}


if ($_GET['action']=="verFacturas") {
	$id = $_GET['id'];
	try {
		print $afipController->muestraFacturasLote($id);
	}
	catch(Exception $e) {
		//mostrar mensaje con func estandar
		PantallaSingleton::muestraError($e->getMessage());
	}
}
else {
	if (isset($_GET['pagina'])) {
		print($afipController->getListaLote($_GET['pagina']));
	}
	else {
		print($afipController->getListaLote());
	}
}

?>