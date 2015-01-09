var _ventana;

function verFichaAFIP(id) {
	if (_ventana) _ventana.close();
	
	_ventana = window.open('about:blank','ficha'+id,'width=600,height=600,scrollbars=yes');
	
	var contenido = "<div style='margin-top:10px;margin-bottom:10px;font-family:Arial'><a href='javascript:window.close();'>Cerrar</a></div>";
	var wait = "<div id='texto' style='font-family:Arial'><b>Consultando a AFIP. Por Favor espere...</b>&nbsp;&nbsp;&nbsp;<img src='images/ajax-loader-small.gif' />";
	
	_ventana.document.write(contenido+wait);
	
	var params = "?action=ficha";
	params += "&id="+id;
	
	new Ajax.Request('ajaxAfip.php', {
		method:'get',
		parameters: params,
		 
		onComplete: function (response) {
			var div = _ventana.document.getElementById('texto');
			div.innerHTML = "<pre>" + response.responseText + "</pre>";
			div.style.backgroundColor = "#FFFFDD";
			_ventana.document.write(contenido);
		}
	});
}