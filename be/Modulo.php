<?php

require_once ('be/Auditoria.php');

class Modulo extends Auditoria {
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
		parent::__construct ();
	
	}
	
	//MAPEO
	public function map($fields) {
		if (is_array($fields)) {
			parent::map($fields);
			$this->assign($this->ID,$fields['id_modulo']);
			$this->assign($this->_nombre,$fields['nombre']);
			$this->assign($this->_nombreCorto,$fields['nombre_corto']);
		}		
	}
	public function to_array() {
		$row = parent::to_array();
		$this->assign($row['id_modulo'], $this->ID);
		$this->assign($row['nombre'], $this->_nombre);
		$this->assign($row['nombre_corto'], $this->_nombreCorto);
		return $row;
	}
	
	//CAMPOS
	private $_nombre;
	private $_nombreCorto;
	
	public function get_nombre() {
		return $this->_nombre;
	}
	
	public function get_nombreCorto() {
		return $this->_nombreCorto;
	}
	
	public function set_nombre($_nombre) {
		$this->_nombre = $_nombre;
	}
	
	public function set_nombreCorto($_nombre_corto) {
		$this->_nombreCorto = $_nombre_corto;
	}
}

?>