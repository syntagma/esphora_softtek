<?php
if(!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once 'be/Compra.php';
require_once 'db/Compra_Table.php';
require_once 'dal/ProveedorFacade.php';

require_once 'dal/EmpresaFacade.php';

class CompraFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Compra";
		$this->_idName="id_compra";
		parent::__construct ();
	
	}
	
	private function actualizaHijas(Compra &$oCompra, $o, TableFacade $f) {
		if ($o->getID() == null) {			
			$f->add($o);			
		}
		else {
			$f->modify($o);
		}
		$oCompra->setTipoDocumento($o);
	}
	
	private function traeHija($o, TableFacade $f) {
		return $f->fetch($o->getID());
	}
	
/*	public function add(Compra &$oCompra) {
		//si la tabla hija tiene id la inserto, si no, la modifico
		$this->actualizaHijas($oCompra, $oCompra->getTipoDocumento(), new TipoDocumentoFacade());
		$this->actualizaHijas($oCompra, $oCompra->getProveedor(), new ProveedorFacade());
		$this->actualizaHijas($oCompra, $oCompra->getEmpresa(), new EmpresaFacade());
		parent::add($oCompra);
	}
*/
		
/*	public function modify(Factura &$oCompra) {
		$this->actualizaHijas($oCompra);
		parent::modify($oCompra);
	}
*/	
	public function fetch($id) {
		$f = parent::fetch($id);
		
		//lleno las tablas hikas
		
		$f->setTipoComprobante($this->traeHija($f->getTipoComprobante(), new TipoComprobanteFacade()));
		$f->setCliente($this->traeHija($f->getProveedor(), new ProveedorFacade()));
		$f->setEmpresa($this->traeHija($f->getEmpresa(), new EmpresaFacade()));
		
		return $f;
	}
	
	public function fetchAll() {
		$dataSet = parent::fetchAll();
		//lleno las pantallas de cada elemento
		$tcf = new TipoComprobanteFacade();
		$pf = new ProveedorFacade();
		$errf = new ErrorFacade();
		$ef = new EmpresaFacade();
		
		for ($i=0; $i < count($dataSet); $i++) {
			$dataSet[$i]->setTipoComprobante($this->traeHija($dataSet[$i]->getTipoComprobante(), $tcf));
			$$dataSet[$i]->setProveedor($this->traeHija($dataSet[$i]->getProveedor(), $pf));
			$dataSet[$i]->setEmpresa($this->traeHija($dataSet[$i]->getEmpresa(), $ef));
		}
		return $dataSet;
	}
	
	public function existeFactura($idProveedor, $idTipoComprobante, $ptoVta, $nroFactura) {
		$filtro = "id_proveedor = $idProveedor and id_tipo_comprobante = $idTipoComprobante and punto_venta = $ptoVta and nro_factura = $nroFactura";
		$result = $this->fetchAllRows(false, $filtro);
		if ($result == array()) return false;
		return true;
	}
}

?>