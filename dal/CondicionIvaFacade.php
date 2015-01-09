<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once ('db/Condicion_iva_Table.php');

class CondicionIvaFacade extends TableFacade {
function __construct() {
		$this->_table="Condicion_Iva";
		$this->_idName="id_condicion_iva";
		parent::__construct ();
	}
}

?>