<?php
require_once 'be/Moneda.php';
require_once 'dal/MonedaFacade.php';
require_once "bc/ABMCtrl.php";


class ABMMonedaCtrl extends ABMCtrl {
	
	
	function __construct() {
		$this->_facade = new MonedaFacade();
		$this->_idName = "id_moneda";
		$this->_filtroValido = "activo = 'S'";
	}
	
	function serverValidation($campos) {
		return $this->_serverValidation("codigo","id_moneda", $campos);
	}
	
	function getMessage() {
		return $this->_errormsg;
	}
}

?>