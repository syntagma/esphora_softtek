<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once ('be/Pais.php');
require_once ('db/Pais_Table.php');

class PaisFacade extends TableFacade {
	
	function __construct() {
		$this->_table = "Pais";
		$this->_idName = "id_pais";
		parent::__construct ();
	
	}
}

?>