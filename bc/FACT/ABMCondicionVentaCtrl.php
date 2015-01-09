<?php
require_once 'be/CondicionVenta.php';
require_once 'dal/CondicionVentaFacade.php';
require_once "bc/ABMCtrl.php";


class ABMCondicionVentaCtrl extends ABMCtrl {
	
	
	function __construct() {
		$this->_facade = new CondicionVentaFacade();
		$this->_idName = "id_condicion_venta";
		$this->_filtroValido = "activo = 'S'";
	}
	
	function serverValidation($campos) {
		return $this->_serverValidation("descripcion", "id_tipo_documento", $campos);
	}
	
	function getMessage() {
		return $this->_errormsg;
	}
}

?>