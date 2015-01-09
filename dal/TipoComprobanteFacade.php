<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once ('be/TipoComprobante.php');
require_once ('db/Tipo_comprobante_Table.php');

class TipoComprobanteFacade extends TableFacade {
function __construct() {
		$this->_table="Tipo_Comprobante";
		$this->_idName="id_tipo_comprobante";
		parent::__construct ();
	}
}

?>