<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');

class PuntoVenta extends Auditoria {
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
			$this->assign($this->ID,$fields['id_punto_venta']);
			$this->assign($this->_numero,$fields['numero']);
			$this->assign($this->_tipoPtoVta,$fields['tipo_pto_vta']);
			$this->assign($this->_idEmpresa,$fields['id_empresa']);
		}		
	}
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID != null) $this->assign($row['id_punto_venta'], $this->ID);
		if ($this->numero!= null) $this->assign($row['numero'], $this->_numero);
		if ($this->_tipoPtoVta != null) $this->assign($row['tipo_pto_vta'], $this->_tipoPtoVta);
		if ($this->_idEmpresa != null) $this->assign($row['id_empresa'], $this->_idEmpresa);		
		return $row;
	}
	//CAMPOS
	private $_numero;
	private $_tipoPtoVta;
	private $_idEmpresa;
	
	public function get_numero() {
		return $this->_numero;
	}
		
	public function set_numero($_numero) {
		$this->_numero = $_numero;
	}
	
	public function get_tipoPtoVta() {
		return $this->_tipoPtoVta;
	}
	
	public function set_tipoPtoVta($_tipoPtoVta) {
		$this->_tipoPtoVta = $_tipoPtoVta;
	}

/**
	 * @return unknown
	 */
	public function get_idEmpresa() {
		return $this->_idEmpresa;
	}
	
	/**
	 * @param unknown_type $_idEmpresa
	 */
	public function set_idEmpresa($_idEmpresa) {
		$this->_idEmpresa = $_idEmpresa;
	}
}

?>