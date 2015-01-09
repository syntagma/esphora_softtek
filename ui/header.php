<div id="mensaje-header"></div>
<?php 
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");
$image = 'css/' . GLOBAL_THEME . '/images/logo.png';
?>

	<div id="div_header">
		<table width=100% height=100%>
			<tr>
				<td align=left style='padding-left:20px;'>
						<?php
							echo "<img src='$image' height='70px'' />";
						?>
				</td>
				<td align=right valign=top>
					<div id='logoutpanel'></div>
				</td>
			</tr>
		</table>
	</div>