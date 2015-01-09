<?php

require_once ('dal/TableFacade.php');
require_once("be/Pantalla.php");
require_once("db/Pantalla_Table.php");

class PantallaFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Pantalla";
		$this->_idName="id_pantalla";
		parent::__construct ();
	}
}

?>