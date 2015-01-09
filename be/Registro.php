<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');
require_once ('be/Lote.php');
require_once ('be/TipoMovimiento.php');

class Registro extends Auditoria {
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
			$this->assign($this->ID,$fields['id_registro']);
			$this->assign($this->_descripcion,$fields['descripcion']);
			
			if(isset($fields['id_tipo_movimiento'])) {
				$this->_oTipoMovimiento = new TipoMovimiento(); 
				$this->_oTipoMovimiento->setID($fields['id_tipo_movimiento']);
			}
			
			if(isset($fields['id_lote'])) {
				$this->_oLote = new Lote(); 
				$this->_oLote->setID($fields['id_lote']);
			}
		}
	}
	
	public function to_array() {
		$row = parent::to_array();
		$this->assign($row['id_registro'], $this->ID);
		$this->assign($row['descripcion'], $this->_descripcion);
		
		if (isset($this->_oTipoMovimiento))
			$this->assign($row['id_tipo_movimiento'], $this->_oTipoMovimiento->getID());
		
		if (isset($this->_oLote))
			$this->assign($row['id_lote'], $this->_oLote->getID());
		
		return $row;
	}
	
	//CAMPOS
	private $_descripcion;
	
	private $_oLote;
	private $_oTipoMovimiento;
	
	public function getLote() {return $this->_oLote;}
	public function getTipoMovimiento() {return $this->_oTipoMovimiento;}
	
	public function setLote(Lote $oLote) {$this->_oLote = $oLote;}
	public function setTipoMovimiento(TipoMovimiento $oTipoMovimiento) {$this->_oTipoMovimiento = $oTipoMovimiento;}

	public function get_descripcion () { return $this->_descripcion; }
	public function set_descripcion ($_descripcion) { $this->_descripcion = $_descripcion; }

}

?>