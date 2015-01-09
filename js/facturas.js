habilitarFechaServ($("chk_presta_serv").checked);

function valida_factura() {
	var res = true;

	res = required('descripcion_cliente', 'pto_vta', 'nro_factura', 'total', 'importe_neto_gravado', 'impuesto_liquidado', 'impuesto_liquidado_rni', 'importe_ope_exentas', 'fec_cbte', 'fecha_venc_pago', 'otros_conceptos') && res;
	res = numeric('pto_vta', 'nro_factura', 'total', 'importe_neto_gravado', 'impuesto_liquidado', 'impuesto_liquidado_rni', 'importe_ope_exentas', 'otros_conceptos') && res;
	
	if ($('chk_presta_serv').checked) {
		res = required('fec_serv_desde', 'fec_serv_hasta') && res;
		res = datevalid('fec_serv_desde', 'fec_serv_hasta') && res;
	}
	
	res = validaDetalles() && res;
	
	var num = parseFloat($("txt_total").value);
	var msg = "";
	
	if (!isNaN(num) && num == 0) {
		msg += "El total no puede ser 0\n";
		res = false;
	}

	if (datevalid('fec_cbte', 'fecha_venc_pago', 'fec_registro_contable')) {
		if (fechaMayor($("txt_fecha_venc_pago").value, $("txt_fec_cbte").value)) {
			msg += "La fecha de vencimiento debe ser mayor a la fecha de comprobante\n";
			res = false;
		}
		if (fechaMayor($("txt_fec_cbte").value, $("txt_fec_registro_contable").value)) {
			msg += "La fecha de registro contable debe ser mayor a la fecha de comprobante\n";
			res = false;
		}
		else {
			//ver que la fecha de periodo contable pertenezca a un periodo abierto
			if (!validaFechaRegistroContable(formatea_date($("txt_fec_registro_contable").value))) {
				msg += "La fecha de registro contable no corresponde a un periodo abierto\n";
				res = false;
			}
		}
	}
	else {
		res = false;
	}
	
	if (msg != "") alert (msg);

	if (_modo == 'E') {
		if (res) res = obtieneCAE();
	}
	else {
		if (_modo == 'M') {
			res = required('cotizacion', 'cae') && numeric('cotizacion') && res;
			
			if (res) graba_factura();
		}
		
		else {
			
			if (_modo == 'A') {
				if (required('cae')) {
					//validar cae con afip
					if (res) validaCAE();
				}
				else {
					res = false;
				}
			}
		}
	}
		
	return res;
}

function validaFechaRegistroContable(fecha) {
	/*
	var params = "";
	params += "?action=validaFechaRegistroContable";
	params += "&fechaRegistroContable=" + fecha;
	
	return validaAjax(params, $('error_afip'));
	*/
	for (var i = 0; i < _periodos.length; i++) {
		if (fecha >= _periodos[i][0] && fecha <= _periodos[i][1]) {
			return true;
		}
	}
	return false;
}

function fechaMayor(txtFecVenc, txtFecCbte) {
	var diaFecVenc = txtFecVenc.substring(0,2);
	var mesFecVenc = txtFecVenc.substring(3,5);
	var anioFecVenc = txtFecVenc.substring(6,10);
	
	var diaFecCbte = txtFecCbte.substring(0,2);
	var mesFecCbte = txtFecCbte.substring(3,5);
	var anioFecCbte = txtFecCbte.substring(6,10);
	
	var dateFecVenc = new Date(anioFecVenc, mesFecVenc, diaFecVenc);
	var dateFecCbte = new Date(anioFecCbte, mesFecCbte, diaFecCbte);
	
	//alert(dateFecVenc.toDateString() + "\n" + dateFecCbte.toDateString);
	
	if (dateFecVenc < dateFecCbte) return true;
	return false;
}

function validaDetalles() {
	var lineaActual;
	var ret = true;
	var mensaje = "";
	var i;
	
	if ($("chkDetallada").checked) {
		lineaActual = $("cantLineas").value;
		
		for (i = 1; i < lineaActual; i++) {
			if (parseFloat($("txtCantidad"+i).value) != 0) {
				if ($("txtConcepto"+i).value == "" || $("txtCantidad"+i).value == "" || $("txtPrecioUnitario"+i).value == "") {
					mensaje += "Existen Lineas de <b>Detalle de Factura</b> vacias... Por favor, ingrese los valores correspondientes o desactive la opcion de <b>detalles de factura</b><br>";
					
					ret = false;
					break;
				}
			}
		}
	}
	
	if ($("chkRetenciones").checked) {
		lineaActual = $("cantLineasRet").value;
		
		for (var i = 1; i < lineaActual; i++) {
			if (parseFloat($("txtAlicuota"+i).value) != 0) {
				if ($("txtBaseImponible"+i).value == "" || $("txtAlicuota"+i).value == "") {
					mensaje += "Existen Lineas de <b>Retenciones</b> vacias... Por favor, ingrese los valores correspondienteso desactive la opcion de <b>retenciones</b><br>";
					
					ret = false;
					break;
				}
			}
		}
	}
		
	if (!ret) {
		$('error_afip').innerHTML = mensaje;
		$('error_afip').style.display = 'block';
	}
	else {
		$('error_afip').style.display = 'none';
	}
	return ret;
}

function habilitarFechaServ(habilita) {
	$("div_fecha_serv").style.display=(habilita?"block":"none");
}

function calculaValores(tot) {
	var t=parseFloat(tot);
	if (!isNaN(t)) {
		var s = t/(1+iva);
		var i = t - s;

		$("txt_total").value = t.toFixed(2);
		$("txt_importe_neto_gravado").value = s.toFixed(2);
		$("txt_impuesto_liquidado").value = i.toFixed(2);
		$("txt_importe_ope_exentas").value = "0.00";
		$("txt_impuesto_liquidado_rni").value = "0.00";
	}
	else {
		$("txt_total").value = "";
		$("txt_importe_neto_gravado").value = "";
		$("txt_impuesto_liquidado").value = "";
		$("txt_importe_ope_exentas").value = "";
		$("txt_impuesto_liquidado_rni").value = "";
	}
}

function sumaTotal(txt) {		
	var ing, ilq, ioe, rni, oco;
	var total = 0;
	
	ing = parseFloat($("txt_importe_neto_gravado").value);
	ilq = parseFloat($("txt_impuesto_liquidado").value);
	ioe = parseFloat($("txt_importe_ope_exentas").value);
	rni = parseFloat($("txt_impuesto_liquidado_rni").value);
	oco = parseFloat($("txt_otros_conceptos").value);

	total += isNaN(ing) ? 0 : ing;
	total += isNaN(ilq) ? 0 : ilq;
	total += isNaN(ioe) ? 0 : ioe;
	total += isNaN(rni) ? 0 : rni;
	total += isNaN(oco) ? 0 : oco;

	$("txt_total").value = total.toFixed(2);

	var num = parseFloat(txt.value);
	
	txt.value = isNaN(num) ? "": num.toFixed(2);
}

function agregaLinea() {
	var txt="";
	var lineaActual = $("cantLineas").value;
	var tagDiv = document.createElement("div");
	
	tagDiv.id = "linea"+lineaActual;
	
		txt += '<table>';
			txt += '<tr>';
				txt += '<td valign=top><textarea maxlength="250" name="txtConcepto'+lineaActual+'" id="txtConcepto'+lineaActual+'" cols=23 rows=3></textarea></td>';
				txt += '<td valign=top><input type="text" name="txtCantidad'+lineaActual+'" id="txtCantidad'+lineaActual+'" style="width:100px" onblur="calculaLinea('+lineaActual+');"/></td>';
				txt += '<td valign=top><select id="cboUM'+lineaActual+'" name="cboUM'+lineaActual+'"></select></td>';
				txt += '<td valign=top><input type="text" name="txtPrecioUnitario'+lineaActual+'" id="txtPrecioUnitario'+lineaActual+'" style="width:100px" onblur="calculaLinea('+lineaActual+');" /></td>';
				txt += '<td valign=top><select onchange="calculaLinea('+lineaActual+');" id="cboIVA'+lineaActual+'" name="cboIVA'+lineaActual+'"></select></td>';
				txt += '<td valign=top><input name="txtSubtotal'+lineaActual+'" type="text" id="txtSubtotal'+lineaActual+'" style="width:100px" readonly="true" /></td>';
				txt += '<td valign=top><input name="txtTotalIVA'+lineaActual+'" type="text" id="txtTotalIVA'+lineaActual+'" style="width:100px" readonly="true" /></td>';
				txt += '<td valign=top><input name="txtTotal'+lineaActual+'" type="text" id="txtTotal'+lineaActual+'" style="width:100px" readonly="true" /></td>';
				txt += '<td valign=top><button type="button" onclick="eliminaLinea('+lineaActual+');"> Eliminar </button> </td>';
			txt += '</tr>';
		txt += '</table>';
	
	tagDiv.innerHTML = txt;
	
	$('detalle_factura').appendChild(tagDiv);
	
	$('cboUM'+lineaActual).innerHTML = $('valores_unidad_medida').innerHTML;
	
	agregaValoresIVA(lineaActual);
	
	++lineaActual;
	
	$("cantLineas").value = lineaActual;
	
}

function agregaLineaRetencion() {
	var txt="";
	var lineaActual = $("cantLineasRet").value;
	var tagDiv = document.createElement("div");
	
	tagDiv.id = "lineaRet"+lineaActual;
	
		txt += '<table>';
			txt += '<tr>';
				txt += '<td valign=top><select onchange="calculaLineaRet('+lineaActual+', this);" id="cboRET'+lineaActual+'" name="cboRET'+lineaActual+'"></select></td>';
				txt += '<td valign=top><input type="text" name="txtDetalleRet'+lineaActual+'" id="txtDetalleRet'+lineaActual+'" style="width:200px" /><select style="display:none;width:202px" id="cboProvinciaRET'+lineaActual+'" name="cboProvinciaRET'+lineaActual+'"></select></td>';
				txt += '<td valign=top><input type="text" name="txtBaseImponible'+lineaActual+'" id="txtBaseImponible'+lineaActual+'" style="width:100px" '+
					   'onblur="calculaLineaRet('+lineaActual+');" '+
					   'onFocus="this.value = $(\'txt_importe_neto_gravado\').value;" /></td>';
				txt += '<td valign=top><input name="txtAlicuota'+lineaActual+'" type="text" id="txtAlicuota'+lineaActual+'" style="width:100px" onblur="calculaLineaRet('+lineaActual+');" /></td>';
				txt += '<td valign=top><input name="txtImporteRet'+lineaActual+'" type="text" id="txtImporteRet'+lineaActual+'" style="width:100px" readonly="true" /></td>';
				txt += '<td valign=top><button type="button" onclick="eliminaLineaRet('+lineaActual+');">Eliminar</button></td>';
			txt += '</tr>';
		txt += '</table>';
	
	tagDiv.innerHTML = txt;
	
	$('retenciones_factura').appendChild(tagDiv);
	
	agregaValoresRET(lineaActual);
	
	$("txtBaseImponible"+lineaActual).value = $("txt_importe_neto_gravado").value;
	
	llenaProvincias(lineaActual);
	
	++lineaActual;
	
	$("cantLineasRet").value = lineaActual;
}

function llenaProvincias(linea, provincia) {
	var cbo = $("cboProvinciaRET"+linea);
	var cboRet = $("cboRET"+linea);
	
	cbo.innerHTML = $("valores_provincia").innerHTML;
	
	if (provincia != undefined) {
		muestraDetalleRet($("hidRET"+cboRet.value).value, linea);
		
		for (var i = 0; i < cbo.options.length; i++) {
			if (cbo.options[i].value == provincia) {
				cbo.options[i].selected = true;
				break;
			}
		}
	}
}

function buscaCliente(cliente, divId, btnObj) {
	if (cliente == "") {
		alert ("Debe ingresar un criterio de busqueda");
	}
	else {
		$(divId).innerHTML = "<img src='images/ajax-loader-small.gif' />";
		btnObj.disabled = true;
		
		new Ajax.Updater (
			divId,
			'busquedaClientes.php',
			{
				method: 'get',
				parameters: '?patron='+cliente,
				
				onComplete: function () {
					btnObj.disabled = false;
				}
			}
		);
	}
}

function agregaValoresIVA(linea, idIVA) 
{
	var cboIVA = $("valoresCBOIVA");
	var cboLinea = $('cboIVA'+linea);
	
	cboLinea.innerHTML = cboIVA.innerHTML;
	if (idIVA != undefined) 
	{
		for (var i = 0; i < cboLinea.options.length; i++) {
			if (cboLinea.options[i].value == idIVA) {
				cboLinea.options[i].selected = true;
				break;
			}
		}
	}
}

function agregaValoresRET(linea, idRET) 
{
	var cbo = $('cboRET'+linea);
	cbo.innerHTML = $('valores_retenciones').innerHTML;
	
	if (idRET != undefined) {
		for (var i = 0; i < cbo.options.length; i++) {
			if (cbo.options[i].value == idRET) {
				cbo.options[i].selected = true;
				break;
			}
		}
	}
}

function floatFixed(txt,n) {
	return parseFloat(parseFloat(txt).toFixed(n));
}

var _oco = 0;
var _ocoRet = 0;

function calculaLinea(linea) {
	var precioUnitario = floatFixed($("txtPrecioUnitario"+linea).value, 2);
	var cantidad = floatFixed($("txtCantidad"+linea).value, 2);
	
	if (isNaN(cantidad)) cantidad = 0;
	
	if(isNaN(precioUnitario)) precioUnitario = 0;
	
	var porcentajeIVA = floatFixed($('hidIVA'+$("cboIVA"+linea).value).value, 3);
	
	var subtotal = precioUnitario * cantidad;
	var totalIVA = subtotal * porcentajeIVA;
	var total = subtotal + totalIVA;
	
	$("txtPrecioUnitario"+linea).value = precioUnitario.toFixed(2);
	$("txtSubtotal"+linea).value = subtotal.toFixed(2);
	$("txtTotal"+linea).value = total.toFixed(2);
	$("txtTotalIVA"+linea).value = totalIVA.toFixed(2);
	
	$("txtCantidad"+linea).value = cantidad.toFixed(2);
	
	if (_calculaTextos) {
		var ing = 0, ilq = 0, ioe = 0, rni = 0, oco = 0;
		
		var lineaActual = $("cantLineas").value;
		
		for (var i=1; i< lineaActual; i++) {
			var tipoIVA = $('hidTipoIVA'+$("cboIVA"+i).value).value
			if (tipoIVA == 'G') {
				ing += parseFloat($("txtSubtotal"+i).value);
			}
			else {
				if (tipoIVA == 'E') {
					ioe += parseFloat($("txtSubtotal"+i).value);
				}
				else {
					oco += parseFloat($("txtSubtotal"+i).value);
				}
			}
			ilq += parseFloat($("txtTotalIVA"+i).value);
		}
		
		_oco = oco;
		oco += _ocoRet;
		
		$("txt_importe_neto_gravado").value = ing.toFixed(2);
		$("txt_impuesto_liquidado").value = ilq.toFixed(2);
		$("txt_importe_ope_exentas").value = ioe.toFixed(2);
		$("txt_impuesto_liquidado_rni").value = rni.toFixed(2);
		$("txt_otros_conceptos").value = oco.toFixed(2);
		
		sumaTotal($("txt_total"));
	}
}

function calculaLineaRet(linea, cbo) {
	var baseImponible = floatFixed($("txtBaseImponible"+linea).value, 2);
	var alicuota = floatFixed($("txtAlicuota"+linea).value, 2);
	
	if (isNaN(baseImponible)) baseImponible = 0;
	if (isNaN(alicuota)) alicuota = 0;
	
	var importe = baseImponible * (alicuota/100);
	
	$("txtImporteRet"+linea).value = importe.toFixed(2);
	$("txtBaseImponible"+linea).value = baseImponible.toFixed(2);
	$("txtAlicuota"+linea).value = alicuota.toFixed(2);
	
	if (_calculaTextos) {
		var oco = 0;
		var lineaActual = $("cantLineasRet").value;
		
		for (var i = 1; i < lineaActual; i++) {
			oco += parseFloat($("txtImporteRet"+i).value);
		}
		
		_ocoRet = oco;
		oco += _oco;
		
		$("txt_otros_conceptos").value = oco.toFixed(2);
		
		sumaTotal($("txt_total"));
	}
	
	if (cbo != undefined) {
		muestraDetalleRet($("hidRET"+cbo.value).value, linea);
	}	
}

function muestraDetalleRet(tipoRet, linea) {
	if (tipoRet == 'P') {
		$("txtDetalleRet"+linea).style.display = "none";
		$("cboProvinciaRET"+linea).style.display = "block";
	}
	else {
		$("txtDetalleRet"+linea).style.display = "block";
		$("cboProvinciaRET"+linea).style.display = "none";
	}
}

function eliminaLinea(linea) {
	$("linea"+linea).style.display="none";
	$("txtCantidad"+linea).value = 0;
	calculaLinea(linea);
}

function eliminaLineaRet(linea) {
	$("lineaRet"+linea).style.display="none";
	$("txtAlicuota"+linea).value = 0;
	calculaLineaRet(linea);
}

function muestraDetalles(muestra, calcula) {
	$("detalles").style.display = muestra ? "block" : "none";
	
	$("txt_importe_neto_gravado").readOnly = muestra;
	$("txt_impuesto_liquidado").readOnly = muestra;
	$("txt_importe_ope_exentas").readOnly = muestra;
	$("txt_impuesto_liquidado_rni").readOnly = muestra;
	
	if (calcula == undefined) calculaLinea(1);
}

function muestraRetenciones(muestra, calcula) {
	$("retenciones").style.display = muestra ? "block" : "none"; 
	
	if (!muestra) {
		$("txt_otros_conceptos").value = "0.00";
	}
	else {
		if (calcula == undefined) calculaLineaRet(1);
	}
	
}

function agregaLineaLlena(_concepto, _cantidad, _precioUnitario, _idIVA, _unidadMedida) {
	var txt="";
	var lineaActual = $("cantLineas").value;
	var tagDiv = document.createElement("div");
	
	tagDiv.id = "linea"+lineaActual;
	
		txt += '<table>';
			txt += '<tr>';
				txt += '<td valign=top><textarea name="txtConcepto'+lineaActual+'" id="txtConcepto'+lineaActual+'" cols=23 rows=3>'+_concepto+'</textarea></td>';
				txt += '<td valign=top><input type="text" value="'+_cantidad+'" name="txtCantidad'+lineaActual+'" id="txtCantidad'+lineaActual+'" style="width:100px" onblur="calculaLinea('+lineaActual+');"/></td>';
				txt += '<td valign=top><select id="cboUM'+lineaActual+'" name="cboUM'+lineaActual+'"></select></td>';
				txt += '<td valign=top><input type="text" value="'+_precioUnitario+'" name="txtPrecioUnitario'+lineaActual+'" id="txtPrecioUnitario'+lineaActual+'" style="width:100px" onblur="calculaLinea('+lineaActual+');" /></td>';
				txt += '<td valign=top><select onchange="calculaLinea('+lineaActual+');" id="cboIVA'+lineaActual+'" name="cboIVA'+lineaActual+'"></select></td>';
				txt += '<td valign=top><input name="txtSubtotal'+lineaActual+'" type="text" id="txtSubtotal'+lineaActual+'" style="width:100px" readonly="true" /></td>';
				txt += '<td valign=top><input name="txtTotalIVA'+lineaActual+'" type="text" id="txtTotalIVA'+lineaActual+'" style="width:100px" readonly="true" /></td>';
				txt += '<td valign=top><input name="txtTotal'+lineaActual+'" type="text" id="txtTotal'+lineaActual+'" style="width:100px" readonly="true" /></td>';
				txt += '<td valign=top><button type="button" onclick="eliminaLinea('+lineaActual+');" >Eliminar </button></td>';
			txt += '</tr>';
		txt += '</table>';
	
	tagDiv.innerHTML = txt;
	
	$('detalle_factura').appendChild(tagDiv);
	
	var cbo = $('cboUM'+lineaActual);
	cbo.innerHTML = $('valores_unidad_medida').innerHTML;

	for (var i = 0; i < cbo.options.length; i++) {
		if (cbo.options[i].value = _unidadMedida) {
			cbo.options[i].selected = true;
			break;
		}
	}
	
	agregaValoresIVA(lineaActual, _idIVA);
	
	calculaLinea(lineaActual);
	++lineaActual;
	
	$("cantLineas").value = lineaActual;
}

function agregaLineaLlenaRet(_idConcepto, _detalle, _baseImponible, _alicuota, _provincia) {
	var txt="";
	var lineaActual = $("cantLineasRet").value;
	var tagDiv = document.createElement("div");
	
	tagDiv.id = "lineaRet"+lineaActual;
	
		txt += '<table>';
			txt += '<tr>';
				txt += '<td valign=top><select onchange="calculaLineaRet('+lineaActual+', this);" id="cboRET'+lineaActual+'" name="cboRET'+lineaActual+'"></select></td>';
				txt += '<td valign=top><input type="text" name="txtDetalleRet'+lineaActual+'" id="txtDetalleRet'+lineaActual+'" style="width:200px" value="'+_detalle+'" /><select style="display:none;width:202px" id="cboProvinciaRET'+lineaActual+'" name="cboProvinciaRET'+lineaActual+'"></select></td>';
				txt += '<td valign=top><input type="text" name="txtBaseImponible'+lineaActual+'" id="txtBaseImponible'+lineaActual+'" style="width:100px" value="'+_baseImponible+'"'+
					   'onblur="calculaLineaRet('+lineaActual+');" '+
					   'onFocus="this.value = $(\'txt_importe_neto_gravado\').value;" /></td>';
				txt += '<td valign=top><input value="'+_alicuota+'" name="txtAlicuota'+lineaActual+'" type="text" id="txtAlicuota'+lineaActual+'" style="width:100px" onblur="calculaLineaRet('+lineaActual+');" /></td>';
				txt += '<td valign=top><input name="txtImporteRet'+lineaActual+'" type="text" id="txtImporteRet'+lineaActual+'" style="width:100px" readonly="true" /></td>';
				txt += '<td valign=top><button type="button" onclick="eliminaLineaRet('+lineaActual+');">Eliminar</button></td>';
			txt += '</tr>';
		txt += '</table>';
	
	tagDiv.innerHTML = txt;
	
	$('retenciones_factura').appendChild(tagDiv);
	
	agregaValoresRET(lineaActual, _idConcepto);
	
	//$("txtBaseImponible"+lineaActual).value = $("txt_importe_neto_gravado").value;
	
	llenaProvincias(lineaActual, _provincia);
	
	calculaLineaRet(lineaActual);
	
	++lineaActual;

	$("cantLineasRet").value = lineaActual;
	
}

function obtieneUltimoCbte() {
	var params = "";
	
	params += "?action=comprobante";
	params += "&tipoComprobante=" + $('cbo_tipo_comprobante').value;
	params += "&puntoVenta=" + $('txt_pto_vta').value;
	//params += "&cuit=30710370792"; // + $('txt_pto_vta').value;
	
	muestraWait($("div_wait"));
	
	new Ajax.Request('ajaxAfip.php', {
		 method:'get',
		 parameters: params,
		 
		 onComplete: function (response) {
			 //alert("success " + response.responseText);
			var nro = parseInt(response.responseText);
			
			if (isNaN(nro)) {
				$('error_afip').innerHTML = response.responseText;
				$('error_afip').style.display = 'block';
				$('txt_nro_factura').value = "";
			}
			else {
				$('error_afip').style.display = 'none';
				$('txt_nro_factura').value = PadDigits(response.responseText, 8);
			}
			
			$("div_wait").style.display = "none";
		 }
	});
}

function validaCAE() {
	var params = "";
	
	params += "?action=valida";
	params += "&tipoComprobante=" + $('cbo_tipo_comprobante').value;
	params += "&punto_vta=" + $('txt_pto_vta').value;	
	params += "&cbte_nro=" + $('txt_nro_factura').value;
	params += "&imp_total=" + $('txt_total').value;
	params += "&fecha_cbte=" + $('txt_fec_cbte').value;
	params += "&cae=" + $('txt_cae').value;
	
	muestraWait($("div_wait"));
	
	var ret = false;
	
	new Ajax.Request('ajaxAfip.php', {
		method:'get',
		parameters: params,
		 
		onComplete: function (response) {
			//alert("success " + response.responseText);
			var nro = parseFloat(response.responseText);
			
			if (isNaN(nro)) {
				$('error_afip').innerHTML = response.responseText;
				$('error_afip').style.display = 'block';
				$('txt_cae').value = "";
				$("div_wait").style.display = "none";
			}
			else {
				$('error_afip').style.display = 'none';
				if (confirm("La factura se grabará y no se podrá deshacer")) graba_factura();
			}
		}
	});
}

function obtenerCAI() {
	var params = "";
	
	params += "?action=cai";
	params += "&tipoComprobante=" + $('cbo_tipo_comprobante').value;
	params += "&puntoVenta=" + $('cbo_punto_venta').value;
	//params += "&cuit=30710370792"; // + $('txt_pto_vta').value;
	
	new Ajax.Request('ajaxAfip.php', {
		 method:'get',
		 parameters: params,
		 
		 onComplete: function (response) {
			 //alert("success " + response.responseText);
			var nro = parseInt(response.responseText);
			
			if (isNaN(nro)) {
				$('error_afip').innerHTML = response.responseText;
				$('error_afip').style.display = 'block';
				$('txt_cae').value = "";
			}
			else {
				$('error_afip').style.display = 'none';
				$('txt_cae').value = response.responseText;
			}
		}
	});
}

function obtenerUltimoNroFacturaBD() {
	var params = "";
	
	params += "?action=comprobanteBD";
	params += "&tipoComprobante=" + $('cbo_tipo_comprobante').value;
	params += "&puntoVenta=" + $('cbo_punto_venta').value;
	//params += "&cuit=30710370792"; // + $('txt_pto_vta').value;
	
	new Ajax.Request('ajaxAfip.php', {
		 method:'get',
		 parameters: params,
		 
		 onComplete: function (response) {
			 //alert("success " + response.responseText);
			var nro = parseInt(response.responseText);
			
			if (isNaN(nro)) {
				$('error_afip').innerHTML = response.responseText;
				$('error_afip').style.display = 'block';
				$('txt_nro_factura').value = "";
			}
			else {
				$('error_afip').style.display = 'none';
				$('txt_nro_factura').value = PadDigits(response.responseText, 8);
			}
		 }
	});
}

function obtieneCAE() {
	
	if (!confirm("La factura se grabará y no se podrá deshacer")) return false;
	
	
	var params = "";
	params += "?action=cae";
	params += "&tipoComprobante=" + $('cbo_tipo_comprobante').value;
	params += "&punto_vta=" + $('txt_pto_vta').value;
	params += "&idcliente=" + $('txt_id_cliente').value;	
	params += "&cbte=" + $('txt_nro_factura').value;
	params += "&imp_total=" + $('txt_total').value;
	params += "&imp_tot_conc=" + $('txt_otros_conceptos').value;
	params += "&imp_neto=" + $('txt_importe_neto_gravado').value;
	params += "&impto_liq=" + $('txt_impuesto_liquidado').value;
	params += "&impto_liq_rni=" + $('txt_impuesto_liquidado_rni').value;
	params += "&imp_op_ex=" + $('txt_importe_ope_exentas').value;
	params += "&fecha_cbte=" + $('txt_fec_cbte').value;
	
	params += "&fecha_serv_desde=" + $('txt_fec_serv_desde').value;
	params += "&fecha_serv_hasta=" + $('txt_fec_serv_hasta').value;
	params += "&fecha_venc_pago=" + $('txt_fecha_venc_pago').value;
	
	params += "&presta_serv=" + $('chk_presta_serv').checked ? "S" : "N";

	muestraWait($("div_wait"));
	
	var id = $('cbo_tipo_comprobante').value + $('txt_pto_vta').value + $('txt_nro_factura').value;
	$('hidIdAfip').value = id;
	
	new Ajax.Request('ajaxAfip.php', {
		method:'get',
		parameters: params,
		 
		onComplete: function (response) {
			 //alert("success " + response.responseText);
			var nro = parseFloat(response.responseText);
			
			if (isNaN(nro)) {
				$('error_afip').innerHTML = response.responseText;
				$('error_afip').style.display = 'block';
				$('txt_cae').value = "";
				$("div_wait").style.display = "none";
			}
			else {
				$('error_afip').style.display = 'none';
				$('txt_cae').value = nro;
				//$("div_wait").style.display = "none";
				graba_factura();
			}
		}
	});
}

function graba_factura () {
	if (required("cae")) {
		document.forms['frmAltaFactura'].submit();
	}
}

var _modo = "";

function salvaPtoVta(combo, cboTipo) {
	for (var i = 0; i < combo.options.length; i++) {
		if (combo.options[i].selected) {
			$("txt_pto_vta").value = PadDigits(parseInt(combo.options[i].text), 4);
			break;
		}
	}
	
	//seleccciono el combo de tipo de punto de venta
	for (var j = 0; j < cboTipo.options.length; j++) {
		if (cboTipo.options[j].value == combo.value) {
			cboTipo.options[j].selected = true;
			break;
		}
	}
	
	var modo = cboTipo.options[cboTipo.selectedIndex].text;
	if (modo != _modo) {
		_modo = modo;
		if (!_readonly) manejarPantalla ();
	}
	muestraCotizacion($("cboMoneda"), 1);
}

function ObtieneNroCbte() {
	if (_modo == 'E') {
		obtieneUltimoCbte();
	}
	else {
		obtenerUltimoNroFacturaBD();
	}
}

function manejarPantalla() {
	$("txt_cae").readOnly = _modo != 'A';
	
	if (_modo == 'M') {
		obtenerCAI();
	}
	else {
		$("txt_cae").value = ""; 
	}
	ObtieneNroCbte();
}	

var _readonly = false;

function deshabilitaForm() {
	deshabilitar(document.getElementsByTagName("input"));
	desaparecer(document.getElementsByTagName("button"));
	deshabilitar(document.getElementsByTagName("select"));
	deshabilitar(document.getElementsByTagName("textarea"));
	$("btnCancelar").style.display = "";
	_readonly = true;
}

function deshabilitar(controles) {
	for (var i = 0; i < controles.length; i++) {
		controles[i].disabled = true;
	}
}

function desaparecer(controles) {
	for (var i = 0; i < controles.length; i++) {
		controles[i].style.display = "none";
	}
}

function muestraCotizacion(cboMoneda, muestramsg) {
	//si es manual
	if (_modo == 'M') {		
		if (cboMoneda.value != _monedaBase) {
			if (!_readonly) $("txt_cotizacion").value = "";
			show("divCotizacion");
		}
		else {
			$("txt_cotizacion").value = "1";
			close("divCotizacion");
		}
	}
	else {
		if (muestramsg == undefined)
			alert ("El punto de venta no permite el cambio de moneda");
		
		for (var i=0; i<cboMoneda.options.length; i++) {
			if (cboMoneda.options[i].value == _monedaBase) {
				cboMoneda.selectedIndex = i;
				break;
			}
		}
		
		close("divCotizacion");
	}
}



//ejecucion
var _calculaTextos = true;
if ($("txt_cae").value != "")
	_calculaTextos = false;

_agregaLinea();
muestraDetalles($("chkDetallada").checked, 1);
muestraRetenciones($("chkRetenciones").checked, 1);

if ($("txt_cae").value != "")
	deshabilitaForm();
	

salvaPtoVta($('cbo_punto_venta'), $('cboTipoPtoVta'));
