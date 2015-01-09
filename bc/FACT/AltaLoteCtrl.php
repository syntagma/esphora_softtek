<?php
require_once "bc/ABMCtrl.php";
require_once 'dal/LoteFacade.php';
require_once 'dal/FacturaFacade.php';
require_once 'bc/BCUtils.php';
require_once 'bc/AFIP/AfipCtrl.php';

class AltaLoteCtrl extends ABMCtrl {
	function __construct() {
		$this->_facade = new LoteFacade();
		$this->_idName = "id_lote";
	}
	
		
	public function addLote($lote, $obtieneCae) {
		$ff = new FacturaFacade();
		$lf = new LoteFacade();
		
		
		$nroFacturaDesde = $lote['descripcion_factura_desde'];
		$nroFacturaHasta = $lote['descripcion_factura_hasta'];
		
		//print_r($lote);
		
		$a = split("-", $nroFacturaDesde);
		$ptoVtaDesde = $a[0];
		$nroFacturaDesde = $a[1];
		
		$a = split("-", $nroFacturaHasta);
		$ptoVtaHasta = $a[0];
		$nroFacturaHasta = $a[1];
		
		//echo "<br>$ptoVtaDesde-$nroFacturaDesde<br>$ptoVtaHasta-$nroFacturaHasta";
		
		$facturas = array();
		$error = "";
		for ($i = $ptoVtaDesde; $i<=$ptoVtaHasta; $i++) {
			
			$limite = $i < $ptoVtaHasta ? 99999999 : $nroFacturaHasta;
			
			for ($j=$nroFacturaDesde; $j<=$limite; $j++) {
				
				$result = $ff->fetchAllRows(true, "pto_vta = $i and nro_factura = $j");
				
				if ($result != array()) {
					$facturas[] = $result[0]['id_factura']; 
				}
				else {
					$error ="Las facturas no son consecutivas. Lote invalidado";
				}
				
			}
		
		}

		if ($error == "") {
			$estado = 1;
		}
		else {
			$estado = 3;
		}
		
		//si no hay id_lote lo inserto
		if($lote['id_lote'] == null) {
			$idLote = $lf->addRow(array(
				'id_estado_lote' => $estado,
				'fecha' => date('YmdHis')
			));		
		}
		else {
			//le modifico el estado
			$idLote = $lote['id_lote'];
			$lf->modifyRow(array(
				'id_lote' => $idLote,
				'id_estado_lote' => $estado
			));
		}
		
		foreach($facturas as $idFactura) {
			$lf->insertFacturaLote($idFactura, $idLote);
		}
		
		if ($error != "") {
			throw new Exception($error);
		}
		
		$ret = "";
		if ($obtieneCae) {
			$afipControl = new AfipCtrl();
			$ret = $afipControl->setCAE($idLote);
		}
		
		return $ret;
	}
}
?>