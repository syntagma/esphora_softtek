<?php $edicion = $_SESSION['edicion']; ?>
<script type="text/javascript" src="js/validators.js"></script>
<form name="frmABMCondicionIva" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; ?>">
<input name="id_condicion_iva" type="hidden" value="<?php echo $edicion['id_condicion_iva']; ?>">
<table width="200" border="0">
  <tr>
    <td align="right"><?php echo Translator::getTrans("descripcion"); ?></td>
    <td><input name="descripcion" type="text" id="txt_descripcion" value="<?php echo $edicion['descripcion']; ?>" maxlength="50"></td>
    <td><div class="div_error_req" id="div_error_req_descripcion"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
  </tr>
  <tr>
    <td align="right"><?php echo Translator::getTrans("codigo_afip"); ?></td>
    <td><input name="codigo_afip" type="text" id="txt_codigo_afip" value="<?php echo $edicion['codigo_afip']; ?>" maxlength="2"></td>
    <td><div class="div_error_req" id="div_error_req_codigo_afip"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
  </tr>  <tr>
    <td align="right">&nbsp;</td>
    <td>
   	  <button type="submit"  
    	onClick="return required('descripcion')"
      >
      	<?php echo Translator::getTrans("GRABAR"); ?>
      </button>
    </td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>