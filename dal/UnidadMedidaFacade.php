<?php

require_once ('db/Unidad_Medida_Table.php');
require_once ('dal/TableFacade.php');
require_once ('be/UnidadMedida.php');

class UnidadMedidaFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Unidad_Medida";
		$this->_idName="id_unidad_medida";
		parent::__construct ();
	
	}
	
	public function getForm() {
		$cols = array("descripcion", "codigo_unidad_medida_afip");
		return parent::getForm($cols);
	}
}

?>