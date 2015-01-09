    <form <?php echo "id='frm_$idResultado'"; ?>>
    	<table>
        	<tr>
            	<td><?php echo Translator::getTrans("fecha"); ?></td>
                <td><input name="tipoBusqueda" type="radio" value="fecha" checked style="width:15px" /></td>
                
                <td rowspan="2" valign="middle" style="vertical-align:middle"><input name="busqueda" type="text" id="txt_busqueda" /></td>
              <td rowspan="2" valign="middle" style="vertical-align:middle">
              	<button type="button" name="btnBuscar" id="btnBuscar" style="width:50px"
                		onclick='buscaFacturas(<?php echo "\"$idResultado\""; ?>, 1);return false;'
                >Search</button>
              </td>
            </tr>
            <tr>
            	<td><?php echo Translator::getTrans("nro_factura"); ?></td>
                <td><input name="tipoBusqueda" type="radio" value="nro_factura" style="width:15px" /></td>
            </tr>
        </table>
    	<div <?php echo "id='resultado_$idResultado'"; ?>>
        </div>
  </form>
