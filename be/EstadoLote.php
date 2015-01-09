<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');

class EstadoLote extends Auditoria {
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
			$this->assign($this->ID,$fields['id_estado_lote']);
			$this->assign($this->_descripcion,$fields['descripcion']);
		}		
	}
	
	public function to_array() {
		$row = parent::to_array();
		$this->assign($row['id_estado_lote'], $this->ID);
		$this->assign($row['descripcion'], $this->_descripcion);
		
		return $row;
	}
	
	
	//CAMPOS
	private $_descripcion;
	
	public function get_descripcion() {
		return $this->_descripcion;
	}
	
	public function set_descripcion($_descripcion) {
		$this->_descripcion = $_descripcion;
	}

	
}

?>