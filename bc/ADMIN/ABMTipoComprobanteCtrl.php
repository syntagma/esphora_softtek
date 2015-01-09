<?php
require_once 'be/TipoComprobante.php';
require_once 'dal/TipoComprobanteFacade.php';
require_once "bc/ABMCtrl.php";


class ABMTipoComprobanteCtrl extends ABMCtrl {
	function __construct() {
		$this->_facade = new TipoComprobanteFacade();
		$this->_idName = "id_tipo_comprobante";
		$this->_filtroValido = "T.activo = 'S'";
	}
	
	function serverValidation($campos) {
		return $this->_serverValidation("cod_comprobante", "id_tipo_comprobante", $campos);
	}
	
	function getMessage() {
		return $this->_errormsg;
	}
}

?>