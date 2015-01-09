function InsertaMenu(div_id, href, titulo) {
	var menuitem="";
	
	menuitem+="<div id='menu_"+div_id+"' class='menuitem'>";
	menuitem+="<a href='"+href+"'>"+titulo+"</a>";
	"</div>";
	$("div_menu").innerHTML += menuitem;
}

function ResaltaMenu(div_id) {
	$("menu_"+div_id).style.fontWeight = "bold";
}

function AgregaSubMenu(div_id) {
	var menuitem = "";
	
	menuitem+="<div id='submenucontainer_"+div_id+"' class='submenucontainer' style='display:none'></div>";
	$("menu_"+div_id).innerHTML += menuitem;
	
	$("menu_"+div_id).onmouseover = function () {
		$("submenucontainer_"+div_id).style.display="block";
	};
	
	$("menu_"+div_id).onmouseout = function () {
		$("submenucontainer_"+div_id).style.display="none";
	};
}

function InsertaSubMenu(parent_id, div_id, href, titulo, primero, funcionActual) {
	var menuitem = "";
	
	if (div_id != funcionActual) {
		menuitem+="<a href='"+href+"'>";
	}
	
	menuitem+="<div id='submenu_"+div_id+"' class='submenuitem";
	
	if (div_id == funcionActual) {
		menuitem+=" seleccionado'";
	}
	else {
		menuitem+="' ";
			
		menuitem+="onmouseover='javascript:this.style.fontWeight=\"bold\"' ";
		menuitem+="onmouseout='javascript:this.style.fontWeight=\"normal\"' ";
	}
	
	if (primero)
		menuitem+="style='border-top-width:1px;'";
	menuitem+=">"+titulo+"</div>";
	
	if (div_id != funcionActual) {
		menuitem+="</a>";
	}
	
	menuitem+="<br />";
	
	$("submenucontainer_"+parent_id).innerHTML += menuitem;
}