<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once ('db/Condicion_venta_Table.php');

class CondicionVentaFacade extends TableFacade {
function __construct() {
		$this->_table="Condicion_Venta";
		$this->_idName="id_condicion_venta";
		parent::__construct ();
	}
}

?>