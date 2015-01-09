<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

class TableFactory {
	public function createTable($tabla, $conn) {
		switch ($tabla) {
			case "Rol":
				$ret = new Rol_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Pantalla":
				$ret = new Pantalla_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Funcion":
				$ret = new Funcion_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Funcion_Pantalla":
				$ret = new Funcion_pantalla_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Rol_Funcion":
				$ret = new Rol_funcion_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Modulo":
				$ret = new Modulo_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Tipo_Comprobante":
				$ret = new Tipo_comprobante_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Tipo_Documento":
				$ret = new Tipo_documento_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Empresa":
				$ret = new Empresa_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Cliente":
				$ret = new Cliente_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Licencia":
				$ret = new Licencia_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Tipo_Movimiento":
				$ret = new Tipo_movimiento_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Registro":
				$ret = new Registro_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Estado_Lote":
				$ret = new Estado_lote_Table($conn, strtoupper($tabla), "verify");
				break;	
			case "Pais":
				$ret = new Pais_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Provincia":
				$ret = new Provincia_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Usuario":
				$ret = new Usuario_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Usuario_Rol_Empresa":
				$ret = new Usuario_rol_empresa_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Lote":
				$ret = new Lote_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Parametros":
				$ret = new Parametros_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Factura":
				$ret = new Factura_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Factura_Lote":
				$ret = new Factura_lote_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Alicuota_Iva":
				$ret = new Alicuota_iva_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Condicion_Iva":
				$ret = new Condicion_iva_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Condicion_Venta":
				$ret = new Condicion_venta_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Detalle_Factura":
				$ret = new Detalle_factura_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Detalle_Compra":
				$ret = new Detalle_compra_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Factura_Motivo_Rechazo":
				$ret = new Factura_motivo_rechazo_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Punto_Venta":
				$ret = new Punto_Venta_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Moneda":
				$ret = new Moneda_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Unidad_Medida":
				$ret = new Unidad_Medida_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Retencion":
				$ret = new Retencion_Table($conn, strtoupper($tabla), "verify");
				break;
			case "Detalle_Percepciones_Factura":
				$ret = new Detalle_percepciones_factura_Table($conn, strtoupper($tabla), "verify");
				break;	
			case "Detalle_Percepciones_Compra":
				$ret = new Detalle_percepciones_compra_Table($conn, strtoupper($tabla), "verify");
				break;	
			case "Proveedor":
				$ret = new Proveedor_Table($conn, strtoupper($tabla), "verify");
				break;	
			case "Compra":
				$ret = new Compra_Table($conn, strtoupper($tabla), "verify");
				break;								
			case "Periodo":
				$ret = new Periodo_Table ($conn, strtoupper($tabla), "verify");
				break;
			case "Motivo_Rechazo":
				$ret = new Motivo_rechazo_Table ($conn, strtoupper($tabla), "verify");
				break;		
				default:
				throw new Exception("No se creo tabla $tabla");
		}
		return $ret;
	}
	
	public function createEntity($tabla) {
		switch ($tabla) {
			case "Rol":
				$ret = new Rol();
				break;
			case "Pantalla":
				$ret = new Pantalla();
				break;
			case "Funcion":
				$ret = new Funcion();
				break;
			case "Tipo_Rechazo":
				$ret = new TipoRechazo();
				break;
			case "Error":
				$ret = new Error();
				break;
			case "Modulo":
				$ret = new Modulo();
				break;
			case "Tipo_Comprobante":
				$ret = new TipoComprobante();
				break;
			case "Tipo_Documento":
				$ret = new TipoDocumento();
				break;
			case "Empresa":
				$ret = new Empresa();
				break;
			case "Cliente":
				$ret = new Cliente();
				break;
			case "Tipo_Movimiento":
				$ret = new TipoMovimiento();
				break;
			case "Registro":
				$ret = new Registro();
				break;
			case "Estado_Lote":
				$ret = new Estado_Lote();
				break;	
			case "Pais":
				$ret = new Pais();
				break;
			case "Provincia":
				$ret = new Provincia();
				break;
			case "Usuario":
				$ret = new Usuario();
				break;
			case "Lote":
				$ret = new Lote();
				break;
			case "Factura":
				$ret = new Factura();
				break;
			case "Detalle_Factura":
				$ret = new DetalleFactura();
				break;
			case "Detalle_Compra":
				$ret = new DetalleCompra();
				break;
			case "Punto_Venta":
				$ret = new PuntoVenta();
				break;
			case "Moneda":
				$ret = new Moneda();
				break;
			case "Unidad_Medida":
				$ret = new UnidadMedida();
				break;
			default:
			case "Alicuota_Iva":
				$ret = new AlicuotaIva();
				break;
			case "Condicion_Iva":
				$ret = new CondicionIva();
				break;
			case "Condicion_Venta":
				$ret = new CondicionVenta();
				break;
			case "Detalle_Percepciones_Factura":
				$ret = new DetallePercepcionesFactura();
				break;
			case "Detalle_Percepciones_Compra":
				$ret = new DetallePercepcionesCompra();
				break;
			case "Proveedor":
				$ret = new Proveedor();
				break;
			case "Compra":
				$ret = new Compra();
				break;
			case "Periodo":
				$ret = new Periodo();
				break;
			default:
				throw new Exception("No se creo entidad $tabla");
		}
		
		return $ret;
	}
}
?>