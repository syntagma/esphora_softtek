<?php

require_once ('db/Punto_Venta_Table.php');
require_once ('dal/TableFacade.php');
require_once ('be/PuntoVenta.php');

class PuntoVentaFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Punto_Venta";
		$this->_idName="id_punto_venta";
		parent::__construct ();
	
	}
	
	public function getForm() {
		$cols = array("numero", "factura_electronica","id_empresa");
		return parent::getForm($cols);
	}
}

?>