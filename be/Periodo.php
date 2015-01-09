<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');

class Periodo extends Auditoria {
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
			$this->assign($this->ID,$fields['id_periodo']);
			$this->assign($this->_nombre,$fields['nombre']);
			$this->assign($this->_fechaInicio,$fields['fecha_inicio']);
			$this->assign($this->_fechaFin,$fields['fecha_fin']);
			$this->assign($this->_estado,$fields['estado']);
			$this->assign($this->_idEmpresa,$fields['id_empresa']);
		}		
	}
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID != null) $this->assign($row['id_periodo'], $this->ID);
		if ($this->_descripcion!= null) $this->assign($row['nombre'], $this->_nombre);
		if ($this->_descripcion!= null) $this->assign($row['fecha_inicio'], $this->_fechaInicio);
		if ($this->_descripcion!= null) $this->assign($row['fecha_fin'], $this->_fechaFin);
		if ($this->_descripcion!= null) $this->assign($row['estado'], $this->_estado);
		if ($this->_descripcion!= null) $this->assign($row['id_empresa'], $this->_idEmpresa);
		return $row;
	}


	//CAMPOS
	private $_nombre;
	private $_fechaInicio;
	private $_fechaFin;
	private $_estado;
	private $_idEmpresa;
				

/**
	 * @return unknown
	 */
	public function get_estado() {
		return $this->_estado;
	}
	
	/**
	 * @return unknown
	 */
	public function get_fechaFin() {
		return $this->_fechaFin;
	}
	
	/**
	 * @return unknown
	 */
	public function get_fechaInicio() {
		return $this->_fechaInicio;
	}
	
	/**
	 * @return unknown
	 */
	public function get_nombre() {
		return $this->_nombre;
	}
	
	/**
	 * @param unknown_type $_estado
	 */
	public function set_estado($_estado) {
		$this->_estado = $_estado;
	}
	
	/**
	 * @param unknown_type $_fechaFin
	 */
	public function set_fechaFin($_fechaFin) {
		$this->_fechaFin = $_fechaFin;
	}
	
	/**
	 * @param unknown_type $_fechaInicio
	 */
	public function set_fechaInicio($_fechaInicio) {
		$this->_fechaInicio = $_fechaInicio;
	}
	
	/**
	 * @param unknown_type $_nombre
	 */
	public function set_nombre($_nombre) {
		$this->_nombre = $_nombre;
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