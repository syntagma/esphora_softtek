<?php
require_once 'be/Usuario.php';
require_once 'dal/UsuarioFacade.php';
require_once "bc/ABMCtrl.php";


class ABMUsuarioCtrl extends ABMCtrl {
	function __construct() {
		$this->_facade = new UsuarioFacade();
		$this->_idName = "id_usuario";
		$this->_order = "login";
		$this->_filtroValido = "U.activo = 'S'";
	}
	
	function serverValidation($campos) {
		//print_r($campos);
		$ret = $this->_serverValidation("login", "id_usuario", $campos);
		
		if ($campos['id_usuario'] == "") {
			if ($campos['password'] == "") {
				$this->_errormsg .= "<br>".Translator::getTrans("PASSWORD_REQUIRED");
				$ret = false;
			}
		}
		
		return $ret;
	}
	
	function getMessage() {
		return $this->_errormsg;
	}
	
	function getListas($id = null) {
		//obtengo la lista de empresas
		$ef = new EmpresaFacade();
		$rows = $ef->fetchAllRows(true);
		
		$rf = new RolFacade();
		$roles = $rf->fetchAllRows(true);
		
		$a = array();
		$lista = array();
		
		$hija = true;
		
		$a['roles'] = array();
		
		foreach ($rows as $row) {
			$id_empresa = $row['id_empresa']; 
			$lista[$id_empresa] = array('desc' => $row['nombre'],
										'value' => $hija);
			$hija = false;
			
			//obtengo la lista de roles por empresa
			$listaroles = array();
			
			foreach($roles as $rol) {
				$listaroles[$rol['id_rol']] = array (	'key' 	=> $rol['id_rol']."_".$id_empresa, 
														'desc' 	=> $rol['descripcion'],
														'value' => false
				);
			}
			
			if ($id != null) {
				$rolesEmpresas = $this->_facade->fetchRolByEmpresa($id, $id_empresa);
				
				foreach($rolesEmpresas as $rolEmpresa) {
					$listaroles[$rolEmpresa['id_rol']]['value'] = true;
				}
			}
			
			$a['roles'][$id_empresa] = $listaroles;
		}
		
		$a['empresas'] = $lista;
		
		return $a;
	}
	
	function insert($campos) {
		$cmp = "funcion_";
		
		$campos_tabla['nombre'] = $campos['nombre'];
		$campos_tabla['apellido'] = $campos['apellido'];
		$campos_tabla['login'] = $campos['login'];
		
		if ($campos['password'] == "") {
			$campos_tabla['password'] = "";
		}
		else {
			$campos_tabla['password'] = md5($campos['password']);
		}
		
		$id = parent::insert($campos_tabla);
		
		foreach($campos as $key => $value) {
			if (substr($key,0,strlen($cmp)) == $cmp) {
				$a = split("_", substr($key,strlen($cmp)));
				
				$this->_facade->insertRolEmpresa($id, $value, $a[1]);
			}
		}
	}
	
	function update($campos) {
		$cmp = "funcion_";
		
		$campos_tabla['nombre'] = $campos['nombre'];
		$campos_tabla['apellido'] = $campos['apellido'];
		$campos_tabla['login'] = $campos['login'];
		
		$campos_tabla['id_usuario'] = $campos['id_usuario'];
		
		if ($campos['password'] != "")
			$campos_tabla['password'] = md5($campos['password']);
		
		parent::update($campos_tabla);
		
		$campos_lista = array();
		
		foreach($campos as $key => $value) {
			if (substr($key,0,strlen($cmp)) == $cmp) {
				$a = split("_", substr($key,strlen($cmp)));
				$campos_lista[] = array('id_rol' => $value, 'id_empresa' => $a[1]); 
			}
		}
		
		$this->_facade->updateRolEmpresa($campos['id_usuario'], $campos_lista);
		
	}
}

?>