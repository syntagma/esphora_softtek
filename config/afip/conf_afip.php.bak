<?php
if(!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");
	
require_once ('Config.php');

class conf_afip {

	private $settings;
	
	function __construct () {
	
		$conf = new Config;
		$root =& $conf->parseConfig(CONFIG_DIR.'/afip/conf_afip.xml', 'XML');

		if (PEAR::isError($root)) {
			//TODO: Tirar Excepcion ///DBALSEIRO: Esta bien que haga die
    		throw new Exception  ('Error leyendo el archivo de Configuracion: ' . $root->getMessage());
		}

		$a=$root->toArray();
		$this->settings = $a['root']['conf'][AMBIENTE];
	
	}
	
	public function printSettings() {
		print_r($this->settings);
	}
	
	function get_cert () {
	   	return (AMBIENTE . "/" . $this->settings["cert"]);
	   	
	}

	function get_privatekey () {
	   	return AMBIENTE . "/" . $this->settings['privatekey'];	
	}
	

	function get_proxy_host () {
	    return $this->settings['proxy_host'] ;
	}


	function get_wsaa_wsdl () {
	   	return $this->settings['wsaa_wsdl'] ;
	}	
	
	function get_wsfe_wsdl () {
	   	return $this->settings['wsfe_wsdl'] ;
	}	

	function get_proxy_port () {
	   	return $this->settings['proxy_port'] ;
	}
	

	function get_service () {
	    return $this->settings['service'] ;
	}
	
	function get_wsaa_url () {
	    return $this->settings['wsaa_url'] ;
	}
	
	function get_wsfe_url () {
	    return $this->settings['wsfe_url'] ;
	}
	
	function get_path_sign() {
		return $this->settings['path_sign'] ;
	}
}
?>