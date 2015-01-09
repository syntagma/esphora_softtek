<?php

require_once ('dal/TableFacade.php');
require_once 'be/EstadoLote.php';
require_once 'db/Estado_lote_Table.php';

class EstadoLoteFacade extends TableFacade {
	
	function __construct() {
		$this->_table = "Estado_Lote";
		$this->_idName = "id_estado_lote";
		parent::__construct ();
	
	}
}

?>