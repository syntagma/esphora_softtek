<?php
define("ESPHORA", true);
require_once 'config/globals.php';
require_once 'dal/RetencionFacade.php';

$ret = new RetencionFacade();

$idDefault = $_GET['idret'];

$compra = "'V'";
if ($_GET['compra'] != null) $compra = "'C'";


try {
	$result = $ret->fetchAllRows(true, "compra_venta in ($compra, 'X')");
	
	foreach ($result as $row) {
		$id = $row['id_retencion'];
		$titulo = $row['descripcion'];
		
		$selected = ($idDefault == $id ? "selected" : "");
		
		echo "<option value='$id' $selected>$titulo</option>";
	}
}
catch (Exception $e) {
	die ("Error al consultar la tabla de retenciones");
}

?>