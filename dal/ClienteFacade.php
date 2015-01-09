<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once 'be/Cliente.php';
require_once 'db/Cliente_Table.php';

require_once 'dal/TipoDocumentoFacade.php';
require_once 'dal/PaisFacade.php';
require_once 'dal/ProvinciaFacade.php';

class ClienteFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Cliente";
		$this->_idName="id_cliente";
		parent::__construct ();
	
	}
	
private function actualizaHijas(Cliente  &$oCliente) {
		$f = new TipoDocumentoFacade(); 
		$e = $oCliente->getTipoDocumento();
		if ($e != null) {
			if ($oCliente->getTipoDocumento()->getID() == null) {			
				$f->add($e);			
			}
			else {
				$f->modify($e);
			}
			$oCliente->setTipoDocumento($e);
		}
	}
	
	public function add(Cliente &$oCliente) {
		//si la tabla hija tiene id la inserto, si no, la modifico
		$this->actualizaHijas($oCliente);
		parent::add($oCliente);
	}
	
	public function modify(Cliente &$oCliente) {
		$this->actualizaHijas($oCliente);
		parent::modify($oCliente);
	}
	
	public function fetch($id) {
		$f = parent::fetch($id);
		
		//seteo pais y provincia del domicilio
		$paisFacade = new PaisFacade();
		$provinciaFacade = new ProvinciaFacade();
		$f->getDomicilio()->setPais($paisFacade->fetch($f->getDomicilio()->getPais()->getID()));
		$f->getDomicilio()->setProvincia($provinciaFacade->fetch($f->getDomicilio()->getProvincia()->getID()));
		
		//lleno las tablas hikas
		$facade = new TipoDocumentoFacade();
		$f->setTipoDocumento($facade->fetch($f->getTipoDocumento()->getID()));
		return $f;
	}
	
	public function fetchAll() {
		$dataSet = parent::fetchAll();
		//lleno las pantallas de cada elemento
		$facade = new TipoDocumentoFacade();
		$paisFacade = new PaisFacade();
		$provinciaFacade = new ProvinciaFacade();
		
		for ($i=0; $i < count($dataSet); $i++) {
			$dataSet[$i]->setTipoDocumento($facade->fetch($dataSet[$i]->getTipoDocumento()->getID()));
			$dataSet[$i]->getDomicilio()->setPais($paisFacade->fetch($dataSet[$i]->getDomicilio()->getPais()->getID()));
			$dataSet[$i]->getDomicilio()->setProvincia($provinciaFacade->fetch($dataSet[$i]->getDomicilio()->getProvincia()->getID()));
		}
		return $dataSet;
	}
	
public function fetchSelectList($filtro=null) {
		if ($filtro != null) 
			$filter = "c.razon_social like '%$filtro%'";
		else 
			$filter = null;
			
		return parent::fetchSelectList($filter);
	}
}

?>