<?php
require_once 'be/AlicuotaIva.php';
require_once 'dal/AlicuotaIvaFacade.php';
require_once "bc/ABMCtrl.php";


class ABMAlicuotaIvaCtrl extends ABMCtrl {
	
	
	function __construct() {
		$this->_facade = new AlicuotaIvaFacade();
		$this->_idName = "id_alicuota_iva";
		$this->_filtroValido = "activo = 'S'";
	}
	
	function serverValidation($campos) {
		return $this->_serverValidation("descripcion", "id_alicuota_iva", $campos);
	}
	
	function getMessage() {
		return $this->_errormsg;
	}
}

?>