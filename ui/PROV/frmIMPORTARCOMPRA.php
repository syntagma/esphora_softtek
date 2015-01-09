<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/ajaxupload.js"></script>
<script type="text/javascript">
var _processtime;

document.observe("dom:loaded", function() {
	new AjaxUpload ('#btnEjecutar', {
		action: 'ajaxImpoCompras.php',
		name: 'f',
		autoSubmit: true,
		responseType: false,

		onChange: function (file, extension) {
			if (extension != "txt") {
				alert ("El archivo a importar debe ser un archivo de texto (.txt)");
				return false;
			}
			if (!confirm("Se procesara el archivo " + file)) return false;
			return true;
		},

		onSubmit: function (file, extension) {
			$('nombre_archivo').innerHTML = file;
			muestraWait($('div_wait'));
			_processtime = new Date();
		},

		onComplete: function (file, response) {
			$('div_wait').style.display="none";
			var milisegundos = new Date();
			milisegundos = milisegundos - _processtime;
			var segundos = milisegundos / 1000;
			var minutos = Math.floor(segundos / 60);
			segundos = segundos - minutos * 60;
			var horas = Math.floor(minutos / 60);
			minutos = minutos - horas * 60;

			milisegundos = " <br><pre style='text-align:left'>Tiempo transcurrido = " + horas.toString() + ":" + minutos.toString() + ":" + segundos.toString() + "</pre>";
			$('resultadoImpo').innerHTML = response;
		}
	});
});
</script>
<div id="resultadoImpo"></div>

<button id="btnEjecutar" type="submit" name="ejecutar">
	<?php
		echo Translator::getTrans ( "EJECUTAR" );
	?> 
</button>

<div class="wait-pantalla-completa" id="div_wait">
	<table width=100% height=100%>
		<tr>
			<td valign="middle" align="center">
				<div class="cuadro-wait-pantalla-completa">
					<b>
						<i>Procesando el archivo</i>
						<div style='display: inline; color: blue' id='nombre_archivo'></div>
						<br><br>
						Esta operacion puede tardar varios minutos.
						<div style='color:red'>Por favor no salga de esta pagina ni cierre el navegador.</div>
						<br><br>
						<img src='css/orange/images/ajax-loader.gif' border=0 />
						<br><br>
						Por favor espere...
					</b>
				</div>
			</td>
		</tr>
	</table>
</div>