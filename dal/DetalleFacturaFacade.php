<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once 'be/DetalleFactura.php';
require_once ('dal/TableFacade.php');
require_once ('db/Detalle_factura_Table.php');

class DetalleFacturaFacade extends TableFacade {
	function __construct() {
		$this->_table="Detalle_Factura";
		$this->_idName="id_detalle_factura";
		parent::__construct ();
	}
	
	function eliminarDetalles($idFactura) {
		$t = $this->getTable();
		
		$result = $t->delete("id_factura = $idFactura");
		
		if (PEAR::isError($result)) {
			throw new Exception("Error al eliminar detalles <br>". $result->getMessage()."<br>".$result->getUserInfo());
		}
	}

	public function fetchDetalleVentas($idFactura) {
		$table = $this->getTable();
		
		$query = array("select"=>'AI.descripcion,AI.porcentaje*100 "porcentaje", AI.tipo_iva, SUM(DF.cantidad * DF.precio_unitario) "neto_gravado", SUM(DF.cantidad * DF.precio_unitario * AI.porcentaje) "impuesto_liquidado"'
						,"from"=>'ALICUOTA_IVA AS AI JOIN DETALLE_FACTURA AS DF ON AI.id_alicuota_iva = DF.id_alicuota_iva'
						,"where"=>'DF.id_factura =' . $idFactura . " group by AI.descripcion,AI.porcentaje,AI.tipo_iva");
						
		
		$result = $table->select($query);
		
		//('motivosRechazo', "FMR.id_factura = $idFactura");
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar Detalle de Ventas<br>".$result->getMessage()."<br>".$result->getUserInfo());
		}
		return $result;
	}	
}

?>