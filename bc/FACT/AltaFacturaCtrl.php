<?php
require_once "bc/ABMCtrl.php";
require_once 'dal/FacturaFacade.php';
require_once 'dal/AfipFacade.php';
require_once 'dal/TipoComprobanteFacade.php';
require_once 'dal/CondicionIvaFacade.php';
require_once 'dal/CondicionVentaFacade.php';
require_once 'dal/PuntoVentaFacade.php';
require_once 'dal/ClienteFacade.php';
require_once 'dal/DetalleFacturaFacade.php';
require_once 'dal/DetallePercepcionFacturaFacade.php';
require_once 'dal/MonedaFacade.php';
require_once 'dal/EmpresaFacade.php';
require_once 'dal/UnidadMedidaFacade.php';
require_once 'bc/BCUtils.php';
require_once 'dal/PeriodoFacade.php';

class AltaFacturaCtrl extends ABMCtrl {
	function __construct() {
		$this->_facade = new FacturaFacade();
		$this->_idName = "id_factura";
	}
	
	/*
	function serverValidation($campos) {
		$ptoVta = $campos['pto_vta'];
		$nroFactura = $campos['nro_factura'];
		$id = $campos['id_factura'];
		
		$filter = "pto_vta = $ptoVta and nro_factura = $nroFactura";
		
		if ($id != "") {
			$filter .= " and id_factura <> $id"; 
		}
		
		
		if ($this->_facade->getCount($filter) > 0) {
			$this->_errormsg = Translator::getTrans("CLAVE_DUPLICADA").": $value";
			return false;
		}
		return true;
	}
	*/
	
	function getListas($id = null) {
		
		$a = array();
		
		$ef = new EmpresaFacade();
		$emp = $ef->fetchRows(GLOBAL_EMPRESA);
		$monedaBase = $emp['id_moneda'];
		
		if ($id == null) {
			
			$idTipoComprobante = $this->_facade->getParametro('TIPO_COMPROBANTE_DEFAULT');
			$idCondicionVenta = null;
			$idPuntoVenta = null;
			
			$idMoneda = $monedaBase;
			
			$idUnidadMedida = null;
		}
		else {
			$reg = $this->_facade->fetchRows($id);
			$idTipoComprobante = $reg['id_tipo_comprobante'];
			$idCondicionVenta = $reg['id_condicion_iva'];
			$idPuntoVenta = $reg['id_punto_venta'];
			$idMoneda = $reg['id_moneda'];
			
			
			$reg['fec_cbte'] = BCUtils::formatDateJS($reg['fec_cbte']);
			$reg['fecha_venc_pago'] = BCUtils::formatDateJS($reg['fecha_venc_pago']);
			
			$cf = new ClienteFacade();
			
			$cliente = $cf->fetchRows($reg['id_cliente']);
			$reg['descripcion_cliente'] = $cliente['razon_social'];
			
			$a['edicion'] = $reg;
			
			if ($reg['detallada'] == 'S') {
				$dff = new DetalleFacturaFacade();
				$a['detalle'] = $dff->fetchAllRows(true, "id_factura = $id");
			} 
			
			if ($reg['retenciones'] == 'S') {
				$drf = new DetallePercepcionesFacturaFacade();
				$a['retenciones'] = $drf->fetchAllRows(true, "id_factura = $id");
				
			}
		}
		
		$periodosAbiertos = array();
		$pf = new PeriodoFacade();
		$result = $pf->fetchAllRows(true, "estado='A'");
		foreach ($result as $row) {
			$periodosAbiertos[] = array (
				'inicio'	=> BCUtils::formatDateBD($row['fecha_inicio']),
				'fin'		=> BCUtils::formatDateBD($row['fecha_fin']),
			);
		}
		
		$a["tipos_comprobante"] = $this->_getHijas("descripcion", $idTipoComprobante, new TipoComprobanteFacade());			
		
		$a["condicion_venta"] = $this->_getHijas("descripcion", $idCondicionVenta, new CondicionVentaFacade());
		
		$a["moneda"] = $this->_getHijas("descripcion", $idMoneda, new MonedaFacade());
		
		$a["punto_venta"] = $this->_getHijas("numero", $idPuntoVenta, new PuntoVentaFacade(), "PUNTO_VENTA.id_empresa = ".GLOBAL_EMPRESA, "numero");

		$a["tipo_pto_vta"] = $this->_getHijas("tipo_pto_vta", $idPuntoVenta, new PuntoVentaFacade());
		
		$a["clientes"] = $this->getListaClientes();
		
		$a['unidad_medida'] = $this->_getHijas("descripcion", $idUnidadMedida, new UnidadMedidaFacade());
		
		$a['moneda_base'] = $monedaBase;
		
		$a['periodos_abiertos'] = $periodosAbiertos;
		return $a;
	}
	
	public function getNombresListas() {
		return array('tipos_comprobante', 'clientes', "condicion_venta", 'detalle', 'edicion', "punto_venta", 'retenciones', 'moneda', 'unidad_medida', 'tipo_pto_vta', 'moneda_base', 'periodos_abiertos');
	}
	
	private function getListaClientes() {
		$cf = new ClienteFacade();
		
		return $cf->fetchSelectList();
	}

	public function addFactura($factura) {
		if(!isset($factura['presta_serv']) || !($factura['presta_serv'] == 1 || $factura['presta_serv'] == "S")) {
			$factura['presta_serv'] = "N";
			$factura['fec_serv_desde'] = null;
			$factura['fec_serv_hasta'] = null;
		}
		else {
			$factura['presta_serv'] = "S";
			//formateo fechas
			$factura['fec_serv_desde'] = BCUtils::formatDate($factura['fec_serv_desde']);
			$factura['fec_serv_hasta'] = BCUtils::formatDate($factura['fec_serv_hasta']);
		}
		
		$factura['fec_cbte'] = BCUtils::formatDate($factura['fec_cbte']);
		$factura['fecha_venc_pago'] = BCUtils::formatDate($factura['fecha_venc_pago']);
		$factura['fec_registro_contable'] = BCUtils::formatDate($factura['fec_registro_contable']);
		
		$factura['id_afip'] = $_COOKIE['esphora_idlote'];
		
		$lineas = array();
		
		if ($factura['detallada'] == "S") {
			for ($i = 1; $i < $factura['cantLineas']; $i++) {
				if ($factura["txtCantidad$i"] != 0) {
					$linea = array(
						'concepto' => $factura["txtConcepto$i"],
						'cantidad' => $factura["txtCantidad$i"],
						'precio_unitario' => $factura["txtPrecioUnitario$i"],
						'id_alicuota_iva' => $factura["cboIVA$i"],
						'id_unidad_medida' => $factura["cboUM$i"]
					);
					$lineas[] = $linea;
				}
			}
		}
		else {
			$factura['detallada'] = "N";
		}
		
		for ($i = 1; $i < $factura['cantLineas']; $i++) {
			unset ($factura["txtConcepto$i"]);
			unset ($factura["txtCantidad$i"]);
			unset ($factura["txtPrecioUnitario$i"]);
			unset ($factura["txtSubtotal$i"]);
			unset ($factura["txtTotalIVA$i"]);
			unset ($factura["txtTotal$i"]);
			unset ($factura["cboIVA$i"]);
			unset ($factura["cboUM$i"]);
		}
		unset($factura['cantLineas']);
		
		$lineasRet = array();
		
		if ($factura['retenciones'] == "S") {
			for ($i = 1; $i < $factura['cantLineasRet']; $i++) {
				if ($factura["txtAlicuota$i"] != 0) {
					//ver si la retencion es con detalle o con provincia
					$rf = new RetencionFacade();
					$retencion = $rf->fetchRows($factura["cboRET$i"]);
					
					if ($retencion['tipo_retencion'] == 'P') {
						$detalle = null;
						$idProvincia = $factura["cboProvinciaRET$i"];
					}
					else {
						$detalle = $factura["txtDetalleRet$i"];
						$idProvincia = null;
					}
					
					$linea = array(
						'id_retencion' => $factura["cboRET$i"],
						'detalle' => $detalle,
						'base_imponible' => $factura["txtBaseImponible$i"],
						'alicuota' => $factura["txtAlicuota$i"],
						'id_provincia' => $idProvincia
					);
					$lineasRet[] = $linea;
				}
			}
		}
		else {
			$factura['retenciones'] = "N";
		}
		
		
		for ($i = 1; $i < $factura['cantLineasRet']; $i++) {
			unset ($factura["cboRET$i"]);
			unset ($factura["txtDetalleRet$i"]);
			unset ($factura["txtBaseImponible$i"]);
			unset ($factura["txtAlicuota$i"]);
			unset ($factura["txtImporteRet$i"]);
			unset ($factura["cboProvinciaRET$i"]);
		}
		
		unset ($factura['cantLineasRet']);
		
		$dff = new DetalleFacturaFacade();
		$drf = new DetallePercepcionesFacturaFacade();
		
		$this->_facade->beginTrans();
		
		try {
			if ($factura['id_factura'] == null) {
				$id_factura = $this->insert($factura);
			}
			else {
				$id_factura = $factura['id_factura'];
				$this->update($factura);
				
				//borrar todos los detalles del id_factura
				$dff->eliminarDetalles($id_factura);
				$drf->eliminarDetalles($id_factura);
			}
			
			//inserto los detalles
			foreach ($lineas as $linea) {
				$linea['id_factura'] = $id_factura;
				
				$dff->addRow($linea);
			}
			
			//inserto los detalles de retenciones
			foreach ($lineasRet as $linea) {
				$linea['id_factura'] = $id_factura;
				
				$drf->addRow($linea);
			}
		}
		catch (Exception $e) {
			$this->_facade->rollbackTrans();
			throw $e;
		}
		$this->_facade->commitTrans();
	}
	
	public function consultaFactura($idAfip) {
		$af = new AfipFacade();
		$ef = new EmpresaFacade();
		
		$emp = $ef->fetchRows(GLOBAL_EMPRESA);
		
		echo "<pre style='text-align:left'>";
		print_r($af->consultaEstructura($idAfip, $emp['nro_documento']));
		echo "</pre>";
	}

	public function getListaFacturas($pagina = null, $order = null) {
		
		if ($pagina == null) $pagina = 1;

		$orden = ($order==null ? 'fec_cbte desc, nro_factura' : $order);
		
		$direction = "";
		if ($orden == $_SESSION['order']) {
			$_SESSION['direction'] = $_SESSION['direction'] == "" ? "desc" : "";
		}
		else {
			$_SESSION['order'] = $orden;
			$_SESSION['direction'] = "";
		}
		
		$direction = $orden == "fec_cbte desc, nro_factura" ? "desc" : $_SESSION['direction'];
			
		$filtro = "";
		if ($_GET['idcliente'] != null) {
			$filtro = " and FACTURA.id_cliente = ".$_GET['idcliente'];
		}
		
		if ($_GET['filtro'] != null) {
			$filtro = " and nro_factura = ".$_GET['filtro'];
		}
		
		$result = $this->_facade->fetchList("$orden $direction", $pagina, 'FACTURA.id_empresa = '.GLOBAL_EMPRESA.$filtro);
		
		$attrs = array('width' => '100%', 'class' => 'tabla-abm');
		
		$attrsPares = array('class' => 'tabla-abm-fila-par');
		$attrsImpares = array('class' => 'tabla-abm-fila-impar');
		
		$table =& new HTML_Table($attrs);
		
		foreach($result as $row) {
			$a = array();
			$i=0;
			$id=0;
			
			$muestraIconos = true;
			
			foreach ($row as $key => $value) {
				$valueCol = $value;
				
				if ($key == 'id_factura') {				
					$id = $value;
					$url = URL_ALTA_FACTURAS."&id=$id";
					$valueCol = "<a href='$url'><img src='css/".GLOBAL_THEME."/images/edit.gif' border=0 /><a>";
				}
				
				if ($key == "detallada") {
					$muestraIconos = true; //$value == "S";
					continue;
				}
				
				if ($key == 'cae') {
					if ($value == null) {
						$url = URL_ALTA_FACTURAS."&id=$id";
						$valueCol = "<a href='$url'><img src='css/".GLOBAL_THEME."/images/edit.gif' border=0 /><a>";
					}
				}
				
				if ($key == 'id_afip') {
					if ($value != null) {
						$valueCol = "<a href='javascript:verFichaAFIP($id);'>Ver datos AFIP</a>";
					}
				}

				$table->setHeaderContents(0, $i, "<a href='".$this->armaHREF(null, null, null, null, $key)."'>".Translator::getTrans($key)."</a>");
				$a[] = $valueCol;
				$i++;
			}
			
			
			if ($muestraIconos) {
				//Agrego columna de Download de Lote
				$valueCol = "<a href='".$this->armaHREF('imprimir', $id)."' onclick='document.cookie=\"__callback__=1\"'> <img src='css/emerald/images/logo-pdf.gif' alt='Imprimir' width=32 height=32 border=0 /img> </a>";
				$table->setHeaderContents(0, $i++, Translator::getTrans('imprimir'));
				$a[] = $valueCol;
				
				/*
				$valueCol = "<a href='".$this->armaHREF('email', $id)."'> <img src='css/emerald/images/email.gif' alt='Email' width=32 height=32 border=0 /img> </a>";
				$table->setHeaderContents(0, $i++, Translator::getTrans('email'));
				$a[] = $valueCol;
				*/
			}
			
			$table->setHeaderContents(0, 0, "Ver");
			$table->addRow($a, $rowAttrs);
		}
		
		$table->altRowAttributes(1, $attrsImpares, $attrsPares, true);
		
		$url = URL_ALTA_FACTURAS;
		
		$boton=<<<EOT
<button style="width:150px" onclick="document.location = '$url';">
	Alta de Facturas
</button>
EOT;
	
		return $this->botonera().$boton.$this->navigator($pagina, false, 'id_empresa = '.GLOBAL_EMPRESA.$filtro).$table->toHtml().$this->navigator($pagina, false, 'id_empresa = '.GLOBAL_EMPRESA.$filtro);
		//fin
	}

	
	function botonera () {
		if ($_GET['idcliente'] != null) unset($_GET['idcliente']);
		$href = $this->armaHREF();
		
		$filtroCliente = <<<EOF
<div style="text-align:left"><form>
	<label>Cliente:</label>
	<select onChange="
		if (!this.options[0].selected) {
			document.location = '$href&idcliente='+this.value;
		}
	">
EOF;
		//pongo las options de cliente
		$filtroCliente .= "<option value='0'>-- Filtro por Clientes --</option>";
		
		$cf = new ClienteFacade();
		$rows = $cf->fetchAllRows(true, null, "razon_social");
		foreach ($rows as $row) {
			$id = $row['id_cliente'];
			$titulo = $row['razon_social'];
			$filtroCliente .= "<option value='$id'>$titulo</option>";
		}
		$filtroCliente .= "</select></form></div>";
		
		$filtroFacturas = <<<EOF
<form>
	<table>
		<tr>
			<td>Nro de Comprobante</td>
			<td><input type="text" id="txtNroFactura" /></td>
			<td>
				<button type="button" onclick="
					if ($('txtNroFactura').value == '') {
						alert('Ingrese un numero de comprobante para buscar');
					}
					else {
						if (isNaN($('txtNroFactura').value == '')) {
							alert('Ingrese un numero valido de comprobante para buscar');
						}
						else {
							document.location='$href&filtro='+$('txtNroFactura').value;
						}
					}
				">
					Search...
				</button>
			</td>
		</tr>
	</table>
</form>
EOF;
		return $filtroCliente.$filtroFacturas;
	}
}
?>