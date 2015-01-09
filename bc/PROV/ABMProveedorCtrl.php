<?php
require_once 'dal/ProveedorFacade.php';
require_once 'dal/CondicionIvaFacade.php';
require_once "bc/ABMCtrl.php";


class ABMProveedorCtrl extends ABMCtrl {
	function __construct() {
		$this->_facade = new ProveedorFacade();
		$this->_idName = "id_proveedor";
		$this->_order = "razon_social";
		
		$this->_filtroValido = "PROVEEDOR.activo = 'S'";
		
		$this->_filtroBusqueda = "PROVEEDOR.razon_social";
	}
	
	function serverValidation($campos) {
		return $this->_serverValidation("razon_social", "id_proveedor", $campos);
	}
	
	function getListas($id = null) {
		
		$a = array();
		
		if ($id == null) {
			$idPais = $this->_facade->getParametro('PAIS_DEFAULT');
			$idProvincia = $this->_facade->getParametro('PROVINCIA_DEFAULT');
			$idTipoDocumento = $this->_facade->getParametro('TIPO_DOCUMENTO_DEFAULT');
			$idCondicionIva = null;
		}
		else {
			$reg = $this->_facade->fetchRows($id);
			$idPais = $reg['id_pais'];
			$idProvincia = $reg['id_provincia'];
			$idTipoDocumento = $reg['id_tipo_documento'];
			$idCondicionIva = $reg['id_condicion_iva'];
		}
		
		$a["tipos_documento"] = $this->_getHijas("descripcion", $idTipoDocumento, new TipoDocumentoFacade());
		
		$a["paises"] = $this->_getHijas("descripcion", $idPais, new PaisFacade());
		
		$a["provincias"] = $this->_getHijas("descripcion", $idProvincia, new ProvinciaFacade(), "id_pais = $idPais");
		
		$a["condicion_iva"] = $this->_getHijas("descripcion", $idCondicionIva, new CondicionIvaFacade());
		
		return $a;
	}
	
	public function getNombresListas() {
		return array('tipos_documento', 'paises', 'provincias');
	}

	
	protected function formBusqueda() {
		$href = $this->armaHREF();
		$ret = <<<EOF
		 	<form id='frmBusqueda'>
		 		<table>
		 			<tr>
		 				<td>Raz&oacute;n Social</td>
		 				<td><input type='text' id='txtCriterio' /></td>
		 				<td><button type='button'
		 					onclick='document.location="$href&filtro="+$("txtCriterio").value;'
		 				>Search...</button></td>
		 			</tr>
		 		</table>
		 	</form>		 				
EOF;
		return $ret;
	}
}

?>