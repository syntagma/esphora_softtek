<?php
$modulo = "PROV";

define("ESPHORA", true);
require_once 'config/globals.php';

require_once "bc/$modulo/ImportarCompraCtrl.php";
require_once 'dal/UsuarioFacade.php';

$uf = new UsuarioFacade();
$oUsuario = $uf->simpleFetch($_COOKIE['usuario']); 
$_SESSION['user'] = $oUsuario;
set_time_limit(6000); //100 minutos maximo

$ctrl = new ImportarCompraCtrl ( );

try {
	$resultado = $ctrl->importarCompras ( true );

	$muestraError = false;
	
	$mensaje = "<table border=1>";
	
	foreach ( $resultado as $key => $res ) {
		if ($res != "") {
			$mensaje .= "<tr>";
			
			if (is_nan ( $key )) {
				$mensaje .= "<td style='background-color:yellow'><pre>" . strtoupper ( $key ) . "</pre></td><td style='background-color:yellow'><pre>$res</pre></td>";
			} 

			else {
				$mensaje .= "<td><pre>Registro $key</pre></td><td><pre>$res</pre></td>";
			}
			
			$mensaje .= "</tr>";
			
			$muestraError = true;
		}
	}
	$mensaje .= "</table>";
	
	if ($muestraError) {
		$mensaje = "<h2>Resultado de la Importaci&oacute;n</h2>$mensaje";
	} else {
		$mensaje = "Importaci&oacute;n exitosa";
	}

} catch ( Exception $e ) {
	$mensaje = $e->getMessage ();
}

echo $mensaje;

//*/
?>