<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');

class DetallePercepcionesCompra extends Auditoria {
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
			$this->assign($this->ID,$fields['id_detalle_percepciones_compra']);
			$this->assign($this->_idCompra,$fields['id_compra']);
			$this->assign($this->_idRetencion,$fields['id_retencion']);
			$this->assign($this->_detalle,$fields['detalle']);
			$this->assign($this->_baseImponible,$fields['base_imponible']);
			$this->assign($this->_alicuota,$fields['alicuota']);
		}		
	}
	
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID !== null) $this->assign($row['id_detalle_percepciones_compra'], $this->ID);
		if ($this->_idCompra !== null) $this->assign($row['id_compra'], $this->_idCompra);
		if ($this->_idRetencion !== null) $this->assign($row['id_retencion'], $this->_idRetencion);
		if ($this->_detalle !== null) $this->assign($row['detalle'], $this->_detalle);
		if ($this->_baseImponible !== null) $this->assign($row['base_imponible'], $this->_baseImponible);
		if ($this->_alicuota !== null) $this->assign($row['alicuota'], $this->_alicuota);		
		return $row;
	}
	/**
	 * @return unknown
	 */
	public function get_alicuota() {
		return $this->_alicuota;
	}
	
	/**
	 * @return unknown
	 */
	public function get_baseImponible() {
		return $this->_baseImponible;
	}
	
	/**
	 * @return unknown
	 */
	public function get_detalle() {
		return $this->_detalle;
	}
	
	/**
	 * @return unknown
	 */
	public function get_idCompra() {
		return $this->_idCompra;
	}
	
	/**
	 * @return unknown
	 */
	public function get_idRetencion() {
		return $this->_idRetencion;
	}
	
	/**
	 * @param unknown_type $_alicuota
	 */
	public function set_alicuota($_alicuota) {
		$this->_alicuota = $_alicuota;
	}
	
	/**
	 * @param unknown_type $_baseImponible
	 */
	public function set_baseImponible($_baseImponible) {
		$this->_baseImponible = $_baseImponible;
	}
	
	/**
	 * @param unknown_type $_detalle
	 */
	public function set_detalle($_detalle) {
		$this->_detalle = $_detalle;
	}
	
	/**
	 * @param unknown_type $_idCompra
	 */
	public function set_idCompra($_idCompra) {
		$this->_idCompra = $_idCompra;
	}
	
	/**
	 * @param unknown_type $_idRetencion
	 */
	public function set_idRetencion($_idRetencion) {
		$this->_idRetencion = $_idRetencion;
	}

	
	private $_idCompra;
	private $_idRetencion;
	private $_detalle;
	private $_baseImponible;
	private $_alicuota;	
}
?>