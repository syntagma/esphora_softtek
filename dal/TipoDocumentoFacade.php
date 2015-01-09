<?php

require_once ('db/Tipo_documento_Table.php');
require_once ('dal/TableFacade.php');
require_once ('be/TipoDocumento.php');

class TipoDocumentoFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Tipo_Documento";
		$this->_idName="id_tipo_documento";
		parent::__construct ();
	
	}
	
	public function getForm() {
		$cols = array("descripcion", "cod_doc_afip");
		return parent::getForm($cols);
	}
}

?>