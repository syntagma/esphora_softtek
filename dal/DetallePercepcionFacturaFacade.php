<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once 'be/DetallePercepcionesFactura.php';
require_once ('dal/TableFacade.php');
require_once ('db/Detalle_percepciones_factura_Table.php');

class DetallePercepcionesFacturaFacade extends TableFacade {
	function __construct() {
		$this->_table="Detalle_Percepciones_Factura";
		$this->_idName="id_detalle_percepciones_factura";
		parent::__construct ();
	}
	
	function eliminarDetalles($idFactura) {
		$t = $this->getTable();
		
		$result = $t->delete("id_factura = $idFactura");
		
		if (PEAR::isError($result)) {
			throw new Exception("Error al eliminar detalles de retenciones<br>". $result->getMessage()."<br>".$result->getUserInfo());
		}
	}
}

?>