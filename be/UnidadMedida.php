<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');

class UnidadMedida extends Auditoria {
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
			$this->assign($this->ID,$fields['id_unidad_medida']);
			$this->assign($this->_descripcion,$fields['descripcion']);
			$this->assign($this->_codigoUnidadMedidaAfip,$fields['codigo_unidad_medida_afip']);
		}		
	}
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID != null) $this->assign($row['id_unidad_medida'], $this->ID);
		if ($this->_factura_electronica != null) $this->assign($row['descripcion'], $this->_descripcion);
		if ($this->_idEmpresa != null) $this->assign($row['codigo_unidad_medida_afip'], $this->_codigoMonedaAfip);		
		return $row;
	}
	
	//CAMPOS
	private $_descripcion;
	private $_codigoUnidadMedidaAfip;
	
	
	/**
	 * @return unknown
	 */
	public function get_codigoUnidadMedidaAfip() {
		return $this->_codigoUnidadMedidaAfip;
	}
	
	/**
	 * @return unknown
	 */
	public function get_descripcion() {
		return $this->_descripcion;
	}

	/**
	 * @param unknown_type $_codigoMonedaAfip
	 */
	public function set__codigoUnidadMedidaAfip($_codigoUnidadMedidaAfip) {
		$this->_codigoUnidadMedidaAfip = $_codigoUnidadMedidaAfip;
	}
	
	/**
	 * @param unknown_type $_descripcion
	 */
	public function set_descripcion($_descripcion) {
		$this->_descripcion = $_descripcion;
	}
}
?>