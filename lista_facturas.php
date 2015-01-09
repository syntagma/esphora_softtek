<?php
define("ESPHORA", true);
require_once 'config/globals.php';
require_once 'dal/FacturaFacade.php';
require_once 'HTML/Table.php';

$tipoBusqueda = $_GET['tipoBusqueda'];
$value = $_GET['value'];
$pagina = $_GET['pagina'];

$destino = $_GET['destino'];

$txtId = "id_".$destino;
$txtDescri = "descripcion_".$destino;
$div = "lista_".$destino;

$filtro = "FACTURA.id_empresa = " . GLOBAL_EMPRESA;

if ($value != "all") {
	if ($tipoBusqueda == "fecha") {
		$filtro .= " and FACTURA.fec_cbte = '$value'";
	}
	else {
		$filtro = " and FACTURA.nro_factura = $value";
	}
}

$ff = new FacturaFacade();

$result = $ff->fetchAllRows(true, $filtro, "FACTURA.pto_vta, FACTURA.nro_factura", "listaFacturas", $pagina);

$attrs = array('class' => 'tabla-abm');
		
$attrsPares = array('class' => 'tabla-abm-fila-par');
$attrsImpares = array('class' => 'tabla-abm-fila-impar');

$table =& new HTML_Table($attrs);
$primero = true;
$ptoVta="";

foreach ($result as $row) {
	$i=0;
	$HTMLTable = array();
	foreach($row as $key => $column) {
		$colHeader = $key;
		
		if ($key == "id_factura") {
			$id = $column;
			continue;
		}
		
		elseif ($key == "nro_factura") {
			$ptoVta = str_pad($ptoVta, 4, "0", STR_PAD_LEFT);
			$nroFact = str_pad($column, 8, "0", STR_PAD_LEFT);
			$colValue = "<a href='javascript:selectValue(\"$txtId\", \"$txtDescri\", \"$ptoVta-$nroFact\", \"$id\", \"$div\");'>$ptoVta-$nroFact</a>";
		}
		
		elseif ($key == "pto_vta") {
			$ptoVta = $column;
			continue;
		}
		
		else {
			$colValue = $column;
		}
		
		$HTMLTable[] = $colValue;
		
		if ($primero) {
			$table->setHeaderContents(0, $i++, $colHeader);
		}
	}
	$table->addRow($HTMLTable);
	$primero = false;
}

$table->altRowAttributes(1,$attrsImpares, $attrsPares, true);
print($table->toHtml());

if ($filtro == null) {
	$filtro = "activo = 'S'";
}
else {
	$filtro = "$filtro and activo = 'S'";
}

$count = $ff->getCount($filtro);
$registros = $ff->getParametro("PAGINADO_LISTA");

$paginas = $count / $registros;

//echo "<br>C=$count<br>R=$registros<br>P=$paginas<br>";

if ($paginas > 1) {
	$nav = "<table><tr>";
	
	if ($pagina == 1) {
		$nav .= "<td>|&lt;</td><td>&lt;&lt;</td>";
	}
	else {
		$j=$pagina-1;
		$nav .= "<td><a href='javascript:buscaFacturas(\"$destino\", 1);'>|&lt;</a></td>";
		$nav .= "<td><a href='javascript:buscaFacturas(\"$destino\", $j);'>&lt;&lt;</a></td>";
	}
		
	for ($i=0; $i<=$paginas; $i++) {
		$j=$i+1;
		
		if ($j == $pagina) {
			$nav .= "<td><b>$j</b></td>";
		}
		else {
			$nav .= "<td><a href='javascript:buscaFacturas(\"$destino\", $j);'>$j</a></td>";
		}
	}
	
	if ($pagina >= $i) {
		$nav .= "<td>&gt;&gt;</td><td>&gt;|</td>";
	}
	else {
		$j = $pagina + 1;
		$nav .= "<td><a href='javascript:buscaFacturas(\"$destino\", $j);'>&gt;&gt;</a></td>";
		$nav .= "<td><a href='javascript:buscaFacturas(\"$destino\", $i);'>&gt;|</a></td>";
	}
	
	$nav .= "</tr></table>";
	
	print ($nav);
}

?>
