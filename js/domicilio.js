$('cbo_pais').onchange = function() {
	var param = "?pais="+this.value;
	
	new Ajax.Updater ('cbo_provincia', 'lista_provincias.php', {
		method: 'get',
		parameters: param,
		onLoading: function() {
			$('cbo_pais').disabled = true;
		},
		onLoaded: function() {
			$('cbo_pais').disabled = false;
		}
	});
}
