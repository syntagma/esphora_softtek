<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once ('db/Periodo_Table.php');

class PeriodoFacade extends TableFacade {
function __construct() {
		$this->_table="Periodo";
		$this->_idName="id_periodo";
		parent::__construct ();
	}
	
	public function fetchListCD($order=null, $pagina=null, $filtro=null) {
		return $this->_fetchList("listCD", $order, $pagina, $filtro);
	}
}

?>