<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');

class DetalleFactura extends Auditoria {
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
			$this->assign($this->ID,$fields['id_detalle_factura']);
			$this->assign($this->_cantidad,$fields['cantidad']);
			$this->assign($this->_concepto,$fields['concepto']);
			$this->assign($this->_id_alicuota_iva,$fields['id_alicuota_iva']);
			$this->assign($this->_id_factura,$fields['id_factura']);
			$this->assign($this->_precio_unitario,$fields['precio_unitario']);
		}		
	}
	
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID != null) $this->assign($row['id_detalle_factura'], $this->ID);
		if ($this->_concepto != null) $this->assign($row['concepto'], $this->_concepto);
		if ($this->_cantidad != null) $this->assign($row['cantidad'], $this->_cantidad);
		if ($this->_id_alicuota_iva != null) $this->assign($row['id_alicuota_iva'], $this->_id_alicuota_iva);
		if ($this->_id_factura != null) $this->assign($row['id_factura'], $this->_id_factura);
		if ($this->_precio_unitario != null) $this->assign($row['precio_unitario'], $this->_precio_unitario);
		
		return $row;
	}
/**
	 * @return unknown
	 */
	public function get_cantidad () { return $this->_cantidad; }

/**
	 * @return unknown
	 */
	public function get_concepto () { return $this->_concepto; }

/**
	 * @return unknown
	 */
	public function get_id_alicuota_iva () { return $this->_id_alicuota_iva; }

/**
	 * @return unknown
	 */
	public function get_id_factura () { return $this->_id_factura; }

/**
	 * @return unknown
	 */
	public function get_precio_unitario () { return $this->_precio_unitario; }

/**
	 * @param unknown_type $_cantidad
	 */
	public function set_cantidad ($_cantidad) { $this->_cantidad = $_cantidad; }

/**
	 * @param unknown_type $_concepto
	 */
	public function set_concepto ($_concepto) { $this->_concepto = $_concepto; }

/**
	 * @param unknown_type $_id_alicuota_iva
	 */
	public function set_id_alicuota_iva ($_id_alicuota_iva) { $this->_id_alicuota_iva = $_id_alicuota_iva; }

/**
	 * @param unknown_type $_id_factura
	 */
	public function set_id_factura ($_id_factura) { $this->_id_factura = $_id_factura; }

/**
	 * @param unknown_type $_precio_unitario
	 */
	public function set_precio_unitario ($_precio_unitario) { $this->_precio_unitario = $_precio_unitario; }

	
	//CAMPOS
	private $_id_factura;
	private $_concepto;
	private $_cantidad;
	private $_precio_unitario;
	private $_id_alicuota_iva;
}
?>