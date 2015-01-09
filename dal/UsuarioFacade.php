<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('dal/TableFacade.php');
require_once 'be/Usuario.php';
require_once 'db/Usuario_Table.php';

require_once 'dal/RolFacade.php';
require_once 'dal/EmpresaFacade.php';

require_once 'db/Usuario_rol_empresa_Table.php';

class UsuarioFacade extends TableFacade {
	
	function __construct() {
		$this->_table="Usuario";
		$this->_idName="id_usuario";
		parent::__construct ();
	
	}
	
public function add(Usuario &$oUsuario) {
		parent::add($oUsuario);
		
		//inserto las pantallas
		$rows = $oUsuario->mapRolEmpresa();
		$this->modifyLink($rows, "Usuario_Rol_Empresa", null);
	}
	
	public function modify(Usuario &$oUsuario) {
		parent::modify($oUsuario);
		
		//modifico las pantallas
		$rows = $oUsuario->mapRolEmpresa();
		$this->modifyLink($rows, "Usuario_Rol_Empresa", array('id_usuario', 'id_rol', 'id_empresa'));
	}
	
	public function fetch($id) {
		$f = parent::fetch($id);
		
		//lleno las pantallas
		
		$ure = TableFactory::createTable("Usuario_Rol_Empresa", $this->_db->getConnection());
		
		$result = $ure->select("all", "id_usuario = ".$f->getID());
		
		if (PEAR::isError($result)) {
			throw new Exception("Error al consultar Usuario_Rol_Empresa");
		}
		
		
		$r = new RolFacade();
		$e = new EmpresaFacade();
		
		foreach ($result as $row) {
			$a = new Auditoria();
			$a->map($row);
			$oRol = $r->fetch($row['id_rol']);
			$oEmpresa = $e->fetch($row['id_empresa']);
			$f->setRolEmpresa($oRol, $oEmpresa, $a);
		}
		
		
		return $f;
	}
	
	public function fetchAll() {
		$dataSet = parent::fetchAll();
		//lleno las pantallas de cada elemento
		
		$ure = TableFactory::createTable("Usuario_Rol_Empresa", $this->_db->getConnection());
		$r = new RolFacade();
		$e = new EmpresaFacade();
			
		for ($i=0; $i < count($dataSet); $i++) {
			$result = $ure->select("all", "id_usuario = ".$dataSet[$i]->getID());
			
			if (PEAR::isError($result)) {
				throw new Exception("Error al consultar Usuario_Rol_Empresa");
			}
			
			foreach ($result as $row) {
				$a = new Auditoria();
				$a->map($row);
				$dataSet[$i]->setRolEmpresa($r->fetch($row['id_rol']), $e->fetch($row['id_empresa']), $a);
			}
		}
		return $dataSet;
	}
	
	public function getIdByLogin($login) {
		$result = $this->getTable()->select("all", " login = '" .$login . "'");		
		if (PEAR::isError($result)) {
			//print_r($result);
			throw new Exception ("Error al seleccionar Login en tabla  ".$this->_table);
		}
		
		return $this->fetch($result[0]["id_usuario"]);
	}
	
	public function fetchRolByEmpresa($id, $idEmpresa) {
		$ure = TableFactory::createTable("Usuario_Rol_Empresa", $this->_db->getConnection());
		
		$result = $ure->select('all', $this->_idName." = $id and id_empresa = $idEmpresa and activo = 'S'");
		
		if (PEAR::isError($result)) {
			throw new Exception("Error al consultar Usuario_Rol_Empresa<br>".$result->getMessage());
		}
		
		return $result;
	}
	
	public function insertRolEmpresa($idUsuario, $idRol, $idEmpresa) {
		$ure = TableFactory::createTable("Usuario_Rol_Empresa", $this->_db->getConnection());
		
		$a = new Auditoria();
		
		$row = $a->to_array();
		
		$row['id_usuario'] 	= $idUsuario;
		$row['id_rol'] 		= $idRol;
		$row['id_empresa'] 	= $idEmpresa;
		
		$result = $ure->insert($row);
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al insertar en Usuario_Rol_Empresa.<br>".$result->getMessage());
		}
	}
	
	public function updateRolEmpresa ($idUsuario, $lista) {
		$ure = TableFactory::createTable("Usuario_Rol_Empresa", $this->_db->getConnection());
		
		//desactivo todas
		$a = new Auditoria();
		$a->unset_fechaCreacion();
		$a->unset_usuarioCreacion();
		$a->set_activo(false);
		
		$result = $ure->update($a->to_array(), $this->_idName." = $idUsuario");
		
		if (PEAR::isError($result)) {
			throw new Exception ("Error al actualizar en Usuario_Rol_Empresa.<br>".$result->getMessage());
		}
		
		$a->set_activo(true);
		
		foreach($lista as $row) {
			//si existe lo actualizo, si no, lo inserto
			$idRol = $row['id_rol'];
			$idEmpresa = $row['id_empresa'];
			
			$filter = "id_usuario = $idUsuario and id_rol = $idRol and id_empresa = $idEmpresa";
			
			$result = $ure->selectCount('all', $filter);
			
			if (PEAR::isError($result)) {
				throw new Exception ("Error al consultar Usuario_Rol_Empresa<br>".$result->getMessage());
			}
			
			if ($result > 0) {
				//lo activo
				$result = $ure->update($a->to_array(), $filter);
			
				if (PEAR::isError($result)) {
					throw new Exception ("Error al activar en Usuario_Rol_Empresa.<br>".$result->getMessage());
				}
			}
			else {
				//lo inserto
				$this->insertRolEmpresa($idUsuario, $idRol, $idEmpresa);
			}
		}
	}
}

?>