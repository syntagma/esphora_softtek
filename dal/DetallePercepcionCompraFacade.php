<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once 'be/DetallePercepcionesCompra.php';
require_once ('dal/TableFacade.php');
require_once ('db/Detalle_percepciones_compra_Table.php');

class DetallePercepcionesCompraFacade extends TableFacade {
	function __construct() {
		$this->_table="Detalle_Percepciones_Compra";
		$this->_idName="id_detalle_percepciones_compra";
		parent::__construct ();
	}
	
	function eliminarDetalles($idCompra) {
		$t = $this->getTable();
		
		$result = $t->delete("id_compra = $idCompra");
		
		if (PEAR::isError($result)) {
			throw new Exception("Error al eliminar detalles de retenciones<br>". $result->getMessage()."<br>".$result->getUserInfo());
		}
	}
}

?>