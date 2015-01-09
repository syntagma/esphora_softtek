<?php
require_once 'be/Periodo.php';
require_once 'dal/PeriodoFacade.php';
require_once "bc/ABMCtrl.php";
require_once 'bc/BCUtils.php';


class ABMPeriodoCtrl extends ABMCtrl {
	
	
	function __construct() {
		$this->_facade = new PeriodoFacade();
		$this->_idName = "id_periodo";
		$this->_filtroValido = "activo = 'S'";
		$this->_filtroEmpresa = "id_empresa = " . GLOBAL_EMPRESA;
		$this->_order = "PERIODO.fecha_inicio DESC";
	}
	
	function serverValidation(&$campos) {
		//formateo fechas
		
		$campos['fecha_inicio'] = BCUtils::formatDate($campos['fecha_inicio']);
		$campos['fecha_fin'] = BCUtils::formatDate($campos['fecha_fin']);
		
		return $this->_serverValidation("nombre", "id_periodo", $campos);
	}
	
	function getMessage() {
		return $this->_errormsg;
	}
}

?>