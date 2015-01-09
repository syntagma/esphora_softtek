function CreaFooter(idFooter) {
	var dtYear = new Date();
    
	var sFooter = "&copy;" + dtYear.getFullYear() + 
    " <a href='http://www.syntagma.com.ar' target='_blank'>Syntagma S.A.</a>";
	
	$(idFooter).innerHTML = sFooter + $(idFooter).innerHTML;
}

function muestraErrorCabecera(mensaje) {
	var divClose = "<div onclick='$(\"mensaje-header\").style.display=\"none\";' style='font-size:7pt; border:1px solid white; color:white; background-color:blue; cursor:pointer; display:inline; padding-left:2px; padding-right:2px; margin:2px'>X</div>";
	$("mensaje-header").innerHTML = "<table><tr><td valign=top align=left>" + divClose + "</td><td align=left>" + mensaje + "</td></tr></table>";
	$("mensaje-header").style.display = "block";
}
