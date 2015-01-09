<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');

class TicketAcceso extends Auditoria {
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
	
	//MAPEO (No se si va a andar)
	public function map($fields) {
		if (is_array($fields)) {
			parent::map($fields);
			$this->assign($this->ID,$fields['id_ticket_Acceso']);
			$this->assign($this->_source,$fields['source']);
			$this->assign($this->_destination,$fields['destination']);
			$this->assign($this->_uniqueId,$fields['uniqueId']);
			$this->assign($this->_generationTime,$fields['generationTime']);
			$this->assign($this->_expirationTime,$fields['expirationTime']);
			$this->assign($this->_token,$fields['token']);
			$this->assign($this->_sign,$fields['sign']);
	
		}		
	}
	
	
	//CAMPOS
	private $_source;
	private $_destination;
	private $_uniqueId;
	private $_generationTime;
	private $_expirationTime;
	private $_token;
	private $_sign;
	
	public function get_source() {
		return $this->_source;
	}
	
	public function get_destination() {
		return $this->_destination;
	}
	
	public function get_uniqueId() {
		return $this->_uniqueId;
	}
	
	public function get_generationTime() {
		return $this->_generationTime;
	}
	
	public function get_expirationTime() {
		return $this->_expirationTime;
	}
	
	public function get_token() {
		return $this->_token;
	}

	public function get_sign() {
		return $this->_sign;
	}
	
	public function set_source($_source) {
		$this->_source = $_source;
	}
	
	public function set_destination($_destination) {
		$this->_destination = $_destination;
	}
	
	public function set_uniqueId($_uniqueId) {
		$this->_uniqueId = $_uniqueId;
	}
	
	public function set_generationTime($_generationTime) {
		$this->_generationTime = $_generationTime;
	}
	
	public function set_expirationTime($_expirationTime) {
		$this->_expirationTime = $_expirationTime;
	}
	
	public function set_token($_token) {
		$this->_token = $_token;
	}
	
	public function set_sign($_sign) {
		$this->_sign = $_sign;
	}
	
}

?>