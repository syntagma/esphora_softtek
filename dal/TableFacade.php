<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once("dal/DBFacade.php");
require_once("dal/TableFactory.php");
require_once("db/Parametros_Table.php");

class TableFacade {
	protected $_db;
	protected $_table;
	protected $_idName;
	
	function __construct() {
		$this->_db = new DBFacade();
	}
	
	public function beginTrans() {
		$this->_db->beginTrans();
	}
	
	public function commitTrans() {
		$this->_db->commitTrans();
	}
	
	public function rollbackTrans() {
		$this->_db->rollbackTrans();
	}
	
	public function getIdName() { return $this->_idName; }
	
	protected function getTable() {
		return TableFactory::createTable($this->_table, $this->_db->getConnection());
	}
	
	protected function getEntity() {
		return TableFactory::createEntity($this->_table);
	}
	
	public function modify(&$be) {
		$be->set_fechaUltimaModificacion();
		$be->set_usuarioUltimaModificacion();
		
		$row = $be->to_array();
				
		unset($row[$this->_idName]);
		
		$result = $this->getTable()->update($row, $this->_idName."=".$be->getID());
		
		if (PEAR::isError($result)) {
			//print_r($row);
			print("<br><br>");
			//print_r($result);
			throw new Exception ("Error al actualizar registro en ".$this->_table);
		}
	}
	
	public function modifyRow($campos) {
		$a = new Auditoria();
		
		$a->unset_fechaCreacion();
		$a->unset_usuarioCreacion();
		
		$row=$a->to_array();
		
		foreach ($campos as $key => $value) {
			$row[$key] = $value;
		}
		
		$id = $row[$this->_idName];
				
		unset($row[$this->_idName]);
		
		$result = $this->getTable()->update($row, $this->_idName."=$id");
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al actualizar registro en ".$this->_table."<br>".$result->getMessage()."<br>".$result->getUserInfo());
		}
	}
	
	public function remove(&$be) {
		if ($be->get_activo()) {
			$be->set_activo(false);
			$this->modify($be);
		}
	}
	
	public function activate(&$be) {
		if (!$be->get_activo()) {
			$be->set_activo(true);
			$this->modify($be);
		}
	}
	
	public function activateID($id) {
		$this->modifyActivoID($id, true);
	}
	
	public function deactivateID($id) {
		$this->modifyActivoID($id, false);
	}
	
	private function modifyActivoID($id, $value) {
		$be = $this->getEntity();
		
		$be->setID($id);
		$be->set_activo($value);
		
		$be->unset_fechaCreacion();
		$be->unset_usuarioCreacion();
		
		$this->modify($be);
	}
	
	public function add(&$be) {
		$t = $this->getTable();
		$be->setID($this->nextID());
		
		$row = $be->to_array();
		
		$result = $t->insert($row);
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al insertar registro en ".$this->_table."<BR>".$result->getMessage()."<BR>");
		}
	}
	
	public function addRow($campos) {
		
		$t = $this->getTable();
		$be = $this->getEntity();
		
		$be->setID($this->nextID());
		
		$row = $be->to_array();
		
		unset($campos[$this->_idName]);
		
		foreach ($campos as $key => $value) {
			$row[$key] = $value;
		}
		
		$result = $t->insert($row);
		
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al insertar registro en ".$this->_table."<BR>".$result->getMessage()."<BR>");
		}
		
		return $row[$this->_idName];
	}
	
	public function nextID() {
		
		$t = $this->getTable();

		if ($this->getCount() == 0) {
			return 1;
		}
		else {
			$result = $t->select(array('select' => "max({$this->_idName})+1 'nextid'"));
			if (PEAR::isError($result)) {
				throw new Exception ("Error al consultar ".$this->_table."<BR>".$result->getMessage()."<br>".$result->getUserInfo() );
			}
			return $result[0]['nextid'];
		}
			
	}
	
	public final function simpleFetch($id) {
		$result = $this->getTable()->select("all", $this->_idName." = $id");		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar ".$this->_table);
		}
		$e = $this->getEntity();
		$e->map($result[0]);
		
		return $e;
	}
	
	public function fetch($id) {
		$result = $this->getTable()->select("all", $this->_idName." = $id");		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar ".$this->_table);
		}
		$e = $this->getEntity();
		$e->map($result[0]);
		
		return $e;
	}
	
	public function getCount($filter = null) {
		$result = $this->getTable()->selectCount('all', $filter);
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar ".$this->_table."<BR>".$result->getMessage()."<br>".$result->getUserInfo());
		}
		
		return $result;
	}
	
	public function fetchRows($id) {
		$table=$this->getTable();
		$result = $table->select("all", $this->_idName." = $id");
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar ".$this->_table."<br>".$result->getMessage()."<br>".$result->getUserInfo());
		}
		return $result[0];
	}
	
	public function fetchAllRows($valid, $filtro = null, $orden=null, $consulta=null, $pagina=null) {
		
		$table=$this->getTable();
		
		$filter = null;
		if ($valid) {
			$filter = strtoupper($this->_table).".activo = 'S'";
		}
		
		if ($filtro != null) {
			if ($filter == null) {
				$filter = $filtro;
			}
			else {
				$filter .= " and $filtro";
			}
		}
		
		if ($consulta == null) $query="all";
		else $query = $consulta;
		
		if ($pagina==null) {
			$start = null;
			$count=null;
		}
		else {
			$count=$this->getParametro("PAGINADO_LISTA");
			$start=($pagina-1)*$count;
		}
		
		$result = $table->select($query, $filter, $orden, $start, $count);
		
		
		
		
		if (PEAR::isError($result)) {
			//print_r($result);
			throw new Exception ("Error al consultar ".$this->_table."<br>".$result->getMessage()."<br>".str_replace("]","<br>", $result->getUserInfo()));
		}
		
		return $result;
	}
	
	public function fetchAll() {
		$table=$this->getTable();
		$result = $table->select("all");
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar ".$this->_table);
		}
		$dataSet = array();
		
		foreach($result as $row) {
			$e = $this->getEntity();
			$e->map($row);
			$dataSet[]=$e;
		}
		return $dataSet;
	}
	
	public function fetchList($order=null, $pagina=null, $filtro=null) {
		return $this->_fetchList("listView", $order, $pagina, $filtro);
	}
	
	protected function _fetchList($query, $order=null, $pagina=null, $filtro=null) {
		$table=$this->getTable();
		
		if ($pagina==null) {
			$start = null;
			$count=null;
		}
		else {
			$count=$this->getParametro("PAGINADO");
			$start=($pagina-1)*$count;
		}
		
		//if ($count - $start < $count) $count = $count - $start;
		
		$result = $table->select($query, $filtro, $order, $start, $count);
		
		//echo "<br>$pagina, $start, $count<br>";
		
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar ".$this->_table."<br>".$result->getMessage()."<br>".$result->getUserInfo());
		}
		
		return $result;
	}
	
	public function fetchSelectList($filtro=null) {
		$table=$this->getTable();
		$result = $table->select('selectListView', $filtro);
		
		if (PEAR::isError($result)) {
			//print_r($result);
			throw new Exception ("Error al consultar ".$this->_table."<br>".$result->getMessage());
		}
		
		return $result;
	}
	
	protected function fetchLinks($table, $field_id, $id, TableFacade $oFacade, &$mainEntity, $send_link = null) {
		$fpt = TableFactory::createTable($table, $this->_db->getConnection());
		$result = $fpt->select('all', $this->_idName." = $id");
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar los links de la entidad");
		}
		
		foreach($result as $link) {
			$oAuditoria = new Auditoria();
			$oAuditoria->map($link);				
			
			$oEntity = $oFacade->fetch($link["id_$field_id"]);
			
			////print_r($oEntity);
			
			//echo "<br><br>";
			
			if ($send_link == null)
				$mainEntity->setLink($oEntity, $oAuditoria, $field_id);
			else
				$mainEntity->setLink($oEntity, $oAuditoria, $field_id, $link);
		}
	}
	
	public function getForm($cols) {
		// [snip] create the object
		$table = $this->getTable();
		// create the HMTL_QuickForm object
		$form =& $table->getForm($cols);
		// display the form
		return $form;
	}
	
	protected function modifyLink($rows, $table, $update) {		
		$fpt = TableFactory::createTable($table, $this->_db->getConnection());
		foreach ($rows as $row) {
			if (!is_array($update)) {
				$result = $fpt->insert($row);
			}
			else {
				$filter = "";
				for ($i = 0; $i < count($update); $i++) { 
					if ($i != 0) {
						$filter .= " and ";
					}
					$filter .= $update[$i].'='.$row[$update[$i]];
				}
				$result = $fpt->update($row, $filter);
			}
			if (PEAR::isError($result))
				throw new Exception("Error al insertar en Funcion_Pantalla");
		}
	}
	
	protected function _fetchTablaLista($id, $tabla) {
		$t = TableFactory::createTable($tabla, $this->_db->getConnection());
		
		$result = $t->select("all", $this->_idName." = $id and activo = 'S'");
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar $tabla<br>".$result->getMessage());
		}
		
		return $result;
	}
	
	protected function _insertTablaLista($lista, $id, $tabla, $id_lista) {
		$t = TableFactory::createTable($tabla, $this->_db->getConnection());
		$a = new Auditoria();
		
		foreach ($lista as $value) {
			$row = $a->to_array();
			
			$row[$this->_idName] = $id;
			$row[$id_lista] = $value;
			
			$result = $t->insert($row);
			
			if (PEAR::isError($result)) {
				throw new Exception ("Error al insertar en $tabla<br>".$result->getMessage());
			}
		}
	}
	
	protected function _updateTablaLista($lista, $id, $tabla, $id_lista) {
		$t = TableFactory::createTable($tabla, $this->_db->getConnection());
		
		$a = new Auditoria();
		
		$a->set_usuarioUltimaModificacion();
		$a->set_fechaUltimaModificacion();
		$a->unset_fechaCreacion();
		$a->unset_usuarioCreacion();
		$a->set_activo(false);
		
		//desactivo toddy
		$result = $t->update($a->to_array(), $this->_idName." = $id");
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al actualizar en $tabla<br>".$result->getMessage());
		}
		
		$a->set_activo(true);
		
		//por cada item de la lista me fijo si existe.... si si lo updeteo... si no lo inserto
		foreach ($lista as $value) {
			
			$result = $t->selectCount("all", $this->_idName." = $id and $id_lista = $value"); 
			
			if (PEAR::isError($result)) {
				throw new Exception ("Error al consultar $tabla<br>".$result->getMessage());
			}
			
			if ($result == 0) {
				$aa = new Auditoria();
				$row = $aa->to_array();
				$row[$this->_idName] = $id;
				$row[$id_lista] = $value;
				
				$result = $t->insert($row);
				
				if (PEAR::isError($result)) {
					throw new Exception ("Error al insertar en $tabla<br>".$result->getMessage());
				}
			}
			else {
				$result = $t->update($a->to_array(), $this->_idName." = $id and $id_lista = $value");
				
				if (PEAR::isError($result)) {
					throw new Exception ("Error al actualizar en $tabla<br>".$result->getMessage());
				}
			}
			
		}
	}
	
	public function getParametro($parametro) {
		$t = TableFactory::createTable("Parametros", $this->_db->getConnection()); 		
		
		$result = $t->select('all', "parametro = '$parametro'");
		
		if (PEAR::isError($result)) {
			////print_r($result);
			throw new Exception ("Error al consultar la tabla de parametros<br>".$result->getMessage());
		}
		
		return $result[0]['valor'];
	}
}
?>