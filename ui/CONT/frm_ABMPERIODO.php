<?php $edicion = $_SESSION['edicion']; 
	function formatDateJS($date) {
		list($anio, $mes, $dia) = split('[/.-]', $date);
		return "$dia/$mes/$anio";
	}
	
	function fechaEdicion($nombreCampo) {
		if ($nombreCampo == null) {
			$nombreCampo = date('d/m/Y');
		}
		else {
			$nombreCampo = formatDateJS($nombreCampo);
		}
		return $nombreCampo;
	}
	
	$edicion['fecha_inicio'] = fechaEdicion($edicion['fecha_inicio']);
	$edicion['fecha_fin'] = fechaEdicion($edicion['fecha_fin']);
	
?>
<script type="text/javascript" src="js/validators.js"></script>
<script type="text/javascript" src="js/datepicker.js"></script>

<link href="css/datepicker.css" rel="stylesheet" type="text/css" />

<form name="frmABMPeriodo" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; ?>">
<input name="id_periodo" type="hidden" value="<?php echo $edicion['id_periodo']; ?>">
<input name="id_empresa" type="hidden" value="<?php echo ($edicion['id_empresa'] != null ? $edicion['id_empresa'] : GLOBAL_EMPRESA); ?>">
<table width="200" border="0">
  <tr>
    <td align="right"><?php echo Translator::getTrans("nombre"); ?></td>
    <td><input name="nombre" type="text" id="txt_nombre" value="<?php echo $edicion['nombre']; ?>" maxlength="50"></td>
    <td><div class="div_error_req" id="div_error_req_nombre"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
  </tr>

	<tr>
		<td nowrap align="right"><?php echo Translator::getTrans("fecha_inicio"); ?></td>
   		<td nowrap align="left">
   			<input 
   				name="fecha_inicio" 
   				type="text" 
   				id="txt_fecha_inicio" 
   				value="<?php echo ($edicion['fecha_inicio'] == null ? date("d/m/Y") : $edicion['fecha_inicio']); ?>" 
   				maxlength="10"
   			/>      		
             <img 
             	align="top" 
                 onclick="displayDatePicker('fecha_inicio');" 
                 style="cursor: pointer;" 
                 <?php
			echo "src='css/". GLOBAL_THEME . "/images/cal.gif'";
		?>
             	border=0
             />
             </td>
   		
   		<td nowrap>
   			<div class="div_error_req" id="div_error_req_fecha_inicio"><?php echo Translator::getTrans("REQUIRED"); ?></div>
       		<div class="div_error_fecha" id="div_error_fecha_fecha_inicio"><?php echo Translator::getTrans("DATE_INVALID"); ?></div>          	
		</td>
 
 
		<td nowrap align="right"><?php echo Translator::getTrans("fecha_fin"); ?></td>
   		<td nowrap align="left">
   			<input 
   				name="fecha_fin" 
   				type="text" 
   				id="txt_fecha_fin" 
                 value="<?php echo ($edicion['fecha_fin'] == null ? date("d/m/Y") : $edicion['fecha_fin']); ?>" 
                 maxlength="10"
             />
   			<img
             	border="0" 
             	align="top"
                 style="cursor: pointer;" 
                 onclick="displayDatePicker('fecha_fin');" 
                 <?php
			echo "src='css/". GLOBAL_THEME . "/images/cal.gif'";
		?>
             />            
         </td>
   
   		<td nowrap>
   			<div class="div_error_req" id="div_error_req_fecha_fin"><?php echo Translator::getTrans("REQUIRED"); ?></div>
       		<div class="div_error_fecha" id="div_error_fecha_fecha_fin"><?php echo Translator::getTrans("DATE_INVALID"); ?></div>          	</td>
	</tr>

	  <tr>
    		<td nowrap align="right"><?php echo Translator::getTrans("estado"); ?></td>
    		<td nowrap align="left">
    			<select name="estado" id="cbo_estado">
      				<option VALUE="A" 
      					<?php 
      						if ($edicion['estado'] == "A") echo "selected";
      					?>
      				><?php echo Translator::getTrans("ABIERTO"); ?> </option>
					<option VALUE="C"
						<?php 
      						if ($edicion['estado'] == "C") echo "selected";
      					?>
					><?php echo Translator::getTrans("CERRADO"); ?> </option>	
    			</select>    		</td>
    
    		<td nowrap>&nbsp;</td>
    
    		<td nowrap align="right">&nbsp;</td>
    
    		<td nowrap>&nbsp;</td>
    		
    		<td nowrap>&nbsp;</td>
  	</tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>
   	  <button type="submit"  
    	onClick="return required('nombre')"
      >
      	<?php echo Translator::getTrans("GRABAR"); ?>
      </button>
    </td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
