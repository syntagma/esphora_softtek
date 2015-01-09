<?php
if(!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once 'be/Factura.php';
require_once 'db/Factura_Table.php';
require_once 'db/Factura_motivo_rechazo_Table.php';

require_once 'dal/TipoComprobanteFacade.php';
require_once 'dal/ClienteFacade.php';
require_once 'dal/EmpresaFacade.php';

class FacturaFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Factura";
		$this->_idName="id_factura";
		parent::__construct ();
	
	}
	
	private function actualizaHijas(Factura &$oFactura, $o, TableFacade $f) {
		if ($o->getID() == null) {			
			$f->add($o);			
		}
		else {
			$f->modify($o);
		}
		$oFactura->setTipoDocumento($o);
	}
	
	private function traeHija($o, TableFacade $f) {
		return $f->fetch($o->getID());
	}
	
	public function add(Factura &$oFactura) {
		//si la tabla hija tiene id la inserto, si no, la modifico
		$this->actualizaHijas($oFactura, $oFactura->getTipoDocumento(), new TipoDocumentoFacade());
		$this->actualizaHijas($oFactura, $oFactura->getCliente(), new ClienteFacade());
		$this->actualizaHijas($oFactura, $oFactura->getError(), new ErrorFacade());
		$this->actualizaHijas($oFactura, $oFactura->getEmpresa(), new EmpresaFacade());
		parent::add($oFactura);
	}
	
	public function modify(Factura &$oFactura) {
		$this->actualizaHijas($oFactura);
		parent::modify($oFactura);
	}
	
	public function fetch($id) {
		$f = parent::fetch($id);
		
		//lleno las tablas hikas
		
		$f->setTipoComprobante($this->traeHija($f->getTipoComprobante(), new TipoComprobanteFacade()));
		$f->setCliente($this->traeHija($f->getCliente(), new ClienteFacade()));
		$f->setError($this->traeHija($f->getError(), new ErrorFacade()));
		$f->setEmpresa($this->traeHija($f->getEmpresa(), new EmpresaFacade()));
		
		return $f;
	}
	
	public function fetchAll() {
		$dataSet = parent::fetchAll();
		//lleno las pantallas de cada elemento
		$tcf = new TipoComprobanteFacade();
		$cf = new ClienteFacade();
		$errf = new ErrorFacade();
		$ef = new EmpresaFacade();
		
		for ($i=0; $i < count($dataSet); $i++) {
			$dataSet[$i]->setTipoComprobante($this->traeHija($dataSet[$i]->getTipoComprobante(), $tcf));
			$$dataSet[$i]->setCliente($this->traeHija($dataSet[$i]->getCliente(), $cf));
			$dataSet[$i]->setError($this->traeHija($dataSet[$i]->getError(), $errf));
			$dataSet[$i]->setEmpresa($this->traeHija($dataSet[$i]->getEmpresa(), $ef));
		}
		return $dataSet;
	}
	
	public function getUltimoNumeroFactura($tipocbte, $ptoVta) {
		$ff = $this->getTable();
		$result = $ff->select("maxNro", "id_tipo_comprobante = $tipocbte and id_punto_venta = $ptoVta and id_empresa = ".GLOBAL_EMPRESA);
		
		if (PEAR::isError($result)) {
			throw new Exception("Error al consultar numero de factura<br>".$result->getMessage());
		}
		
		$nroFact = $result[0]["numero_factura"];
		
		if ($nroFact == 99999999) {
			throw new Exception("Error: No existen mas numeros de factura disponibles");
		}
		
		return $nroFact + 1;
	}
	
	public function fetchRowsByLote($id_Lote) {
		$table=$this->getTable();
		$result = $table->select('facturasByLote', "id_lote = $id_Lote");
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar ".$this->_table."<br>".$result->getMessage()."<br>".$result->getUserInfo());
		}
		return $result;
	}
	
	
	public function getCae($idFactura) {
		$table=$this->getTable();
		$result = $table->select('listView', "F.id_factura = $idFactura");
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar ".$this->_table."<br>".$result->getMessage()."<br>".$result->getUserInfo());
		}
		return $result;
	}
	
	public function grabaRechazo($motivo, $ptovta, $nrocbte) {
		$id = $this->getID($ptovta, $nrocbte);
		
		$motivoTable = TableFactory::createTable("Factura_Motivo_Rechazo", $this->_db->getConnection());
		
		$result = $motivoTable->insert(array(
			'id_motivo_rechazo' => $motivo,
			'id_factura'		=> $id
		));
		
		if(PEAR::isError($result)) {
			throw new Exception ("Error al insertar Motivos de Rechazo<br>".$result->getMessage()."<br>".$result->getUserInfo());
		}
	}
	
	public function borraRechazo($ptovta, $nrocbte) {
		$id = $this->getID($ptovta, $nrocbte);
		
		$motivoTable = TableFactory::createTable("Factura_Motivo_Rechazo", $this->_db->getConnection());
		
		$result = $motivoTable->delete ("id_factura = $id");
		
		if(PEAR::isError($result)) {
			throw new Exception ("Error al eliminar Motivos de Rechazo<br>".$result->getMessage()."<br>".$result->getUserInfo());
		}
	}
	
	public function getID($ptovta, $nrocbte) {
		$result = $this->fetchAllRows(true, "pto_vta = $ptovta and nro_factura = $nrocbte");
		
		return $result[0]['id_factura'];
	}
	
	public function fectchFacturasPorLote($idLote) {
		$table = $this->getTable();
		
		$result = $table->select('listaFacturasByLote', "FL.id_lote = $idLote");
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar ".$this->_table."<br>".$result->getMessage()."<br>".$result->getUserInfo());
		}
		return $result;
	}
	
	public function fetchRechazos($idFactura) {
		$table = $this->getTable();
		
		$result = $table->select('motivosRechazo', "FMR.id_factura = $idFactura");
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar Motivos de Rechazo<br>".$result->getMessage()."<br>".$result->getUserInfo());
		}
		return $result;
	}
	
	public function grabaCAE($cae, $ptovta, $nrocbte) {
		$id = $this->getID($ptovta, $nrocbte);

		$this->modifyRow(array(	'id_factura'	=> $id,
								'cae'			=> $cae
		));		
	}
}

?>