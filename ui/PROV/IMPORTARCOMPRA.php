<?php
require_once "bc/$modulo/ImportarCompraCtrl.php";

//inserto nombre de funcion
PantallaSingleton::agregaTituloFuncion ( $funcion );

//edicion...
$ctrl = new ImportarCompraCtrl ( );

if ($_POST) {
	//print_r($_POST);
	try {
		$resultado = $ctrl->importarCompras ( true );
		
		$muestraError = false;
		
		$mensaje = "<table border=1>";
		
		//print_r($resultado);
		

		foreach ( $resultado as $key => $res ) {
			if ($res != "") {
				$mensaje .= "<tr>";
				
				if (is_nan ( $key )) {
					$mensaje .= "<td style='background-color:yellow'>" . strtoupper ( $key ) . "</td><td style='background-color:yellow'>$res</td>";
				} 

				else {
					$mensaje .= "<td>Registro $key</td><td>$res</td>";
				}
				
				$mensaje .= "</tr>";
				
				$muestraError = true;
			}
		}
		$mensaje .= "</table>";
		
		if ($muestraError) {
			PantallaSingleton::agregaTitulo ( "Resultado de Importacion" );
			print ( $mensaje );
			//PantallaSingleton::showMessage(Translator::getTrans("IMPORT_ERROR"));
		} else {
			print ( Translator::getTrans ( "IMPORT_SUCCESS" ) );
		}
	
	} catch ( Exception $e ) {
		PantallaSingleton::muestraError ( $e->getMessage () );
	}

}

//muestro el form
require "ui/$modulo/frmIMPORTARCOMPRA.php";

?>