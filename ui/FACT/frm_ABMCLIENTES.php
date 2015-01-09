<?php 
	$edicion = $_SESSION['edicion'];
	$tipos_documento = $_SESSION['tipos_documento'];
	$paises = $_SESSION['paises'];
	$provincias = $_SESSION['provincias'];
	$condicion_iva = $_SESSION['condicion_iva'];
?>

<script type="text/javascript" src="js/validators.js"></script>

<form name="frmABMCliente" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; ?>">

<input name="id_cliente" type="hidden" value="<?php echo $edicion['id_cliente']; ?>">

<table width="200" border="0">

  <tr>
    <td style='padding: 5px;' align="right"><?php echo Translator::getTrans("tipo_documento"); ?></td>
    <td style='padding: 5px;'><select name="id_tipo_documento" id="cbo_tipo_documento">
      <?php PantallaSingleton::agregaCombo($tipos_documento); ?>
    </select></td>
    <td style='padding: 5px;' align="right">&nbsp;</td>
    <td style='padding: 5px;' align="right"><?php echo Translator::getTrans("nro_documento"); ?></td>
    <td style='padding: 5px;'><input name="nro_documento" type="text" id="txt_nro_documento" value="<?php echo $edicion['nro_documento']; ?>" maxlength="50"></td>
    <td style='padding: 5px;'><div class="div_error_req" id="div_error_req_nro_documento"><?php echo Translator::getTrans("REQUIRED"); ?></div>
      <div class="div_error_num" id="div_error_num_nro_documento"><?php echo Translator::getTrans("NUMERIC"); ?></div></td>
    </tr>
  <tr>
    <td style='padding: 5px;' align="right"><?php echo Translator::getTrans("condicion_iva"); ?></td>
    <td style='padding: 5px;'><select name="id_condicion_iva" id="cbo_condicion_iva">
      <?php PantallaSingleton::agregaCombo($condicion_iva); ?>
    </select></td>
    <td style='padding: 5px;' align="right">&nbsp;</td>
    <td style='padding: 5px;' align="right">&nbsp;</td>
    <td style='padding: 5px;'>&nbsp;</td>
    <td style='padding: 5px;'>&nbsp;</td>
  </tr>
  <tr>
    <td style='padding: 5px;' align="right"><?php echo Translator::getTrans("razon_social"); ?></td>
    <td style='padding: 5px;'><input name="razon_social" type="text" id="txt_razon_social" value="<?php echo $edicion['razon_social']; ?>" maxlength="50" /></td>
    
    <td style='padding: 5px;' align="right"><div class="div_error_req" id="div_error_req_razon_social"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
    <td style='padding: 5px;' align="right"><?php echo Translator::getTrans("email"); ?></td>
    <td style='padding: 5px;'><input name="email" type="text" id="txt_email" value="<?php echo $edicion['email']; ?>" maxlength="50"></td>
    <td style='padding: 5px;'><div class="div_error_email" id="div_error_email_email"><?php echo Translator::getTrans("EMAIL"); ?></div></td>
    </tr>

  <tr>
    <td colspan="6" style='border:1px solid black; padding: 5px;'>
		<?php 
			echo Translator::getTrans("domicilio"); 
			require 'ui/frm_domicilio.php';
		?>    </td>
    </tr>
  <tr>
    <td colspan="6" style='padding: 5px;'>
    	<button type="submit"  
    		onClick="
        		var ret = required('nro_documento', 'razon_social');  
                ret = numeric('nro_documento') && ret;
    			ret = emailvalid('email') && ret;
                return ret;
            "
        >
        	<?php echo Translator::getTrans("GRABAR"); ?>        </button>    </td>
  </tr>
</table>

</form>