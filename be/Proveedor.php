<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');
require_once ('be/TipoDocumento.php');
require_once ('be/Domicilio.php');

class Proveedor extends Auditoria {
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
			$this->assign($this->ID,$fields['id_proveedor']);
			$this->assign($this->_nroDocumento,$fields['nro_documento']);
			$this->assign($this->_razonSocial,$fields['razon_social']);
			$this->assign($this->_email,$fields['email']);
			
			if (isset($fields['telefono'])) {
				$this->_oTelefono = new Telefono();
				$this->_oTelefono->set_telefono($fields['telefono']);
			}
			
			$this->_oDomicilio = new Domicilio();
			$this->_oDomicilio->map($fields);
			
			if(isset($fields['id_tipo_documento'])) {
				$this->_oTipoDocumento = new TipoDocumento(); 
				$this->_oTipoDocumento->setID($fields['id_tipo_documento']);
			}
		}		
	}
	
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID != null) $this->assign($row['id_proveedor'], $this->ID);
		if ($this->_nroDocumento != null) $this->assign($row['nro_documento'], $this->_nroDocumento);
		if ($this->_razonSocial != null) $this->assign($row['razon_social'], $this->_razonSocial);
		if ($this->_email != null) $this->assign($row['email'], $this->_email);
		
		if(isset($this->_oTelefono)) {
			$this->assign($row['telefono'], $this->_oTelefono->get_telefono());
		}
		
		
		if (isset($this->_oDomicilio)) {
			foreach ($this->_oDomicilio->to_array() as $key => $value) {
				$row[$key] = $value;
			}
		}
		
		if (isset($this->_oTipoDocumento))
			$row['id_tipo_documento'] = $this->_oTipoDocumento->getID();
		return $row;
	}
	
	//CAMPOS
	private $_oTipoDocumento;
	private $_razonSocial;
	private $_nroDocumento;
	private $_email;
	private $_oDomicilio;
	private $_oTelefono;
	
	public function getTelefono() {
		return $this->_oTelefono;
	}
	
	public function setTelefono(Telefono $oTelefono) {
		$this->_oTelefono = $oTelefono;
	}
	
	public function getDomicilio() {
		return $this->_oDomicilio;
	}
	
	public function set_Domicilio(Domicilio $oDomicilio) {
		$this->_oDomicilio = $oDomicilio;
	}
	
	public function getTipoDocumento() {
		return $this->_oTipoDocumento;
	}
	
	public function setTipoDocumento(TipoDocumento $oTipoDocumento) {
		$this->_oTipoDocumento = $oTipoDocumento;
	}
	
	
	public function get_email() {
		return $this->_email;
	}
	
	public function get_nroDocumento() {
		return $this->_nroDocumento;
	}
	
	
	public function get_razonSocial() {
		return $this->_razonSocial;
	}
	
	
	public function set_email($_email) {
		$this->_email = $_email;
	}
	
	
	public function set_nroDocumento($_nroDocumento) {
		$this->_nroDocumento = $_nroDocumento;
	}
	
	public function set_razonSocial($_razonSocial) {
		$this->_razonSocial = $_razonSocial;
	}
}

?>