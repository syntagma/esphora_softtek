<?php

	function ColoredTable($header, $data, &$pdf) {
		// Colors, line width and bold font
		$pdf->SetFillColor ( 255, 0, 0 );
		$pdf->SetTextColor ( 255 );
		$pdf->SetDrawColor ( 128, 0, 0 );
		$pdf->SetLineWidth ( 0.3 );
		$pdf->SetFont ( '', 'B' );
		// Header
		$w = array (40, 35, 40, 45 );
		for($i = 0; $i < count ( $header ); $i ++)
			$pdf->Cell ( $w [$i], 7, $header [$i], 1, 0, 'C', 1 );
		$pdf->Ln ();
		// Color and font restoration
		$pdf->SetFillColor ( 224, 235, 255 );
		$pdf->SetTextColor ( 0 );
		$pdf->SetFont ( '' );
		// Data
		$fill = 0;
		foreach ( $data as $row ) {
			$pdf->Cell ( $w [0], 6, $row [0], 'LR', 0, 'L', $fill );
			$pdf->Cell ( $w [1], 6, $row [1], 'LR', 0, 'L', $fill );
			$pdf->Cell ( $w [2], 6, number_format ( $row [2] ), 'LR', 0, 'R', $fill );
			$pdf->Cell ( $w [3], 6, number_format ( $row [3] ), 'LR', 0, 'R', $fill );
			$pdf->Ln ();
			$fill = ! $fill;
		}
		$pdf->Cell ( array_sum ( $w ), 0, '', 'T' );
	}
	
	//seteo de idioma
	$pdf->setLanguageArray('es'); 
	
	//Seteo de Cabecera
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

	// set default header data
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
	
	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
	//set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	
	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
	
	// add a page
	$pdf->AddPage();
	
	//Column titles
	$header = array('Registro', 'Mensaje');
	
	//Data loading
	$data = $resultado;
	
	// print colored table
	ColoredTable($header, $data, $pdf);
	
/*	$Tipo_Letra="vera";
	$espacioY = 10;
	$Y = 45;
	
	// Inicio de Pagina
	$pdf->AddPage();

	// Tipo de Comprobante
	$pdf->SetXY( 15, 12);
	$pdf->SetFont( $Tipo_Letra, "B", 18);
	$pdf->Cell( 12, 4,"Resultado de Importacion de Compras" );
	
	// Titulos
	$pdf->SetXY( 20, $Y-20);
	$pdf->SetFont( $Tipo_Letra, "B", 10);
	$pdf->Cell( 12, 4,"Registro");

	$pdf->SetXY( "158", $Y-20);
	$pdf->SetFont( $Tipo_Letra, "B", 10);
	$pdf->Cell( 30, 4,"Mensaje");

	
	//TABLA DE LINEAS
	foreach ( $resultado as $key => $res ) {
		if ($res != "") {
			
			if (is_nan ( $key )) {
				$pdf->SetXY( 20, $Y);
				$pdf->SetFont( $Tipo_Letra, "", 8);
				$pdf->Cell(10, 4,strtoupper ( $key ));

				$pdf->SetXY( 80, $Y);
				$pdf->SetFont( $Tipo_Letra, "", 8);
				$pdf->MultiCell(30, 60,$res);
			} 

			else {
				$pdf->SetXY( 20, $Y);
				$pdf->SetFont( $Tipo_Letra, "", 8);
				$pdf->Cell(10, 4,strtoupper ( $key ));

				$pdf->SetXY( 80, $Y);
				$pdf->SetFont( $Tipo_Letra, "", 8);
				$pdf->MultiCell(30, 60,$res);
			}
				
			$muestraError = true;
			$Y += $espacioY;
		}
	}
*/

	
?>