<?php
require_once 'be/TipoDocumento.php';
require_once 'dal/TipoDocumentoFacade.php';
require_once "bc/ABMCtrl.php";


class ABMTipoDocumentoCtrl extends ABMCtrl {
	
	
	function __construct() {
		$this->_facade = new TipoDocumentoFacade();
		$this->_idName = "id_tipo_documento";
		$this->_filtroValido = "T.activo = 'S'";
	}
	
	function serverValidation($campos) {
		return $this->_serverValidation("descripcion", "id_tipo_documento", $campos);
	}
	
	function getMessage() {
		return $this->_errormsg;
	}
}

?>