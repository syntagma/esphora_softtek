<?php $edicion = $_SESSION['edicion']; ?>
<script type="text/javascript" src="js/validators.js"></script>
<form name="frmABMTipoComprobante" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; ?>">
<input name="id_tipo_comprobante" type="hidden" value="<?php echo $edicion['id_tipo_comprobante']; ?>">
<table width="200" border="0">
  <tr>
    <td align="right"><?php echo Translator::getTrans("descripcion"); ?></td>
    <td><input name="descripcion" type="text" id="txt_descripcion" value="<?php echo $edicion['descripcion']; ?>" maxlength="50"></td>
    <td><div class="div_error_req" id="div_error_req_descripcion"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
  </tr>
  <tr>
    <td align="right"><?php echo Translator::getTrans("cod_comprobante"); ?></td>
    <td><input name="cod_comprobante" type="text" id="txt_cod_comprobante" value="<?php echo $edicion['cod_comprobante']; ?>" maxlength="2"></td>
    <td><div class="div_error_req" id="div_error_req_cod_comprobante"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
  </tr>
  
  <tr>
    <td align="right"><?php echo Translator::getTrans("nombre_corto"); ?></td>
    <td><input name="nombre_corto" type="text" id="txt_nombre_corto" value="<?php echo $edicion['nombre_corto']; ?>" maxlength="45"></td>
    <td><div class="div_error_req" id="div_error_req_nombre_corto"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
  </tr>
  
  <tr>
    <td align="right"><?php echo Translator::getTrans("letra"); ?></td>
    <td><input name="letra" type="text" id="txt_letra" value="<?php echo $edicion['letra']; ?>" maxlength="1"></td>
    <td><div class="div_error_req" id="div_error_req_letra"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
  </tr>
  
  <tr>
    <td align="right">&nbsp;</td>
    <td>
   	  <button type="submit" 
    	onClick="return required('descripcion', 'cod_comprobante', 'nombre_corto', 'letra')"
      >
      	<?php echo Translator::getTrans("GRABAR"); ?>
      </button>
    </td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>
