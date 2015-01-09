<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");
	

require_once("be/Rol.php");
require_once("db/Rol_Table.php");
require_once("db/Rol_funcion_Table.php");
require_once 'dal/TableFacade.php';
require_once 'dal/FuncionFacade.php';

/**
 * Fachada para manejar la tabla de rol
 *
 */
class RolFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Rol";
		$this->_idName="id_rol";
		parent::__construct();
	}
	
	public function add(Rol &$oRol) {
		parent::add($oRol);
		
		//inserto las funciones
		$rows = $oRol->mapFunciones();
		$this->modifyLink($rows, "Rol_Funcion", null);
	}
	
	public function modify(Rol &$oRol) {
		parent::modify($oRol);
		
		//modifico las pantallas
		$rows = $oRol->mapFunciones();
		$this->modifyLink($rows, "Rol_Funcion", array('id_rol', 'id_funcion'));
	}
	
	public function fetch($id) {
		$f = parent::fetch($id);
		
		//lleno las pantallas
		$oFuncionFacade = new FuncionFacade();
		$this->fetchLinks("Rol_Funcion", "funcion", $id, $oFuncionFacade, $f);
		return $f;
	}
	
	public function fetchAll() {
		$dataSet = parent::fetchAll();

		//lleno las pantallas de cada elemento
		$oFuncionFacade = new FuncionFacade();
		for ($i=0; $i < count($dataSet); $i++) {
			$this->fetchLinks("Rol_Funcion", "funcion", $dataSet[$i]->getID(), $oFuncionFacade, $dataSet[$i]);
		}
		return $dataSet;
	}
	
	public function fetchTablaLista($id) {
		return $this->_fetchTablaLista($id, "Rol_Funcion");
	}
	
	public function insertTablaLista($lista, $id) {
		$this->_insertTablaLista($lista, $id, "Rol_Funcion", "id_funcion");
	}
	
	public function updateTablaLista($lista, $id) {
		$this->_updateTablaLista($lista, $id, "Rol_Funcion", "id_funcion");
	}
}

?>