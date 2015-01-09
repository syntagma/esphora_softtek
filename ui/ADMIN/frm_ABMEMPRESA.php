<?php 
	$edicion = $_SESSION['edicion'];
	$tipos_documento = $_SESSION['tipos_documento'];
	$paises = $_SESSION['paises'];
	$provincias = $_SESSION['provincias'];
?>

<script type="text/javascript" src="js/validators.js"></script>

<form name="frmABMEmpresa" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; ?>">

<input name="id_empresa" type="hidden" value="<?php echo $edicion['id_empresa']; ?>">

<table width="200" border="0">
	<tr>
		<td nowrap align="right"><?php echo Translator::getTrans("moneda"); ?></td>
		<td nowrap>
			<select name="id_moneda" id="cbo_moneda">
				<?php PantallaSingleton::agregaCombo($monedas); ?>
			</select>    		
		</td>
		<td nowrap>&nbsp;</td>
		<td nowrap>&nbsp;</td>
		<td nowrap>&nbsp;</td>
		<td nowrap>&nbsp;</td>
		<td nowrap>&nbsp;</td>
		<td nowrap>&nbsp;</td>
		<td nowrap>&nbsp;</td>
  </tr>
  <tr>
    <td style='padding: 5px;' align="right"><?php echo Translator::getTrans("tipo_documento"); ?></td>
    <td style='padding: 5px;'><select name="id_tipo_documento" id="cbo_tipo_documento">
    	<?php PantallaSingleton::agregaCombo($tipos_documento); ?>        
    </select></td>
    
    <td style='padding: 5px;' align="right">&nbsp;</td>
    <td style='padding: 5px;' align="right"><?php echo Translator::getTrans("nro_documento"); ?></td>
    <td style='padding: 5px;'><input name="nro_documento" type="text" id="txt_nro_documento" value="<?php echo $edicion['nro_documento']; ?>" maxlength="50" /></td>
    
    <td style='padding: 5px;' ><div class="div_error_req" id="div_error_req_nro_documento"><?php echo Translator::getTrans("REQUIRED"); ?></div>
      <div class="div_error_num" id="div_error_num_nro_documento"><?php echo Translator::getTrans("NUMERIC"); ?></div></td>
    <td style='padding: 5px;'><?php echo Translator::getTrans("nombre"); ?></td>
    <td style='padding: 5px;'><input name="nombre" type="text" id="txt_nombre" value="<?php echo $edicion['nombre']; ?>" maxlength="50" /></td>
    <td><div class="div_error_req" id="div_error_req_nombre"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
  </tr>

  <tr>
    <td style='padding: 5px;' align="right"><?php echo Translator::getTrans("fecha_inicio_actividades"); ?></td>
    <td style='padding: 5px;'><input name="fecha_inicio_actividades" type="text" id="txt_fecha_inicio_actividades" value="<?php echo $edicion['fecha_inicio_actividades']; ?>" maxlength="10" /></td>
    <td style='padding: 5px;'>
    	<div class="div_error_req" id="div_error_req_fecha_inicio_actividades"><?php echo Translator::getTrans("REQUIRED"); ?></div>
    	<div class="div_error_fecha" id="div_error_fecha_fecha_inicio_actividades"><?php echo Translator::getTrans("DATE_INVALID"); ?></div>    </td>
    
    <td style='padding: 5px;' align="right"><?php echo Translator::getTrans("ingresos_brutos"); ?></td>
    <td style='padding: 5px;'><input name="ingresos_brutos" type="text" id="txt_ingresos_brutos" value="<?php echo $edicion['ingresos_brutos']; ?>" maxlength="11"></td>
    <td style='padding: 5px;'>
      	<div class="div_error_req" id="div_error_req_ingresos_brutos"><?php echo Translator::getTrans("REQUIRED"); ?></div>    </td>
    
    <td style='padding: 5px;' align="right"><?php echo Translator::getTrans("nombre_fantasia"); ?></td>
    <td style='padding: 5px;'><input name="nombre_fantasia" type="text" id="txt_nombre_fantasia" value="<?php echo $edicion['nombre_fantasia']; ?>" maxlength="250" /></td>
    <td style='padding: 5px;'>
    	<div class="div_error_req" id="div_error_req_nombre_fantasia"><?php echo Translator::getTrans("REQUIRED"); ?></div>    </td>
  </tr>

  <tr>
    <td colspan="9" style='border:1px solid black; padding: 5px;'>
		<?php 
			echo Translator::getTrans("domicilio"); 
			require 'ui/frm_domicilio.php';
		?>    </td>
    </tr>
  <tr>
    <td colspan="9" style='padding: 5px;'><button type='button'
    	onclick=
        		"var ret = required('nro_documento', 'nombre', 'calle', 'numero', 'piso', 'departamento', 'codigo_postal', 'telefono', 'ciudad', 'fecha_inicio_actividades', 'ingresos_brutos', 'nombre_fantasia');  
                ret = numeric('numero', 'piso', 'codigo_postal', 'nro_documento') && ret; 
    			ret = datevalid('fecha_inicio_actividades') && ret;
                if(ret) forms['frmABMEmpresa'].submit();"
        ><?php echo Translator::getTrans("GRABAR"); ?></button>    </td>
    </tr>
</table>

</form>