function PadDigits(n, totalDigits) 
{ 
    n = n.toString(); 
    var pd = ''; 
    if (totalDigits > n.length) 
    { 
        for (i=0; i < (totalDigits-n.length); i++) 
        { 
            pd += '0'; 
        } 
    } 
    return pd + n.toString(); 
}

function close(div_id) {
	$(div_id).style.display="none";
}

function show(div_id) {
	$(div_id).style.display="block";
}

var _swap=1;
function swap(div_id, id) {
	if (id != _swap) {
		close(div_id + _swap);
		show(div_id + id);
		$("a_"+_swap).style.fontWeight = "normal";
		_swap = id;
		$("a_"+_swap).style.fontWeight = "bold";
	}
}

function swap_prev(div_id) {
	if (_swap != 1) 
		swap(div_id, _swap - 1);
}

function swap_next(div_id, last) {
	if (_swap != last) 
		swap(div_id, _swap + 1);
}

function selectValue(id, descri, value, idValue, div_id) {
	$('txt_'+descri).value = value;
	$('txt_'+id).value = idValue;
	close(div_id);
	
}


function formatea_date(txt) {
	var dia = txt.substring(0,2);
	var mes = txt.substring(3,5);
	var anio = txt.substring(6,10);
	
	return anio.toString()+mes.toString()+dia.toString();
}

function muestraMensajeDiv(divID) {
	var txt = $(divID).textContent;
	if (txt == undefined) txt = $(divID).innerText;
	alert (txt);
}

function getViewport() {
	var e = window, a = 'inner';
	
	if(!('innerWidth' in e)) {
		var t = document.documentElement
		e = t && t.clientWidth ? t : document.body; 
		a = 'client';
	}

	return {
		width: e[a+'Width'], 
		height: e[a+'Height']
	};
}


function getDocumentport() {
	return {
		width: document.width, 
		height: document.height
	};
}

function muestraWait(objWait) {
	if (objWait == null) return;
	
	objWait.style.width = getViewport().width + "px";
	objWait.style.height = getDocumentport().height + "px";
	objWait.style.display = "block";
}