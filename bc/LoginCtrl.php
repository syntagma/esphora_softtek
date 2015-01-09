<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");
	
require_once("dal/UsuarioFacade.php");
require_once("dal/EmpresaFacade.php");
require_once("be/Usuario.php");
require_once "Auth.php";
require_once "dal/DBFacade.php";

class LoginCtrl {
	
	public function getUsuario ($username) {
		
		$oUsuarioFacade = new UsuarioFacade();
		$oUsuario = $oUsuarioFacade->getIdByLogin($username);
		
		return $oUsuario;
	}
	
	public function getAuth ($funcion) {
		
		$db = new DBFacade();
		$loginData = $db->getLoginData();
		
		$options = array(
				"dsn" => $db->getDSN(),
				"table" => $loginData['user_table'],
				"usernamecol" => $loginData['login_field'],
				"passwordcol" => $loginData['password_field']
		);

		$oAuth = new Auth("MDB2", $options, $funcion);
	
		return $oAuth;
	}
	
	public function getEmpresas() {
		$ef = new EmpresaFacade();
		
		$result = $ef->fetchAllRows(true,null,"nombre");
		
		$nombres = array();
		foreach ($result as $row) {
			$nombres[]=array ('id_empresa' => $row['id_empresa'],
							  'nombre' => $row['nombre']);
		}
		
		return $nombres;
	}
}

?>