function buscaFacturas(id, pagina) {
	
	var value = document.forms["frm_"+id].busqueda.value;
	var a = document.forms["frm_"+id].tipoBusqueda;
	var tipoBusqueda;
	
	for (var i=0; i < a.length; i++) {
		if (a[i].checked) {
			tipoBusqueda = a[i].value;
			break;
		}
	}
	
	if (validador_requerido(value)) {
		if (tipoBusqueda == "fecha") {
			if (validador_date(value)) {
				value = formatea_date(value);
			}
			else {
				alert ("Fecha no valida");
				return;
			}
		}
		else if (tipoBusqueda == "nro_factura") {
			if (!validador_numerico(value)) {
				alert ("Numero de factura invalido");
				return;
			}
		}
	}
	else {
		value = "all";
	}
	
	var param = 
		"?tipoBusqueda="+tipoBusqueda+
		"&value="+value+
		"&pagina="+pagina+
		"&destino="+id;
	
	new Ajax.Updater(
		'resultado_'+id, 
		'lista_facturas.php', 
		{
			method: 'get',
			parameters: param
		}
	);
}

