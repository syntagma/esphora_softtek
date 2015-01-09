<?php
define('ESPHORA',true);
require_once 'config/globals.php';
require_once 'dal/ProvinciaFacade.php';

$pais = $_GET['pais'];

$p = new ProvinciaFacade();

$rows = $p->fetchAllRows(true, "id_pais = $pais");

$selected = "selected='selected'";

foreach ($rows as $row) {
	$id = $row['id_provincia'];
	$desc = $row['descripcion'];
	echo "<option value='$id' $selected>$desc</option>";
	$selected = "";
}

?>