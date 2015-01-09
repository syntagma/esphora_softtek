<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once 'be/Empresa.php';
require_once 'db/Empresa_Table.php';
require_once 'db/Licencia_Table.php';


require_once 'dal/TipoDocumentoFacade.php';
require_once 'dal/PaisFacade.php';
require_once 'dal/ProvinciaFacade.php';

class EmpresaFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Empresa";
		$this->_idName="id_empresa";
		parent::__construct ();
	
	}
	
	private function actualizaHijas(Empresa &$oEmpresa) {
		$f = new TipoDocumentoFacade(); 
		$e = $oEmpresa->getTipoDocumento();
		//TODO:Hacerlo en todas las facades
		if ($e != null) {
			if ($oEmpresa->getTipoDocumento()->getID() == null) {			
				$f->add($e);			
			}
			else {
				$f->modify($e);
			}
		
			$oEmpresa->setTipoDocumento($e);
		}
	}
	
	public function add(Empresa &$oEmpresa) {
		//si la tabla hija tiene id la inserto, si no, la modifico
		$this->actualizaHijas($oEmpresa);
		parent::add($oEmpresa);
		
		$rows = $oEmpresa->mapLicencias();
		$this->modifyLink($rows, "Licencia", null);
	}
	
	public function modify(Empresa &$oEmpresa) {
		$this->actualizaHijas($oEmpresa);
		parent::modify($oEmpresa);
		
		$rows = $oEmpresa->mapLicencias();
		$this->modifyLink($rows, "Licencia", array('id_empresa', 'id_modulo'));
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
		
		$oModuloFacade = new ModuloFacade();
		$this->fetchLinks("Licencia", "modulo", $id, $oModuloFacade, $f, true);
		
		return $f;
	
	}
	
	public function fetchAll() {
		$dataSet = parent::fetchAll();
		//lleno las pantallas de cada elemento
		$facade = new TipoDocumentoFacade();
		$oModuloFacade = new ModuloFacade();
		$paisFacade = new PaisFacade();
		$provinciaFacade = new ProvinciaFacade();
		for ($i=0; $i < count($dataSet); $i++) {
			$dataSet[$i]->setTipoDocumento($facade->fetch($dataSet[$i]->getTipoDocumento()->getID()));
			$dataSet[$i]->getDomicilio()->setPais($paisFacade->fetch($dataSet[$i]->getDomicilio()->getPais()->getID()));
			$dataSet[$i]->getDomicilio()->setProvincia($provinciaFacade->fetch($dataSet[$i]->getDomicilio()->getProvincia()->getID()));
			$this->fetchLinks("Licencia", "modulo", $dataSet[$i]->getID(), $oModuloFacade, $dataSet[$i], true);
		}	
		return $dataSet;
	} 
}

?>