<?php if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo"); ?>
<div id="div_footer">
	<div style="font-size: 8pt">
		<?php 
			if(isset($_SESSION['user'])) {
				$ef = new EmpresaFacade();
				$r = $ef->fetchRows(GLOBAL_EMPRESA);
				echo "Empresa: ".$r['nombre']."<br>";
				unset($ef);
				unset($r);
			}
		
			$cfg = new conf_conexion();
			echo $cfg->get_db().":".$cfg->get_user()."@".$cfg->get_host()."/".$cfg->get_dbname();
		?>
	</div>
	<div style="text-align:left">Version 2.2</div>
</div>