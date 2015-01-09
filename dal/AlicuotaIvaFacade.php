<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once ('db/Alicuota_iva_Table.php');

class AlicuotaIvaFacade extends TableFacade {
function __construct() {
		$this->_table="Alicuota_Iva";
		$this->_idName="id_alicuota_iva";
		parent::__construct ();
	}
}

?>