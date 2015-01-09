<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

/**
 * Business Entity de PANTALLA
 *
 */
require_once("be/Auditoria.php");

class Pantalla extends Auditoria {
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
		parent::__construct();
	}
	
	//MAPEO
	public function map($fields) {
		if (is_array($fields)) {
			parent::map($fields);
			$this->assign($this->ID,$fields['id_pantalla']);
			$this->assign($this->_descripcion,$fields['descripcion']);
			$this->assign($this->_valor,$fields['valor']);			
		}		
	}
	public function to_array() {
		$row = parent::to_array();
		$this->assign($row['id_pantalla'], $this->ID);
		$this->assign($row['descripcion'], $this->_descripcion);
		$this->assign($row['valor'], $this->_valor);
		return $row;
	}
	//CAMPOS
	private $_descripcion;
	private $_valor;
	
	public function get_descripcion() {
		return $this->_descripcion;
	}
	
	public function get_valor() {
		return $this->_valor;
	}
	
	public function set_descripcion($_descripcion) {
		$this->_descripcion = $_descripcion;
	}
	
	public function set_valor($_valor) {
		$this->_valor = $_valor;
	}
}	
?>