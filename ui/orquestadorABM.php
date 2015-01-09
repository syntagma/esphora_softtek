<?php
$muestraLista = true;
if (isset($_GET['action']) && ($_GET['action'] == 'edit' || $_GET['action'] == 'add')) {
	if($_POST) {
		//print_r($_POST);
		try {
			if ($_GET['action'] == 'add') {
				$abmc->insert($_POST);
			}
			else {
				$abmc->update($_POST);
			}
		}
		catch (Exception $e) {
			PantallaSingleton::muestraError($e->getMessage());
			$muestraLista = false;
		}
	}

	else {
		$muestraLista = false;
	}
}

if ($muestraLista) {
	PantallaSingleton::muestraLista($funcion, $abmc);
}
else {
	try {
		$_SESSION['edicion'] = PantallaSingleton::obtieneDatosForm($abmc);
	}
	catch (Exception $e) {
		PantallaSingleton::muestraError($e->getMessage());
	}
	
	PantallaSingleton::agregaTituloFuncion($funcion);
	
	require "ui/$modulo/frm_$funcion.php";
	unset($_SESSION['edicion']);
	
	foreach ($abmc->getNombresListas() as $value)
		unset($_SESSION[$value]);
	
}
?>