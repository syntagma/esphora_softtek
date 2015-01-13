<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');
require_once ('be/TipoComprobante.php');
require_once ('be/Cliente.php');
require_once ('be/Empresa.php');

class Factura extends Auditoria {
	//ID
	private $ID;
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
			$this->assign($this->ID,$fields['id_factura']);
			$this->assign($this->_idPuntoVenta,$fields['id_punto_venta']);
			$this->assign($this->_nroFactura,$fields['nro_factura']);
			$this->assign($this->_total,$fields['total']);
			$this->assign($this->_importeNetoGravado,$fields['importe_neto_gravado']);
			$this->assign($this->_impuestoLiquidado,$fields['impuesto_liquidado']);
			$this->assign($this->_impuestoLiquidadoMi,$fields['impuesto_liquidado_rni']);
			$this->assign($this->_importeOpeExentas,$fields['importe_ope_exentas']);
			$this->assign($this->_fecServDesde,$fields['fec_serv_desde']);
			$this->assign($this->_fecServHasta,$fields['fec_serv_hasta']);
			$this->assign($this->_fechaVencPago,$fields['fecha_venc_pago']);
			$this->assign($this->_fecCbte,$fields['fec_cbte']);
			$this->assign($this->_prestaServ,$fields['presta_serv']);
			$this->assign($this->_tipoFactProdServ,$fields['tipoFactProdServ']);
			
			if(isset($fields['id_tipo_comprobante'])) {
				$this->_oTipoComprobante = new TipoComprobante(); 
				$this->_oTipoComprobante->setID($fields['id_tipo_comprobante']);
			}
			
			if(isset($fields['id_cliente'])) {
				$this->_oCliente = new TipoCliente(); 
				$this->_oCliente->setID($fields['id_cliente']);
			}
			
			if(isset($fields['id_empresa'])) {
				$this->_oEmpresa = new Empresa(); 
				$this->_oEmpresa->setID($fields['id_empresa']);
			}
		}		
	}
	
	public function to_array() {
		$row = parent::to_array();
		$this->assign($row['id_factura'], $this->ID);
		$this->assign($row['id_punto_venta'], $this->_idPuntoVenta);
		$this->assign($row['nro_factura'], $this->_nroFactura);
		$this->assign($row['total'], $this->_total);
		$this->assign($row['importe_neto_gravado'], $this->_importeNetoGravado);
		$this->assign($row['impuesto_liquidado'], $this->_impuestoLiquidado);
		$this->assign($row['impuesto_liquidado_rni'], $this->_impuestoLiquidadoMi);
		$this->assign($row['importe_ope_exentas'], $this->_importeOpeExentas);
		$this->assign($row['fec_serv_desde'], $this->_fecServDesde);
		$this->assign($row['fec_serv_hasta'], $this->_fecServHasta);
		$this->assign($row['fecha_venc_pago'], $this->_fechaVencPago);
		$this->assign($row['fec_cbte'], $this->_fecCbte);
		$this->assign($row['presta_serv'], $this->_prestaServ);
		$this->assign($row['tipoFactProdServ'], $this->_tipoFactProdServ);
		if (isset($this->_oTipoComprobante))
			$this->assign($row['id_tipo_comprobante'], $this->_oTipoComprobante->getID());
			
		if (isset($this->_oCliente))
			$this->assign($row['id_cliente'], $this->_oCliente->getID());
				
		if (isset($this->_oEmpresa))
			$this->assign($row['id_empresa'], $this->_oEmpresa->getID());
			
		return $row;
	}
	
	//CAMPOS
	private $_idPuntoVenta;
	private $_nroFactura;
	private $_total;
	private $_importeNetoGravado;
	private $_impuestoLiquidado;
	private $_impuestoLiquidadoMi;
	private $_importeOpeExentas;
	private $_fecServDesde;
	private $_fecServHasta;
	private $_fechaVencPago;
	private $_fecCbte;
	private $_prestaServ;
	private $_tipoFactProdServ;
	private $_oTipoComprobante;
	private $_oCliente;
	private $_oEmpresa;
	
	public function getTipoComprobante() { return $this->_oTipoComprobante; }
	public function getCliente() { return $this->_oCliente; }
	public function getEmpresa() { return $this->_oEmpresa; }
	
	public function setTipoComprobante(TipoComprobante $oTipoComprobante) { $this->_oTipoComprobante = $oTipoComprobante; }
	public function setCliente(Cliente $oCliente) { $this->_oCliente = $oCliente; }
	public function setEmpresa(Empresa $oEmpresa) { $this->_oEmpresa = $oEmpresa; }
	
	public function get_tipoFactProdServ() {
		return $this->_tipoFactProdServ;
	}
	
	public function get_fecCbte() {
		return $this->_fecCbte;
	}
	
	public function get_fechaVencPago() {
		return $this->_fechaVencPago;
	}
	
	public function get_fecServDesde() {
		return $this->_fecServDesde;
	}
	
	public function get_fecServHasta() {
		return $this->_fecServHasta;
	}
	
	public function get_importeNetoGravado() {
		return $this->_importeNetoGravado;
	}
	
	public function get_importeOpeExentas() {
		return $this->_importeOpeExentas;
	}
	
	public function get_impuestoLiquidado() {
		return $this->_impuestoLiquidado;
	}
	
	public function get_impuestoLiquidadoMi() {
		return $this->_impuestoLiquidadoMi;
	}
	
	public function get_nroFactura() {
		return $this->_nroFactura;
	}
	
	public function get_prestaServ() {
		return $this->_prestaServ;
	}
	
	public function get_idPuntoVenta() {
		return $this->_idPuntoVenta;
	}
	
	public function set_tipoFactProdServ($_tipoFactProdServ) {
		$this->_tipoFactProdServ = $_tipoFactProdServ;
	}
	
	public function get_total() {
		return $this->_total;
	}
	
	public function set_fecCbte($_fecCbte) {
		$this->_fecCbte = $_fecCbte;
	}
	
	public function set_fechaVencPago($_fechaVencPago) {
		$this->_fechaVencPago = $_fechaVencPago;
	}
	
	public function set_fecServDesde($_fecServDesde) {
		$this->_fecServDesde = $_fecServDesde;
	}
	
	public function set_fecServHasta($_fecServHasta) {
		$this->_fecServHasta = $_fecServHasta;
	}
	
	public function set_importeNetoGravado($_importeNetoGravado) {
		$this->_importeNetoGravado = $_importeNetoGravado;
	}
	
	public function set_importeOpeExentas($_importeOpeExentas) {
		$this->_importeOpeExentas = $_importeOpeExentas;
	}
	
	public function set_impuestoLiquidado($_impuestoLiquidado) {
		$this->_impuestoLiquidado = $_impuestoLiquidado;
	}
	
	public function set_impuestoLiquidadoMi($_impuestoLiquidadoMi) {
		$this->_impuestoLiquidadoMi = $_impuestoLiquidadoMi;
	}
	
	public function set_nroFactura($_nroFactura) {
		$this->_nroFactura = $_nroFactura;
	}
	
	public function set_prestaServ($_prestaServ) {
		$this->_prestaServ = $_prestaServ;
	}
	
	public function set_idPuntoVenta($_idPuntoVenta) {
		$this->_idPuntoVenta = $_idPuntoVenta;
	}
	
	public function set_total($_total) {
		$this->_total = $_total;
	}
}

?>