<?php
//PantallaSingleton::muestraLista($funcion, $abmc);
require_once "bc/$modulo/AltaCompraCtrl.php";
//require_once "bc/$modulo/ImprimirFacturaCtrl.php";

$abmc = new AltaCompraCtrl ( );

//inserto la lista
PantallaSingleton::agregaTituloFuncion ( $funcion );

/*if ($_GET ['action'] == "imprimir") {
	
	$id = $_GET ['id'];
	//proceso de obtener cae
	try {
		$imprimir = new ImprimirFacturaCtrl ( );
		$imprimir->imprimirFacturas ( $id );
	} catch ( Exception $e ) {
		//mostrar mensaje con func estandar
		PantallaSingleton::muestraError ( $e->getMessage () );
	}
}

if ($_GET ['action'] == "email") {
	
	$id = $_GET ['id'];
	//proceso de Generar el Lote en XML
	try {
		$abmc->email ( $id );
	} catch ( Exception $e ) {
		//mostrar mensaje con func estandar
		PantallaSingleton::muestraError ( $e->getMessage () );
	}
}
*/

print ( $abmc->getListaCompras ( $_GET ['page'], $_GET ['order'] ) );

$_SESSION ['goback'] = $_SERVER ['SCRIPT_NAME'] . "?" . $_SERVER ['QUERY_STRING'];

?>