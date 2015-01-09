<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

class Auditoria {
	/**
	 * @return unknown
	 */
	public function get_activo() {
		if ($this->_activo == "S")
			return true;
		else
			return false;			
	}
	
	/**
	 * @return unknown
	 */
	public function get_fechaCreacion() {
		return $this->_fechaCreacion;
	}
	
	/**
	 * @return unknown
	 */
	public function get_fechaUltimaModificacion() {
		return $this->_fechaUltimaModificacion;
	}
	
	/**
	 * @return unknown
	 */
	public function get_usuarioCreacion() {
		return $this->_usuarioCreacion;
	}
	
	/**
	 * @return unknown
	 */
	public function get_usuarioUltimaModificacion() {
		return $this->_usuarioUltimaModificacion;
	}
	
	/**
	 * @param unknown_type $_activo
	 */
	public function set_activo($_activo) {
		if ($_activo)
			$this->_activo = 'S';
		else
			$this->_activo = 'N';
	}
	
	/**
	 * @param unknown_type $_fechaCreacion
	 */
	public function set_fechaCreacion($fecha = null) {
		if ($fecha == null)
			$this->_fechaCreacion = date('YmdHis');
		else

			$this->_fechaCreacion = $fecha;
	}
	
	/**
	 * @param unknown_type $_fechaUltimaModificacion
	 */
	public function set_fechaUltimaModificacion($fecha = null) {
		if ($fecha == null)
			$this->_fechaUltimaModificacion = date('YmdHis');
		else

			$this->_fechaCreacion = $fecha;
	}
	
	public function unset_fechaCreacion() {
		$this->_fechaCreacion = null;
	}
	
	public function unset_usuarioCreacion() {
		$this->_usuarioCreacion = null;
	}
	
	/**
	 * @param unknown_type $_usuarioCreacion
	 */
	public function set_usuarioCreacion() {
		if (isset($_SESSION['user'])) $this->_usuarioCreacion = $_SESSION['user']->getID();
	}
	
	/**
	 * @param unknown_type $_usuarioUltimaModificacion
	 */
	public function set_usuarioUltimaModificacion() {
		if (isset($_SESSION['user'])) $this->_usuarioUltimaModificacion = $_SESSION['user']->getID();
	}
	
	function __construct() {
		$this->set_activo(true);
		$this->set_fechaCreacion();
		$this->set_fechaUltimaModificacion();
		$this->set_usuarioCreacion();
		$this->set_usuarioUltimaModificacion();
	}
	
	public function map($fields) {
		if (is_array($fields)) {
			$this->assign($this->_fechaCreacion,$fields['fecha_creacion']);
			$this->assign($this->_fechaUltimaModificacion,$fields['fecha_ult_modificacion']);
			$this->assign($this->_usuarioCreacion,$fields['usr_creacion']);
			$this->assign($this->_usuarioUltimaModificacion,$fields['usr_ult_modificacion']);
			$this->assign($this->_activo,$fields['activo']);
		}
	}
	
	public function to_array() {
		//TODO: Hacerlo en todas las entidades
		$row = array ();
		if ($this->_fechaCreacion !== null) $this->assign($row['fecha_creacion'], $this->_fechaCreacion);
		if ($this->_fechaUltimaModificacion !== null) $this->assign($row['fecha_ult_modificacion'], $this->_fechaUltimaModificacion);
		if ($this->_usuarioCreacion !== null) $this->assign($row['usr_creacion'], $this->_usuarioCreacion);
		if ($this->_usuarioUltimaModificacion !== null) $this->assign($row['usr_ult_modificacion'], $this->_usuarioUltimaModificacion);
		if ($this->_activo !== null) $this->assign($row['activo'], $this->_activo);
		return $row;
	}
	
	protected function assign(&$campo, $valor) {
		if ($valor !== null) 
			$campo = $valor;
	}

	private $_fechaUltimaModificacion;
	private $_fechaCreacion;
	private $_usuarioUltimaModificacion;
	private $_usuarioCreacion;
	private $_activo;
}
?>