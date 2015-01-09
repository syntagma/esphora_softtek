<?php $edicion = $_SESSION['edicion']; ?>
<script type="text/javascript" src="js/validators.js"></script>
<script type="text/javascript" src="js/datepicker.js"></script>

<link href="css/datepicker.css" rel="stylesheet" type="text/css" />

<form name="frmABMPuntoVenta" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; ?>">
<input name="id_punto_venta" type="hidden" value="<?php echo $edicion['id_punto_venta']; ?>">
<input name="id_empresa" type="hidden" value="<?php echo ($edicion['id_empresa'] != null ? $edicion['id_empresa'] : GLOBAL_EMPRESA); ?>">
<table width="200" border="0">
  <tr>
    <td align="right"><?php echo Translator::getTrans("numero"); ?></td>
    <td align="left"><input name="numero" type="text" id="txt_numero" value="<?php echo $edicion['numero']; ?>" maxlength="50"></td>
    <td>
		<div class="div_error_req" id="div_error_req_numero"><?php echo Translator::getTrans("REQUIRED"); ?></div>
		<div class="div_error_num" id="div_error_num_numero"><?php echo Translator::getTrans("NUMERIC"); ?></div>
	</td>
  </tr>
  <tr>
    <td align="right" valign="top"><?php echo Translator::getTrans("tipo_pto_vta"); ?></td>
    <td align="left">
		<select name="tipo_pto_vta" id="cboTipoPtoVta"
			onchange="muestraCAI(this);"
		> 
			<?php
				$selected = array(
									'E' => array('titulo' => "Factura Electronica", 'selected' => ""), 
									'M' => array('titulo' => "Manual", 'selected' => ""), 
									'A' => array('titulo' => "Aplicativo AFIP", 'selected' => "")
				);
				if ($edicion['tipo_pto_vta'] != null) $selected[$edicion['tipo_pto_vta']]['selected'] = "selected";
				
				foreach ($selected as $key => $value) {
					echo "<option value='$key' ".$selected[$key]['selected'].">".$selected[$key]['titulo']."</option>";
				}
			?>
		</select>
		
		<div id="divCAI" style="display:none; border:1px solid black; padding:3px">
			<table>
				<tr>
					<td align="right">
						CAI
					</td>
					<td align="left">
						<input type="text" name="cai" id="txt_cai" value="<?php echo $edicion['cai']; ?>" maxlength="45" />
						<div class="div_error_req" id="div_error_req_cai"><?php echo Translator::getTrans("REQUIRED"); ?></div>
						<div class="div_error_num" id="div_error_num_cai"><?php echo Translator::getTrans("NUMERIC"); ?></div>
					</td>
				</tr>
				<tr>
					<td nowrap align="right">
						Fecha Vencimiento CAI
					</td>
					<td nowrap align="left">
						<input type="text" name="fec_venc_cai" id="txt_fec_venc_cai" value="<?php echo $edicion['fec_venc_cai']; ?>" maxlength="45" />
						<img
			                border="0" 
			                align="top"
			                style="cursor: pointer;" 
			                onclick="displayDatePicker('fec_venc_cai');" 
			                <?php
			                    echo "src='css/". GLOBAL_THEME . "/images/cal.gif'";
			                ?>
			            />
						<div class="div_error_req" id="div_error_req_fec_venc_cai"><?php echo Translator::getTrans("REQUIRED"); ?></div>
			            <div class="div_error_fecha" id="div_error_fecha_fec_venc_cai"><?php echo Translator::getTrans("DATE_INVALID"); ?></div>
			        </td>
			    </tr>
			</table>
		</div>
	</td>
    <td></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>
   	  <button 
   	  	type="submit"  
    	onClick="return validaForm();"
      >
      	<?php echo Translator::getTrans("GRABAR"); ?>
      </button>
    </td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>

<script type="text/javascript">
	function muestraCAI(cboTipoPtoVta) {
		if (cboTipoPtoVta.value == 'M') {
			show('divCAI');
		}
		else {
			close('divCAI');
		}
	}

	function validaForm() {
		var res = required('numero');

		if ($('cboTipoPtoVta').value == 'M') {
			res = required('cai') && numeric('cai') && res;
			res = required('fec_venc_cai') && datevalid('fec_venc_cai') && res;
		}

		return res;
	}
	
	muestraCAI($("cboTipoPtoVta"));
</script>