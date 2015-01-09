<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");


$os = strtolower(PHP_OS);
if($os != "winnt") $sep = ":";
else $sep = ";";

/*
echo "Separador: $sep <br>";
echo "Os: $os <br>"; 
*/

ini_set(
"include_path", (
    "pear$sep"."tcpdf$sep".
    ini_get("include_path")
    )
);

function esphora_setcookie($clave, $valorDefault) {
	$valor = "";
	if ($_POST[$clave]) {
		setcookie($clave,$_POST[$clave]);
		$valor = $_POST[$clave];
	}
	else {
		if ($_COOKIE[$clave]) {
			$valor = $_COOKIE[$clave];
		}
		else {
			$valor = $valorDefault;
		}
	}
	return $valor;
}

//TODO: obtener los valores de default por parametro

define("GLOBAL_THEME", esphora_setcookie('tema', 'orange'));
define("GLOBAL_I10N", esphora_setcookie('i10n', 'es-ar'));
define("GLOBAL_EMPRESA", esphora_setcookie('empresa', 1));

define("CONFIG_DIR", "config/");

//define("AMBIENTE", "test");
//define("AMBIENTE", "produccion");
define("AMBIENTE", "produccion");

define("URL_LISTA_FACTURAS", "index.php?modulo=FACT&funcion=CONSULTAFACTURA");
define("URL_ALTA_FACTURAS", "index.php?modulo=FACT&funcion=ALTAFACTURA");
define("URL_LISTA_COMPRAS", "index.php?modulo=PROV&funcion=CONSULTACOMPRA");
define("URL_ALTA_COMPRAS", "index.php?modulo=PROV&funcion=ALTACOMPRA");

define("COMPANY_LOGO","config/company_logo.jpg");

//SETEO DE LOG
require_once 'Log.php';

function esphora_log($message, $titulo) {
	$log = &Log::singleton("file", "esphora.log", "ESPHORA");
	
	$msg = print_r($message, true);
	
	if (!isset($_SESSION["user"])) {
		$usuario = "ajax";
	}
	else {
		$usuario = $_SESSION["user"]->get_login();
	}
	
	$log->log("$usuario - $titulo:\n$msg");
}

//defino la funcion trace
function trace ($var) {
	echo "<pre style='text-align:left'>";
	print_r($var);
	echo "</pre><hr>";
}
?>