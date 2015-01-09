<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');

class TipoComprobante extends Auditoria {
	//ID
	private $ID;
	
	/**
	 * @return unknown
	 */
	public function get_letra() {
		return $this->_letra;
	}
	
	/**
	 * @return unknown
	 */
	public function get_nombreCorto() {
		return $this->_nombreCorto;
	}
	
	/**
	 * @param unknown_type $_letra
	 */
	public function set_letra($_letra) {
		$this->_letra = $_letra;
	}
	
	/**
	 * @param unknown_type $_nombreCorto
	 */
	public function set_nombreCorto($_nombreCorto) {
		$this->_nombreCorto = $_nombreCorto;
	}
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
			$this->assign($this->ID,$fields['id_tipo_comprobante']);
			$this->assign($this->_descripcion,$fields['descripcion']);
			$this->assign($this->_codComprobante,$fields['cod_comprobante']);
			$this->assign($this->_nombreCorto,$fields['nombre_corto']);
			$this->assign($this->_letra,$fields['letra']);
		}		
	}
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID != null) $this->assign($row['id_tipo_comprobante'], $this->ID);
		if ($this->_descripcion != null) $this->assign($row['descripcion'], $this->_descripcion);
		if ($this->_codComprobante != null) $this->assign($row['cod_comprobante'], $this->_codComprobante);
		if ($this->_nombreCorto != null) $this->assign($row['nombre_corto'], $this->_nombreCorto);
		if ($this->_letra != null) $this->assign($row['letra'], $this->_letra);
		return $row;
	}
	
	//CAMPOS
	private $_descripcion;
	private $_codComprobante;
	private $_nombreCorto;
	private $_letra;
	
	public function get_codComprobante() {
		return $this->_codComprobante;
	}
	
	public function get_descripcion() {
		return $this->_descripcion;
	}
	
	public function set_codComprobante($_codComprobante) {
		$this->_codComprobante = $_codComprobante;
	}
	
	public function set_descripcion($_descripcion) {
		$this->_descripcion = $_descripcion;
	}
}

?>