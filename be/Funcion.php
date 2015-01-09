<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

/**
 * Business Entity de PANTALLA
 *
 */
require_once("be/Auditoria.php");
require_once("be/Pantalla.php");
require_once 'be/Modulo.php';
require_once("be/BE_Utils.php");

class Funcion extends Auditoria {
	//ID
	private $ID;
	
	/**
	 * @return unknown
	 */
	public function get_muestraMenu() {
		return $this->_muestraMenu;
	}
	
	/**
	 * @param unknown_type $_muestraMenu
	 */
	public function set_muestraMenu($_muestraMenu) {
		$this->_muestraMenu = $_muestraMenu;
	}
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
			$this->assign($this->ID,$fields['id_funcion']);
			$this->assign($this->_descripcion,$fields['descripcion']);
			$this->assign($this->_valor,$fields['valor']);
			$this->assign($this->_muestraMenu,$fields['muestra_menu']);
			
			if (isset($fields['id_modulo'])) {
				$this->_oModulo = new Modulo();
				$this->_oModulo->setID($fields['id_modulo']);
			}
		}		
	}
	
	public function to_array() {
		$row = parent::to_array();
		$this->assign($row['id_funcion'], $this->ID);
		$this->assign($row['descripcion'], $this->_descripcion);
		$this->assign($row['valor'], $this->_valor);
		$this->assign($row['muestra_menu'], $this->_muestraMenu);
		
		if (isset($this->_oModulo)) {
			$this->assign($row['id_modulo'], $this->_oModulo->getID());
		}
		
		return $row;
	}
	//CAMPOS
	private $_descripcion;
	private $_valor;
	
	private $_oModulo;
	
	public function getModulo() {
		return $this->_oModulo;
	}
	
	public function setModulo(Modulo $oModulo) {
		$this->_oModulo = $oModulo;
	}
	
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
	
	//LINKS
	//pantallas
	private $_muestraMenu;
	
	private $_aPantallas = array();
	public function getPantallas() { return $this->_aPantallas; }
	
	public function addPantalla(Pantalla $oPantalla) {
		$a = new Auditoria();
		BE_Utils::add($oPantalla, $this->_aPantallas, 'pantalla', $a);
	}
	
	public function setLink(Pantalla $oPantalla, Auditoria $oAuditoria, $field_id) {
		BE_Utils::add($oPantalla, $this->_aPantallas, $field_id, $oAuditoria);
	}
	
	public function removePantalla($id) {
		BE_Utils::remove($id, $this->_aPantallas, 'pantalla');
	}
	
	public function activatePantalla($id) {
		BE_Utils::activate($id, $this->_aPantallas, 'pantalla');
	}
	
	public function mapPantallas() {
		$a = array();
		foreach ($this->_aPantallas as $p) {
			$b = $p['auditoria']->to_array();
			$b['id_funcion'] = $this->ID;
			$b['id_pantalla'] = $p['pantalla']->getID(); 
			$a[] = $b;
		}
		return $a;
	}
}
?>