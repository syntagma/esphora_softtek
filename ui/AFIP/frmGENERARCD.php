<form name="frmGenerarCD" method="post" enctype="multipart/form-data"
   action="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; ?>">
<table width="647" border="0" align="center">
  <tr>
    <td height="89" colspan="3" align="left" valign="middle" nowrap style="padding-top:5px"><p>Por favor, coloque el a&ntilde;o y el mes del per&iacute;odo a generar en los siguientes campos.</p>
      <p>Luego al presionar el boton, se generar&aacute; el Medio Mangetico con la informaci&oacute;n del per&iacute;odo seleccionado.</p></td>
    </tr>
  <tr>
    <td height="89" align="left" valign="middle" nowrap style="padding-top:5px"><p>A&ntilde;o (ej: 2008)</p>
      <p>
        <input name="ano" type="text" id="txt_ano" value="<?php echo $edicion['ano']; ?>" size="10" maxlength="4">
      </p></td>
    <td width="101" height="89" align="left" valign="middle" nowrap style="padding-top:5px"><p>Mes (ej: 01)</p>
      <p>
        <input name="mes" type="text" id="txt_ano2" value="<?php echo $edicion['mes']; ?>" size="5" maxlength="2" />
      </p></td>
     <td width="101" height="89" align="left" valign="middle" nowrap style="padding-top:5px"><p>Mes (ej: 01)</p>
      <a href= "http://www.syntagma.com.ar/Esphora/index.php?modulo=AFIP&funcion=GENERARCD&action=generarCD" >
         Generar ZIP
      </a></td>     
	-
	<td width="436"><p>&nbsp;</p></td> 
  </tr>
  <tr>
  <td width="96" align="center">
   <button type="button" name="ejecutar" onClick= "http://www.syntagma.com.ar/Esphora/index.php?modulo=AFIP&funcion=GENERARCD&action=generarCD"> <?php echo Translator::getTrans("EJECUTAR"); ?> </button>   </td>
  </tr>
</table>
</form>