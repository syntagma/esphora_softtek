<?php 
	$edicion = $_SESSION['edicion'];
?>
<script type="text/javascript" src="js/validators.js"></script>
<script type="text/javascript" src="js/BusquedaFacturas.js"></script>

<form name="frmAltaLote" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; ?>">

<input name="id_lote" type="hidden" value="<?php echo $edicion['id_lote']; ?>">

<table>
	<tr>
	  	<td nowrap style='padding: 5px;' align="right">
		<?php echo Translator::getTrans("factura_desde"); ?>	</td>
	<td nowrap style='padding: 5px;'>
		<input name="id_factura_desde" 
			id="txt_id_factura_desde" 
			type="hidden" 
			value="<?php echo $edicion['id_factura_desde']; ?>" 
		/>
        <table cellpadding="0" cellspacing="0">
        	<tr>
            	<td nowrap>
					<input name="descripcion_factura_desde" 
						type="text"
						id="txt_descripcion_factura_desde" 
                		value="<?php echo $edicion['descripcion_factura_desde']; ?>" 
						maxlength="50" 
						readonly="true" 
					/>				</td>
            	
				<td nowrap>
					<input name="btnSelect" 
						type="button" 
						value="..." 
						style="width:18px;height:23px" 
            			onclick="
							$('lista_factura_desde').style.display='block'; 
							$('lista_factura_hasta').style.display='none';
						"
					/>				</td>
			</tr>
        </table>	</td>
	<td nowrap>
		<div class="div_error_req" id="div_error_req_descripcion_factura_desde">
			<?php echo Translator::getTrans("REQUIRED"); ?>		</div>	</td>
    
    	<td nowrap style='padding: 5px;' align="right">
		<?php echo Translator::getTrans("factura_hasta"); ?>	</td>
    
	<td nowrap style='padding: 5px;'>
		<input name="id_factura_hasta" 
			id="txt_id_factura_hasta" 
			type="hidden" 
        	value="<?php echo $edicion['id_factura_hasta']; ?>" 
		/>
        <table cellpadding="0" cellspacing="0">
        	<tr>
            	<td nowrap="nowrap">
					<input name="descripcion_factura_hasta" 
						type="text"  
						id="txt_descripcion_factura_hasta" 
          				value="<?php echo $edicion['descripcion_factura_hasta']; ?>" 
						maxlength="50" 
						readonly="true" 
					/>				</td>
            
				<td nowrap="nowrap">
					<input name="btnSelect2" 
						type="button" 
						value="..." 
						style="width:18px;height:23px" 
            			onclick="
							$('lista_factura_hasta').style.display='block'; 
							$('lista_factura_desde').style.display='none';
						" 
					/>				</td>
          	</tr>
		</table>	</td>
	<td nowrap>
		<div class="div_error_req" id="div_error_req_descripcion_factura_hasta">
			<?php echo Translator::getTrans("REQUIRED"); ?>		</div>	</td>
    </tr>
	<tr>
	  <td colspan="6" align="left" nowrap>Obtener CAE 
      <input type="checkbox" name="chkCAE" id="chkCAE" value='S' /></td>
    </tr>
	<tr>
    	<td colspan="6" align="left" nowrap>
        	<button type="submit"   
            	onclick="return required('descripcion_factura_desde', 'descripcion_factura_hasta');"
            >
            	<?php echo Translator::getTrans("GRABAR"); ?>            </button>        </td>
    </tr>
</table>
</form>
<div id="lista_factura_desde" class="lista_flotante" style="width:1000px;height:300px">
	<div class="titulo1"><?php echo Translator::getTrans("factura_desde"); ?></div>
    
    <?php 
		$idResultado = "factura_desde";
		require "ui/frmBuscaFactura.php";
	?>
    
	<a href="javascript:close('lista_factura_desde');"><?php echo Translator::getTrans("CLOSE"); ?></a>
</div>

<div id="lista_factura_hasta" class="lista_flotante" style="width:1000px;height:300px">
	<div class="titulo1"><?php echo Translator::getTrans("factura_hasta"); ?></div>

    <?php 
		$idResultado = "factura_hasta";
		require "ui/frmBuscaFactura.php";
	?>
	

	<br />

    <a href="javascript:close('lista_factura_hasta');"><?php echo Translator::getTrans("CLOSE"); ?></a>
</div>

