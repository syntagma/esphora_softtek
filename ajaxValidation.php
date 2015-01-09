<?php
define("ESPHORA", true);
require_once 'config/globals.php';
require_once "dal/PeriodoFacade.php";

$action = $_GET['action'];
switch ($action) {
case "validaFechaRegistroContable":
	$fecha = $_GET['fechaRegistroContable'];
	echo validaFechaRegistroContable($fecha);
	break;
}

function validaFechaRegistroContable($fecha) {
	$pf = new PeriodoFacade();
	$result = $pf->fetchAllRows(true, "estado = 'A' and '$fecha' between fecha_inicio and fecha_fin");
	if ($result == array()) return "La fecha de registro contable no corresponde a un periodo abierto";
	else return 1;
}
?>