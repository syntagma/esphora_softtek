<?php
require_once 'be/CondicionIva.php';
require_once 'dal/CondicionIvaFacade.php';
require_once "bc/ABMCtrl.php";


class ABMCondicionIvaCtrl extends ABMCtrl {
	
	
	function __construct() {
		$this->_facade = new CondicionIvaFacade();
		$this->_idName = "id_condicion_iva";
		$this->_filtroValido = "activo = 'S'";
	}
	
	function serverValidation($campos) {
		return $this->_serverValidation("descripcion", "id_condicion_iva", $campos);
	}
	
	function getMessage() {
		return $this->_errormsg;
	}
}

?>