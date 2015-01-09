<?php
require_once "bc/$modulo/AltaCompraCtrl.php";

//inserto nombre de funcion
PantallaSingleton::agregaTituloFuncion($funcion);

//edicion...
$ctrl = new AltaCompraCtrl();

if ($_POST) {
	//print_r($_POST);
	try	{
		$ctrl->addFactura($_POST);
		header("Location: ".$_SERVER['SCRIPT_NAME']."?modulo=$modulo&funcion=CONSULTACOMPRA");
		//PantallaSingleton::showMessage(Translator::getTrans("INVOICE_SUCCESS"));
	}
	catch(Exception $e) {
		PantallaSingleton::muestraError($e->getMessage());
	}
	
}

if ($_GET['id'] == null) {
	$a = $ctrl->getListas();
}
else {
	$a = $ctrl->getListas($_GET['id']);
}

foreach($a as $key => $value) {
	$_SESSION[$key] = $value;
}

//muestro el form
require "ui/$modulo/frmALTACOMPRA.php";

try {
	$a = $ctrl->getNombresListas();
}
catch(Exception $e) {
	PantallaSingleton::muestraError($e->getMessage());
}

foreach ($a as $value) {
	unset ($_SESSION[$value]);
}

?>