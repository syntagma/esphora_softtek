<?php
define("ESPHORA", true);
require_once 'config/globals.php';
require_once 'dal/AlicuotaIvaFacade.php';

$iva = new AlicuotaIvaFacade();

$idDefault = $_GET['idiva'];

try {
	$result = $iva->fetchAllRows(true);
	
	foreach ($result as $row) {
		$id = $row['id_alicuota_iva'];
		$titulo = $row['descripcion'];
		
		$selected = ($idDefault == $id ? "selected" : "");
		
		echo "<option value='$id' $selected>$titulo</option>";
	}
}
catch (Exception $e) {
	die ("Error al consultar la tabla de alicuotas de iva");
}

?>