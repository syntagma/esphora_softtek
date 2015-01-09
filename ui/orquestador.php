<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once 'ui/translator/Translator.php';
require_once 'ui/PantallaDecorator.php';
require_once('ui/login.php');
require_once 'dal/DBFacade.php';

set_time_limit  ( 1000 );

try {
	$db = new DBFacade();
	$db->_connect();
}
catch (Exception $e) {
	PantallaSingleton::muestraError($e->getMessage());
	die ("Error en el archivo de configuracion de base de datos. No se puede iniciar la aplicacion"); 
}
unset($db);


if(LoginSingleton::getAuth()->checkAuth()) {
	try {
		
		$pantalla = new PantallaDecorator(); 
		
		if (!$pantalla->checkActivo()) {
			
			$pantalla->endSession(Translator::getTrans("USUARIO_DESACTIVADO"));
			$muestra_menu = false;
		}
		elseif (!$pantalla->checkEmpresa()) {
			$pantalla->endSession(Translator::getTrans("USUARIO_EMPRESA_NO_MATCH"));
			$muestra_menu = false;
		}
		
		elseif(isset($_GET["action"]) && $_GET["action"] == "logout") {
			LoginSingleton::getAuth()->logout();
			
			$muestra_menu = false;
		}
		else {
			
			if ($_COOKIE['__callback__'] == "1")
				$__callback = false;
			else
				$__callback = true;
			
			setcookie('__callback__', "0");
			
			$pantalla->arma_logout();
			$pantalla->arma_menu($__callback);
			if (!$_GET) {
				//resalto el menu de home
				$pantalla->resalta_menu('home');
				
				require "ui/bienvenida.php";
				
			} else {
				if(isset($_GET["modulo"]) && $_GET["modulo"] != null) {
					$modulo= $_GET["modulo"];
				}
				else {
					die ("ERROR: No se ha especificado un modulo");
				}
				
				$db = new DBFacade();
				//$a = $db->checkLicencias($modulo); 
				 
				if (!$a['result']) {
					if ($a['cancela']) {
						die ("<p class='error-licencias'>".$a['mensaje']."</p>");
					}
					else {
						$pantalla->muestraErrorCabecera($a['mensaje']);
					}
				}
				
				
				$pantalla->resalta_menu($modulo);
				
				if(isset($_GET["funcion"]) && $_GET["funcion"] != null) {
					$funcion=$_GET["funcion"];
					
					
					if ($pantalla->checkFuncion($funcion)) {
						//integrar el archivo correspondiente
						require "ui/$modulo/$funcion.php";
					}
					else {
						
						$pantalla->muestraProhibido($funcion);
					}
				}
				
				else {
					$pantalla->arma_pantalla_modulo($modulo);
				}
			}
		}
	}
	catch (Exception $e) {
		PantallaSingleton::muestraError($e->getMessage());
	}
}

?>
