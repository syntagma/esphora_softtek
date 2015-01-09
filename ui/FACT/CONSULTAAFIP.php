<?php
require_once "bc/$modulo/AltaFacturaCtrl.php";

//inserto nombre de funcion
PantallaSingleton::agregaTituloFuncion($funcion);

//edicion...
$ctrl = new AltaFacturaCtrl();

if ($_POST and isset($_POST['id'])) {
	//print_r($_POST);
	try	{
		$ctrl->consultaFactura($_POST['id']);
	}
	catch(Exception $e) {
		PantallaSingleton::muestraError($e->getMessage());
	}
	
}

//muestro el form
require "ui/$modulo/frmCONSULTAAFIP.php";

?>