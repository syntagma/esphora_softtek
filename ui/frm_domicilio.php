

<table border="0">
        <tr>
          <td style='padding: 5px;'><?php echo Translator::getTrans("calle"); ?></td>
          <td style='padding: 5px;'><input name="calle" type="text" id="txt_calle" value="<?php echo $edicion['calle']; ?>" maxlength="50" /></td>
          <td style='padding: 5px;'><div class="div_error_req" id="div_error_req_calle"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
          
          <td style='padding: 5px;'><?php echo Translator::getTrans("numero"); ?></td>
          <td style='padding: 5px;'><input name="numero" type="text" id="txt_numero" value="<?php echo $edicion['numero']; ?>" maxlength="5" /></td>
          <td style='padding: 5px;'>
          	<div class="div_error_req" id="div_error_req_numero"><?php echo Translator::getTrans("REQUIRED"); ?></div>
            <div class="div_error_num" id="div_error_num_numero"><?php echo Translator::getTrans("NUMERIC"); ?></div>          </td>
        </tr>
        
        <tr>
          <td style='padding: 5px;'><?php echo Translator::getTrans("piso"); ?></td>
          <td style='padding: 5px;'><input name="piso" type="text" id="txt_piso" value="<?php echo $edicion['piso']; ?>" maxlength="2" /></td>
          <td style='padding: 5px;'>
          	<div class="div_error_req" id="div_error_req_piso"><?php echo Translator::getTrans("REQUIRED"); ?></div>
            <div class="div_error_num" id="div_error_num_piso"><?php echo Translator::getTrans("NUMERIC"); ?></div>          </td>
          
          <td style='padding: 5px;'><?php echo Translator::getTrans("departamento"); ?></td>
          <td style='padding: 5px;'><input name="departamento" type="text" id="txt_departamento" value="<?php echo $edicion['departamento']; ?>" maxlength="2" /></td>
          <td style='padding: 5px;'><div class="div_error_req" id="div_error_req_departamento"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
        </tr>
        
        <tr>
          <td style='padding: 5px;'><?php echo Translator::getTrans("codigo_postal"); ?></td>
          <td style='padding: 5px;'><input name="codigo_postal" type="text" id="txt_codigo_postal" value="<?php echo $edicion['codigo_postal']; ?>" maxlength="7" /></td>
          <td style='padding: 5px;'>
          	<div class="div_error_req" id="div_error_req_codigo_postal"><?php echo Translator::getTrans("REQUIRED"); ?></div>
            <div class="div_error_num" id="div_error_num_codigo_postal"><?php echo Translator::getTrans("NUMERIC"); ?></div>          </td>
          
          <td style='padding: 5px;'><?php echo Translator::getTrans("telefono"); ?></td>
          <td style='padding: 5px;'><input name="telefono" type="text" id="txt_telefono" value="<?php echo $edicion['telefono']; ?>" maxlength="50" /></td>
          <td style='padding: 5px;'><div class="div_error_req" id="div_error_req_telefono"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
        </tr>
        <tr>
          <td style='padding: 5px;'><?php echo Translator::getTrans("ciudad"); ?></td>
          <td style='padding: 5px;'><input name="ciudad" type="text" id="txt_ciudad" value="<?php echo $edicion['ciudad']; ?>" maxlength="50" /></td>
          <td style='padding: 5px;'><div class="div_error_req" id="div_error_req_ciudad"><?php echo Translator::getTrans("REQUIRED"); ?></div></td>
          <td style='padding: 5px;'>&nbsp;</td>
          <td style='padding: 5px;'>&nbsp;</td>
          <td style='padding: 5px;'>&nbsp;</td>
        </tr>
        <tr>
          <td style='padding: 5px;'><?php echo Translator::getTrans("pais"); ?></td>
          <td style='padding: 5px;'><select name="id_pais" id="cbo_pais">
          		<?php PantallaSingleton::agregaCombo($paises); ?>
          </select>          </td>
          <td>&nbsp;</td>
          
          <td style='padding: 5px;'><?php echo Translator::getTrans("provincia"); ?></td>
          <td style='padding: 5px;'><select name="id_provincia" id="cbo_provincia">
          		<?php PantallaSingleton::agregaCombo($provincias); ?>
          </select>          </td>
          <td style='padding: 5px;'>&nbsp;</td>
        </tr>
      </table>
      
      <script type="text/javascript" src="js/domicilio.js"></script>