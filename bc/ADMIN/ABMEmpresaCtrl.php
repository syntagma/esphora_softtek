<?php
require_once 'be/Empresa.php';
require_once 'dal/EmpresaFacade.php';
require_once 'dal/MonedaFacade.php';
require_once "bc/ABMCtrl.php";
require_once 'bc/BCUtils.php';

class ABMEmpresaCtrl extends ABMCtrl {
	function __construct() {
		$this->_facade = new EmpresaFacade();
		$this->_idName = "id_empresa";
		$this->_order = "nombre";
	}
	
	function serverValidation(&$campos) {
		$campos['fecha_inicio_actividades'] = BCUtils::formatDate($campos['fecha_inicio_actividades']);
		return $this->_serverValidation("nombre", "id_empresa", $campos);
	}
	
	function getListas($id = null) {
		
		$a = array();
		
		if ($id == null) {
			$idPais = $this->_facade->getParametro('PAIS_DEFAULT');
			$idProvincia = $this->_facade->getParametro('PROVINCIA_DEFAULT');
			$idTipoDocumento = $this->_facade->getParametro('TIPO_DOCUMENTO_DEFAULT');
			$idMoneda = 1;
		}
		else {
			$reg = $this->_facade->fetchRows($id);
			$idPais = $reg['id_pais'];
			$idProvincia = $reg['id_provincia'];
			$idTipoDocumento = $reg['id_tipo_documento'];
			$idMoneda = $reg['id_moneda'];
		}
		
		$a["tipos_documento"] = $this->_getHijas("descripcion", $idTipoDocumento, new TipoDocumentoFacade());
		
		$a["paises"] = $this->_getHijas("descripcion", $idPais, new PaisFacade());
		
		$a["provincias"] = $this->_getHijas("descripcion", $idProvincia, new ProvinciaFacade(), "id_pais = $idPais");
		
		$a["monedas"] = $this->_getHijas("descripcion", $idMoneda, new MonedaFacade());
		
		return $a;
	}
	
	public function getNombresListas() {
		return array('tipos_documento', 'paises', 'provincias');
	}
}

?>