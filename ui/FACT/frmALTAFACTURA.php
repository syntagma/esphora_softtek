<?php 
	$edicion = $_SESSION['edicion'];
	$tipos_comprobante = $_SESSION['tipos_comprobante'];
	$clientes = $_SESSION['clientes'];
	
  // echo "<pre>";
  // print_r($edicion);
  // echo "</pre>";
  // exit;
	
	$condicion_venta = $_SESSION['condicion_venta'];
	$punto_venta = $_SESSION['punto_venta'];
	
	$tipo_pto_vta = $_SESSION['tipo_pto_vta'];
	
	$detalle = $_SESSION['detalle'];
	
	$retenciones = $_SESSION['retenciones'];
	
	$moneda= $_SESSION['moneda'];
	
	$unidad_medida = $_SESSION['unidad_medida'];
	
	$monedaBase = $_SESSION['moneda_base'];
	
	PantallaSingleton::agregaVariableGlobalJS("iva", "PORC_IVA");
	
	$periodos_abiertos = $_SESSION['periodos_abiertos'];
	
	$scrPeriodos = "var _periodos = new Array();";
	$i = 0;
	foreach ($periodos_abiertos as $periodo) {
		$scrPeriodos .= "_periodos[$i] = new Array();";
		$scrPeriodos .= "_periodos[$i][0] = ".$periodo['inicio'].";";
		$scrPeriodos .= "_periodos[$i][1] = ".$periodo['fin'].";";
		$i++; 
	}
	
	echo <<<EOF
	<script type='text/javascript'>;
		var _monedaBase = $monedaBase;
		$scrPeriodos;
	</script>
EOF;
?>


<script type="text/javascript" src="js/validators.js"></script>
<script type="text/javascript" src="js/datepicker.js"></script>

<link href="css/datepicker.css" rel="stylesheet" type="text/css" />

<select id="valores_unidad_medida" style="display:none">
	<?php PantallaSingleton::agregaCombo($unidad_medida); ?>
</select>

<select id="valores_provincia" style="display:none">
	<?php PantallaSingleton::agregaComboProvincias(); ?>
</select>

<select id="valores_retenciones" style="display:none">
	<?php PantallaSingleton::agregaComboRetenciones("V"); ?>
</select>


<div id="error_afip" class="mensaje_excepcion" style="display:none"></div>

<form name="frmAltaFactura" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; ?>">

	<input name="id_afip" id="hidIdAfip" type="hidden">
	<input name="id_factura" type="hidden" value="<?php echo $edicion['id_factura']; ?>">
	<input name="id_empresa" type="hidden" value="<?php echo ($edicion['id_empresa'] != null ? $edicion['id_empresa'] : GLOBAL_EMPRESA); ?>">

	<table width="200" border="0">
  		<tr>
    		<td nowrap align="right">
    			<?php echo Translator::getTrans("cliente"); ?>    		</td>
    		<td nowrap align="left">
    			<input name="id_cliente" id="txt_id_cliente" type="hidden" value="<?php echo $edicion['id_cliente']; ?>">
        		<table cellpadding="0" cellspacing="0" align="left">
        			<tr>
            			<td nowrap>
            				<input 
            					name="descripcion_cliente" 
            					type="text"  
            					id="txt_descripcion_cliente" 
            					value="<?php echo $edicion['descripcion_cliente']; ?>" 
            					maxlength="50" 
            					disabled readonly 
            				/>            			</td>
            
            			<td nowrap>
            				<input 
            					name="btnSelectClient" 
            					type="button" 
            					value="..." 
            					style="width:18px;height:23px" 
            					onClick="$('lista_clientes').style.display = 'block';"
            				/>            			</td>
            		</tr>
        		</table>
        
        		<div id="lista_clientes" class="lista_flotante">
       				<table>
       					<tr>
       						<td>Raz&oacute;n Social:</td>
       						<td><input type="text" id="txt_search_razonSocial" /></td>
       						<td>
       							<button 
       								type="button" 
       								onclick="buscaCliente($('txt_search_razonSocial').value, 'contenedor_clientes', this);"
       							>Search...</button>       						</td>
       					</tr>
       				</table>
       				<br>
 	        		<div id="contenedor_clientes"></div>
	        		<a href="javascript:close('lista_clientes');"><?php echo Translator::getTrans("CLOSE"); ?></a>	        	</div>	        </td>
    
    		<td nowrap>
    			<div class="div_error_req" id="div_error_req_descripcion_cliente"><?php echo Translator::getTrans("REQUIRED"); ?></div>			</td>
    
    		<td nowrap style='padding: 5px;' align="right"><?php echo Translator::getTrans("tipo_comprobante"); ?></td>
    		<td nowrap style='padding: 5px;' align="left">
        		<select name="id_tipo_comprobante" id="cbo_tipo_comprobante" onchange="ObtieneNroCbte();">
          			<?php PantallaSingleton::agregaCombo($tipos_comprobante); ?>        
        		</select>			</td>
    		<td nowrap>&nbsp;</td>
  		</tr>
  
  		<tr>
    		<td nowrap align="right"><?php echo Translator::getTrans("condicion_venta"); ?></td>
    		<td nowrap align="left">
    			<select name="id_condicion_venta" id="cbo_condicion_venta">
      				<?php PantallaSingleton::agregaCombo($condicion_venta); ?>
    			</select>    		</td>
    
    		<td nowrap>&nbsp;</td>
    
    		<td nowrap align="right">Tipo de Factura</td>
    
    		<td nowrap align="left">
        
        <?php
          $valoresPS = array('SERVICIO' => true, 'PRODUCTO' => false);

          $chequeadoPS = array();
          foreach ($valoresPS as $clavePS => $valorPS) {
        ?>
            <input 
              type="radio" 
              name="tipoFactProdServ" 
              value="<?php echo $clavePS; ?>" 
              <?php echo (($edicion == array() && $valorPS) || $edicion['tipofactprodserv'] == $clavePS) ? "checked" : ""; ?>
            ><?php echo ucfirst(strtolower($clavePS)); ?></input>
        <?php
          }
        ?>
			</td>
    		
    		<td nowrap>&nbsp;</td>
  		</tr>
  
  		<tr>
    		<td nowrap align="right"><?php echo Translator::getTrans("pto_vta"); ?></td>
    		<td nowrap align="left">
    			<input type="hidden" id="txt_pto_vta">
				
				<div style="display:none">
					<select id='cboTipoPtoVta'>
						<?php PantallaSingleton::agregaCombo($tipo_pto_vta); ?>
					</select>
				</div>
				
        		<select name="id_punto_venta" id="cbo_punto_venta" onchange="salvaPtoVta(this, $('cboTipoPtoVta'));$('txt_nro_factura').value = '';">
      				<?php PantallaSingleton::agregaCombo($punto_venta); ?>
	    		</select>			</td>
    
    		<td nowrap>
    			<div class="div_error_req" id="div_error_req_pto_vta"><?php echo Translator::getTrans("REQUIRED"); ?></div>
        		<div class="div_error_num" id="div_error_num_pto_vta"><?php echo Translator::getTrans("NUMERIC"); ?></div>			</td>
    
    		<td nowrap align="right"><?php echo Translator::getTrans("nro_factura"); ?></td>
    
    		<td nowrap align="left">
    			<input 
    				name="nro_factura" 
    				type="text" 
    				id="txt_nro_factura" 
    				readonly
    				value="<?php echo $edicion['nro_factura'] == null ? "" : str_pad($edicion['nro_factura'], 8, "0", STR_PAD_LEFT); ?>" 
    				maxlength="8"
    			/>			</td>
    
    		<td nowrap>
    			<div class="div_error_req" id="div_error_req_nro_factura"><?php echo Translator::getTrans("REQUIRED"); ?></div>
        		<div class="div_error_num" id="div_error_num_nro_factura"><?php echo Translator::getTrans("NUMERIC"); ?></div>			</td>
  		</tr>
  

  		<tr>
  		  <td nowrap align="right"><?php echo Translator::getTrans("moneda"); ?></td>
  		  <td nowrap align="left">
				<select name="id_moneda" id="cboMoneda" onchange="muestraCotizacion(this);">
					<?php PantallaSingleton::agregaCombo($moneda); ?>
				</select>
				<div style="display:none; border: 1px solid black" id="divCotizacion">
					<label><?php echo Translator::getTrans("cotizacion"); ?></label>
					<input 
						name="cotizacion" 
						type="text" 
						id="txt_cotizacion" 
						value="<?php echo $edicion['cotizacion']; ?>" 
						maxlength="15"
					/>
					<div class="div_error_req" id="div_error_req_cotizacion"><?php echo Translator::getTrans("REQUIRED"); ?></div>
					<div class="div_error_num" id="div_error_num_cotizacion"><?php echo Translator::getTrans("NUMERIC"); ?></div>
				</div>		  </td>
  		  <td nowrap>&nbsp;</td>
  		  <td nowrap align="right">&nbsp;</td>
  		  <td nowrap>&nbsp;</td>
  		  <td nowrap>&nbsp;</td>
	  </tr>
  		<tr>
    		<td nowrap align="right">&nbsp;</td>
    		<td nowrap>&nbsp;</td>
    		<td nowrap>&nbsp;</td>
    		<td nowrap align="right">&nbsp;</td>
    		<td nowrap>&nbsp;</td>
    		<td nowrap>&nbsp;</td>
  		</tr>
  		
  		<tr>
    		<td nowrap align="right"><?php echo Translator::getTrans("importe_neto_gravado"); ?></td>
    		<td nowrap align="left">
    			<input 
    				name="importe_neto_gravado" 
    				type="text" 
    				id="txt_importe_neto_gravado" 
    				onBlur="sumaTotal(this)"
			    	value="<?php echo $edicion['importe_neto_gravado']; ?>" 
			    	maxlength="15"
			    />			</td>
    
    		<td nowrap>
    			<div class="div_error_req" id="div_error_req_importe_neto_gravado"><?php echo Translator::getTrans("REQUIRED"); ?></div>
        		<div class="div_error_num" id="div_error_num_importe_neto_gravado"><?php echo Translator::getTrans("NUMERIC"); ?></div>			</td>
    
    		<td nowrap align="right"><?php echo Translator::getTrans("importe_ope_exentas"); ?></td>
    		
    		<td nowrap align="left">
    			<input 
    				name="importe_ope_exentas" 
    				type="text" 
    				id="txt_importe_ope_exentas" 
    				onBlur="sumaTotal(this)"
    				value="<?php echo $edicion['importe_ope_exentas']; ?>" 
    				maxlength="15"
    			/>			</td>
    
    		<td nowrap>
    			<div class="div_error_req" id="div_error_req_importe_ope_exentas"><?php echo Translator::getTrans("REQUIRED"); ?></div>
        		<div class="div_error_num" id="div_error_num_importe_ope_exentas"><?php echo Translator::getTrans("NUMERIC"); ?></div>			</td>
  		</tr>
  
  		<tr>
    		<td nowrap align="right"><?php echo Translator::getTrans("impuesto_liquidado"); ?></td>
    		<td nowrap align="left">
    			<input 
    				name="impuesto_liquidado" 
    				type="text" 
    				id="txt_impuesto_liquidado" 
    				onBlur="sumaTotal(this)"
    				value="<?php echo $edicion['impuesto_liquidado']; ?>" 
    				maxlength="15"
    			/>    		</td>
    	
    		<td nowrap>
    			<div class="div_error_req" id="div_error_req_impuesto_liquidado"><?php echo Translator::getTrans("REQUIRED"); ?></div>
        		<div class="div_error_num" id="div_error_num_impuesto_liquidado"><?php echo Translator::getTrans("NUMERIC"); ?></div>			</td>
    
    		<td nowrap align="right"><?php echo Translator::getTrans("impuesto_liquidado_rni"); ?></td>
    		<td nowrap align="left">
    			<input 
    				name="impuesto_liquidado_rni" 
    				type="text" 
    				id="txt_impuesto_liquidado_rni" 
    				onBlur="sumaTotal(this)"
    				value="<?php echo $edicion['impuesto_liquidado_rni']; ?>" 
    				maxlength="15"
    			/>			</td>
    
    		<td nowrap>
    			<div class="div_error_req" id="div_error_req_impuesto_liquidado_rni"><?php echo Translator::getTrans("REQUIRED"); ?></div>
        		<div class="div_error_num" id="div_error_num_impuesto_liquidado_rni"><?php echo Translator::getTrans("NUMERIC"); ?></div>			</td>
  		</tr>
  
  		<tr>
  		  <td nowrap align="right"><?php echo Translator::getTrans("otros_conceptos"); ?></td>
  		  <td nowrap align="left">
          		<input 
    				name="otros_conceptos" 
    				type="text" 
    				id="txt_otros_conceptos" 
    				onblur="sumaTotal(this)"
    				value="<?php echo $edicion['otros_conceptos']; ?>" 
    				maxlength="15"
    				readonly="true" 
    			/>			</td>
  		  
        <td nowrap>
        	<div class="div_error_req" id="div_error_req_otros_conceptos"><?php echo Translator::getTrans("REQUIRED"); ?></div>
        	<div class="div_error_num" id="div_error_num_otros_conceptos"><?php echo Translator::getTrans("NUMERIC"); ?></div>		</td>
  		<td nowrap colspan="3" align="right">&nbsp;</td>
		</tr>
  		
		<tr>
    		<td nowrap align="right"><?php echo Translator::getTrans("total"); ?></td>
    		<td nowrap align="left">
    			<input 
    				name="total" 
    				type="text" 
    				id="txt_total" 
    				value="<?php echo $edicion['total']; ?>" 
    				maxlength="15" 
    				readonly="true" 
    			/>			</td>
    
    		<td nowrap>
    			<div class="div_error_req" id="div_error_req_total"><?php echo Translator::getTrans("REQUIRED"); ?></div>
      			<div class="div_error_num" id="div_error_num_total"><?php echo Translator::getTrans("NUMERIC"); ?></div>			</td>
    
    		<td nowrap align="right">CAE / CAI</td>
            <td nowrap align="left"><input 
    				name="cae" 
    				type="text" 
    				id="txt_cae" 
    				value="<?php echo $edicion['cae']; ?>" 
    				maxlength="45" 
    				readonly="true" 
    			/>			</td>
    		<td nowrap><div class="div_error_req" id="div_error_req_cae"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
		</tr>
  
  		<tr>
    		<td nowrap align="right">&nbsp;</td>
			<td nowrap><br /></td>
    
    		<td nowrap>&nbsp;</td>
    		<td nowrap colspan="3"></td>
  		</tr>
  		
        <tr>
		    <td nowrap align="right"><?php echo Translator::getTrans("comentarios"); ?></td>
    		<td colspan="4" nowrap>
    			<textarea name="comentarios" id="txt_comentarios" style="width:100%" rows="5"><?php echo $edicion['comentarios']; ?></textarea>			</td>
    		<td nowrap><div class="div_error_req" id="div_error_req_comentarios"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
	  </tr>
      
  		<tr>
    		<td nowrap align="right"><?php echo Translator::getTrans("presta_serv"); ?></td>
    		<td nowrap align="left">
    			<input 
    				name="presta_serv" 
    				id="chk_presta_serv" 
    				type="checkbox" 
    				value="1" 
    	 			onClick="habilitarFechaServ(this.checked);"
					<?php echo ($edicion['presta_serv'] == null ? "" : ($edicion['presta_serv'] == "1" ? "checked" : "")); ?>
				/>
      			<div style="border:1px solid black; display:none" id="div_fecha_serv">
        			<table>
          				<tr>
            				<td nowrap align="right"><?php echo Translator::getTrans("fec_serv_desde"); ?></td>
            				<td nowrap align="left">
            					<input 
            						name="fec_serv_desde" 
            						type="text" 
            						id="txt_fec_serv_desde" 
				    				value="<?php echo $edicion['fec_serv_desde']; ?>" 
				    				maxlength="10"
				    			/>				    		
                            	<img
                                    border="0" 
                                    align="top"
                                    style="cursor: pointer;" 
                                    onclick="displayDatePicker('fec_serv_desde');" 
                                    <?php
                                        echo "src='css/". GLOBAL_THEME . "/images/cal.gif'";
                                    ?>
                                />                            </td>
            
            				<td nowrap>
            					<div class="div_error_req" id="div_error_req_fec_serv_desde"><?php echo Translator::getTrans("REQUIRED"); ?></div>
                				<div class="div_error_fecha" id="div_error_fecha_fec_serv_desde"><?php echo Translator::getTrans("DATE_INVALID"); ?></div>							</td>
          				</tr>
          				
          				<tr>
            				<td nowrap align="right"><?php echo Translator::getTrans("fec_serv_hasta"); ?></td>
            				<td nowrap align="left">
            					<input 
            						name="fec_serv_hasta" 
            						type="text" 
            						id="txt_fec_serv_hasta" 
				    				value="<?php echo $edicion['fecha_serv_desde']; ?>" 
				    				maxlength="10"
				    			/>
                            	<img
                                    border="0" 
                                    align="top"
                                    style="cursor: pointer;" 
                                    onclick="displayDatePicker('fec_serv_hasta');" 
                                    <?php
                                        echo "src='css/". GLOBAL_THEME . "/images/cal.gif'";
                                    ?>
                                />                            </td>
            
            				<td nowrap>
            					<div class="div_error_req" id="div_error_req_fec_serv_hasta"><?php echo Translator::getTrans("REQUIRED"); ?></div>
                				<div class="div_error_fecha" id="div_error_fecha_fec_serv_hasta"><?php echo Translator::getTrans("DATE_INVALID"); ?></div>							</td>
          				</tr>
        			</table>
      			</div>			</td>
    		
    		<td nowrap>&nbsp;</td>
    
    		<td nowrap colspan="3" align="right">&nbsp;</td>
    	</tr>
  
  		<tr>
  		  <td nowrap align="right"><?php echo Translator::getTrans("fec_registro_contable"); ?></td>
  		  <td nowrap align="left"><input 
      				name="fec_registro_contable" 
      				type="text" 
      				id="txt_fec_registro_contable" 
      				value="<?php echo ($edicion['fec_registro_contable'] == null ? date("d/m/Y") : $edicion['fec_registro_contable']); ?>" 
      				maxlength="10"
      			/>
	      <img alt=""
                	border="0" 
                	align="top" 
                    style="cursor: pointer;" 
                    onclick="displayDatePicker('fec_registro_contable');" 
                    <?php
						echo "src='css/". GLOBAL_THEME . "/images/cal.gif'";
					?>
                /></td>
  		  <td nowrap><div class="div_error_req" id="div_error_req_fec_registro_contable"><?php echo Translator::getTrans("REQUIRED"); ?></div>
          		<div class="div_error_fecha" id="div_error_fecha_fec_registro_contable"><?php echo Translator::getTrans("DATE_INVALID"); ?></div></td>
  		  <td nowrap align="right">&nbsp;</td>
  		  <td nowrap align="left">&nbsp;</td>
  		  <td nowrap>&nbsp;</td>
	  </tr>
  		<tr>
	  		<td nowrap align="right"><?php echo Translator::getTrans("fec_cbte"); ?></td>
      		<td nowrap align="left">
      			<input 
      				name="fec_cbte" 
      				type="text" 
      				id="txt_fec_cbte" 
      				value="<?php echo ($edicion['fec_cbte'] == null ? date("d/m/Y") : $edicion['fec_cbte']); ?>" 
      				maxlength="10"
      			/>      		
                <img 
                	align="top" 
                    onclick="displayDatePicker('fec_cbte');" 
                    style="cursor: pointer;" 
                    <?php
						echo "src='css/". GLOBAL_THEME . "/images/cal.gif'";
					?>
                	border=0
                />                </td>
      		
      		<td nowrap>
      			<div class="div_error_req" id="div_error_req_fec_cbte"><?php echo Translator::getTrans("REQUIRED"); ?></div>
          		<div class="div_error_fecha" id="div_error_fecha_fec_cbte"><?php echo Translator::getTrans("DATE_INVALID"); ?></div>			</td>
    
    
	  		<td nowrap align="right"><?php echo Translator::getTrans("fecha_venc_pago"); ?></td>
      		<td nowrap align="left">
      			<input 
      				name="fecha_venc_pago" 
      				type="text" 
      				id="txt_fecha_venc_pago" 
                    value="<?php echo ($edicion['fecha_venc_pago'] == null ? date("d/m/Y") : $edicion['fecha_venc_pago']); ?>" 
                    maxlength="10"
                />
      			<img
                	border="0" 
                	align="top"
                    style="cursor: pointer;" 
                    onclick="displayDatePicker('fecha_venc_pago');" 
                    <?php
						echo "src='css/". GLOBAL_THEME . "/images/cal.gif'";
					?>
                />            </td>
      
      		<td nowrap>
      			<div class="div_error_req" id="div_error_req_fecha_venc_pago"><?php echo Translator::getTrans("REQUIRED"); ?></div>
          		<div class="div_error_fecha" id="div_error_fecha_fecha_venc_pago"><?php echo Translator::getTrans("DATE_INVALID"); ?></div>          	</td>
  		</tr>
  
  		<tr>
    		<td colspan="6"  nowrap align="left">
    			<div style="display:none">
    			<label>
      				<input 
      					type="checkbox" 
      					style="width:25px; height:15px;" 
      					name="detallada" 
      					value="S" 
      					id="chkDetallada"
	  					<?php echo ($edicion['detallada'] == null ? "checked" : ($edicion['detallada'] == "S" ? "checked" : "")); ?>
       					onclick="muestraDetalles(this.checked);"
      				/>
      				Detalle de Factura				</label>
      			</div>
      			<input id="cantLineas" name="cantLineas" type="hidden" value="1" />
      			<div>
      				<?php PantallaSingleton::hiddenIVA(); ?>
      			</div>			</td>
    	</tr>
  		
  		<tr>
    		<td colspan="6" nowrap>
    			<div id="detalles" style="display:none;border:1px solid black;; padding:5px">
    				<div id="detalle_factura" style="padding:5px">
        				<strong>Detalle de Factura</strong>
							<table cellpadding="2" style="color:#555555;">
                				<tr>
									<td style="padding-right:5px;text-align:left" width=200>Concepto</td>
									<td style="padding-right:5px;text-align:left" width=100>Cantidad</td>
									<td style="padding-right:5px;text-align:left" width=175>Unidad de Medida</td>
									<td style="padding-right:5px;text-align:left" width=100>Precio Unitario</td>
									<td style="padding-right:5px;text-align:left" width=175>Alicuota IVA</td>
									<td style="padding-right:5px;text-align:left" width=100>Subtotal</td>
									<td style="padding-right:5px;text-align:left" width=100>Total IVA</td>
									<td style="padding-right:5px;text-align:left" width=100>Total</td>
								</tr>
             				</table>
         			</div>
          	
          			<button  type="button" onclick="agregaLinea()"> Agregar Detalle </button>
        		</div>			</td>
    	</tr>
  		
  		<tr>
    		<td colspan="6"  nowrap>&nbsp;</td>
    	</tr>
  		
        
        <tr>
    		<td colspan="6"  nowrap align="left">
    			<label>
      				<input 
      					type="checkbox" 
      					style="width:25px; height:15px;" 
      					name="retenciones" 
      					value="S" 
      					id="chkRetenciones"
	  					<?php echo ($edicion['retenciones'] == null ? "" : $edicion['retenciones'] == "S" ? "checked" : ""); ?>
       					onclick="muestraRetenciones(this.checked);"
      				/>
      				Percepciones				</label>
      			
      			<input id="cantLineasRet" name="cantLineasRet" type="hidden" value="1" />
				<div>
      				<?php PantallaSingleton::hiddenRET(); ?>
      			</div>			</td>
    	</tr>
  		
  		<tr>
    		<td colspan="6" nowrap>
    			<div id="retenciones" style="display:none;border:1px solid black;; padding:5px">
    				<div id="retenciones_factura" style="padding:5px">
        				<strong>Retenciones</strong>
						<table cellpadding="2" style="color:#555555;">
               				<tr>
								<td style="padding-right:5px;text-align:left" width=175>Concepto</td>
								<td style="padding-right:5px;text-align:left" width=200>Detalle</td>
								<td style="padding-right:5px;text-align:left" width=100>Base Imponible</td>
								<td style="padding-right:5px;text-align:left" width=100>Alicuota %</td>
								<td style="padding-right:5px;text-align:left" width=100>Importe</td>
							</tr>
            			</table>
         			</div>
          	
          			<button  type="button" onclick="agregaLineaRetencion()">Agregar Percepcion</button>
        		</div>			</td>
    	</tr>
  		
  		<tr>
    		<td colspan="6"  nowrap>&nbsp;</td>
    	</tr>
        
  		<tr>
    		<td  nowrap>
   	  			<button 
   	  				type="button"  
    				onClick="return valida_factura();"
      			>
   	  				<?php echo Translator::getTrans("GRABAR"); ?>				</button>			</td>
    
    		<td nowrap>&nbsp;</td>
    		<td align="right" nowrap>&nbsp;</td>
    		<td align="right" nowrap>&nbsp;</td>
    		<td align="right" nowrap>
    			<?php
					if ($_SESSION['goback'] != null) {
						$urlVuelta = $_SESSION['goback'];
						unset($_SESSION['goback']);
					}
					else {
						$urlVuelta = URL_LISTA_FACTURAS;
					}
					echo "<button type='button' id='btnCancelar' onClick='document.location=\"$urlVuelta\";'>";
					echo Translator::getTrans("Volver");
					echo "</button>";			
				?>			</td>
    		<td align="right" nowrap>&nbsp;</td>
  		</tr>
	</table>
</form>

<?php 
	$cuerpo = "";
	if ($detalle == null) {
		$cuerpo = "agregaLinea();";
	}
	else {
		$i=0;
		foreach ($detalle as $lineaFactura) {
			$concepto = $lineaFactura['concepto'];
			
			echo "<div id='concepto$i' style='display:none'>$concepto</div>";
			
			
			$cantidad = $lineaFactura['cantidad'];
			$precioUnitario = $lineaFactura['precio_unitario'];
			$idIVA = $lineaFactura['id_alicuota_iva'];
			
			$unidadMedida = $lineaFactura['id_unidad_medida'];
			
			$cuerpo .= "agregaLineaLlena($('concepto$i').innerHTML, $cantidad, $precioUnitario, $idIVA, $unidadMedida);\n";
			
			$i++;
		}
	}
	
	if ($retenciones == null) {
		$cuerpo .= "agregaLineaRetencion();";
	}
	else {
		foreach ($retenciones as $lineaFactura) {
			$idConcepto = $lineaFactura['id_retencion'];
			$detalle = $lineaFactura['detalle'];
			$baseImponible = $lineaFactura['base_imponible'];
			$alicuota = $lineaFactura['alicuota'];
			$provincia = $lineaFactura['id_provincia'];
			
			if (trim($provincia) == "") $provincia = "null";
			$cuerpo .= "agregaLineaLlenaRet($idConcepto, '$detalle', $baseImponible, $alicuota, $provincia);\n";
		}
	}
	//trace($cuerpo);
	echo <<<EOS
		<script type="text/javascript">
			function _agregaLinea() {
				$cuerpo
			}
		</script>
EOS;
?>
<script type="text/javascript" src="js/facturas.js?1"></script>

<div class="wait-pantalla-completa" id="div_wait">
	<table width=100% height=100%>
		<tr>
			<td valign="middle" align="center">
				<div class="cuadro-wait-pantalla-completa">
					<B>
						<i>Obteniendo Datos de la AFIP...</i><br><br>
						Esta operacion puede tardar varios segundos.<br><br>
						<img src='css/orange/images/ajax-loader.gif' border=0 />
						<br><br>Por favor espere...
					</B>
				</div>
			</td>
		</tr>
	</table>
</div>