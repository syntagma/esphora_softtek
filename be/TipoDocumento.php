<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');

class TipoDocumento extends Auditoria {
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
			$this->assign($this->ID,$fields['id_tipo_documento']);
			$this->assign($this->_descripcion,$fields['descripcion']);
			$this->assign($this->_codDocAFIP,$fields['cod_doc_afip']);
		}		
	}
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID != null) $this->assign($row['id_tipo_documento'], $this->ID);
		if ($this->_descripcion!= null) $this->assign($row['descripcion'], $this->_descripcion);
		if ($this->_codDocAFIP != null) $this->assign($row['cod_doc_afip'], $this->_codDocAFIP);
		return $row;
	}
	//CAMPOS
	private $_descripcion;
	private $_codDocAFIP;
	
	public function get_descripcion() {
		return $this->_descripcion;
	}
		
	public function set_descripcion($_descripcion) {
		$this->_descripcion = $_descripcion;
	}
	public function get_codDocAFIP() {
		return $this->_codDocAFIP;
	}
	
	public function set_codDocAFIP($_codDocAFIP) {
		$this->_codDocAFIP = $_codDocAFIP;
	}

}

?>