<?php
require_once 'be/UnidadMedida.php';
require_once 'dal/UnidadMedidaFacade.php';
require_once "bc/ABMCtrl.php";


class ABMUnidadMedidaCtrl extends ABMCtrl {
	
	
	function __construct() {
		$this->_facade = new UnidadMedidaFacade();
		$this->_idName = "id_unidad_medida";
		$this->_filtroValido = "activo = 'S'";
	}
	
	function serverValidation($campos) {
		return $this->_serverValidation("descripcion", "id_unidad_medida", $campos);
	}
	
	function getMessage() {
		return $this->_errormsg;
	}
}

?>