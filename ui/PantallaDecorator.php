<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once 'be/Usuario.php';
require_once 'dal/AlicuotaIvaFacade.php';
require_once 'dal/RetencionFacade.php';

class PantallaDecorator {
	
	
	public function muestraErrorCabecera($mensaje) {
		echo "<script type='text/javascript'>muestraErrorCabecera('$mensaje');</script>";
	}
	
	public function getUsuario() {
		if (!isset($_SESSION['user'])) {
			$oUsuario = LoginSingleton::getLoginCtrl()->getUsuario(LoginSingleton::getAuth()->getUsername());
			$_SESSION['user']=$oUsuario;
			setcookie("usuario", $oUsuario->getID());
		}		
		else {
			$oUsuario=$_SESSION['user'];
			setcookie("usuario", $oUsuario->getID());
		}
		return $oUsuario;
	}
	
	public function checkActivo() {
		try {
			$result = $this->getUsuario()->get_activo();
			}
			catch (Exception $e)
			{
				throw new Exception ($e->getMessage());
			}
		return $result;	
	}
	
	public function checkEmpresa() {
		$activo = false;
		
		foreach($this->getUsuario()->getRolEmpresa() as $value) {
			
			if ($value['auditoria']->get_activo() && $value['empresa']->get_activo() && $value['empresa']->getID() == GLOBAL_EMPRESA) {
				
				$activo = true;
				break;
			}	
		}
		return $activo;
	}
	
	public function checkFuncion($funcion) {
		if (isset($_SESSION['funciones'])) {
			
			$arrFunciones = $_SESSION['funciones'];
			
			return isset($arrFunciones[$funcion]);
		}
		else {
			return false;
		}
	}
	
	public function muestraProhibido($funcion) {
		$arrFunciones = $_SESSION['funciones'];
		
		$mensaje = Translator::getTrans("FUNCION_NO_DISPONIBLE").": ".$arrFunciones[$funcion];
		
		PantallaSingleton::muestraError($mensaje);
	}
	
	public function endSession($mensaje) {
		PantallaSingleton::muestraError($mensaje);
		
		//mato la sesion
		LoginSingleton::getAuth()->logout();
	}
	
	public function arma_logout() {
		$oUsuario = $this->getUsuario();
		
		$html = "<table><tr><td><img src='css/".GLOBAL_THEME."/images/user.gif' /><td>".
		"<td>".$oUsuario->get_nombre()."&nbsp;".$oUsuario->get_apellido().
		"&nbsp;<a href='".$_SERVER['SCRIPT_NAME']."?action=logout'>".Translator::getTrans(LOGOUT)."</a></td></tr></table>";
		
		echo<<<EOS
			<script type='text/javascript'>
				$('logoutpanel').innerHTML = "$html";
			</script>
EOS;
	}
	
	public function arma_menu ($__callback) {
		
		$oUsuario = $this->getUsuario();
		
		$arrMenu = array('home' => array('href' => $_SERVER['SCRIPT_NAME'], 'titulo' => Translator::getTrans('HOME')));
		$arrSubMenu = array();
		
		$roles = $oUsuario->getRolEmpresa();
		$arrFunciones = array();
		
		foreach($roles as $rol) {
			
			if ($rol['rol']->get_activo() && $rol['auditoria']->get_activo() && $rol['empresa']->getID() == GLOBAL_EMPRESA) {	
				$funciones = $rol['rol']->getFunciones();
				
				foreach($funciones as $funcion) {
					
					if ($funcion['funcion']->get_activo() && $funcion['auditoria']->get_activo()) {
						
						$modulo = $funcion['funcion']->getModulo();
						
						if ($funcion['funcion']->get_muestraMenu() == "S") {
						
							$arrSubMenu[$modulo->get_nombreCorto()][$funcion['funcion']->get_valor()] = array(
								'href' => $_SERVER['SCRIPT_NAME'].'?modulo='.$modulo->get_nombreCorto().'&funcion='.$funcion['funcion']->get_valor(),
								'titulo' => Translator::getTrans($funcion['funcion']->get_valor(), $funcion['funcion']->get_descripcion())
							);
							
							
							if (!isset($arrMenu[$modulo->get_nombreCorto()])) {
								$arrMenu[$modulo->get_nombreCorto()] = array(
									'href' => $_SERVER['SCRIPT_NAME'].'?modulo='.$modulo->get_nombreCorto(),
									'titulo' => Translator::getTrans($modulo->get_nombreCorto(), $modulo->get_nombre())
								);
							}
						}
						
						$arrFunciones[$funcion['funcion']->get_valor()]=$funcion['funcion']->get_descripcion();
						
					}
				}
			}
		}
		
		$_SESSION['funciones']=$arrFunciones;
		$funcionActual = $_GET['funcion'];
		
		//trace($arrSubMenu);
		
		echo '<script type="text/javascript">';
		foreach ($arrMenu as $key => $value) {
			echo "InsertaMenu('$key', '".$value['href']."', '".$value['titulo']."');";	
		}
		
		
		foreach ($arrSubMenu as $key => $value) {
			echo "AgregaSubMenu('$key');";
			$primero="true";
			foreach($value as $name => $element) {
				$script = "InsertaSubMenu('$key', '$name', '".$element['href']."', '".$element['titulo']."', $primero, '$funcionActual');"; 
				if ($__callback == true) 
					echo $script;
				$primero="false";
			}
		}
		
		echo '</script>';
	}
	
	public function resalta_menu($menu) {
		echo '<script type="text/javascript">';
		echo "ResaltaMenu('$menu');";
		echo '</script>';
	}
	
	public function arma_pantalla_modulo($mod) {
		$oUsuario = $this->getUsuario();
		
		$roles = $oUsuario->getRolEmpresa();
		
		$arr=array();
		
		foreach($roles as $rol) {
			$funciones = $rol['rol']->getFunciones();
			foreach($funciones as $funcion) {
				if($funcion['funcion']->getModulo()->get_nombreCorto() == $mod && $funcion['funcion']->get_muestraMenu() == "S") {
					$titulo = $funcion['funcion']->getModulo()->get_nombre();
					if(!isset($arr[$funcion['funcion']->get_valor()])) {
						$arr[$funcion['funcion']->get_valor()] = array(
							'href' => $_SERVER['SCRIPT_NAME']."?modulo=$mod&funcion=".$funcion['funcion']->get_valor(),
							'titulo' => Translator::getTrans($funcion['funcion']->get_valor(), $funcion['funcion']->get_descripcion())
						);
					}
				}
			}
		}
		
		if (count($arr) > 0) {
			echo "<div class='titulo1'>$titulo</div>";
			echo "<ul class='lista-funciones'>";
			foreach ($arr as $value) {
				echo "<li><a href='".$value['href']."'>".$value['titulo']."</a></li>";
			}
			echo "</ul>";
		}
	}
	
}

class PantallaSingleton {
	public function agregaScript($file) {
		echo "<script type='text/javascript' src='js/$file'></script>";
	}
	
	function agregaTitulo($titulo) {
		echo "<div class='titulo1'>$titulo</div>";
	}
	
	function agregaTituloFuncion($funcion) {
		$arrFunciones = $_SESSION['funciones'];
		PantallaSingleton::agregaTitulo(Translator::getTrans($funcion, $arrFunciones[$funcion]));
	}
	
	function muestraLista($funcion, ABMCtrl $abmc) {
		PantallaSingleton::agregaTituloFuncion($funcion);
		
		if (isset($_GET['action']) && ($_GET['action'] == 'activate' || $_GET['action'] == 'deactivate')) {
			if (isset($_GET['id']) && $_GET['id'] != null) {
				$abmc->setActivo($_GET['action'], $_GET['id']); 
			}
		}
		
		try {
			print($abmc->getLista($_GET['page'], ($_GET['inactivos'] == 1 ? true : false), $_GET['order'], $_GET['filtro'] ));
		}
		catch (Exception $ex) {
			print($ex->getMessage());
		}
	}
	
	function obtieneDatosForm(ABMCtrl $abmc) {
		$listas = array();
		
		if (isset($_GET['id']) && $_GET['id'] != null) {
			$listas = $abmc->getListas($_GET['id']); 
		}
		else {
			$listas = $abmc->getListas();
		}
		
		foreach ($listas as $key => $value) {
			$_SESSION[$key] = $value;
		}
		
		if ($_GET['action'] == 'edit') {
			return $abmc->getFields($_GET['id']);
		}
		else {
			return array();
		}
		
	}
	
	function linkInicio() {
		echo "<a href='".$_SERVER['SCRIPT_NAME']."'>".Translator::getTrans("VOLVER_LOGIN")."</a>";
	}
	
	function muestraError($mensaje) {
		echo "<table><tr><td><div class='mensaje_excepcion'>$mensaje</div></td></tr></table>";
	}
	
	function agregaChecks($lista, $separacion=null) {
		$chk = "<table>";
		
		$titulo = "";
		$nuevotitulo="";
		foreach ($lista as $key => $value) {
			
			if ($separacion != null) {
				
				$nuevotitulo = $value["titulo"];
				
				if ($nuevotitulo != $titulo) {
					$titulo = $nuevotitulo;
					$chk .= "<tr><td align=left><b>$titulo</b></td><td>&nbsp;</td></tr>";
				}
			}
			
			if ($value['value']) $checked = "checked";
			else $checked = "";
			
			$chk .= "<tr><td><input type='checkbox' id='funcion_".$value['key']."' name='funcion_".$value['key']."' value='$key' $checked></td>";
			$chk .= "<td>".Translator::getTrans($value['key'], $value['desc'])."</td></tr>";
		
		}
		
		$chk .= "</table>";
		echo $chk;
	}
	
	function agregaCombo($lista) {
		$option = "";
		
		foreach ($lista as $key => $value) {
			
			$desc = $value['desc'];
			
			if ($value['value']) $selected = "selected='selected'";
			else $selected = "";
			
			if ($value['name'] == null) {
				$option .= "<option value='$key' $selected>$desc</option>";
			}
			else {
				$name = $value['name'];
				$option .= "<option value='$key' name='$name' $selected>$desc</option>";
			}
			
		}
		
		echo $option;
	}
	
	function agregaVariableGlobalJS($nombre, $parametro) {
		$tf = new TableFacade();
		$resultado = $tf->getParametro($parametro);
		echo "<script type='text/javascript'>var $nombre = $resultado;</script>";
	}
	
	function agregaLista($lista, $id, $descri, $div) {
		if ($lista == array()) {
			echo "No se encontraron resultados";
			return;
		}
		
		$idValue = "";
		
		$tf = new TableFacade();
		$paginado=$tf->getParametro("PAGINADO_LISTA");
		
		$pagina=1;
		
		$i = 0;
		
		$defTabla = "<table border=1>";
		
		echo "<div id='$div$pagina'>";	
		echo $defTabla;
		
		foreach($lista as $row) {
			
			if ($i == $paginado) {
				$i=0;
				$pagina++;
				echo "</table></div>";
						
				echo "<div id='$div$pagina' style='display:none'>";	
				echo $defTabla;
			}
			
			$i++;
			
			echo "<tr>";
			
			foreach($row as $key => $value) {
				
				if ($key != $id) {
					echo "<td style='padding:5px'>";
					
					if($key == $descri) {
						echo "<a href='javascript:selectValue(\"$id\", \"$descri\", \"$value\", \"$idValue\", \"$div\");'>$value</a>";
					}
					else {
						echo $value;
					}
					
					echo "</td>";
				}
				else {
					$idValue = $value;
				}
			}
			
			echo "</tr>";
		}
		
		echo "</table></div>";
		echo "<br>";
		
		if ($pagina > 1) {
			$i = $pagina;
			
			//inserto el navegador
		
			
			echo "<table border=0><tr>";
			echo "<td style='padding:2px'><a href='javascript:swap(\"$div\", 1);'>|&lt;</a></td>";
			echo "<td style='padding:2px'><a href='javascript:swap_prev(\"$div\");'>&lt;&lt;</a></td>";
			
			$fw="bold";
			for ($j=1; $j<=$i; $j++) {	
				echo "<td style='padding:2px'><a id='a_$j' style='font-weight:$fw' href='javascript:swap(\"$div\", $j);'>$j</a></td>";
				$fw="normal";
			}
			echo "<td style='padding:2px'><a href='javascript:swap_next(\"$div\", $i);'>&gt;&gt;</a></td>";
			echo "<td style='padding:2px'><a href='javascript:swap(\"$div\", $i);'>&gt;|</a></td>";
			echo "</tr></table>";
		}
	}
	
	function showMessage($message) {
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
	
	function hiddenIVA() {
		$aif = new AlicuotaIvaFacade();
		
		$result = $aif->fetchAllRows(true);
		
		foreach($result as $row) {
			$id = $row['id_alicuota_iva'];
			$porcentaje = $row['porcentaje'];
			$tipoIva = $row['tipo_iva'];
			
			echo "<input type='hidden' id='hidIVA$id' value='$porcentaje' />";
			echo "<input type='hidden' id='hidTipoIVA$id' value='$tipoIva' />";
		}
		echo "<select id='valoresCBOIVA' style='display:none' disabled>";
		foreach($result as $row) {
			$id = $row['id_alicuota_iva'];
			$descripcion = $row['descripcion'];
			echo "<option value=$id>$descripcion</option>";
		}
		echo "</select>";
	}
	
	function hiddenRET() {
		$rf = new RetencionFacade();
		
		$result = $rf->fetchAllRows(true);
		
		foreach($result as $row) {
			$id = $row['id_retencion'];
			$retencion = $row['tipo_retencion'];
			
			echo "<input type='hidden' id='hidRET$id' value='$retencion' />";
		}
	}
	
	function agregaComboProvincias() {
		$pf = new ProvinciaFacade();
		
		$result = $pf->getProvinciasPais();
		
		foreach($result as $provincia) {
			$id = $provincia['id_provincia'];
			$descri = $provincia['descripcion'];
			echo "<option value='$id'>$descri</option>";
		}
	}
	
	function agregaComboRetenciones($compra) {
		$ret = new RetencionFacade();
		$result = $ret->fetchAllRows(true, "compra_venta in ('$compra', 'X')");
	
		foreach ($result as $row) {
			$id = $row['id_retencion'];
			$titulo = $row['descripcion'];
			
			echo "<option value='$id'>$titulo</option>";
		}
	}
}