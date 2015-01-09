<?php
require_once "bc/ABMCtrl.php";
require_once "HTTP/Upload.php";
require_once 'bc/BCUtils.php';
require_once ('dal/XmlFacade.php');
require_once ("bc/$modulo/AltaCompraCtrl.php");
require_once ("bc/$modulo/ABMProveedorCtrl.php");
require_once 'pear/File.php';
require_once 'dal/CompraFacade.php';
require_once 'dal/EmpresaFacade.php';
require_once 'dal/ProveedorFacade.php';
require_once 'dal/AlicuotaIvaFacade.php';
require_once 'dal/RetencionFacade.php';
require_once("reports/pdf.php");
require_once 'be/Compra.php';
require_once 'be/DetalleCompra.php';
require_once 'be/DetallePercepcionesCompra.php';

class ImportarCompraCtrl extends ABMCtrl {

	private $archivo;
	
	private $_cache = array();
	
	private function uploadFile() {
		$upload = new HTTP_Upload("es");
		$file = $upload->getFiles("f");	
	
		if ($file->isValid()) {
				$this->archivo = "import/" . $file->moveTo("import/");
				$resultado = null;
		} elseif ($file->isMissing()) {
			$resultado = "No ha seleccionado un archivo.";
		} elseif ($file->isError()) {
			$resultado = $file->errorMsg();
		}
		else {
			$resultado = "error en el archivo importado";
		}
		return ($resultado);
	}
	
	private function normalizarCompra ($compra) {
		$compraNormalizada['tipoRegistro'] = substr($compra,0,1);
		$compraNormalizada['fec_cbte'] = substr($compra,1,8);
		$compraNormalizada['cod_cbte_afip'] = substr($compra,9,2);
		$compraNormalizada['controlador_fiscal'] = substr($compra,11,1);
		$compraNormalizada['punto_venta'] = substr($compra,12,4);
		$compraNormalizada['nro_comprobante'] = substr($compra,16,20);
		$compraNormalizada['fec_registro_contable'] = substr($compra,36,8);
		$compraNormalizada['codigo_aduana'] = substr($compra,44,3);
		$compraNormalizada['codigo_destinacion'] = substr($compra,47,4);
		$compraNormalizada['nro_despacho'] = substr($compra,51,6);
		$compraNormalizada['dig_verif_despacho'] = substr($compra,57,1);
		$compraNormalizada['cod_docum_proveedor'] = substr($compra,58,2);
		$compraNormalizada['nro_docum_proveedor'] = substr($compra,60,11);
		$compraNormalizada['razon_social'] = substr($compra,71,30);
		$compraNormalizada['total'] = substr($compra,101,15);
		$compraNormalizada['total_conc_no_gravados'] = substr($compra,116,15);
		$compraNormalizada['neto_gravado'] = substr($compra,131,15);
		$compraNormalizada['alicuota_iva'] = substr($compra,146,4);
		$compraNormalizada['impuesto_liquidado'] = substr($compra,150,15);
		$compraNormalizada['ope_exentas'] = substr($compra,165,15);
		$compraNormalizada['perc_iva'] = substr($compra,180,15);
		$compraNormalizada['perc_impuestos_nacionales'] = substr($compra,195,15);
		$compraNormalizada['perc_iibb'] = substr($compra,210,15);
		$compraNormalizada['perc_impuestos_municipales'] = substr($compra,225,15);
		$compraNormalizada['impuestos_internos'] = substr($compra,240,15);
		$compraNormalizada['cod_tipo_responsable_afip'] = substr($compra,255,2);
		$compraNormalizada['cod_moneda_afip'] = substr($compra,257, 3);
		$compraNormalizada['cotizacion'] = substr($compra,260,10);
		$compraNormalizada['cant_alicuotas'] = substr($compra,270,1);
		$compraNormalizada['cod_operacion'] = substr($compra,271,1);
		$compraNormalizada['cae'] = substr($compra,272,14);
		$compraNormalizada['fec_vencimiento'] = substr($compra,186,8);
		$compraNormalizada['observaciones'] = substr($compra,186,75);
		$compraNormalizada['cantLineasRet'] = 0;
		$compraNormalizada['retenciones'] = "N";
		$compraNormalizada['detallada'] = "S";
		$compraNormalizada['cantLineas'] = 0;
		$compraNormalizada['impuesto_liquidado_rni'] = 0;
		
		return ($compraNormalizada);	
	}
	
	private function normalizarCabecera ($cabecera) {
		$cabeceraNormalizada['tipoRegistro'] = substr($cabecera,0,1);
		$cabeceraNormalizada['periodo'] = substr($cabecera,1,6);
		$cabeceraNormalizada['cantidad'] = substr($cabecera,17,12);
		$cabeceraNormalizada['cuit'] = substr($cabecera,60,11);
		$cabeceraNormalizada['total'] = substr($cabecera,101,15);
		$cabeceraNormalizada['total_conc_no_gravados'] = substr($cabecera,116,15);
		$cabeceraNormalizada['neto_gravado'] = substr($cabecera,131,15);
		$cabeceraNormalizada['impuesto_liquidado'] = substr($cabecera,150,15);
		$cabeceraNormalizada['ope_exentas'] = substr($cabecera,165,15);
		$cabeceraNormalizada['perc_iva'] = substr($cabecera,180,15);
		$cabeceraNormalizada['perc_impuestos_nacionales'] = substr($cabecera,195,15);
		$cabeceraNormalizada['perc_iibb'] = substr($cabecera,210,15);
		$cabeceraNormalizada['perc_impuestos_municipales'] = substr($cabecera,225,15);
		$cabeceraNormalizada['impuestos_internos'] = substr($cabecera,240,15);
		$cabeceraNormalizada['impuesto_liquidado_rni'] = 0;

		return ($cabeceraNormalizada);	
	}	
	
	private function getProveedor($compra,$idTipoDocumento) {
		$pf = new ProveedorFacade();
		
		$nroDoc = $compra['nro_docum_proveedor'];
		
		if (!isset($this->_cache["Proveedor"])) {
			$this->_cache["Proveedor"] = array();

			$result = $pf->fetchAllRows(true);
			
			foreach ($result as $row) {
//				$key = $row['id_tipo_documento'].'-'.$row['nro_documento'];
				$key = $row['nro_documento'];
				$this->_cache["Proveedor"][$key] = $row['id_proveedor'];
			}
		}
		
		//$key = "$idTipoDocumento-$nroDoc";
		$key = $nroDoc;
		
		/*
		echo "<pre>";
		echo $key;
		echo $this->_cache["Proveedor"][$key];
		echo "</pre>";
		*/
		
		if (!isset($this->_cache["Proveedor"][$key])) {
		
			//agrego al Proveedor
			$proveedor = array(
					'id_proveedor' => null,
					'razon_social' => $compra['razon_social'],
					'id_tipo_documento' => $idTipoDocumento,
					'nro_documento' => $nroDoc,
					'calle' => $compra['calle'],
					'numero' => $compra['numero'],
					'piso' => $compra['piso'],
					'departamento' => $compra['departamento'],
					'ciudad' => $compra['ciudad'],
					'id_provincia' => $compra['provincia'],
					'id_pais' => $compra['pais'],
					'telefono' => $compra['telefono']
			);
				
			if ($compra['provincia'] == null) {
				unset ($proveedor['id_provincia']);
			}
			
			if ($compra['pais'] == null) {
				unset ($proveedor['id_pais']);
			}
			
			$cc = new ABMProveedorCtrl();
			
			try {
				$result = $cc->insert($proveedor);
			}
			catch (Exception $e) {
				throw new Exception ('Error al dar de alta el proveedor ' . $e->getMessage());
			}
			//echo ("Alta: " . $result);
			$this->_cache["Proveedor"][$key] = $result; 
			return $result;
		}
		else {
			return $this->_cache["Proveedor"][$key];
		}
	}
	
	private function getIdEmpresa($cuit) {
		return $this->_getIdFromCache("Empresa", new EmpresaFacade(), "nro_documento", "id_empresa", $cuit);
	}
	
	private function getIdTipoComprobante($codCbteAfip)
	{
		return $this->_getIdFromCache("TipoComprobante", new TipoComprobanteFacade(), "cod_comprobante", "id_tipo_comprobante", $codCbteAfip);
	}

	private function getIdMoneda($codMonedaAfip)
	{
		return $this->_getIdFromCache("Moneda", new MonedaFacade(), "codigo_moneda_afip", "id_moneda", $codMonedaAfip);
	}
	
	private function getIdTipoDocumento($codTipoDocumentoAfip)
	{
		return $this->_getIdFromCache("TipoDocumento", new TipoDocumentoFacade(), "cod_doc_afip", "id_tipo_documento", $codTipoDocumentoAfip);
	}

	private function getIdUnidadMedida($descripcion)
	{
		return $this->_getIdFromCache("UnidadMedida", new UnidadMedidaFacade(), "descripcion", "id_unidad_medida", $descripcion);
	}

	private function getIdAlicuotaIva($porcentaje)
	{
		return $this->_getIdFromCache("AlicuotaIva", new AlicuotaIvaFacade(), "porcentaje", "id_alicuota_iva", $porcentaje);
	}
			
	private function getIdRetencion($tipo, $origen)
	{
		
		$rf = new RetencionFacade();
		$result = $rf->fetchAllRows(true,"tipo_retencion='".$tipo."' and compra_venta = '".$origen."'");
		
		return ($result[0]["id_retencion"]);
	}
		
	private function _getIdFromCache($tabla, TableFacade $facade, $campoClave, $campoID, $valorClave) {
		if (isset ($this->_cache[$tabla])) {
			foreach($this->_cache[$tabla] as $item) {
				if ($item["valor"] == $valorClave) {
					return $item["id"];
				}
			}
			return null;
		}
		else {
			//lleno el cache
			try {
				$result = $facade->fetchAllRows(true);
			}
			catch (Exception $e) {
				throw new Exception ($e->getMessage());
			}
			$this->_cache[$tabla] = array ();
			foreach ($result as $row) {
				$this->_cache[$tabla][] = array("valor" => $row[$campoClave], "id" => $row[$campoID]);
			}
			return $this->_getIdFromCache($tabla, $facade, $campoClave, $campoID, $valorClave);
		}
	}
	
	private function imprimirResultado ($resultado)
	{
		try {
			
			$muestraError = false;
			
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor("Esphora - Facturacion Electronica");
			$pdf->SetTitle("Importacion de Compras");
			$pdf->SetSubject("Importacion de Compras");
	//		$pdf->SetKeywords("TCPDF, PDF, example, test, guide");
		
	
			require ('reports/importarCompras.php');		
			if ($muestraError) {
				//Close and output PDF document
				ob_clean();
				$pdf->Output("ResultadoImportacion.pdf");
				return (true);
				//PantallaSingleton::showMessage(Translator::getTrans("IMPORT_ERROR"));
			} else {
				return (true);
			}
		
		} 
			catch ( Exception $e ) {
			throw new Exception ( $e->getMessage ());
			}

		return (true);
	}
	
	private function armarPercepciones($percNacionalesCompra,$percIvaCompra, $percIIBBCompra, $percMunicipalesCompra, $impuestosInternosCompra, $impNetoGravadoCompra){
				// Si son nacionales
				$percepciones = array();
				
					if ($percNacionalesCompra > 0) {
						$nacionales = new DetallePercepcionesCompra();
						$nacionales->map(array(
						'id_retencion' => $this->getIdRetencion('N','X'),
						'detalle' => "Perc. Nac. Importadas por Interfaz",
						'base_imponible' => $impNetoGravadoCompra,
						'alicuota' => round($percNacionalesCompra/$impNetoGravadoCompra*100,2)
						)
						);
						$percepciones[]=$nacionales;
					}
					
	
					// Si son de IVA
					if ($percIvaCompra > 0) {
						$iva = new DetallePercepcionesCompra();
						$iva->map(array(
						'id_retencion' => $this->getIdRetencion('N','C'),
						'detalle' => "Perc. de IVA Importadas por Interfaz",
						'base_imponible' => $impNetoGravadoCompra,
						'alicuota' => round($percIvaCompra/$impNetoGravadoCompra*100, 2)
						)
						);
						$percepciones[]=$iva;
					}
				
					// Si son provinciales
					if ($percIIBBCompra > 0) {
						
						$IIBB = new DetallePercepcionesCompra();
						$IIBB->map(array(
						'id_retencion' => $this->getIdRetencion('P','X'),
						'detalle' => "Perc. de IIBB Prov. Importadas por Interfaz",
						'base_imponible' => $impNetoGravadoCompra,
						'alicuota' => round($percIIBBCompra/$impNetoGravadoCompra*100,2)
						)
						);
						$percepciones[]=$IIBB;
					}
				
					// Si son municipales
					if ($percMunicipalesCompra > 0) {
						$municipales = new DetallePercepcionesCompra();
						$municipales->map(array(
						'id_retencion' => $this->getIdRetencion('M','X'),
						'detalle' => "Perc. de IIBB Munic. Importadas por Interfaz",
						'base_imponible' => $impNetoGravadoCompra,
						'alicuota' => round($percMunicipalesCompra/$impNetoGravadoCompra*100,2)
						)
						);
						$percepciones[]=$municipales;
					}	
				
					// Si son impuestos internos
					if ($impuestosInternosCompra > 0) {
						$internos = new DetallePercepcionesCompra();
						$internos->map(array(
						'id_retencion' => $this->getIdRetencion('I','X'),
						'detalle' => "Perc. de Imp. Int. Importadas por Interfaz",
						'base_imponible' => $impNetoGravadoCompra,
						'alicuota' => round($impuestosInternosCompra/$impNetoGravadoCompra*100,2)
						)
						);
						$percepciones[]=$internos;
					}					
				
				return $percepciones;
	}

	private function armarDetalles($impNetoGravado,$alicuotaIVA)
	{
				$detalle = new DetalleCompra();
				$detalle->map(array(
				'cantidad' 	=> 1,
				'concepto' => 'Linea Importada de Interfaz' ,
				'id_alicuota_iva' => $this->getIdAlicuotaIva($alicuotaIVA/100),
				'precio_unitario' => $impNetoGravado,
				'id_unidad_medida' => $this->getIdUnidadMedida("OTRAS UNIDADES")
				)
				);
				return ($detalle);
	}
	
	private $totalAcumulado = 0;
	private $impNetoGravadoAcumulado =  0;
	private $impExentoAcumulado =  0;
	private $impLiquidadoAcumulado =  0;
	private $impLiquidadoRNIAcumulado =  0;
	private $percIvaAcumulado =  0;
	private $percNacionalesAcumulado =  0;
	private $percIIBBAcumulado = 0;
	private $percMunicipalesAcumulado =  0;
	private $impuestosInternosAcumulado =  0;
	
	private $totalCompra = 0;
	private $impNetoGravadoCompra =  0;
	private $impExentoCompra =  0;
	private $impLiquidadoCompra =  0;
	private $impLiquidadoRNICompra =  0;
	private $percIvaCompra =  0;
	private $percNacionalesCompra =  0;
	private $percIIBBCompra = 0;
	private $percMunicipalesCompra =  0;
	private $impuestosInternosCompra =  0;
	
	private $erroresCompra = array();
	private $errorRegistro =false;
	
	private $percepciones = array();
	private $detalles = array();
	
	private function inicializarLinea() {
		$this->totalCompra = 0;
		$this->impNetoGravadoCompra =  0;
		$this->impExentoCompra =  0;
		$this->impLiquidadoCompra =  0;
		$this->impLiquidadoRNICompra =  0;
		$this->percIvaCompra =  0;
		$this->percNacionalesCompra =  0;
		$this->percIIBBCompra = 0;
		$this->percMunicipalesCompra =  0;
		$this->impuestosInternosCompra =  0;
		
		$this->percepciones = array();
		$this->detalles = array();
		$this->errorRegistro = false;
	}
	
	private function leerLinea($compra, $i) {
				$compraNormalizada = $this->normalizarCompra($compra);
				$this->erroresCompra[$i] = "";
				
				$total = $compraNormalizada['total']/100;
				$impNetoGravado = ($compraNormalizada['neto_gravado']/100);
				$impExento = ($compraNormalizada['ope_exentas']/100);
				$impLiquidado = ($compraNormalizada['impuesto_liquidado']/100);
				$impLiquidadoRNI = ($compraNormalizada['impuesto_liquidado_rni']/100);
				$percIva = ($compraNormalizada['perc_iva']/100);
				$percNacionales = ($compraNormalizada['perc_impuestos_nacionales']/100);
				$percIIBB = ($compraNormalizada['perc_iibb']/100);
				$percMunicipales = ($compraNormalizada['perc_impuestos_municipales']/100);
				$impuestosInternos = ($compraNormalizada['impuestos_internos']/100);
				
				
				$this->totalAcumulado += $total;
				$this->impNetoGravadoAcumulado +=  $impNetoGravado;
				$this->impExentoAcumulado +=  $impExento;
				$this->impLiquidadoAcumulado +=  $impLiquidado;
				$this->impLiquidadoRNIAcumulado +=  $impLiquidadoRNI;
				$this->percIvaAcumulado +=  $percIva;
				$this->percNacionalesAcumulado +=  $percNacionales;
				$this->percIIBBAcumulado += $percIIBB;
				$this->percMunicipalesAcumulado +=  $percMunicipales;
				$this->impuestosInternosAcumulado +=  $impuestosInternos;
				
				$this->totalCompra += $total;
				$this->impNetoGravadoCompra +=  $impNetoGravado;
				$this->impExentoCompra +=  $impExento;
				$this->impLiquidadoCompra +=  $impLiquidado;
				$this->impLiquidadoRNICompra +=  $impLiquidadoRNI;
				$this->percIvaCompra +=  $percIva;
				$this->percNacionalesCompra +=  $percNacionales;
				$this->percIIBBCompra += $percIIBB;
				$this->percMunicipalesCompra +=  $percMunicipales;
				$this->impuestosInternosCompra +=  $impuestosInternos;
				
				$this->detalles[] = $this->armarDetalles($impNetoGravado,$compraNormalizada["alicuota_iva"]/100);
				return $compraNormalizada;
	}
	
	private function grabarLinea($compraNormalizada, $i) {
				$subtotal = $this->impNetoGravadoCompra + $this->impExentoCompra + $this->impLiquidadoCompra + $this->impLiquidadoRNICompra + $this->percIvaCompra + $this->percNacionalesCompra + $this->percIIBBCompra + $this->percMunicipalesCompra + $this->impuestosInternosCompra;
				if ((string)$this->totalCompra != (string)$subtotal) {
					$this->erroresCompra[$i] .= "\n El total informado no coincide con los subtotales";
					$this->errorRegistro=true;
				}
		
		
				$ptoVta = $compraNormalizada['punto_venta'];
				$nroFactura = $compraNormalizada['nro_comprobante'];
				
				//otener datos segun c—digo de AFIP
				
				if ($compraNormalizada['cod_cbte_afip'] == 0) {
					$idTipoComprobante = 1;
				}
				else {
					$idTipoComprobante = $this->getIdTipoComprobante($compraNormalizada['cod_cbte_afip']);
				}
				 
				
				if ($compraNormalizada['cod_moneda_afip'] == "   "){
					$idMoneda = $this->getIdMoneda("PES");
				} else {
					$idMoneda = $this->getIdMoneda($compraNormalizada['cod_moneda_afip']);
				}
				
				$idTipoDocumento = $compraNormalizada['cod_docum_proveedor'];
				
				if (trim($idTipoDocumento) == "") {
					$this->erroresCompra[$i] .= "Codigo de documento del proveedor invalido";
					$this->errorRegistro=true;;
				}
				$idTipoDocumento = $this->getIdTipoDocumento($idTipoDocumento);
	
				try {
					$idProveedor = $this->getProveedor($compraNormalizada,$idTipoDocumento);
					}
					catch (Exception $e) {
					$this->erroresCompra[$i] .= "\n" .  $e->getMessage();
					$this->errorRegistro=true;;
					}
				
				//validar que no exista la factura (id prov, tipo cbte, pto vta, nro cbte)
				
				$cf = new CompraFacade();
					
				if ($cf->existeFactura($idProveedor, $idTipoComprobante, $ptoVta, $nroFactura)) {
					$this->erroresCompra[$i] .= "\n La factura ya existe para este proveedor";
					$this->errorRegistro=true;;
				}
				
				//validar fecha vencimiento y factura
				$fecFactura = BCUtils::validaDateBD($compraNormalizada['fec_cbte']);
				
				
				
				if ($compraNormalizada['fec_vencimiento'] == '00000000') {
					$fechaVencPago = null;
				}else {
					$fechaVencPago = BCUtils::validaDateBD($compraNormalizada['fec_vencimiento']);
				}
				
				//TODO: Validar periodo abierto.
				$fechaRegContable = BCUtils::validaDateBD($compraNormalizada['fec_registro_contable']);
				
				if ($fecFactura == null) {
					$this->erroresCompra[$i] .= "Fecha de Factura invalida";
					$this->errorRegistro=true;;
				}
				
				if ($fechaRegContable== null) {
					$this->erroresCompra[$i] .= "Fecha de Registro Contable invalida";
					$this->errorRegistro=true;;
				}
				
				$cotizacion = ($compraNormalizada['cotizacion']/1000000);
				
				$nuevaCompra = new Compra();
				$nuevaCompra->map(array(
					'id_compra' => null,
					'id_empresa' => GLOBAL_EMPRESA,
					'id_proveedor' => $idProveedor,
					'id_tipo_comprobante' => $idTipoComprobante,
					'id_condicion_venta' => 1, //no existe este dato en el registro de importacion
					'punto_venta' => $ptoVta,
					'nro_factura' => $nroFactura,
					'importe_neto_gravado' => $this->impNetoGravadoCompra,
					'importe_ope_exentas' => $this->impExentoCompra,
					'impuesto_liquidado' => $this->impLiquidadoCompra,
					'impuesto_liquidado_rni' => $this->impLiquidadoRNICompra,
					'total' => $this->totalCompra,
					'fecha_venc_pago' => $fechaVencPago,
					'fec_cbte' => $fecFactura,
					'fec_registro_contable' => $fechaRegContable,
					'perc_iva' => $this->percIvaCompra,
					'perc_impuestos_nacionales' => $this->percNacionalesCompra,
				 	'perc_iibb' => $this->percIIBBCompra,
				 	'perc_impuestos_municipales' => $this->percMunicipalesCompra,
				 	'impuestos_internos' => $this->impuestosInternosCompra,
					'id_moneda' => $idMoneda,
					'cotizacion' => $cotizacion,
//				  	'detallada' => $compraNormalizada['detallada'],
//				  	'retenciones' => $compraNormalizada['retenciones'],
				  	'cae' => $compraNormalizada['cae'],
				  	'comentarios' => $compraNormalizada['comentarios']			
				)
				);
				
				//Armo las percepciones segun las columnas usadas
				$percepciones = $this->armarPercepciones($this->percNacionalesCompra,$this->percIvaCompra, $this->percIIBBCompra, $this->percMunicipalesCompra, $this->impuestosInternosCompra, $this->impNetoGravadoCompra);
				
				
				
				if (!$this->errorRegistro) {
					try {
						$acc =new AltaCompraCtrl();
						$acc->addCompra($nuevaCompra,$this->detalles,$percepciones);
					}
					catch (Exception $e) {
						$this->erroresCompra[$i] .= "\n" .  $e->getMessage();
					}
				}
				
				$this->inicializarLinea();
	}
		
	private function grabarCompras () {
		$i = 0;
		$compras = file($this->archivo);
		$nroFacturaAnterior = substr($compras[0],16,20);
		
		$compraNormalizada = null;
		
		//leer primer linea (caso especial)
		//si el primer caracter del archivo no es uno, entonces no hay nada para importar o el archivo es invalido
		if (substr($compras[0], 0, 1) != "1") {
			throw new Exception("No hay datos para importar o el archivo es invalido");
		}
		else {
			$compraNormalizada = $this->leerLinea($compras[0], 0);
		}
		
		$primero = true;
		foreach ($compras as $compra) {
			//Se lleva el contador
			$i++;
			
			
			
			//si es el primer ciclo, lo salteo
			if ($primero) {
				$primero = false;
				continue;
			}
			
			//si la linea es una totalizadora, grabo lo que tenga y verifico totales (?)
			if (substr($compra, 0, 1) == "2") {
				$this->grabarLinea($compraNormalizada, $i-1);
				
				$this->validarImpo($compra, $i);
				
				break;
			}
			else {
				$facturaActual = substr($compra,16,20);
				
				if ($facturaActual != $nroFacturaAnterior) {
					$this->grabarLinea($compraNormalizada, $i-1);
					$nroFacturaAnterior = $facturaActual;
				}
			}
			
			$compraNormalizada = $this->leerLinea($compra, $i);
		}
		
		return $this->erroresCompra;
		
	}
	
	private function validarImpo($compra, $i) {
				$cabeceraNormalizada = $this->normalizarCabecera($compra);	
				
				if ($this->totalAcumulado != ($cabeceraNormalizada['total']/100)) 
				{
					$this->erroresCompra[$i] .= "El total acumulado en las facturas no coincide con el informado en la linea de resumen." . $totalAcumulado . ' y ' . ($cabeceraNormalizada['total']/100) ;
					$this->errorRegistro=true;;
				}
				
				if ($this->impNetoGravadoAcumulado != ($cabeceraNormalizada['neto_gravado']/100))
				{
					$this->erroresCompra[$i] .= "El neto gravado acumulado en las facturas no coincide con el informado en la linea de resumen.";
					$this->errorRegistro=true;;
				}
				
				if ($this->impExentoAcumulado != ($cabeceraNormalizada['ope_exentas']/100))
							{
					$this->erroresCompra[$i] .= "El importe exento acumulado en las facturas no coincide con el informado en la linea de resumen.";
					$this->errorRegistro=true;;
				}
				
				if ($this->impLiquidadoAcumulado != ($cabeceraNormalizada['impuesto_liquidado']/100))
				{
					$this->erroresCompra[$i] .= "El impuesto liquidado acumulado en las facturas no coincide con el informado en la linea de resumen.";
					$this->errorRegistro=true;;
				}
				
				if ($this->impLiquidadoRNIAcumulado != ($cabeceraNormalizada['impuesto_liquidado_rni']/100))
				{
					$this->erroresCompra[$i] .= "El impuesto liquidado RNI acumulado en las facturas no coincide con el informado en la linea de resumen.";
					$this->errorRegistro=true;;
				}
				
				if ($this->percIvaAcumulado != ($cabeceraNormalizada['perc_iva']/100))
				{
					$this->erroresCompra[$i] .= "El importe de percepciones de IVA acumulado en las facturas no coincide con el informado en la linea de resumen.";
					$this->errorRegistro=true;;
				}
				
				if ($this->percNacionalesAcumulado != ($cabeceraNormalizada['perc_impuestos_nacionales']/100))
				{
					$this->erroresCompra[$i] .= "El importe de Percepciones Nacionales acumulado en las facturas no coincide con el informado en la linea de resumen.";
					$this->errorRegistro=true;;
				}
				
				if ($this->percIIBBAcumulado != ($cabeceraNormalizada['perc_iibb']/100))
				{
					$this->erroresCompra[$i] .= "El importe de Percepciones de IIBB acumulado en las facturas no coincide con el informado en la linea de resumen.";
					$this->errorRegistro=true;;
				}
				
				if ($this->percMunicipalesAcumulado != ($cabeceraNormalizada['perc_impuestos_municipales']/100))
				{
					$this->erroresCompra[$i] .= "El importe de Percepciones Municipales acumulado en las facturas no coincide con el informado en la linea de resumen.";
					$this->errorRegistro=true;;
				}
				
				if ($this->impuestosInternosAcumulado != ($cabeceraNormalizada['impuestos_internos']/100))
				{
					$this->erroresCompra[$i] .= "El importe de Impuestos Internos acumulado en las facturas no coincide con el informado en la linea de resumen.";
					$this->errorRegistro=true;;
				}
	}
	
	public function importarCompras($htmlFile) {
		if ($htmlFile) {
			$res = $this->uploadFile();
			
			if ($res != null) throw new Exception($res);
		}
		
		$result = $this->grabarCompras();
		
		$this->imprimirResultado($result);
		
		return ($result);
	}
}
?>