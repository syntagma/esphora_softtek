<?php
require_once 'bc/BCUtils.php';

require_once 'dal/FacturaFacade.php';
require_once 'dal/EmpresaFacade.php';
require_once 'dal/ClienteFacade.php';

require_once('tcpdf/config/lang/eng.php');
require_once("reports/pdf.php");

class ImprimirFacturaCtrl extends ABMCtrl {

	private $archivo;
	
	private function generarPDF($pdf, $factura, $cliente, $lineas, $comprobante, $condicionVenta, $condicionIva) {
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor("Esphora - Facturacion Electronica");
		$pdf->SetTitle("Factura" . $factura["nro_factura"]);
		$pdf->SetSubject("Factura: " . $factura["nro_factura"]);
//		$pdf->SetKeywords("TCPDF, PDF, example, test, guide");
		
		$ef = new EmpresaFacade();
		$oEmpresa  = $ef->fetchRows(GLOBAL_EMPRESA);
		$cuit = $oEmpresa['nro_documento'];
		
		require ('reports/factura'.$cuit.'.php');
	
		//Close and output PDF document
		ob_clean();
		$pdf->Output("factura-".$factura["nro_factura"].".pdf", "D");

		//include_once("tcpdf/examples/example_001.php");
	}
	
	
	 
	private function getIdEmpresa($cuit) {
		$ef = new EmpresaFacade();
		
		$result = $ef->fetchAllRows(true, "id_tipo_documento = 1 and nro_documento = $cuit");
		
		if ($result == array()) {
			return null;
		}
		else {
			return $result[0]['id_empresa'];
		}
	}
	
	private function getFactura($idFactura) {
		$ff = new FacturaFacade();
		$result = $ff->fetchRows($idFactura);
	
		
		return $result;
	}
	
	private function getCliente($factura) {
		$cf = new ClienteFacade();
		
		$idCliente = $factura['id_cliente'];
		
		$result = $cf->fetchRows($idCliente);
		
		$pf = new ProvinciaFacade();
		$provincia = $pf->fetchRows($result["id_provincia"]);
		$result["provincia"] = $provincia["descripcion"];
		
		$pf = new PaisFacade();
		$pais = $pf->fetchRows($result["id_pais"]);
		$result["pais"] = $pais["descripcion"];
		
		return $result;
	}
	
	private function getLineas($idfactura) {
		$dff = new DetalleFacturaFacade();
			
		$result = $dff->fetchAllRows(false,"DETALLE_FACTURA.id_factura = $idfactura");
		return $result;
	}
	
	private function getComprobante($idTipoComprobante) {
		$tcf = new TipoComprobanteFacade();
			
		$result = $tcf->fetchRows($idTipoComprobante);
		
		return $result;
	}

	private function getCondicionVenta($idCondicionVenta) {
		$cvf = new CondicionVentaFacade();
			
		$result = $cvf->fetchRows($idCondicionVenta);
		
		return $result;
	}

	private function getCondicionIva($idCondicionIva) {
		$cif = new CondicionIvaFacade();
					
		$result = $cif->fetchRows($idCondicionIva);
		
		return $result;
	}
	
	
	public function imprimirFacturas($idFactura) {
		
		$factura = $this->getFactura($idFactura);
		$cliente = $this->getCliente($factura);
		$lineas = $this->getLineas($idFactura);
		$comprobante = $this->getComprobante($factura["id_tipo_comprobante"]);
		$condicionIva = $this->getCondicionIva($cliente["id_condicion_iva"]);
		$condicionVenta = $this->getCondicionVenta($factura["id_condicion_venta"]);
		$pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 
		$this->generarPDF($pdf, $factura, $cliente, $lineas, $comprobante, $condicionVenta, $condicionIva);
	}
}
?>