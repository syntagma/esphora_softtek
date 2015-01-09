<?php

require_once ('be/Auditoria.php');
require_once ('be/Funcion.php');
require_once ('be/Empresa.php');

class Usuario extends Auditoria {
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
			$this->assign($this->ID,$fields['id_usuario']);
			$this->assign($this->_nombre,$fields['nombre']);
			$this->assign($this->_apellido,$fields['apellido']);
			$this->assign($this->_login,$fields['login']);
			$this->assign($this->_password,$fields['password']);
			
		}		
	}
	
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID != null) $this->assign($row['id_usuario'],$this->ID);
		if ($this->_nombre != null) $this->assign($row['nombre'], $this->_nombre);
		if ($this->_apellido != null) $this->assign($row['apellido'], $this->_apellido);
		if ($this->_login != null) $this->assign($row['login'], $this->_login);
		if ($this->_password != null) $this->assign($row['password'], $this->_password);
		
		return $row;
	}
	
	//CAMPOS
	private $_nombre;
	private $_apellido;
	private $_login;
	private $_password;
	
	
	public function get_apellido() {
		return $this->_apellido;
	}
	
	public function get_login() {
		return $this->_login;
	}
	
	public function get_nombre() {
		return $this->_nombre;
	}
	
	public function get_password() {
		return $this->_password;
	}
	
	public function set_apellido($_apellido) {
		$this->_apellido = $_apellido;
	}
	
	public function set_login($_login) {
		$this->_login = $_login;
	}
	
	public function set_nombre($_nombre) {
		$this->_nombre = $_nombre;
	}
	
	public function set_password($_password) {
		$this->_password = $_password;
	}

	//LINKS
	//rol_empresas
	private $_aRolEmpresa = array();
	public function getRolEmpresa() { return $this->_aRolEmpresa; }
	
	public function addRolEmpresa(Rol $oRol, Empresa $oEmpresa) {
		foreach ($this->_aRolEmpresa as $e) {
			if ($oRol->getID() == $e['rol']->getID() && $oEmpresa->getID() == $e['empresa']->getID()) {
				throw new Exception("El elemento ya existe para la entidad");			
			}
		}
		
		$a = new Auditoria();		
		$this->_aRolEmpresa[] = array (
											'rol' => $oRol,
											'empresa' => $oEmpresa,
											'auditoria' => $a
		);
	}
	
	public function setRolEmpresa(Rol $oRol, Empresa $oEmpresa, Auditoria $oAuditoria) {
		foreach ($this->_aRolEmpresa as $e) {
			if ($oRol->getID() == $e['rol']->getID() and $oEmpresa->getID() == $e['empresa']->getID()) {
				throw new Exception("El elemento ya existe para la entidad");			
			}
		}
				
		$this->_aRolEmpresa[] = array (
											'rol' => $oRol,
											'empresa' => $oEmpresa,
											'auditoria' => $oAuditoria
		);
	}
	
	public function removeRolEmpresa($idRol, $idEmpresa) {
		$actualizada = false;
		for ($i = 0; $i < count($this->_aRolEmpresa); $i++) {
			if ($this->_aRolEmpresa[$i]['rol']->getID() == $idRol and $this->_aRolEmpresa[$i]['empresa']->getID() == $idEmpresa) {
				if ($this->_aRolEmpresa[$i]['auditoria']->getActivo()) {
					$this->_aRolEmpresa[$i]['auditoria']->setActivo(false);
					$actualizada = true;
				}
				else {
					throw new Exception("Esta relacion ya esta desactivada");
				}
			}
		}
		if (!$actualizada) {
			throw new Exception("No existe la relacion");
		}
	}
	
	public function activatePantalla($idRol, $idEmpresa) {
	$actualizada = false;
		for ($i = 0; $i < count($this->_aRolEmpresa); $i++) {
			if ($this->_aRolEmpresa[$i]['rol']->getID() == $idRol and $this->_aRolEmpresa[$i]['empresa']->getID() == $idEmpresa) {
				if (!$this->_aRolEmpresa[$i]['auditoria']->getActivo()) {
					$this->_aRolEmpresa[$i]['auditoria']->setActivo(true);
					$actualizada = true;
				}
				else {
					throw new Exception("Esta relacion ya esta activada");
				}
			}
		}
		if (!$actualizada) {
			throw new Exception("No existe la relacion");
		}
	}
	
	public function mapRolEmpresa() {
		$a = array();
		foreach ($this->_aRolEmpresa as $p) {
			$b = $p['auditoria']->to_array();
			$b['id_usuario'] = $this->ID;
			$b['id_empresa'] = $p['empresa']->getID();
			$b['id_rol'] = $p['rol']->getID(); 
			$a[] = $b;
		}
		return $a;
	}
	
}

?>