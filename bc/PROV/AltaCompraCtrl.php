<?php
require_once "bc/ABMCtrl.php";
require_once 'dal/CompraFacade.php';
require_once 'dal/TipoComprobanteFacade.php';
require_once 'dal/CondicionIvaFacade.php';
require_once 'dal/CondicionVentaFacade.php';
require_once 'dal/PuntoVentaFacade.php';
require_once 'dal/ProveedorFacade.php';
require_once 'dal/MonedaFacade.php';
require_once 'dal/EmpresaFacade.php';
require_once 'dal/UnidadMedidaFacade.php';
require_once 'bc/BCUtils.php';
require_once 'be/Compra.php';
require_once 'be/DetalleCompra.php';
require_once 'be/DetallePercepcionesCompra.php';
require_once 'dal/DetallePercepcionCompraFacade.php';
require_once 'dal/DetalleCompraFacade.php';

class AltaCompraCtrl extends ABMCtrl {
	function __construct() {
		$this->_facade = new CompraFacade();
		$this->_idName = "id_compra";
	}
	
	function getListas($id = null) {
		
		$a = array();
		
		$ef = new EmpresaFacade();
		$emp = $ef->fetchRows(GLOBAL_EMPRESA);
		$monedaBase = $emp['id_moneda'];
		
		if ($id == null) {
			
			$idTipoComprobante = $this->_facade->getParametro('TIPO_COMPROBANTE_DEFAULT');
			$idCondicionVenta = null;
			
			$idMoneda = $monedaBase;
			
			$idUnidadMedida = null;
		}
		else {
			$reg = $this->_facade->fetchRows($id);
			$idTipoComprobante = $reg['id_tipo_comprobante'];
			$idCondicionVenta = $reg['id_condicion_iva'];
			$idMoneda = $reg['id_moneda'];
			
			
			$reg['fec_cbte'] = BCUtils::formatDateJS($reg['fec_cbte']);
			$reg['fecha_venc_pago'] = BCUtils::formatDateJS($reg['fecha_venc_pago']);
			
			$pf = new ProveedorFacade();
			
			$proveedor = $pf->fetchRows($reg['id_proveedor']);
			$reg['descripcion_cliente'] = $proveedor['razon_social'];
			
			$a['edicion'] = $reg;
			
			if ($reg['detallada'] == 'S') {
				$dcf = new DetalleCompra();
				$a['detalle'] = $dcf->fetchAllRows(true, "id_compra = $id");
			} 
			
			if ($reg['retenciones'] == 'S') {
				$drc = new DetallePercepcionesCompraFacade();
				$a['retenciones'] = $drc->fetchAllRows(true, "idCompra = $id");
				
			}
		}
		
		$a["tipos_comprobante"] = $this->_getHijas("descripcion", $idTipoComprobante, new TipoComprobanteFacade());			
		
		$a["condicion_venta"] = $this->_getHijas("descripcion", $idCondicionVenta, new CondicionVentaFacade());
		
		$a["moneda"] = $this->_getHijas("descripcion", $idMoneda, new MonedaFacade());
		
		$a["proveedores"] = $this->getListaProveedores();
		
		$a['unidad_medida'] = $this->_getHijas("descripcion", $idUnidadMedida, new UnidadMedidaFacade());
		
		$a['moneda_base'] = $monedaBase;
		return $a;
	}
	
	public function getNombresListas() {
		return array('tipos_comprobante', 'proveedores', "condicion_venta", 'detalle', 'edicion', 'retenciones', 'moneda', 'unidad_medida', 'moneda_base');
	}
	
	private function getListaProveedores() {
		$pf = new ProveedorFacade();
		
		return $pf->fetchSelectList();
	}

	public function addCompra(Compra $compra, $detallesCompra = null , $detallePercepcionCompra = null) {
		
		$compra->set_fecCbte(BCUtils::formatDate($compra->get_fecCbte()));
		$compra->set_fechaVencPago(BCUtils::formatDate($compra->get_fechaVencPago()));
		
		
//		$compra['fec_cbte'] = BCUtils::formatDate($compra['fec_cbte']);
//		$compra['fecha_venc_pago'] = BCUtils::formatDate($compra['fecha_venc_pago']);

		
		if ($detallesCompra != array()) {		
			$compra->set_detallada("S");
			$dff = new DetalleCompraFacade();
		}
		else {
			$compra->set_detallada("N");
		}
		
		if ($detallePercepcionCompra != Array()) {
			$compra->set_retenciones("S");
			$dpf = new DetallePercepcionesCompraFacade();
		}
		else {
			$compra->set_retenciones("N");
		}
		
		$cf = new CompraFacade();
		
		if ($compra->getID() == null) {
			$cf->add($compra);
			$id_compra = $compra->getID();
		}
		else {
			$id_compra = $compra->getID();
			$cf->modify($compra);
			
			//borrar todos los detalles del id_factura
			$dff->eliminarDetalles($id_compra);
			$dpf->eliminarDetalles($id_compra);
		}
		
		//inserto los detalles
		if ($compra->get_detallada() == 'S') {
			foreach ($detallesCompra as $linea) {
				$linea->set_idCompra ($id_compra);
				
				$dff->add($linea);
			}
		}
		
		//inserto los detalles de retenciones
		if ($compra->get_retenciones() == 'S'){
			foreach ($detallePercepcionCompra as $linea) {
				$linea->set_idCompra ($id_compra);
				$dpf->add($linea);
			}
		}
		
		
	}
	
	
	
	public function getListaCompras($pagina = null, $order = null) {
		
		if ($pagina == null) $pagina = 1;

		$orden = ($order==null ? 'id_compra' : $order);
		
		
		$direction = "";
		if ($orden == $_SESSION['order']) {
			$_SESSION['direction'] = $_SESSION['direction'] == "" ? "desc" : "";
		}
		else {
			$_SESSION['order'] = $orden;
			$_SESSION['direction'] = "";
		}
		
		$direction = $orden == "id_compra" ? "desc" : $_SESSION['direction'];
			
		$filtro = "";
		if ($_GET['idproveedor'] != null) {
			$filtro = " and COMPRA.id_proveedor = ".$_GET['idproveedor'];
		}
		
		if ($_GET['filtro'] != null) {
			$filtro = " and COMPRA.nro_factura = ".$_GET['filtro'];
		}
		
		$result = $this->_facade->fetchList("$orden $direction", $pagina, 'COMPRA.id_empresa = '.GLOBAL_EMPRESA.$filtro);
		
		$attrs = array('width' => '100%', 'class' => 'tabla-abm');
		
		$attrsPares = array('class' => 'tabla-abm-fila-par');
		$attrsImpares = array('class' => 'tabla-abm-fila-impar');
		
		$table =& new HTML_Table($attrs);
		
		foreach($result as $row) {
			$a = array();
			$i=0;
			$id=0;
			
			//$muestraIconos = true;
			
			foreach ($row as $key => $value) {
				$valueCol = $value;
				
				if ($key == 'id_compra') {				
					$id = $value;
					$url = URL_ALTA_COMPRAS."&id=$id";
					$valueCol = "<a href='$url'><img src='css/".GLOBAL_THEME."/images/edit.gif' border=0 /><a>";
				}
				
				if ($key == "detallada") {
					//$muestraIconos = $value == "S";
					continue;
				}
/*				
				if ($key == 'cae') {
					if ($value == null) {
						$url = URL_ALTA_COMPRAS."&id=$id";
						$valueCol = "<a href='$url'><img src='css/".GLOBAL_THEME."/images/edit.gif' border=0 /><a>";
					}
				}*/

				$table->setHeaderContents(0, $i, "<a href='".$this->armaHREF(null, null, null, null, $key)."'>".Translator::getTrans($key)."</a>");
				$a[] = $valueCol;
				$i++;
			}
			
			
/*			if ($muestraIconos) {
				//Agrego columna de Download de Lote
				$valueCol = "<a href='".$this->armaHREF('imprimir', $id)."'> <img src='css/emerald/images/logo-pdf.gif' alt='Imprimir' width=32 height=32 border=0 /img> </a>";
				$table->setHeaderContents(0, $i++, Translator::getTrans('imprimir'));
				$a[] = $valueCol;
				
				$valueCol = "<a href='".$this->armaHREF('email', $id)."'> <img src='css/emerald/images/email.gif' alt='Email' width=32 height=32 border=0 /img> </a>";
				$table->setHeaderContents(0, $i++, Translator::getTrans('email'));
				$a[] = $valueCol;
			}
*/			
			$table->setHeaderContents(0, 0, "Ver");
			$table->addRow($a, $rowAttrs);
		}
		
		$table->altRowAttributes(1, $attrsImpares, $attrsPares, true);
		
		$url = URL_ALTA_COMPRAS;
		
		$boton=<<<EOT
<button style="width:150px" onclick="document.location = '$url';">
	Alta de Facturas de Compra
</button>
EOT;
	
		return $this->botonera().$boton.$this->navigator($pagina, false, 'id_empresa = '.GLOBAL_EMPRESA.$filtro).$table->toHtml().$this->navigator($pagina, false, 'id_empresa = '.GLOBAL_EMPRESA.$filtro);
		//fin
	}

	
	function botonera () {
		if ($_GET['idproveedor'] != null) unset($_GET['idproveedor']);
		$href = $this->armaHREF();
		
		$filtroProveedor = <<<EOF
<div style="text-align:left"><form>
	<label>Proveedor:</label>
	<select onChange="
		if (!this.options[0].selected) {
			document.location = '$href&idproveedor='+this.value;
		}
	">
EOF;
		//pongo las options de cliente
		$filtroProveedor .= "<option value='0'>-- Filtro por Proveedores --</option>";
		
		$pf = new ProveedorFacade();
		$rows = $pf->fetchAllRows(true);
		foreach ($rows as $row) {
			$id = $row['id_proveedor'];
			$titulo = $row['razon_social'];
			$filtroProveedor .= "<option value='$id'>$titulo</option>";
		}
		$filtroProveedor .= "</select></form></div>";
		
		$filtroProveedor = <<<EOF
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
		return $filtroProveedor.$filtroFacturas;
	}
}
?>