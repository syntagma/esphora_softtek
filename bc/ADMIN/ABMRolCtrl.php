<?php
require_once 'be/Rol.php';
require_once 'dal/RolFacade.php';
require_once 'dal/ModuloFacade.php';
require_once "bc/ABMCtrl.php";

class ABMRolCtrl extends ABMCtrl {
	function __construct() {
		$this->_facade = new RolFacade();
		$this->_idName = "id_rol";
	}
	
	function serverValidation($campos) {
		return $this->_serverValidation("descripcion", "id_rol", $campos);
	}
	
	function getMessage() {
		return $this->_errormsg;
	}
	
	function getListas($id = null) {
		//devolver todas las funciones con el check vacio
		$ff = new FuncionFacade();
		
		return $this->_getListas($id, 'id_funcion', 'descripcion', 'valor', 'lista_funciones', $ff, "id_modulo", new ModuloFacade(), "id_modulo", "nombre");
		
	}
	
	function insert($campos) {
		$cmp = "funcion_";
		
		$campos_tabla['descripcion'] = $campos['descripcion'];
		$id = parent::insert($campos_tabla);
		
		$campos_lista = array();
		
		foreach($campos as $key => $value) {
			if (substr($key,0,strlen($cmp)) == $cmp) {
				$campos_lista[] = $value; 
			}
		}
		
		$this->_facade->insertTablaLista($campos_lista, $id);
		
	}
	
	function update($campos) {
		$cmp = "funcion_";
		
		$campos_tabla['descripcion'] = $campos['descripcion'];
		$campos_tabla['id_rol'] = $campos['id_rol'];
		parent::update($campos_tabla);
		
		$campos_lista = array();
		
		foreach($campos as $key => $value) {
			if (substr($key,0,strlen($cmp)) == $cmp) {
				$campos_lista[] = $value; 
			}
		}
		
		$this->_facade->updateTablaLista($campos_lista, $campos['id_rol']);
		
	}
	
	public function getNombresListas() {
		return array('lista_funciones');
	}
}

?>