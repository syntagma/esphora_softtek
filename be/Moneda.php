<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');

class Moneda extends Auditoria {
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
			$this->assign($this->ID,$fields['id_moneda']);
			$this->assign($this->_codigo,$fields['codigo']);
			$this->assign($this->_descripcion,$fields['descripcion']);
			$this->assign($this->_codigoMonedaAfip,$fields['codigo_moneda_afip']);
		}		
	}
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID != null) $this->assign($row['id_moneda'], $this->ID);
		if ($this->numero!= null) $this->assign($row['codigo'], $this->_codigo);
		if ($this->_factura_electronica != null) $this->assign($row['descripcion'], $this->_descripcion);
		if ($this->_idEmpresa != null) $this->assign($row['codigo_moneda_afip'], $this->_codigoMonedaAfip);		
		return $row;
	}
	
	//CAMPOS
	private $_codigo;
	private $_descripcion;
	private $_codigoMonedaAfip;
	
	/**
	 * @return unknown
	 */
	public function get_codigo() {
		return $this->_codigo;
	}
	
	/**
	 * @return unknown
	 */
	public function get_codigoMonedaAfip() {
		return $this->_codigoMonedaAfip;
	}
	
	/**
	 * @return unknown
	 */
	public function get_descripcion() {
		return $this->_descripcion;
	}
	
	/**
	 * @param unknown_type $_codigo
	 */
	public function set_codigo($_codigo) {
		$this->_codigo = $_codigo;
	}
	
	/**
	 * @param unknown_type $_codigoMonedaAfip
	 */
	public function set_codigoMonedaAfip($_codigoMonedaAfip) {
		$this->_codigoMonedaAfip = $_codigoMonedaAfip;
	}
	
	/**
	 * @param unknown_type $_descripcion
	 */
	public function set_descripcion($_descripcion) {
		$this->_descripcion = $_descripcion;
	}
}
?>