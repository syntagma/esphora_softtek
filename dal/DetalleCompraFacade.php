<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once 'be/DetalleCompra.php';
require_once ('dal/TableFacade.php');
require_once ('db/Detalle_compra_Table.php');

class DetalleCompraFacade extends TableFacade {
	function __construct() {
		$this->_table="Detalle_Compra";
		$this->_idName="id_detalle_compra";
		parent::__construct ();
	}
	
	function eliminarDetalles($idCompra) {
		$t = $this->getTable();
		
		$result = $t->delete("id_compra = $idCompra");
		
		if (PEAR::isError($result)) {
			throw new Exception("Error al eliminar detalles <br>". $result->getMessage()."<br>".$result->getUserInfo());
		}
	}

	public function fetchDetalleCompras($idCompra) {
		$table = $this->getTable();
		
		$query = array("select"=>'ALICUOTA_IVA.descripcion,ALICUOTA_IVA.porcentaje*100 "porcentaje", SUM(DETALLE_FACTURA.cantidad * DETALLE_FACTURA.precio_unitario) "neto_gravado", SUM(DETALLE_FACTURA.cantidad * DETALLE_FACTURA.precio_unitario * ALICUOTA_IVA.porcentaje) "impuesto_liquidado"'
						,"from"=>'ALICUOTA_IVA JOIN DETALLE_FACTURA ON ALICUOTA_IVA.`id_alicuota_iva` = DETALLE_FACTURA.`id_alicuota_iva`'
						,"where"=>'DETALLE_FACTURA.id_compra =' . $idCompra . " group by ALICUOTA_IVA.descripcion,ALICUOTA_IVA.porcentaje");
						
		
		$result = $table->select($query);
		
		//('motivosRechazo', "FMR.id_factura = $idFactura");
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar Detalle de Compras<br>".$result->getMessage()."<br>".$result->getUserInfo());
		}
		return $result;
	}	
}

?>