<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');

class CondicionIva extends Auditoria {
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
			$this->assign($this->ID,$fields['id_condicion_iva']);
			$this->assign($this->_descripcion,$fields['descripcion']);
			$this->assign($this->_descripcion,$fields['codigo_afip']);
		}		
	}
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID != null) $this->assign($row['id_condicion_iva'], $this->ID);
		if ($this->_descripcion!= null) $this->assign($row['descripcion'], $this->_descripcion);
		if ($this->_descripcion!= null) $this->assign($row['codigo_afip'], $this->_codigo_afip);
		return $row;
	}
	//CAMPOS
	private $_descripcion;
	private $_codigo_afip;
	
	public function get_descripcion() {
		return $this->_descripcion;
	}
		
	public function set_descripcion($_descripcion) {
		$this->_descripcion = $_descripcion;
	}
	/**
	 * @return unknown
	 */
	public function get_codigo_afip() {
		return $this->_codigo_afip;
	}
	
	/**
	 * @param unknown_type $_codigo_afip
	 */
	public function set_codigo_afip($_codigo_afip) {
		$this->_codigo_afip = $_codigo_afip;
	}


}

?>