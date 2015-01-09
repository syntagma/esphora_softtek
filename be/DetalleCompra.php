<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');

class DetalleCompra extends Auditoria {
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
			$this->assign($this->ID,$fields['id_detalle_compra']);
			$this->assign($this->_cantidad,$fields['cantidad']);
			$this->assign($this->_concepto,$fields['concepto']);
			$this->assign($this->_idAalicuotaIva,$fields['id_alicuota_iva']);
			$this->assign($this->_idCompra,$fields['idcompra']);
			$this->assign($this->_precioUnitario,$fields['precio_unitario']);
			$this->assign($this->_idUnidadMedida,$fields['id_unidad_medida']);
		}		
	}
	/**
	 * @return unknown
	 */
	public function get_cantidad() {
		return $this->_cantidad;
	}
	
	/**
	 * @return unknown
	 */
	public function get_concepto() {
		return $this->_concepto;
	}
	
	/**
	 * @return unknown
	 */
	public function get_idAalicuotaIva() {
		return $this->_idAalicuotaIva;
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
	public function get_precioUnitario() {
		return $this->_precioUnitario;
	}
	
	/**
	 * @param unknown_type $_cantidad
	 */
	public function set_cantidad($_cantidad) {
		$this->_cantidad = $_cantidad;
	}
	
	/**
	 * @param unknown_type $_concepto
	 */
	public function set_concepto($_concepto) {
		$this->_concepto = $_concepto;
	}
	
	/**
	 * @param unknown_type $_idAalicuotaIva
	 */
	public function set_idAalicuotaIva($_idAalicuotaIva) {
		$this->_idAalicuotaIva = $_idAalicuotaIva;
	}
	
	/**
	 * @param unknown_type $_idCompra
	 */
	public function set_idCompra($_idCompra) {
		$this->_idCompra = $_idCompra;
	}
	
	/**
	 * @param unknown_type $_precioUnitario
	 */
	public function set_precioUnitario($_precioUnitario) {
		$this->_precioUnitario = $_precioUnitario;
	}
	/**
	 * @return unknown
	 */
	public function get_idUnidadMedida() {
		return $this->_idUnidadMedida;
	}
	
	/**
	 * @param unknown_type $_idUnidadMedida
	 */
	public function set_idUnidadMedida($_idUnidadMedida) {
		$this->_idUnidadMedida = $_idUnidadMedida;
	}


	
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID !== null) $this->assign($row['id_detalle_compra'], $this->ID);
		if ($this->_concepto !== null) $this->assign($row['concepto'], $this->_concepto);
		if ($this->_cantidad !== null) $this->assign($row['cantidad'], $this->_cantidad);
		if ($this->_idAalicuotaIva !== null) $this->assign($row['id_alicuota_iva'], $this->_idAalicuotaIva);
		if ($this->_idCompra !== null) $this->assign($row['id_compra'], $this->_idCompra);
		if ($this->_precioUnitario !== null) $this->assign($row['precio_unitario'], $this->_precioUnitario);
		if ($this->_idUnidadMedida !== null) $this->assign($row['id_unidad_medida'], $this->_idUnidadMedida);
		return $row;
	}


	
	//CAMPOS
	private $_idCompra;
	private $_concepto;
	private $_cantidad;
	private $_precioUnitario;
	private $_idAalicuotaIva;
	private $_idUnidadMedida;
}
?>