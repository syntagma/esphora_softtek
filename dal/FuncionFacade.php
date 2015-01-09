<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once 'dal/TableFacade.php';
require_once("be/Funcion.php");
require_once("db/Funcion_Table.php");
require_once("db/Funcion_pantalla_Table.php");

require_once 'dal/PantallaFacade.php';
require_once 'dal/ModuloFacade.php';

class FuncionFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Funcion";
		$this->_idName="id_funcion";
		parent::__construct();
	}
	
	private function actualizaHijas(Funcion &$oFuncion) {
		$f = new ModuloFacade(); 
		$e = $oFuncion->getModulo();
		if ($e->getID() == null) {			
			$f->add($e);			
		}
		else {
			$f->modify($e);
		}
		$oFuncion->setModulo($e);
	}
	
	public function add(Funcion &$oFuncion) {
		$this->actualizaHijas($oFuncion);
		parent::add($oFuncion);
		
		//inserto las pantallas
		$rows = $oFuncion->mapPantallas();
		$this->modifyLink($rows, "Funcion_Pantalla", null);
	}
	
	public function modify(Funcion &$oFuncion) {
		$this->actualizaHijas($oFuncion);
		parent::modify($oFuncion);
		
		//modifico las pantallas
		$rows = $oFuncion->mapPantallas();
		$this->modifyLink($rows, "Funcion_Pantalla", array('id_funcion', 'id_pantalla'));
	}
	
	public function fetch($id) {
		$f = parent::fetch($id);
		
		//lleno las tablas hikas
		$facade = new ModuloFacade();
		$f->setModulo($facade->fetch($f->getModulo()->getID()));
		
		//lleno las pantallas
		$oPantallaFacade = new PantallaFacade();
		$this->fetchLinks("Funcion_Pantalla", "pantalla", $id, $oPantallaFacade, $f);
		return $f;
	}
	
	public function fetchAll() {
		$dataSet = parent::fetchAll();
		//lleno las pantallas de cada elemento
		$oPantallaFacade = new PantallaFacade();
		$facade = new ModuloFacade();
		for ($i=0; $i < count($dataSet); $i++) {
			$dataSet[$i]->setModulo($facade->fetch($dataSet[$i]->getModulo()->getID()));
			$this->fetchLinks("Funcion_Pantalla", "pantalla", $dataSet[$i]->getID(), $oPantallaFacade, $dataSet[$i]);
		}
		return $dataSet;
	}
}

?>