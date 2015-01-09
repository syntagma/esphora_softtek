<?php 
	$edicion = $_SESSION['edicion']; 

	$monedas = $_SESSION['monedas'];
?>
<script type="text/javascript" src="js/validators.js"></script>
<form name="frmABMMoneda" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; ?>">
<input name="id_moneda" type="hidden" value="<?php echo $edicion['id_moneda']; ?>">
<table width="200" border="0">
  <tr>
    <td align="right"><?php echo Translator::getTrans("codigo"); ?></td>
    <td><input name="codigo" type="text" id="txt_codigo" value="<?php echo $edicion['codigo']; ?>" minlength="3" maxlength="3"></td>
    <td><div class="div_error_req" id="div_error_req_codigo"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
  </tr>
  <tr>
    <td align="right"><?php echo Translator::getTrans("descripcion"); ?></td>
    <td><input name="descripcion" type="text" id="txt_descripcion" value="<?php echo $edicion['descripcion']; ?>" maxlength="50"></td>
    <td><div class="div_error_req" id="div_error_req_descripcion"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
  </tr>
  <tr>
    <td align="right"><?php echo Translator::getTrans("codigo_moneda_afip"); ?></td>
    <td><input name="codigo_moneda_afip" type="text" id="txt_codigo_moneda_afip" value="<?php echo $edicion['codigo_moneda_afip']; ?>" minlength="3" maxlength="3"></td>
    <td><div class="div_error_req" id="div_error_req_codigo_moneda_afip"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
  </tr>
  
  <tr>
    <td align="right">&nbsp;</td>
    <td>
   	  <button type="submit"  
    	onClick="return required('codigo', 'descripcion', 'codigo_moneda_afip')"
      >
      	<?php echo Translator::getTrans("GRABAR"); ?>
      </button>
    </td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>