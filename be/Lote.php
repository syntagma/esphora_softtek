<?php

require_once ('be/Auditoria.php');
require_once ('be/Factura.php');
require_once 'be/EstadoLote.php';

class Lote extends Auditoria {
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
			$this->assign($this->ID,$fields['id_lote']);
			$this->assign($this->_fecha,$fields['fecha']);
		}		
	}
	public function to_array() {
		$row = parent::to_array();
		$this->assign($row['id_lote'], $this->ID);
		$this->assign($row['fecha'], $this->_fecha);
		return $row;
	}
	
	//CAMPOS
	private $_fecha;
	private $_oEstadoLote;
	
	public function getEstadoLote() {
		return $this->_oEstadoLote;
	}
	
	public function setEstadoLote(EstadoLote $oEstadoLote) {
		$this->_oEstadoLote = $oEstadoLote; 
	}
	
	public function get_fecha() {
		return $this->_fecha;
	}
	
	public function set_fecha($_fecha) {
		$this->_fecha = $_fecha;
	}
	
	//LINKS
	//array de funciones
	private $_aFacturas = array();
	public function getFacturas() { return $this->_aFacturas; }
	
	public function addFactura(Factura $oFactura) {
		$a = new Auditoria();
		BE_Utils::add($oFactura, $this->_aFactura, 'factura', $a);
	}
	
	public function setLink(Factura $oFactura, Auditoria $oAuditoria, $field_id) {
		BE_Utils::add($oFactura, $this->_aFacturas, $field_id, $oAuditoria);
	}
	
	public function removePantalla($id) {
		BE_Utils::remove($id, $this->_aFactura, 'factura');
	}
	
	public function activatePantalla($id) {
		BE_Utils::activate($id, $this->_aFacturas, 'factura');
	}
	
	public function mapFacturas() {
		$a = array();
		foreach ($this->_aFacturas as $p) {
			$b = $p['auditoria']->to_array();
			$b['id_lote'] = $this->ID;
			$b['id_factura'] = $p['factura']->getID(); 
			$a[] = $b;
		}
		return $a;
	}
	
}

?>