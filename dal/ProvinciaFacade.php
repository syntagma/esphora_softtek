<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once ('dal/EmpresaFacade.php');
require_once ('be/Provincia.php');
require_once ('db/Provincia_Table.php');

class ProvinciaFacade extends TableFacade {
	
	function __construct() {
		$this->_table = "Provincia";
		$this->_idName = "id_provincia";
		parent::__construct ();
	
	}
	
	function getProvinciasPais() {
		$ef = new EmpresaFacade();
		$result = $ef->fetchRows(GLOBAL_EMPRESA);
		$idPais = $result['id_pais'];
		
		$ret = array();
		$rows = $this->fetchAllRows(true, "id_pais = $idPais");
		
		foreach($rows as $row) {
			$ret[] = array ("id_provincia" => $row['id_provincia'], "descripcion" => $row['descripcion']);
		}
		
		return $ret;
	}
}

?>