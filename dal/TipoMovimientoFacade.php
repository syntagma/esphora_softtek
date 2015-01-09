<?php

require_once ('dal/TableFacade.php');
require_once 'be/TipoMovimiento.php';
require_once 'db/Tipo_movimiento_Table.php';

class TipoMovimientoFacade extends TableFacade {
	
	function __construct() {
		$this->_table = "Tipo_Movimiento";
		$this->_idName = "id_tipo_movimiento";
		parent::__construct ();
	
	}
}

?>