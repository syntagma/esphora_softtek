<?php
require_once 'be/PuntoVenta.php';
require_once 'dal/PuntoVentaFacade.php';
require_once "bc/ABMCtrl.php";
require_once 'bc/BCUtils.php';

class ABMPuntoVentaCtrl extends ABMCtrl {
	
	
	function __construct() {
		$this->_facade = new PuntoVentaFacade();
		$this->_idName = "id_punto_venta";
		$this->_filtroValido = "P.activo = 'S'";
		$this->_filtroEmpresa = "id_empresa = " . GLOBAL_EMPRESA;
	}
	
	function serverValidation(&$campos) {
		if ($campos['tipo_pto_vta'] != 'M') {
			unset($campos["cai"]);
		}
		else {
			$campos['fec_venc_cai'] = BCUtils::formatDate($campos['fec_venc_cai']);
		}
		
		return $this->_serverValidation("numero", "id_punto_venta", $campos);
	}
	
	function getMessage() {
		return $this->_errormsg;
	}
	
	public function getFields($id) {
		$campos = parent::getFields($id);
		$campos['fec_venc_cai'] = BCUtils::formatDateJS($campos['fec_venc_cai']);
		return $campos;
	}
}

?>