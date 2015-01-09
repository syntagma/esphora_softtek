<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once 'be/Proveedor.php';
require_once 'db/Proveedor_Table.php';

require_once 'dal/TipoDocumentoFacade.php';
require_once 'dal/PaisFacade.php';
require_once 'dal/ProvinciaFacade.php';

class ProveedorFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Proveedor";
		$this->_idName="id_proveedor";
		parent::__construct ();
	
	}
	
private function actualizaHijas(Proveedor  &$oProveedor) {
		$f = new TipoDocumentoFacade(); 
		$e = $oProveedor->getTipoDocumento();
		if ($e != null) {
			if ($oProveedor->getTipoDocumento()->getID() == null) {			
				$f->add($e);			
			}
			else {
				$f->modify($e);
			}
			$oProveedor->setTipoDocumento($e);
		}
	}
	
	public function add(Proveedor &$oProveedor) {
		//si la tabla hija tiene id la inserto, si no, la modifico
		$this->actualizaHijas($oProveedor);
		parent::add($oProveedor);
	}
	
	public function modify(Proveedor &$oProveedor) {
		$this->actualizaHijas($oProveedor);
		parent::modify($oProveedor);
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
			$filter = "PROVEEDOR.razon_social like '%$filtro%'";
		else 
			$filter = null;
			
		return parent::fetchSelectList($filter);
	}
}

?>