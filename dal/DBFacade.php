<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once("MDB2.php");
require_once(CONFIG_DIR."/conf_conexion.php");
require_once("dal/EmpresaFacade.php");
require_once("dal/ConnectionSingleton.php");

class DBFacade {
	
	private $_db;
	private $_user;
	private $_password;
	private $_host;
	private $_port;
	private $_dbname;
	
	private $_loaded=false;
	private $_conn;
	private $_connected=false;
	private $_dsn;
	
	private $_userTable;
	private $_loginField;
	private $_passwordField;
	
	function _loadData() {		
		
		$oConf = new conf_conexion();
		
		$this->_db=$oConf->get_db(); 
		$this->_user=$oConf->get_user(); 
		$this->_password=$oConf->get_password(); 
		$this->_host=$oConf->get_host(); 
		$this->_port=$oConf->get_port(); 
		$this->_dbname=$oConf->get_dbname();
		
		$this->_userTable=$oConf->get_userTable();
		$this->_loginField=$oConf->get_loginField();
		$this->_passwordField=$oConf->get_passwordField();
	
		
//		$this->_dsn=$this->_bd."://".$this->_user.":".$this->_password."@".$this->_host.":".$this->_port."/".$this->_dbname;

	$this->_dsn=array(
	    'phptype'  => $this->_db,
	    'username' => $this->_user,
	    'password' => $this->_password,
	    'hostspec' => $this->_host,
	    'database' => $this->_dbname,
		'port' 	   => $this->_port
);

		
		$this->_loaded=true;
	}
	
	function checkLicencias($modulo) {

		$ef = new EmpresaFacade();
		$cuit = $ef->fetchRows(GLOBAL_EMPRESA);
		$cuit = $cuit['nro_documento'];
	
		$txtLic = md5(date('Ym').$modulo.$cuit);
		
		//me fijo que este la licencia en el archivo
		$nomArchivo = CONFIG_DIR . "licencias.dat";
		
		if (file_exists($nomArchivo)) {
			//leo linea por linea a ver si encuentro la licencia
			$lines = file($nomArchivo);
				
			foreach ($lines as $line) {
				if ($line == $txtLic) return array('result' => true);
			}
		}
		
		$conn = MDB2::connect(conf_conexion::getConnStrLic());
		
		if (PEAR::isError($conn)) {
			//pongo un mensaje en la cabecera para avisar que no se pudo comprobar la licencia
			return array('result' => false, 'cancela' => true, mensaje => "No se pudo conectar a SYNTAGMA para comprobar la Licencia.<br>Por favor revise la conexion a internet del servidor.");
		}
		
		$result = $conn->query ("select sysdate() hoy, FECHA_VENCIMIENTO venc from syntagmalicencia.LICENCIAMIENTO where NOMBRE_CORTO = '$modulo' and CUIT = $cuit order by FECHA_VENCIMIENTO desc");
		
		if (PEAR::isError($result)) {
			//pongo un mensaje en la cabecera para avisar que no se pudo comprobar la licencia
			$ret = array('result' => false, 'cancela' => true, 'mensaje' => "Ha ocurrio un error al consultar licencias.<br>Por favor comuniquese con mesa de ayuda.<br>".$result->getMessage()."<br>".$result->getUserInfo());
		} 
		else {
			$hayRegs = false;
			$caduca = true;
			
			while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC)) {
				$hayRegs = true;
				
				if ($row['venc'] > $row['hoy']) {
					$caduca = false;
					break;
				}
			}
			
			if (!$hayRegs) {
				$ret = array('result' => false, 'cancela' => true, 'mensaje' => "NO POSEE LICENCIAS PARA OPERAR CON ESTE MODULO.<br>Por favor comuniquese con <a href='http://syntagma.com.ar' target=_blank>Syntagma S.A.</a> para obtener las licencias correspondientes");
			}
			else if ($caduca)
				$ret = array('result' => false, 'cancela' => true, 'mensaje' => "LAS LICENCIAS PARA ESTE MODULO HAN CADUCADO.<br>Por favor comuniquese con <a href='http://syntagma.com.ar' target=_blank>Syntagma S.A.</a> para renovar las licencias correspondientes");
			else {
				$ret = array('result' => true);
				
				//actualizo la licencia local
				if ($fp = fopen ($nomArchivo, 'a+')) {				
					fwrite($fp, $txtLic."\n") or $ret = array('result' => false, 'cancela' => false, 'mensaje' => "No se pudo actualizar el archivo de licencias");
					fclose ($fp);
				}
				else {
					$ret = array('result' => false, 'cancela' => false, 'mensaje' => "No se pudo abrir el archivo de licencias");
				}
			}
		}
		
		$conn->disconnect();
		
		return $ret;
	}
	
	function _connect() {
		if (!$this->_loaded) $this->_loadData();

		$this->_conn = ConnectionSingleton::getConnection($this->_dsn);
		
		if (PEAR::isError($this->_conn)) {
			$this->_connected=false;
			print("Connect String: ");print_r($this->_dsn);print("<br>");
			throw new Exception("Error de Conexion: ". $this->_conn->getMessage() . ', ' . $this->_conn->getDebugInfo());
		}
		else {
			$this->_connected=true;
		}
	}
	
	function beginTrans() {
		if (!$this->_connected) $this->_connect();
		$this->_conn->beginTransaction();
	}
	
	function commitTrans() {
		if (!$this->_connected) $this->_connect();
		$this->_conn->commit();
	}
	
	function rollbackTrans() {
		if (!$this->_connected) $this->_connect();
		$this->_conn->rollback();
	}
	
	function disconnect() {
		if ($this->_connected) $this->_conn->disconnect();
		$this->_connected = false;
	}
	
	function getConnection() {		
		if (!$this->_connected) $this->_connect();
		
		return $this->_conn;
	}
	
	function getDBName() {
		if (!$this->_loaded) $this->_loadData();
		return $this->_dbname;
	}
	
	function getDSN() {
		if (!$this->_loaded) $this->_loadData();
		$dsn=$this->_db."://".$this->_user.":".$this->_password."@".$this->_host.":".$this->_port."/".$this->_dbname;
		return $dsn;
	}
	
	function getLoginData() {
		if (!$this->_loaded) $this->_loadData();
		$loginData = array ('user_table' => $this->_userTable,
							'login_field' => $this->_loginField,
							'password_field' => $this->_passwordField);
		return $loginData;
	}
}

?>