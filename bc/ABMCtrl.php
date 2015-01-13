<?php
require_once 'HTML/Table.php';


class ABMCtrl {
	protected $_facade;
	protected $_idName;
	protected $_errormsg;
	protected $_order=null;
	protected $_filtroValido=null;
	protected $_filtroBusqueda = "";
	protected $_filtroEmpresa = "";
	
	public function agregaWait($mensaje) {
		$ret = <<<EOF
<div class="wait-pantalla-completa" id="div_wait">
	<table width=100% height=100%>
		<tr>
			<td valign="middle" align="center">
				<div class="cuadro-wait-pantalla-completa">
					<B>
						<i>$mensaje</i><br><br>
						Esta operacion puede tardar varios segundos.<br><br>
						<img src='css/orange/images/ajax-loader.gif' border=0 />
						<br><br>Por favor espere...
					</B>
				</div>
			</td>
		</tr>
	</table>
</div>
EOF;
		return $ret;
	}
	
	public function getNombresListas() {
		return array();
	}
	
	public function setActivo($activate, $id) {
		if ($activate == "activate") {
			$this->_facade->activateID($id);
		}
		else {
			$this->_facade->deactivateID($id);
		}
	}
	
	public function getLista ($pagina=null, $inactivos = null, $order = null, $busqueda = null){			
		
		if ($pagina == null) $pagina = 1;
		
		if ($inactivos == 1) {
			$filtro = $this->_filtroValido;
		}
		else {
			$filtro = null;
		}
		
		if ($busqueda != null) {
			if ($filtro != null) $filtro .= " and ";
			$filtro .= $this->_filtroBusqueda." like '%$busqueda%'";
		}
		
		if ($order == null) {
			$order = $this->_order;
		}
		
		if ($this->_filtroEmpresa != null) {
			if ($filtro != null) $filtro .= " and ";
			$filtro .= $this->_filtroEmpresa;
		}
		
		if ($order == null) {
			$order = $this->_order;
		}
		
		
		$result = $this->_facade->fetchList($order, $pagina, $filtro);
		
		$attrs = array('width' => '100%', 'class' => 'tabla-abm');
		
		$attrsPares = array('class' => 'tabla-abm-fila-par');
		$attrsImpares = array('class' => 'tabla-abm-fila-impar');
		
		
		$table =& new HTML_Table($attrs);
		
		
		//$table->setCaption('Tipos de Documento');
		
		foreach($result as $row) {
			$a = array();
			$i=0;
			$id = 0;
			foreach ($row as $key => $value) {
				if ($key == "activo") {
					if ($value == "N") {
						$rowAttrs = array ('class' => 'tabla-abm-fila-inactiva');
						$colHeader = "";
						$colValue = "<a href='".$this->armaHREF('activate', $id)."'><img src='css/".GLOBAL_THEME."/images/activate.gif' border=0 /></a>";
					}
					else {
						$rowAttrs = null;
						$colHeader = "";
						$colValue = "<a href='".$this->armaHREF('deactivate', $id)."'><img src='css/".GLOBAL_THEME."/images/deactivate.gif' border=0 /></a>";
					}
				}
				else {
					if ($key == $this->_idName) {
						$id = $value;
						$colHeader = Translator::getTrans("EDITAR");										
						$colValue = "<a href='".$this->armaHREF('edit', $value)."'><img src='css/".GLOBAL_THEME."/images/edit.gif' border=0 /></a>"; 
					}
					else {
						$colHeader = "<a href='".$this->armaHREF(null, null, null, null, $key)."'>".Translator::getTrans($key)."</a>";
						$colValue = $value;
					}
				}
				
				$table->setHeaderContents(0, $i, $colHeader);
				$a[] = $colValue;
				$i++;
			}
			$table->addRow($a, $rowAttrs);
		}
		
		if ($inactivos == 1) {
			$checked = false;
		}
		else {
			$checked = true;
		}
		
		$table->altRowAttributes(1,$attrsImpares, $attrsPares, true);
		return $this->formBusqueda().$this->botonera($checked).$this->navigator($pagina, $checked).$table->toHtml().$this->navigator($pagina, $checked);		
	
	}
	
	protected function formBusqueda() {
		return "";
	}
	
	protected function navigator($pagina, $checked, $filtroPadre = null) {
		
		if ($filtroPadre == null) {
		$filtro = $checked ? null : "activo = 'S'";
		}
		else {
			$filtro = $filtroPadre;
		}
		
		$registros=$this->_facade->getCount($filtro);
		$count = $this->_facade->getParametro("PAGINADO");
		
		$paginas = $registros / $count;
		
		if ($pagina == null) { 
			$pag = 1;
		}
		else {
			$pag = $pagina;
		}
		
		//echo "<br>$registros<br>$count<br>$paginas<br>";
		
		$ret = "";
		$estilo = "style='padding:3px'";
		
		$primerRegistro = (($pag - 1) * $count) + 1;
		
		$ultimoRegistro = $primerRegistro + $count - 1;
		
		if ($ultimoRegistro > $registros) $ultimoRegistro -= $ultimoRegistro - $registros;
		
		$ret = "<div class='cuenta-navigator'>Registros $primerRegistro-$ultimoRegistro de $registros</div>";
		
		if ($paginas > 1) {
			$ret .= "<table><tr>";
			
			if ($pag == 1) {
				$ahref = "";
				$ahrefPrev = "";
				$cierraA = "";
			}
			else {
				$href = $this->armaHREF(null, null, 1);
				$ahref = "<a href='$href'>";
				
				$href = $this->armaHREF(null, null, $pagina - 1);
				$ahrefPrev = "<a href='$href'>";
				$cierraA = "</a>";
			}
			
			$ret.="<td $estilo>$ahref|&lt;$cierraA</td><td $estilo>$ahrefPrev&lt;&lt;$cierraA</td>";
			
			/*for ($i = 0; $i <= $paginas; $i++) {
				
				$j=$i+1;
				
				$href = $this->armaHREF(null, null, $j);
				
				if ($j == $pag) {
					$ret.="<td $estilo><b>$j</b></td>";
				}
				else {
					$ret.="<td $estilo><a href='$href'>$j</a></td>";
				}
			}
			*/
			if ($pag == $j) {
				$ahref = "";
				$ahrefPrev = "";
				$cierraA = "";
			}
			else {
				$href = $this->armaHREF(null, null, $j);
				$ahref = "<a href='$href'>";
				
				$href = $this->armaHREF(null, null, $pag + 1);
				$ahrefPrev = "<a href='$href'>";
				$cierraA = "</a>";
			}
			
			$ret.="<td $estilo>$ahrefPrev&gt;&gt;$cierraA</td><td $estilo>$ahref&gt;|$cierraA</td>";
			
			$ret.="</tr></table>";
		}
		
		return $ret;

	}
	
	private function botonera($inactivos) {
		$ret = "<form id='frmBotonera'>";
		$ret .=	"<table>";
		$ret .=	"<tr>";
		$ret .=	"<td>";
			$ret .=	"<button name='btnNew' type='button'"; 
			$ret .=	"onclick='javascript:document.location=\"".$this->armaHREF('add')."\";'>";
			$ret .=	Translator::getTrans("NUEVO");
			$ret .=	"</button>";
			$ret .=	"</td>";
			
			$ret .=	"</tr>";
			$ret .=	"<tr>";
			
			$ret .=	"<td nowrap>";
			$ret .=	"Mostrar Inactivos <input type='checkbox'";
			$ret .=	($inactivos ? " checked " : " ");
			$ret .=	"onclick='javascript:document.location=\"".$this->armaHREF(null, null, null, ($inactivos ? 1 : 2))."\";'>";
			$ret .=	"</td></tr></table></form>";
			
		return $ret;
	}
	
	protected function armaHREF($action=null, $id = null, $page=null, $inactivos = null, $order = null) {
		foreach($_GET as $variable => $contenido) {
			$href[$variable]=$contenido;
		}
		
		if ($action != null) {
			$href['action']=$action;
		}
		else {
			unset($href['action']);
		}
		
		if ($id == null) {
			unset($href['id']);
		}
		else {
			$href['id']=$id;
		}
		
		if ($page!=null) {
			$href['page'] = $page;
		}
		
		if ($inactivos != null) {
			$href['inactivos'] = $inactivos;
		}
		
		unset($href['filtro']);
		
		if ($order != null) {
			$href['order'] = $order;
		}
		
		
		$strHREF = $_SERVER['SCRIPT_NAME']."?";
		$primero = false;
		
		foreach($href as $variable => $contenido) {
			if($primero) {
				$strHREF.="&";							
			}
			$primero = true;
			$strHREF.="$variable=$contenido"; 
		}
		
		return $strHREF;
	}
	
	public function getFields($id) {
		return $this->_facade->fetchRows($id);
	}
	
	public function insert($campos) {
		if($this->serverValidation($campos)) {
			return $this->_facade->addRow($campos);
		}
		else {
			throw new Exception(Translator::getTrans("INSERT_ERROR")."<br>".$this->getMessage());
		}
	}
	
	public function update($campos) {
		if($this->serverValidation($campos)) {
			$this->_facade->modifyRow($campos);
		}
		else {
			throw new Exception(Translator::getTrans("UPDATE_ERROR")."<br>".$this->getMessage());
		}
	}
	
	public function serverValidation($campos) {
		return true;
	}
	
	public function getMessage() {
		return "";
	}
	
	public function getListas($id=null) {
		return array();
	}
	
	protected function _getListas($id, $idName, $desc, $valor, $retvalue, TableFacade $tf, $orden=null, TableFacade $tf2=null, $id2=null, $desc2=null) {
		$rows = $tf->fetchAllRows(true,null,$orden);
		
		$lista = array();
		
		foreach ($rows as $row) {
			if ($tf2 != null) {
				$row2=$tf2->fetchRows($row[$id2]);
				$titulo=$row2[$desc2];
				
			}
			else {
				$titulo = "";
			}
			
			$lista[$row[$idName]] = array ( 'key' 	=> $row[$valor], 
											'desc' 	=> $row[$desc],
											'value' => false,
											'titulo' => $titulo
			);
		}
		
		//ver las funciones que pertenecen a este id
		if ($id != null) {
			$elementos = $this->_facade->fetchTablaLista($id);
			
			foreach ($elementos as $elemento) {
				$lista[$elemento[$idName]]['value'] = true;
			}
		}
		
		return array($retvalue => $lista);
	}
	
	protected function _serverValidation($claveFuncional, $claveBD, $campos) {
		$value = $campos[$claveFuncional];
		$id = $campos[$claveBD];
		
		$filter = "$claveFuncional = '$value'";
		if ($id != "") {
			$filter .= " and $claveBD <> $id"; 
		}

		if ($this->_filtroEmpresa != "") {
			$filter .= " and $this->_filtroEmpresa" ; 
		}		
		
		if ($this->_facade->getCount($filter) > 0) {
			$this->_errormsg = Translator::getTrans("CLAVE_DUPLICADA").": $value";
			return false;
		}
		return true;
	}
	
	protected function _getHijas($desc, $selected, TableFacade $tf, $filtroAdic = null, $name = null) {
		$rows = $tf->fetchAllRows(true, $filtroAdic);
		
		$lista = array();
		
		foreach ($rows as $row) {
			$hija = ($row[$tf->getIdName()] == $selected);
			
			if ($name == null) {
				$lista[$row[$tf->getIdName()]] = array(	'desc' => $row[$desc],
														'value' => $hija);
			}
			else {
				$lista[$row[$tf->getIdName()]] = array(	'desc'	=> $row[$desc],
														'value' => $hija,
														'name'	=> $row[$name]);
			}
		}
		
		return $lista;
	}
}

?>