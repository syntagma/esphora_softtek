<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once 'be/Pais.php';
require_once 'be/Provincia.php';

class Domicilio {
	private $_calle;
	private $_numero;
	private $_piso;
	private $_departamento;
	private $_codigoPostal;
	
	private $_oProvincia;
	private $_oPais;
	
	public function get_calle() {
		return $this->_calle;
	}
	
	public function get_codigoPostal() {
		return $this->_codigoPostal;
	}
	
	public function get_departamento() {
		return $this->_departamento;
	}
	
	public function get_numero() {
		return $this->_numero;
	}
	
	public function getPais() {
		return $this->_oPais;
	}
	
	public function getProvincia() {
		return $this->_oProvincia;
	}
	
	public function get_piso() {
		return $this->_piso;
	}
	
	public function set_calle($_calle) {
		$this->_calle = $_calle;
	}
	
	public function set_codigoPostal($_codigoPostal) {
		$this->_codigoPostal = $_codigoPostal;
	}
	
	public function set_departamento($_departamento) {
		$this->_departamento = $_departamento;
	}
	
	public function set_numero($_numero) {
		$this->_numero = $_numero;
	}
	
	public function setPais(Pais $_oPais) {
		$this->_oPais = $_oPais;
	}
	
	public function setProvincia(Provincia $_oProvincia) {
		$this->_oProvincia = $_oProvincia;
	}
	
	public function set_piso($_piso) {
		$this->_piso = $_piso;
	}
	
	public function map($fields) {
		$this->assign($this->_calle,$fields['calle']);
		$this->assign($this->_numero,$fields['numero']);
		$this->assign($this->_piso,$fields['piso']);
		$this->assign($this->_departamento,$fields['departamento']);
		$this->assign($this->_codigoPostal,$fields['codigo_postal']);
		
		if (isset($fields['id_pais'])) {
			$this->_oPais = new Pais();
			$this->_oPais->setID($fields['id_pais']);
		}
		
		if (isset($fields['id_provincia'])) {
			$this->_oProvincia = new Provincia();
			$this->_oProvincia->setID($fields['id_provincia']);
		}
	}
	
	public function to_array() {
		$row = array();
		$this->assign($row['calle'], $this->_calle);
		$this->assign($row['numero'], $this->_numero);
		$this->assign($row['piso'], $this->_piso);
		$this->assign($row['departamento'], $this->_departamento);
		$this->assign($row['codigo_postal'], $this->_codigoPostal);
		
		if (isset($this->_oProvincia)) {
			$this->assign($row['id_provincia'], $this->_oProvincia->getID());
		}
		
		if (isset($this->_oPais)) {
			$this->assign($row['id_pais'], $this->_oPais->getID());
		}
		
	}
	
	private function assign(&$campo, $valor) {
		if ($valor != null) 
			$campo = $valor;
	}
}

?>