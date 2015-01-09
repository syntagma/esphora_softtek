<?php

require_once ('dal/TableFacade.php');
require_once ('be/Lote.php');
require_once ('db/Lote_Table.php');
require_once ('db/Factura_lote_Table.php');
require_once ('dal/FacturaFacade.php');
require_once ('dal/EstadoLoteFacade.php');

class LoteFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Lote";
		$this->_idName="id_lote";
		parent::__construct ();
	
	}
	
	private function actualizaHijas(Lote &$oLote) {
		$f = new EstadoLoteFacade(); 
		$e = $oLote->getEstadoLote();
		if ($oLote->getEstadoLote()->getID() == null) {			
			$f->add($e);			
		}
		else {
			$f->modify($e);
		}
		$oLote->setEstadoLote($e);
	}
	
	public function add(Lote &$oLote) {
		$this->actualizaHijas($oLote);
		parent::add($oLote);
		
		//inserto las funciones
		$rows = $oLote->mapFacturas();
		$this->modifyLink($rows, "Factura_Lote", null);
	}
	
	public function modify(Lote &$oLote) {
		$this->actualizaHijas($oLote);
		parent::modify($oLote);
		
		//modifico las pantallas
		$rows = $oLote->mapFacturas();
		$this->modifyLink($rows, "Factura_Lote", array('id_lote', 'id_factura'));
	}
	
	public function fetch($id) {
		$f = parent::fetch($id);
		
		//lleno las hijas
		$facade = new EstadoLoteFacade();
		
		$f->setEstadoLote($facade->fetch($f->getEstadoLote()->getID()));
		
		//lleno las pantallas
		$oFacturaFacade = new FacturaFacade();
		$this->fetchLinks("Factura_Lote", "factura", $id, $oFacturaFacade, $f);
		return $f;
	}
	
	public function fetchAll() {
		$dataSet = parent::fetchAll();

		//lleno las pantallas de cada elemento
		$oFacturaFacade = new FacturaFacade();
		$facade = new EstadoLoteFacade();
		
		for ($i=0; $i < count($dataSet); $i++) {
			$f->setEstadoLote($facade->fetch($f->getEstadoLote()->getID()));
			$this->fetchLinks("Factura_Lote", "factura", $dataSet[$i]->getID(), $oFacturaFacade, $dataSet[$i]);
		}
		return $dataSet;
	}
	
	public function setCae($idLote, $cae) 
	{
		$dataSet = array();
		
		$dataSet["id_lote"] = $idLote;
		$dataSet["cae"] = $cae;
		$dataSet["id_estado_lote"] = 2;	
		
		$this->modifyRow($dataSet);
		
	}
	
	public function loteValido($idLote) 
	{
		$dataSet = array();
		
		$dataSet["id_lote"] = $idLote;
		$dataSet["id_estado_lote"] = 2;	
		
		$this->modifyRow($dataSet);
		
	}
	

	public function agregaError($idLote, $error) 
	{
		$dataSet = array();
		
		$dataSet["id_lote"] = $idLote;
		$dataSet["mensaje_error"] = $error;
		$dataSet["id_estado_lote"] = 3;	
		
		$this->modifyRow($dataSet);
		
	}
	
	public function rechazaLote($idLote) 
	{
		$dataSet = array();
		
		$dataSet["id_lote"] = $idLote;
		$dataSet["id_estado_lote"] = 4;	
		
		$this->modifyRow($dataSet);
		
	}
	
	public function insertFacturaLote($idFactura, $idLote) {
		$auditoria = new Auditoria();
		
		$row = $auditoria->to_array();
		$row['id_lote'] = $idLote;
		$row['id_factura'] = $idFactura;
		
		$flt =TableFactory::createTable("Factura_Lote", $this->_db->getConnection());
		
		$result = $flt->insert($row);
		
		if (PEAR::isError($result)) {
			throw new Exception("Error al insertar en Factura_Lote<br>".$result->getMessage());
		}
	}
	
	public function getCountFacturas($filter = null) {
		$t=TableFactory::createTable("Factura_Lote",$this->_db->getConnection());
		$result = $t->selectCount('all', $filter);
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar ".$this->_table."<BR>".$result->getMessage()."<br>".$result->getUserInfo());
		}
		
		return $result;
	}
	
	public function getLoteInterfazOut($idLote) {
		$t=$this->getTable();
		$result = $t->select(
			array (		'select' => 'l.id_lote "id_lote", l.fecha "fecha_lote", right(concat(\'0000\', min(PUNTO_VENTA.numero)), 4) "pto_vta", right(concat(\'00000000\', min(f.nro_factura)), 8) "factura_desde", right(concat(\'00000000\', max(nro_factura)), 8) "factura_hasta", e.nro_documento "cuit_empresa", td.descripcion "tipo_doc_cliente", c.nro_documento "nro_doc_cliente", sum(f.total) "total"',
					 	'from'	  => 'FACTURA_LOTE fl, LOTE l, FACTURA f, EMPRESA e, CLIENTE c, TIPO_DOCUMENTO td, PUNTO_VENTA',
					 	'where'  => "l.id_lote = $idLote and l.id_lote = fl.id_lote and f.id_factura = fl.id_factura and f.id_empresa = e.id_empresa and f.id_cliente = c.id_cliente and c.id_tipo_documento = td.id_tipo_documento and f.id_punto_venta = PUNTO_VENTA.id_punto_venta group by l.id_lote, l.fecha, e.nro_documento, c.nro_documento, td.descripcion",
			)
		);
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar ".$this->_table."<BR>".$result->getMessage()."<br>".$result->getUserInfo());
		}
		
		return $result;
	}
}

?>