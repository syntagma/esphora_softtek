<?php
//PantallaSingleton::muestraLista($funcion, $abmc);
require_once "bc/$modulo/AltaFacturaCtrl.php";

$abmc = new AltaFacturaCtrl();

//inserto la lista
PantallaSingleton::agregaTituloFuncion($funcion);

if ($_GET['action']=="imprimir") {
	
	$id = $_GET['id'];
	//proceso de obtener cae
	try {
		$abmc->imprimir($id);
	}
	catch(Exception $e) {
		//mostrar mensaje con func estandar
		PantallaSingleton::muestraError($e->getMessage());
	}
}


if ($_GET['action']=="email") {
	
	$id = $_GET['id'];
	//proceso de Generar el Lote en XML
	try {
		$abmc->email($id);
	}
	catch(Exception $e) {
		//mostrar mensaje con func estandar
		PantallaSingleton::muestraError($e->getMessage());
	}
}

if (isset($_GET['pagina'])) {
	print($abmc->getListaFacturas($_GET['pagina']));
}
else {
	print($abmc->getListaFacturas());
}
?>