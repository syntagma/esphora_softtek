
//validadores de requeridos
function required () {
	var a = required.arguments;
	var ret = true;
	for (var i=0; i < a.length; i++) {
		if (! valida_req(a[i])) {
			ret = false;
		}
	}
	
	return ret;
}

function validador_requerido(value) {
	var ret = true;
	
	if (value == "") {
		ret = false;
	}
	
	return ret;
}

function valida_req(id) {
	var ret = validador_requerido($("txt_"+id).value);
	$("div_error_req_"+id).style.display = ret ? "none" : "block";
	return ret;
}


//validadores de numericos
function numeric () {
	var a = numeric.arguments;
	var ret = true;
	for (var i=0; i < a.length; i++) {
		if (! valida_num(a[i])) {
			ret = false;
		}
	}
	
	return ret;
}

function validador_numerico(num) {
	var ret = true;
	
	if (isNaN(num)) {
		ret = false;
	}
	
	return ret;
}

function valida_num(id) {
	var num = parseInt($("txt_"+id).value);
	
	var ret = validador_numerico(num);
	
	$("div_error_num_"+id).style.display = ret ? "none" : "block";
	
	return ret;
}

function emailvalid() {
	var a=emailvalid.arguments;
	var ret=true;
	for (var i=0; i<a.length; i++) {
		if (!valida_email(a[i])) {
			ret = false;
		}
	}
	return ret;
}

function validador_email(address) {
	var ret = true;
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	
	if (address != "") {
		if(reg.test(address) == false) {
			ret = false;
		}
	}
	
	return ret;
}

function valida_email(id) {
	
	var address = $('txt_'+id).value;
	
	var ret = validador_email(address);
	
	$("div_error_email_"+id).style.display = ret ? "none" : "block";
	return ret;
}

//validadres de fecha
function datevalid() {
	var a=datevalid.arguments;
	var ret=true;
	for (var i=0; i<a.length; i++) {
		if (!valida_date(a[i])) {
			ret = false;
		}
	}
	return ret;
}

function validador_date(txt) {
	var ret = true;
	
	var regex = /^[\d]{2}[\-|\/\.][\d]{2}[\-|\/\.][\d]{4}$/;
	
	if (!regex.test(txt)) {
		ret = false;
	}
	else {
		var dia = txt.substring(0,2);
		var mes = txt.substring(3,5);
		var anio = txt.substring(6,10);

		//ver si el anio es valido
		if (anio < 1900 || anio > 2100) {
			ret = false;
		}
		else if(mes < 1 || mes > 12) {
			ret = false;
		}
		else {
			if (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 8 || mes == 10 || mes == 12) {
				if (dia > 31) {
					ret = false;
				}
			}
			else if (mes == 4 || mes == 6 || mes == 9 || mes ==11) {
				if (dia > 30) {
					ret = false;
				}
			}
			else {
				if (dia > 28) {
					if (dia == 29) {
						//si el año es bisiesto esta todo ok 
						//si es divisible por 4
						if (anio % 4 == 0) {
							if (anio % 100 == 0 && anio % 400 != 0) {
								ret = false;
							}
						}
						else {
							ret = false;
						}
					}
					else {
						ret = false;
					}
				}	
			}
		}
	}
	
	return ret;
}

function valida_date(id) {
	var txt = $('txt_'+id).value;
	
	var ret = validador_date(txt); 
	
	$('div_error_fecha_'+id).style.display = (ret ? "none" : "block");
	return ret;	
}

var _ajaxResponse;
var _loop
function validaAjax(params, divError) {
	_ajaxResponse = "";
	_loop = true;
	
	new Ajax.Request('ajaxValidation.php', {
		 method:'get',
		 parameters: params,
		 
		 onComplete: function (response) {
			 //alert("success " + response.responseText);
			var nro = parseInt(response.responseText);
			
			if (isNaN(nro)) {
				_ajaxResponse = response.responseText;
			}
			_loop = false;
		}
	});
	
	while(_loop);
	
	if (_ajaxResponse == "") {
		return true;
		if (divError != undefined) divError.style.display = "none";
	}
	else {
		if (divError == undefined) {
			alert (_ajaxResponse);
		}
		else {
			divError.innerHTML = _ajaxResponse;
			divError.style.display = "block";
		}
		return false;
	}
}