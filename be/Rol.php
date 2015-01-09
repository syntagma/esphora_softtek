<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

/**
 * Business Entity de ROL
 *
 */
require_once("be/Auditoria.php");
require_once("be/Funcion.php");

class Rol extends Auditoria {
	//ID
	private $ID;
	public function setID($ID) {
		$this->ID = $ID;
	}
	public function getID() {
		return $this->ID;
	}
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct();
	}
	
	//MAPEO
	public function map($fields) {
		if (is_array($fields)) {
			parent::map($fields);
			$this->assign($this->ID,$fields['id_rol']);
			$this->assign($this->_descripcion,$fields['descripcion']);
		}		
	}
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID != null) $this->assign($row['id_rol'], $this->ID);
		if ($this->_descripcion != null) $this->assign($row['descripcion'], $this->_descripcion);
		return $row;
	}
	//CAMPOS
	private $_descripcion;
	
	public function get_descripcion() {
		return $this->_descripcion;
	}
	
	public function set_descripcion($sDescripcion) {
		$this->_descripcion = $sDescripcion;
	}
	
	//LINKS
	//array de funciones
	private $_aFunciones = array();
	public function getFunciones() { return $this->_aFunciones; }
	
	public function addFuncion(Funcion $oFuncion) {
		$a = new Auditoria();
		BE_Utils::add($oFuncion, $this->_aFunciones, 'funcion', $a);
	}
	
	public function setLink(Funcion $oFuncion, Auditoria $oAuditoria, $field_id) {
		BE_Utils::add($oFuncion, $this->_aFunciones, $field_id, $oAuditoria);
	}
	
	public function removePantalla($id) {
		BE_Utils::remove($id, $this->_aFunciones, 'funcion');
	}
	
	public function activatePantalla($id) {
		BE_Utils::activate($id, $this->_aFunciones, 'funcion');
	}
	
	public function mapFunciones() {
		$a = array();
		foreach ($this->_aFunciones as $p) {
			$b = $p['auditoria']->to_array();
			$b['id_rol'] = $this->ID;
			$b['id_funcion'] = $p['funcion']->getID(); 
			$a[] = $b;
		}
		return $a;
	}
	
}

?>