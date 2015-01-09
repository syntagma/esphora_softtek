<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');

class DetallePercepcionesFactura extends Auditoria {
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
			$this->assign($this->ID,$fields['id_detalle_percepciones_factura']);
			$this->assign($this->_id_factura,$fields['id_factura']);
			$this->assign($this->_id_retencion,$fields['id_retencion']);
			$this->assign($this->_detalle,$fields['detalle']);
			$this->assign($this->_base_imponible,$fields['base_imponible']);
			$this->assign($this->_alicuota,$fields['alicuota']);
		}		
	}
	
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID != null) $this->assign($row['id_detalle_percepciones_factura'], $this->ID);
		if ($this->_id_factura != null) $this->assign($row['id_factura'], $this->_id_factura);
		if ($this->_id_retencion != null) $this->assign($row['id_retencion'], $this->_id_retencion);
		if ($this->_detalle != null) $this->assign($row['detalle'], $this->_detalle);
		if ($this->_base_imponible != null) $this->assign($row['base_imponible'], $this->_base_imponible);
		if ($this->_alicuota != null) $this->assign($row['alicuota'], $this->_alicuota);
		
		return $row;
	}
	
	private $_id_factura;
	private $_id_retencion;
	private $_detalle;
	private $_base_imponible;
	private $_alicuota;
	
	public function get_alicuota() {
		return $this->_alicuota;
	}
	
	public function get_base_imponible() {
		return $this->_base_imponible;
	}
	
	public function get_detalle() {
		return $this->_detalle;
	}
	
	public function get_id_factura() {
		return $this->_id_factura;
	}
	
	public function get_id_retencion() {
		return $this->_id_retencion;
	}
	
	public function set_alicuota($_alicuota) {
		$this->_alicuota = $_alicuota;
	}
	
	public function set_base_imponible($_base_imponible) {
		$this->_base_imponible = $_base_imponible;
	}
	
	public function set_detalle($_detalle) {
		$this->_detalle = $_detalle;
	}
	
	public function set_id_factura($_id_factura) {
		$this->_id_factura = $_id_factura;
	}
	
	public function set_id_retencion($_id_retencion) {
		$this->_id_retencion = $_id_retencion;
	}

	
}
?>