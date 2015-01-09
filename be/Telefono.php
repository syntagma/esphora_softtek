<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

class Telefono {
	private $_telefono;
	
	public function get_telefono() {
		return $this->_telefono;
	}
	
	public function set_telefono($_telefono) {
		$this->_telefono = $_telefono;
	}
}

?>