<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once 'be/Registro.php';
require_once 'db/Registro_Table.php';

require_once 'dal/LoteFacade.php';
require_once 'dal/TipoMovimientoFacade.php';

class RegistroFacade extends TableFacade {
	function __construct() {
		$this->_table="Registro";
		$this->_idName="id_registro";
		parent::__construct ();
	
	}
	
	private function actualizaHijas(Registro &$oRegistro) {
		$f = new LoteFacade(); 
		$e = $oRegistro->getLote();
		if ($oRegistro->getLote()->getID() == null) {			
			$f->add($e);			
		}
		else {
			$f->modify($e);
		}
		$oRegistro->setLote($e);
		
		$f = new TipoMovimientoFacade();
		$e = $oRegistro->getTipoMovimiento();
		if ($oRegistro->getTipoMovimiento()->getID() == null) {			
			$f->add($e);			
		}
		else {
			$f->modify($e);
		}
		$oRegistro->setTipoMovimiento($e);
	}
	
	public function add(Registro &$oRegistro) {
		//si la tabla hija tiene id la inserto, si no, la modifico
		$this->actualizaHijas($oRegistro);
		parent::add($oRegistro);
	}
	
	public function modify(Registro &$oRegistro) {
		$this->actualizaHijas($oRegistro);
		parent::modify($oRegistro);
	}
	
	public function fetch($id) {
		$f = parent::fetch($id);
		
		//lleno las tablas hikas
		$facade1 = new TipoMovimientoFacade();
		$facade2 = new LoteFacade();
		
		$f->setTipoMovimiento($facade1->fetch($f->getTipoMovimiento()->getID()));
		$f->setLote($facade2->fetch($f->getLote()->getID()));
		
		return $f;
	
	}
	
	public function fetchAll() {
		$dataSet = parent::fetchAll();
		//lleno las pantallas de cada elemento
		$facade1 = new TipoMovimientoFacade();
		$facade2 = new LoteFacade();
		
		for ($i=0; $i < count($dataSet); $i++) {
			$dataSet[$i]->setTipoMovimiento($facade1->fetch($dataSet[$i]->getTipoMovimiento()->getID()));
			$dataSet[$i]->setLote($facade2->fetch($dataSet[$i]->getLote()->getID()));
		}	
		return $dataSet;
	} 
}

?>