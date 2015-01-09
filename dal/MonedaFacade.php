<?php

require_once ('db/Moneda_Table.php');
require_once ('dal/TableFacade.php');
require_once ('be/Moneda.php');

class MonedaFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Moneda";
		$this->_idName="id_moneda";
		parent::__construct ();
	
	}
	
	public function getForm() {
		$cols = array("codigo", "descripcion", "codigo_moneda_afip");
		return parent::getForm($cols);
	}
}

?>