<?php

class BE_Utils {
	function add($oEntity, &$aEntity, $name, $oAuditoria, $adic = null) {
		//me fijo que no exista el elemento
		foreach($aEntity as $e) {
			if ($e[$name] == $oEntity->getID()) {
				throw new Exception ("El elemento ya existe para esta entidad");
			}
		}
		if ($adic == null) {
			$aEntity[] = array($name => $oEntity, 'auditoria' => $oAuditoria);
		}
		else {
			$aEntity[] = array($name => $oEntity, 'auditoria' => $oAuditoria, 'adicional' => $adic);
		}
	}
	
	function remove($id, &$aEntity, $name) {
		$actualizada = false;
		for ($i=0; $i<count($aEntity); $i++) {
			if ($aEntity[$i][$name]->getID() == $id) {
				if ($aEntity[$i]['auditoria']->get_activo()) {
					$aEntity[$i]['auditoria']->set_activo(false);
					$actualizada = true;
				}
				else {
					throw new Exception("El elemento ya esta activado para esta entidad");
				}
			}
		}
		if (!$actualizada) {
			throw new Exception ("El elemento no existe para esta entidad");
		}
	}
	
	function activate($id, &$aEntity, $name) {
		$actualizada = false;
		for ($i=0; $i<count($aEntity); $i++) {
			if ($aEntity[$i][$name]->getID() == $id) {
				if (!$aEntity[$i]['auditoria']->get_activo()) {
					$aEntity[$i]['auditoria']->set_activo(true);
					$actualizada = true;
				}
				else {
					throw new Exception("El elemento ya esta activado para esta entidad");
				}
			}
		}
		if (!$actualizada) {
			throw new Exception ("El elemento no existe para esta entidad");
		}
	}
}

?>