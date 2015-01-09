<?php
require_once "bc/$modulo/AltaLoteCtrl.php";

//inserto nombre de funcion
PantallaSingleton::agregaTituloFuncion($funcion);

//edicion...
$ctrl = new AltaLoteCtrl();

if ($_POST) {
	//print_r($_POST);
	try	{
		$resultado = $ctrl->addLote(array(
							'id_lote' => $_POST['id_lote'],
							'descripcion_factura_desde' => $_POST['descripcion_factura_desde'], 
							'descripcion_factura_hasta' => $_POST['descripcion_factura_hasta']
							)
							, ($_POST['chkLote'] == 'S')
		);
		
		//PantallaSingleton::showMessage(Translator::getTrans("LOTE_SUCCESS"));
		
		echo Translator::getTrans("LOTE_SUCCESS");
		if ($resultado != "") {
			 echo "<br>CAE=$resultado";			 			 
		}
	}
	catch(Exception $e) {
		PantallaSingleton::muestraError($e->getMessage());
	}
	
}

$a = $ctrl->getListas();

foreach($a as $key => $value) {
	$_SESSION[$key] = $value;
}

//muestro el form
require "ui/$modulo/frmALTALOTE.php";

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