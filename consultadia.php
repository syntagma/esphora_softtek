<html><head><title>CONSULTA DE COMPROBANTES POR DIA</title></head>
<body>
<h2>CONSULTA DE COMPROBANTES POR DIA</h2>
<?php
define("ESPHORA", true);
require 'config/globals.php';
require_once 'dal/AfipFacade.php';
require_once 'dal/EmpresaFacade.php';

set_time_limit(32000);

$empresa = 2;

$dia = "15";
$mes = "09";
$anio = "2009";

$hora_inicial = 11;
$minuto_inicial = 0;
$segundo_inicial = 0;

$hora_final = 14;
$minuto_final = 0;
$segundo_final = 0;


$cuit = obtieneCUIT($empresa); 

$af = new AfipFacade();

echo "<h3>Consulta del $dia/$mes/$anio para el CUIT $cuit</h3>";
echo "<pre>";
for ($hora = $hora_inicial; $hora < $hora_final + 1; $hora++) {
	if ($hora == $hora_final) 
		$minuto_limite = $minuto_final + 1;
	else
		$minuto_limite = 60; 
	
	for ($minuto = $minuto_inicial; $minuto < $minuto_limite; $minuto++) {
		$minuto_inicial = 0;
		
		if ($hora == $hora_final && $minuto == $minuto_final)
			$segundo_limite = $segundo_final + 1;
		else
			$segundo_limite = 60;
		
		for ($segundo = $segundo_inicial; $segundo < $segundo_limite; $segundo++) {			
			$segundo_inicial = 0;
			
			$s_hora = str_pad($hora, 2, "0", STR_PAD_LEFT);
			$s_minuto = str_pad($minuto, 2, "0", STR_PAD_LEFT);
			$s_segundo = str_pad($segundo, 2, "0", STR_PAD_LEFT);
			
			$id = $anio.$mes.$dia.$s_hora.$s_minuto.$s_segundo;
			
			$sigue = false;
			do {
				$sigue = false;
				try {
					$result = $af->consultaEstructura($id, $cuit);
				}
				catch(Exception $e) {
					echo "<b>id = $id</b><br />";
					echo $e->getMessage()."<br />";
					$sigue = true;
				}
			} while ($sigue);
			
			
			if ($result->FEAutRequestResult->RError->percode == 0) {
				echo "<b>id = $id</b><br />";				
				print_r($result);
				echo "<hr />";
			}
		}
	}
}
echo "</pre>";

function obtieneCUIT($l_empresa) {
	$ef = new EmpresaFacade();
	$result = $ef->fetchRows($l_empresa);
	return $result['nro_documento'];
}
?>
</body>
</html>