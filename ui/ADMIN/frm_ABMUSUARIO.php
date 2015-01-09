<?php 
	$edicion = $_SESSION['edicion']; 
	$roles = $_SESSION['roles'];
	$empresas = $_SESSION['empresas'];
?>
<script type="text/javascript" src="js/validators.js"></script>

<form name="frmABMUsuario" method="post" action="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; ?>">
<input name="id_usuario" type="hidden" value="<?php echo $edicion['id_usuario']; ?>">
<table width="200" border="0">
  <tr>
    <td align="right"><?php echo Translator::getTrans("nombre"); ?></td>
    <td><input name="nombre" type="text" id="txt_nombre" value="<?php echo $edicion['nombre']; ?>" maxlength="50"></td>
    <td><div class="div_error_req" id="div_error_req_nombre"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
    
    <td><?php echo Translator::getTrans("apellido"); ?></td>
    <td><input name="apellido" type="text" id="txt_apellido" value="<?php echo $edicion['apellido']; ?>" maxlength="50"></td>
    <td><div class="div_error_req" id="div_error_req_apellido"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
  </tr>
  
  <tr>
    <td align="right"><?php echo Translator::getTrans("login"); ?></td>
    <td><input name="login" type="text" id="txt_login" value="<?php echo $edicion['login']; ?>" maxlength="50"></td>
    <td><div class="div_error_req" id="div_error_req_login"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
    
    <td><?php echo Translator::getTrans("password"); ?></td>
    <td><input name="password" type="password" id="txt_password" value="" maxlength="50"></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="6" align="left">
    	<?php echo Translator::getTrans("rol_empresa"); ?>     </td>
  </tr>
  <tr>
    <td align="right"><?php echo Translator::getTrans("empresas"); ?></td>
    <td><select name="cboEmpresa" id="cboEmpresa">
    	<?php PantallaSingleton::agregaCombo($empresas); ?> 
    </select>
    </td>
    <td style="border:1px solid black" colspan="4">
    	Roles
      	<?php
			$display="block";
			foreach($roles as $idEmpresa => $lista_roles) {
				echo "<div id='empresa_$idEmpresa' style='display:$display'>";
		  		PantallaSingleton::agregaChecks($lista_roles);
				echo "</div>";
				$display="none";
			} 
		?>
    </td>
    </tr>
  <tr>
    <td colspan="6">
   	  <button type="submit"   
    	onClick="return required('nombre', 'apellido', 'login');"
      >
      	<?php echo Translator::getTrans("GRABAR"); ?>
      </button>
     </td>
    </tr>
</table>

</form>

<script type="text/javascript">
	var empresaActual = $('cboEmpresa').value;
	
	$('cboEmpresa').onchange = function() {
		var id = this.value;
		$('empresa_'+empresaActual).style.display="none";
		$('empresa_'+id).style.display="block";
		empresaActual=id;
	}
</script>
