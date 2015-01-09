<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once ('be/Auditoria.php');
require_once ('be/TipoComprobante.php');
require_once ('be/Proveedor.php');
require_once ('be/Empresa.php');

class Compra extends Auditoria {
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
	
	//CAMPOS
	private $_puntoVenta;
	private $_nroFactura;
	private $_total;
	private $_importeNetoGravado;
	private $_impuestoLiquidado;
	private $_impuestoLiquidadoRni;
	private $_importeOpeExentas;
	private $_fechaVencPago;
	private $_fecCbte;
	private $_fecRegistroContable;
	private $_percIva;
	private $_percImpNacionales;
	private $_percIIBB;
	private $_percImpuestosMunicipales;
	private $_impuestosInternos;
	private $_idMoneda;
	private $_cotizacion;
	private $_idTipoComprobante;
	private $_idCondicionVenta;
	private $_detallada;
	private $_retenciones;
	private $_idEmpresa;
	private $_idProveedor;
	private $_cae;
	private $_comentarios;
	
	//MAPEO
	public function map($fields) {
		if (is_array($fields)) {
			parent::map($fields);
			$this->assign($this->ID,$fields['id_compra']);
			$this->assign($this->_puntoVenta,$fields['punto_venta']);
			$this->assign($this->_nroFactura,$fields['nro_factura']);
			$this->assign($this->_total,$fields['total']);
			$this->assign($this->_importeNetoGravado,$fields['importe_neto_gravado']);
			$this->assign($this->_impuestoLiquidado,$fields['impuesto_liquidado']);
			$this->assign($this->_impuestoLiquidadoRni,$fields["impuesto_liquidado_rni"]);
			$this->assign($this->_importeOpeExentas,$fields["importe_ope_exentas"]);
			$this->assign($this->_fechaVencPago,$fields['fecha_venc_pago']);
			$this->assign($this->_fecRegistroContable,$fields['fec_registro_contable']);
			$this->assign($this->_percIva,$fields['perc_iva']);
			$this->assign($this->_percImpNacionales,$fields['perc_impuestos_nacionales']);
			$this->assign($this->_percIIBB,$fields['perc_iibb']);
			$this->assign($this->_percImpuestosMunicipales,$fields['perc_impuestos_municipales']);
			$this->assign($this->_impuestosInternos,$fields['impuestos_internos']);
			$this->assign($this->_idMoneda,$fields['id_moneda']);
			$this->assign($this->_cotizacion,$fields['cotizacion']);
			$this->assign($this->_idTipoComprobante,$fields['id_tipo_comprobante']);
			$this->assign($this->_idCondicionVenta,$fields['id_condicion_venta']);
			$this->assign($this->_detallada,$fields['detallada']);
			$this->assign($this->_retenciones,$fields['retenciones']);
			$this->assign($this->_idEmpresa,$fields['id_empresa']);
			$this->assign($this->_idProveedor,$fields['id_proveedor']);
			$this->assign($this->_cae,$fields['cae']);
			$this->assign($this->_comentarios,$fields['comentarios']);
			$this->assign($this->_fecCbte,$fields["fec_cbte"]);		
		}		
	}
	
	public function to_array() {
		$row = parent::to_array();
		$this->assign($row['id_compra'], $this->ID);
		$this->assign($row['punto_venta'], $this->_puntoVenta);
		$this->assign($row['nro_factura'], $this->_nroFactura);
		$this->assign($row['total'], $this->_total);
		$this->assign($row['importe_neto_gravado'], $this->_importeNetoGravado);
		$this->assign($row['impuesto_liquidado'], $this->_impuestoLiquidado);
		$this->assign($row['impuesto_liquidado_rni'], $this->_impuestoLiquidadoRni);
		$this->assign($row['importe_ope_exentas'], $this->_importeOpeExentas);
		$this->assign($row['fecha_venc_pago'], $this->_fechaVencPago);
		$this->assign($row['fec_cbte'], $this->_fecCbte);
		$this->assign($row['fec_registro_contable'],$this->_fecRegistroContable);
		$this->assign($row['perc_iva'],$this->_percIva);
		$this->assign($row['perc_impuestos_nacionales'],$this->_percImpNacionales);
		$this->assign($row['perc_iibb'],$this->_percIIBB);
		$this->assign($row['perc_impuestos_municipales'],$this->_percImpuestosMunicipales);
		$this->assign($row['impuestos_internos'],$this->_impuestosInternos);	
		$this->assign($row['id_moneda'],$this->_idMoneda);	
		$this->assign($row['cotizacion'],$this->_cotizacion);	
		$this->assign($row['id_tipo_comprobante'],$this->_idTipoComprobante);	
		$this->assign($row['id_condicion_venta'],$this->_idCondicionVenta);	
		$this->assign($row['detallada'],$this->_detallada);	
		$this->assign($row['retenciones'],$this->_retenciones);	
		$this->assign($row['id_empresa'],$this->_idEmpresa);	
		$this->assign($row['id_proveedor'],$this->_idProveedor);	
		$this->assign($row['cae'],$this->_cae);	
		$this->assign($row['comentarios'],$this->_comentarios);	
		return ($row);
	}
	/**
	 * @return unknown
	 */
	public function get_cae() {
		return $this->_cae;
	}
	
	/**
	 * @return unknown
	 */
	public function get_comentarios() {
		return $this->_comentarios;
	}
	
	/**
	 * @return unknown
	 */
	public function get_cotizacion() {
		return $this->_cotizacion;
	}
	
	/**
	 * @return unknown
	 */
	public function get_detallada() {
		return $this->_detallada;
	}
	
	/**
	 * @return unknown
	 */
	public function get_fecCbte() {
		return $this->_fecCbte;
	}
	
	/**
	 * @return unknown
	 */
	public function get_fechaVencPago() {
		return $this->_fechaVencPago;
	}
	
	/**
	 * @return unknown
	 */
	public function get_fecRegistroContable() {
		return $this->_fecRegistroContable;
	}
	
	/**
	 * @return unknown
	 */
	public function get_idCondicionVenta() {
		return $this->_idCondicionVenta;
	}
	
	/**
	 * @return unknown
	 */
	public function get_idEmpresa() {
		return $this->_idEmpresa;
	}
	
	/**
	 * @return unknown
	 */
	public function get_idMoneda() {
		return $this->_idMoneda;
	}
	
	/**
	 * @return unknown
	 */
	public function get_idProveedor() {
		return $this->_idProveedor;
	}
	
	/**
	 * @return unknown
	 */
	public function get_idTipoComprobante() {
		return $this->_idTipoComprobante;
	}
	
	/**
	 * @return unknown
	 */
	public function get_importeNetoGravado() {
		return $this->_importeNetoGravado;
	}
	
	/**
	 * @return unknown
	 */
	public function get_importeOpeExentas() {
		return $this->_importeOpeExentas;
	}
	
	/**
	 * @return unknown
	 */
	public function get_impuestoLiquidado() {
		return $this->_impuestoLiquidado;
	}
	
	/**
	 * @return unknown
	 */
	public function get_impuestoLiquidadoRni() {
		return $this->_impuestoLiquidadoRni;
	}
	
	/**
	 * @return unknown
	 */
	public function get_impuestosInternos() {
		return $this->_impuestosInternos;
	}
	
	/**
	 * @return unknown
	 */
	public function get_nroFactura() {
		return $this->_nroFactura;
	}
	
	/**
	 * @return unknown
	 */
	public function get_percIIBB() {
		return $this->_percIIBB;
	}
	
	/**
	 * @return unknown
	 */
	public function get_percImpNacionales() {
		return $this->_percImpNacionales;
	}
	
	/**
	 * @return unknown
	 */
	public function get_percImpuestosMunicipales() {
		return $this->_percImpuestosMunicipales;
	}
	
	/**
	 * @return unknown
	 */
	public function get_percIva() {
		return $this->_percIva;
	}
	
	/**
	 * @return unknown
	 */
	public function get_puntoVenta() {
		return $this->_puntoVenta;
	}
	
	/**
	 * @return unknown
	 */
	public function get_retenciones() {
		return $this->_retenciones;
	}
	
	/**
	 * @return unknown
	 */
	public function get_total() {
		return $this->_total;
	}
	
	/**
	 * @param unknown_type $_cae
	 */
	public function set_cae($_cae) {
		$this->_cae = $_cae;
	}
	
	/**
	 * @param unknown_type $_comentarios
	 */
	public function set_comentarios($_comentarios) {
		$this->_comentarios = $_comentarios;
	}
	
	/**
	 * @param unknown_type $_cotizacion
	 */
	public function set_cotizacion($_cotizacion) {
		$this->_cotizacion = $_cotizacion;
	}
	
	/**
	 * @param unknown_type $_detallada
	 */
	public function set_detallada($_detallada) {
		$this->_detallada = $_detallada;
	}
	
	/**
	 * @param unknown_type $_fecCbte
	 */
	public function set_fecCbte($_fecCbte) {
		$this->_fecCbte = $_fecCbte;
	}
	
	/**
	 * @param unknown_type $_fechaVencPago
	 */
	public function set_fechaVencPago($_fechaVencPago) {
		$this->_fechaVencPago = $_fechaVencPago;
	}
	
	/**
	 * @param unknown_type $_fecRegistroContable
	 */
	public function set_fecRegistroContable($_fecRegistroContable) {
		$this->_fecRegistroContable = $_fecRegistroContable;
	}
	
	/**
	 * @param unknown_type $_idCondicionVenta
	 */
	public function set_idCondicionVenta($_idCondicionVenta) {
		$this->_idCondicionVenta = $_idCondicionVenta;
	}
	
	/**
	 * @param unknown_type $_idEmpresa
	 */
	public function set_idEmpresa($_idEmpresa) {
		$this->_idEmpresa = $_idEmpresa;
	}
	
	/**
	 * @param unknown_type $_idMoneda
	 */
	public function set_idMoneda($_idMoneda) {
		$this->_idMoneda = $_idMoneda;
	}
	
	/**
	 * @param unknown_type $_idProveedor
	 */
	public function set_idProveedor($_idProveedor) {
		$this->_idProveedor = $_idProveedor;
	}
	
	/**
	 * @param unknown_type $_idTipoComprobante
	 */
	public function set_idTipoComprobante($_idTipoComprobante) {
		$this->_idTipoComprobante = $_idTipoComprobante;
	}
	
	/**
	 * @param unknown_type $_importeNetoGravado
	 */
	public function set_importeNetoGravado($_importeNetoGravado) {
		$this->_importeNetoGravado = $_importeNetoGravado;
	}
	
	/**
	 * @param unknown_type $_importeOpeExentas
	 */
	public function set_importeOpeExentas($_importeOpeExentas) {
		$this->_importeOpeExentas = $_importeOpeExentas;
	}
	
	/**
	 * @param unknown_type $_impuestoLiquidado
	 */
	public function set_impuestoLiquidado($_impuestoLiquidado) {
		$this->_impuestoLiquidado = $_impuestoLiquidado;
	}
	
	/**
	 * @param unknown_type $_impuestoLiquidadoRni
	 */
	public function set_impuestoLiquidadoRni($_impuestoLiquidadoRni) {
		$this->_impuestoLiquidadoRni = $_impuestoLiquidadoRni;
	}
	
	/**
	 * @param unknown_type $_impuestosInternos
	 */
	public function set_impuestosInternos($_impuestosInternos) {
		$this->_impuestosInternos = $_impuestosInternos;
	}
	
	/**
	 * @param unknown_type $_nroFactura
	 */
	public function set_nroFactura($_nroFactura) {
		$this->_nroFactura = $_nroFactura;
	}
	
	/**
	 * @param unknown_type $_percIIBB
	 */
	public function set_percIIBB($_percIIBB) {
		$this->_percIIBB = $_percIIBB;
	}
	
	/**
	 * @param unknown_type $_percImpNacionales
	 */
	public function set_percImpNacionales($_percImpNacionales) {
		$this->_percImpNacionales = $_percImpNacionales;
	}
	
	/**
	 * @param unknown_type $_percImpuestosMunicipales
	 */
	public function set_percImpuestosMunicipales($_percImpuestosMunicipales) {
		$this->_percImpuestosMunicipales = $_percImpuestosMunicipales;
	}
	
	/**
	 * @param unknown_type $_percIva
	 */
	public function set_percIva($_percIva) {
		$this->_percIva = $_percIva;
	}
	
	/**
	 * @param unknown_type $_puntoVenta
	 */
	public function set_puntoVenta($_puntoVenta) {
		$this->_puntoVenta = $_puntoVenta;
	}
	
	/**
	 * @param unknown_type $_retenciones
	 */
	public function set_retenciones($_retenciones) {
		$this->_retenciones = $_retenciones;
	}
	
	/**
	 * @param unknown_type $_total
	 */
	public function set_total($_total) {
		$this->_total = $_total;
	}
}
?>