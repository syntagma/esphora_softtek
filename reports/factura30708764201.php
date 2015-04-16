<?php
		
	//seteo de idioma
	$pdf->setLanguageArray('es'); 

	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	$Tipo_Letra="vera";
	$espacioY = 25;
	$Y = 105;
	
	// Inicio de Pagina
	$pdf->AddPage();

	// Tipo de Comprobante
	$pdf->SetXY( 123, 12);
	$pdf->SetFont( $Tipo_Letra, "B", 10);
	$pdf->Cell( 12, 4,$comprobante["nombre_corto"] );
	
	// Fecha
	$pdf->SetXY( "140", "26");
	$pdf->SetFont( $Tipo_Letra, "B", 10);
	list($year , $month, $day) = split('[/.-]', $factura["fec_cbte"]);
	$pdf->Cell( "12", 4,$day . "/" . $month . "/" . $year  );

	// Nro de Factura
	$pdf->SetXY( "158", "17");
	$pdf->SetFont( $Tipo_Letra, "B", 16);
	$pdf->Cell( "12", 4,str_pad($factura["nro_factura"],8,'0',STR_PAD_LEFT));

	// Letra de Factura
	$pdf->SetXY( "108", "16");
	$pdf->SetFont( $Tipo_Letra, "B", 16);
	$pdf->Cell( "12", 4,$comprobante["letra"]);
		
	// Cuit Cliente
	$cuit_normalizado=substr($cliente["nro_documento"],0,2) . "-" . substr($cliente["nro_documento"],2,8) . "-" . substr($cliente["nro_documento"],10,1);
	$pdf->SetXY( "30", "71");
	$pdf->SetFont( $Tipo_Letra, "B", 10);
	$pdf->Cell( "12", 4,$cuit_normalizado);
	
	// Nombre del Cliente
	$pdf->SetXY( "30", "50");
	$pdf->SetFont( $Tipo_Letra, "B", 10);
	$pdf->Cell( "12", 4,$cliente["razon_social"]);
	
	// Direccion del Cliente
	if(trim($cliente["calle"])!='')
		$direccion = $cliente["calle"]. ' ' . $cliente["numero"] . ' ' . $cliente["piso"] . ' ' . $cliente["departamento"] . " - ";
	if(trim($cliente["ciudad"]) !='')
		$direccion .= $cliente["ciudad"].", ";
	if(trim($cliente["id_provincia"])!='')
		$direccion .= $cliente["provincia"] . " - ";
	$direccion .=$cliente["pais"];

	// Direccion de Facturacion
	$pdf->SetXY( "30", "60");
	$pdf->SetFont($Tipo_Letra,'',10);
	$pdf->MultiCell(120,4,$direccion,0,null,"L");
	
	// Condicion de venta
	$pdf->SetXY( "48", "81");
	$pdf->SetFont( $Tipo_Letra, "", 10);
	$pdf->Cell( "12", 4,$condicionVenta["descripcion"]);
	
	// IVA
	$pdf->SetXY( "105", "71");
	$pdf->SetFont( $Tipo_Letra, "", 10);
	$pdf->Cell( "12", 4,$condicionIva["descripcion"]);
	
	
	// ENCABEZADOS DE TABLA
	$pdf->SetFont( $Tipo_Letra, "", 10);
	$pdf->SetXY( 30, 91);
	$pdf->Cell( 12, 4,"Descripcion");
	$pdf->SetXY( 100, 91);
	$pdf->Cell( 12, 4,"Cantidad");
	$pdf->SetXY( 135, 91);
	$pdf->Cell( 12, 4,"P.Unitario");	

	
	// Tipo de Cambio
	$pdf->SetXY( 15, 185);
	$pdf->SetFont( $Tipo_Letra, "", 10);
	$texto = "El tipo de cambio a los efectos fiscales es $ (tipo de cambio)";
	//$pdf->Cell( 12, 4,$texto);	
	
	$utils = new BCUtils();
	// Total en Letras
	$pdf->SetXY( 15, 195);
	$pdf->SetFont( $Tipo_Letra, "", 10);
	$texto = "Son Pesos: " . $utils->montoLetras(abs($factura["total"]));
	$pdf->Cell( 12, 4,$texto);	
	
	//Comentarios
	$pdf->SetXY( 15, 200);
	$pdf->SetFont( $Tipo_Letra, "B", 8);
	$texto = $factura["comentarios"];
	$pdf->MultiCell( 140, 4,$texto,0,"L");		
	
	//SubTotal
	$pdf->SetFont( $Tipo_Letra, "", 10);
	$pdf->SetXY( 145, 215);
	$pdf->Cell(12, 4,"SubTotal: ");
	$pdf->SetXY( 185, 215);
	$importe = number_format($factura["importe_neto_gravado"],2);
	$pdf->Cell(12, 4,$importe,null,null,'R');
		
	//Importe Exento
	$pdf->SetFont( $Tipo_Letra, "", 10);
	$pdf->SetXY( 145, 230);
	$pdf->Cell(12, 4,"Exento: ");
	$pdf->SetXY( 185, 230);
	$importe = number_format($factura["importe_ope_exentas"],2);
	$pdf->Cell(12, 4,$importe,null,null,'R');
		
	//Impuesto Liquidado
	$pdf->SetFont( $Tipo_Letra, "", 10);
	$pdf->SetXY( 145, 240);
	$pdf->Cell(12, 4,"IVA: ");
	$pdf->SetXY( 185, 240);
	$importe = number_format($factura["impuesto_liquidado"],2);
	$pdf->Cell(12, 4,$importe,null,null,'R');
	
	//Perc IIBB
	$pdf->SetFont( $Tipo_Letra, "", 10);
	$pdf->SetXY( 145, 250);
	$pdf->Cell(12, 4,"Perc. IIBB Bs.As.: ");
	$pdf->SetXY( 185, 250);
	$importe = number_format($factura["otros_conceptos"],2);
	$pdf->Cell(12, 4,$importe,null,null,'R');

	//Total
	$pdf->SetFont( $Tipo_Letra, "", 10);
	$pdf->SetXY( 145, 260);
	$pdf->Cell(12, 4,"Total:");
	$pdf->SetXY( 185, 260);
	$importe = number_format($factura["total"],2);
	$pdf->Cell(12, 4,$importe,null,null,'R');
		
	//LEYENDA
	$pdf->SetFont( $Tipo_Letra, "", 10);
	$pdf->SetXY( 25, 232);
	//$textoLargo = "En caso de no ser abonada en termino devengara intereses a una tasa equivalente al doble de la tasa del Banco de la Nacion Argentina para descuento de documentos hasta la fecha de su efectivo pago";
	$textoLargo = "";
	if ($factura['tipofactprodserv'] == 'SERVICIO') {
		$textoLargo = "La mora en el pago de la presente factura generara un interes punitorio del 3% mensual en Pesos.";
	}
	
	if ($factura['tipofactprodserv'] == 'PRODUCTO') {
		$textoLargo = "La mora en el pago de la presente factura generara un interes punitorio del 8% anual en Dolares.";
	}
	
	$pdf->MultiCell(61,4,$textoLargo,0,'L');
	
	// CAE
	$pdf->SetXY( 115, 278);
	$pdf->SetFont( $Tipo_Letra, "", 10);
	$pdf->Cell( 12, 4,"CAE: " .$factura["cae"]);
	
	// FEC VENC CAE
	$pdf->SetXY( 115, 283);
	$pdf->SetFont( $Tipo_Letra, "", 10);
	$pdf->Cell( 12, 4,"FEC VENC:" .$day . "/" . $month . "/" . $year );
	
	//TABLA DE LINEAS
	foreach ($lineas as $l)
	{
		//Descripcion
		$pdf->SetXY( 20, $Y);
		$pdf->SetFont( $Tipo_Letra, "", 10);
		$pdf->MultiCell(70, 20,$l["concepto"],null,null,'L');		
		
		//Cantidad
		$pdf->SetXY( 105, $Y);
		$pdf->SetFont( $Tipo_Letra, "", 10);
		$importe = number_format($l["cantidad"],2);
		$pdf->Cell(12, 4,$importe,null,null,'R');		
				
		//P.Unitario
		$pdf->SetXY( 145, $Y);
		$pdf->SetFont( $Tipo_Letra, "", 10);
		$importe = number_format($l["precio_unitario"],2);
		$pdf->Cell(12, 4,$importe,null,null,'R');		
				
		//P.Total
		$pdf->SetXY( 185, $Y);
		$pdf->SetFont( $Tipo_Letra, "", 10);
		$importe = number_format($l["cantidad"]*$l["precio_unitario"],2);
		$pdf->Cell(12, 4,$importe,null,null,'R');		
				
		$Y += $espacioY;
	}
?>