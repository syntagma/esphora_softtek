<?php 
	$edicion = $_SESSION['edicion']; 
	$lista_funciones = $_SESSION['lista_funciones']; 
?>
<script type="text/javascript" src="js/validators.js"></script>
<form name="frmABMRol" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; ?>">
<input name="id_rol" type="hidden" value="<?php echo $edicion['id_rol']; ?>">
<table width="200" border="0">
  <tr>
    <td align="right"><?php echo Translator::getTrans("descripcion"); ?></td>
    <td><input name="descripcion" type="text" id="txt_descripcion" value="<?php echo $edicion['descripcion']; ?>" maxlength="50"></td>
    <td><div class="div_error_req" id="div_error_req_descripcion"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
  </tr>
  
  <tr>
    <td align="right"><?php echo Translator::getTrans("funciones"); ?></td>
    <td style="border:1px solid black">
    	<?php PantallaSingleton::agregaChecks($lista_funciones, true); ?>
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
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