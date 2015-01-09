<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');

class AlicuotaIva extends Auditoria {
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
			$this->assign($this->ID,$fields['id_alicuota_iva']);
			$this->assign($this->_descripcion,$fields['descripcion']);
			$this->assign($this->_porcentaje,$fields['porcentaje']);
		}		
	}
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID != null) $this->assign($row['id_alicuota_iva'], $this->ID);
		if ($this->numero!= null) $this->assign($row['descripcion'], $this->_descripcion);
		if ($this->_factura_electronica != null) $this->assign($row['porcentaje'], $this->_porcentaje);		
		return $row;
	}

	//CAMPOS
	private $_descripcion;
	private $_porcentaje;
	
	/**
	 * @return unknown
	 */
	public function get_descripcion() {
		return $this->_descripcion;
	}
	
	/**
	 * @return unknown
	 */
	public function get_porcentaje() {
		return $this->_porcentaje;
	}
	
	/**
	 * @param unknown_type $_descripcion
	 */
	public function set_descripcion($_descripcion) {
		$this->_descripcion = $_descripcion;
	}
	
	/**
	 * @param unknown_type $_porcentaje
	 */
	public function set_porcentaje($_porcentaje) {
		$this->_porcentaje = $_porcentaje;
	}
}

?>