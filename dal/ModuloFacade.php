<?php

require_once ('dal/TableFacade.php');
require_once 'db/Modulo_Table.php';
require_once 'be/Modulo.php';

class ModuloFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Modulo";
		$this->_idName="id_modulo";
		parent::__construct ();
	}
}

?>