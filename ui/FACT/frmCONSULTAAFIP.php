<script type="text/javascript">
function onClickSubmit() {
	if ($('id').value == "") {
		alert('Debe seleccionar un id'); 
		return false;
	}
	else {
		muestraWait($('div_wait'));
		return true;
	}
}
</script>
<form name="frmConsultaAfip" method="post"
	enctype="multipart/form-data"
	action="<?php
	echo $_SERVER ['SCRIPT_NAME'] . "?" . $_SERVER ['QUERY_STRING'];
	?>">
<table width="200" border="0">
	<tr>
		<td nowrap>ID de Lote&nbsp;<input type="text" id="id" name="id" /></td>
	</tr>
	<tr>
		<td>
			<button type="submit" name="ejecutar" onclick="return onClickSubmit();">
				<?php
					echo Translator::getTrans ( "EJECUTAR" );
				?> 
			</button>
		</td>
	</tr>
</table>

</form>
<div class="wait-pantalla-completa" id="div_wait">
	<table width=100% height=100%>
		<tr>
			<td valign="middle" align="center">
				<div class="cuadro-wait-pantalla-completa">
					<b><i>Procesando archivo de Facturas de Proveedores...</i><br><br>
					Esta operacion puede tardar varios segundos.<br><br>
					<img src='css/orange/images/ajax-loader.gif' border=0 />
					<br><br>Por favor espere...</b>
				</div>
			</td>
		</tr>
	</table>
</div>