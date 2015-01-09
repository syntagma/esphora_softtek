<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once ('db/Retencion_Table.php');

class RetencionFacade extends TableFacade {
	
	function __construct() {
		$this->_table = "Retencion";
		$this->_idName = "id_retencion";
		parent::__construct ();
	
	}
	
	public function fetchRetenciones($idFactura) {
		$table = $this->getTable();
		
		$query = array(
			"select" 	=> "R.tipo_retencion, D.detalle, sum(D.base_imponible * D.alicuota / 100) importe",
			"from"		=> "DETALLE_PERCEPCIONES_FACTURA D INNER JOIN RETENCION R ON R.id_retencion = D.id_retencion",
			"where"		=> "D.id_factura = $idFactura GROUP BY R.tipo_retencion, D.detalle"
		);
						
		
		$result = $table->select($query);
		
		//('motivosRechazo', "FMR.id_factura = $idFactura");
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al consultar Detalle de Ventas<br>".$result->getMessage()."<br>".$result->getUserInfo());
		}
		return $result;
	}
}

?>