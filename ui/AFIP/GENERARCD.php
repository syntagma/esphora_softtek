<?php
require_once "bc/$modulo/MediosMagneticosCtrl.php";

$mediosMagneticosController = new MediosMagneticosCtrl();

//inserto la lista
PantallaSingleton::agregaTituloFuncion($funcion);

if ($_GET['action']=="generarCD") {
	
	$periodo = $_GET['id'];
	$rutaZip = ""; 
	//proceso de generar el CD
	try {
		$rutaZip = $mediosMagneticosController->generarCD($periodo); 
	}
	catch(Exception $e) {
		//mostrar mensaje con func estandar
		PantallaSingleton::muestraError($e->getMessage());
	}
	
	
	$stilo = "text-align:left;background-color:silver;font-weight:bold";
	if ($rutaZip == "") {
		echo "<div style='$stilo'>Hubo un error al empaquetar los archivos en formato zip.<br>Por favor dirijase a <a href='import/' target=_blank>este directorio</a> para bajar los archivos correspondientes en forma individual</div>";
	}
	else {
		//mandar link
		echo "<div style='$stilo'>Los archivos fueron generados con exito.<br><a targer=_blank href='$rutaZip'>Descarguelos en formato ZIP aqui</a></div>";
	}
	
}


//muestro el form
//require "ui/$modulo/frmGENERARCD.php";

print($mediosMagneticosController->getLista($_GET['page'], null, $_GET['order']));
?>