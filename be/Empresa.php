<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');
require_once ('be/TipoDocumento.php');
require_once ('be/Domicilio.php');
require_once ('be/Telefono.php');

class Empresa extends Auditoria {
	//ID
	private $ID;
	
	/**
	 * @return unknown
	 */
	public function get_fechaInicioActividades() {
		return $this->_fechaInicioActividades;
	}
	
	/**
	 * @return unknown
	 */
	public function get_ingresos_brutos() {
		return $this->_ingresos_brutos;
	}
	
	/**
	 * @return unknown
	 */
	public function get_nombre_fantasia() {
		return $this->_nombre_fantasia;
	}
	
	/**
	 * @param unknown_type $_fechaInicioActividades
	 */
	public function set_fechaInicioActividades($_fechaInicioActividades) {
		$this->_fechaInicioActividades = $_fechaInicioActividades;
	}
	
	/**
	 * @param unknown_type $_ingresos_brutos
	 */
	public function set_ingresos_brutos($_ingresos_brutos) {
		$this->_ingresos_brutos = $_ingresos_brutos;
	}
	
	/**
	 * @param unknown_type $_nombre_fantasia
	 */
	public function set_nombre_fantasia($_nombre_fantasia) {
		$this->_nombre_fantasia = $_nombre_fantasia;
	}
	public function setID($ID) {
		$this->ID = $ID;
	}
	public function getID() {
		return $this->ID;
	}
	
	//CONSTRUCTOR
	function __construct() {
		parent::__construct ();
		
	}
	
	//MAPEO
	public function map($fields) {
		if (is_array($fields)) {
			parent::map($fields);
			$this->assign($this->ID,$fields['id_empresa']);
			$this->assign($this->_nroDocumento,$fields['nro_documento']);
			$this->assign($this->_nombre,$fields['nombre']);
			
			$this->assign($this->_fechaInicioActividades,$fields['fechaInicioActividades']);
			$this->assign($this->_ingresos_brutos,$fields['ingresos_brutos']);
			$this->assign($this->_nombre_fantasia,$fields['nombre_fantasia']);
			
			if (isset($fields['telefono'])) {
				$this->_oTelefono = new Telefono();
				$this->_oTelefono->set_telefono($fields['telefono']);
			}
			
			$this->_oDomicilio = new Domicilio();
			$this->_oDomicilio->map($fields);
			
			if(isset($fields['id_tipo_documento'])) {
				$this->_oTipoDocumento = new TipoDocumento(); 
				$this->_oTipoDocumento->setID($fields['id_tipo_documento']);
			}
		}		
	}
	
	public function to_array() {
		$row = parent::to_array();
		if ($this->ID != null) $this->assign($row['id_empresa'], $this->ID);
		if ($this->_nroDocumento != null) $this->assign($row['nro_documento'], $this->_nroDocumento);
		if ($this->_nombre != null) $this->assign($row['nombre'], $this->_nombre);
		
		if ($this->_fechaInicioActividades != null) $this->assign($row['fechaInicioActividades'], $this->_fechaInicioActividades);
		if ($this->_ingresos_brutos != null) $this->assign($row['ingresos_brutos'], $this->_ingresos_brutos);
		if ($this->_nombre_fantasia != null) $this->assign($row['nombre_fantasia'], $this->_nombre_fantasia);
		
		
		if (isset($this->_oTelefono)) {
			$this->assign($row['telefono'], $this->_oTelefono->get_telefono());
		}
		
		if (isset($this->_oDomicilio))
			foreach ($this->_oDomicilio->to_array() as $key => $value) {
				$row[$key] = $value;
			}
		
		if (isset($this->_oTipoDocumento)) {
			$this->assign($row['id_tipo_documento'], $this->_oTipoDocumento->getID());
		}
		return $row;
	}
	
	//CAMPOS
	private $_oTipoDocumento;
	private $_nroDocumento;
	private $_nombre;
	private $_oDomicilio;
	private $_oTelefono;
	private $_fechaInicioActividades;
	private $_ingresos_brutos;
	private $_nombre_fantasia;
	
	public function getTelefono() {
		return $this->_oTelefono;
	}
	
	public function setTelefono(Telefono $oTelefono) {
		$this->_oTelefono = $oTelefono;
	}
	
	
	public function getTipoDocumento() {
		return $this->_oTipoDocumento;
	}
	
	public function setTipoDocumento(TipoDocumento $oTipoDocumento) {
		$this->_oTipoDocumento = $oTipoDocumento;
	}
	public function getDomicilio() {
		return $this->_oDomicilio;
	}
	
	public function get_nombre() {
		return $this->_nombre;
	}
	
	public function get_nroDocumento() {
		return $this->_nroDocumento;
	}
	
	public function setDomicilio(Domicilio $oDomicilio) {
		$this->_oDomicilio = $oDomicilio;
	}
	
	public function set_nombre($_nombre) {
		$this->_nombre = $_nombre;
	}
	
	public function set_nroDocumento($_nroDocumento) {
		$this->_nroDocumento = $_nroDocumento;
	}
	
	//LINKS
	//Licencias (Modulos)
	private $_aLicencias = array();
	public function getLicencias() { return $this->_aPantallas; }
	
	public function addLicencia(Modulo $oModulo, DateTime $fechaValidezDesde, DateTime $fechaValidezHasta) {
		$validez = array(	
							'fecha_validez_desde' => $fechaValidezDesde->format("YmdHis"),
							'fecha_validez_hasta' => $fechaValidezHasta->format("YmdHis")
		);
		$a = new Auditoria();
		BE_Utils::add($oModulo, $this->_aLicencias, 'modulo', $a, $validez);
	}
	
	
	public function setLink(Modulo $oModulo, Auditoria $oAuditoria, $field_id, $adicional) {
		$validez = array(	
							'fecha_validez_desde' => $adicional['fecha_validez_desde'],
							'fecha_validez_hasta' => $adicional['fecha_validez_hasta']
		);
		BE_Utils::add($oModulo, $this->_aLicencias, $field_id, $oAuditoria, $validez);
	}
	
	
	public function removeLicencia($id) {
		BE_Utils::remove($id, $this->_aLicencias, 'modulo');
	}
	
	public function activateLicencia($id) {
		BE_Utils::activate($id, $this->_aLicencias, 'modulo');
	}
	
	public function mapLicencias() {
		$a = array();
		foreach ($this->_aLicencias as $p) {
			$b = $p['auditoria']->to_array();
			$b['id_empresa'] = $this->ID;
			$b['id_modulo'] = $p['modulo']->getID(); 
			
			$b['fecha_validez_desde'] = $p['adicional']['fecha_validez_desde'];
			$b['fecha_validez_hasta'] = $p['adicional']['fecha_validez_hasta'];
			
			$a[] = $b;
		}
		return $a;
	}
}

?>