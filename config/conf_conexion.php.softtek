<?php
if(!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");
	
require_once ("Config.php");

class conf_conexion {

	private $settings;
	
	function __construct () {
	
		$conf = new Config;
		$root =& $conf->parseConfig(CONFIG_DIR.'conf_conexion.xml', 'XML');

		if (PEAR::isError($root)) {

    		die('Error leyendo el archivo de Configuracion: ' . $root->getMessage());
		}

		$a=$root->toArray();
		$this->settings = $a['root']['conf'][AMBIENTE];
	
	}
	
	public function getConnStrLic() {
		$conf = new Config;
		$root =& $conf->parseConfig(CONFIG_DIR.'conf_conexion.xml', 'XML');

		if (PEAR::isError($root)) {

    		die('Error leyendo el archivo de Configuracion: ' . $root->getMessage());
		}

		$a=$root->toArray();
		$lic = $a['root']['conf']['licencias'];
		//		$this->_dsn=$this->_bd."://".$this->_user.":".$this->_password."@".$this->_host.":".$this->_port."/".$this->_dbname;
		
		return $lic['bd']."://".$lic['user'].":".$lic['password']."@".$lic['host'].":".$lic['port']."/".$lic['dbname'];
		/*
		return array(
	    'phptype'  => $lic['bd'],
	    'username' => $lic['user'],
	    'password' => $lic['password'],
	    'hostspec' => $lic['host'],
	    'database' => $lic['dbname'],
		'port' 	   => $lic['port']
		);*/
	}
	
	public function printSettings() {
		print_r($this->settings);
	}
	
	function get_userTable() {
		return $this->settings['users_table'];
	}
	
	function get_loginField() {
		return $this->settings['login_field'];
	}
	
	function get_passwordField() {
		return $this->settings['password_field'];
	}
	
	function get_db () {
	   	return $this->settings['bd'];
	   	
	}

	function get_user () {
	   	return $this->settings['user'];	
	}
	

	function get_password () {
	    return $this->settings['password'] ;
	}


	function get_host () {
	   	return $this->settings['host'] ;
	}	
	

	function get_port () {
	   	return $this->settings['port'] ;
	}
	

	function get_dbname () {
	    return $this->settings['dbname'] ;
	}
}
?>