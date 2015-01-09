<form name="frmImportarFactura" method="post" enctype="multipart/form-data"
   action="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; ?>">
<table width="200" border="0">
  <tr>
	<td colspan="2" nowrap>
   <input type="file" name="f" />   </td>
  </tr>
  <tr>
    <td align="left" valign="middle" nowrap style="padding-top:5px">Importar Lote      </td>
    <td align="left" valign="middle" nowrap style="padding-top:5px"><input name="importaLote" type="checkbox" value="S" checked  
      		onclick="$('chkCAE').disabled = !this.checked;"
      /></td>
  </tr>
  <tr>
   <td valign="bottom" nowrap>
   	Obtener CAE     </td>
   <td valign="bottom" nowrap><input type="checkbox" name="chkCAE" id="chkCAE" value="S" checked /></td>
  </tr>
  <tr>
  <td colspan="2">
   <input type="submit" name="ejecutar" value=<?php echo Translator::getTrans("EJECUTAR"); ?> />   </td>
  </tr>
</table>

</form>