<?php 
define("ESPHORA", true);

require_once("config/globals.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Esphora</title>
<?php 
echo '<link href="css/'.GLOBAL_THEME.'/base.css" rel="stylesheet" type="text/css" />';
echo '<link href="css/'.GLOBAL_THEME.'/menu.css" rel="stylesheet" type="text/css" />';
echo '<link href="css/'.GLOBAL_THEME.'/center.css" rel="stylesheet" type="text/css" />';
echo '<link href="css/'.GLOBAL_THEME.'/forms.css" rel="stylesheet" type="text/css" />';

?>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/footer.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript">

	window.onload = function() {
		CreaFooter("div_footer");
	};
	
</script>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <!-- Header -->
    <td>
    	<?php 
			require "ui/header.php";
		?>
    </td>
  </tr>
  <tr>
    <!-- Menu Principal -->
    <td>
    	<?php 
			require "ui/menu.php";
		?>    
    </td>
  </tr>
  <tr>
    <!-- Body -->
    <td>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    	<tr>			
	    	<?php
	    		echo "<td id='div_center'>";
    			require ("ui/orquestador.php");
    		?>
    		</td>
    	</tr>
    	<tr>
    		<td>
    		<?php
    			require "ui/footer.php";
			?>
			</td>
		</tr>
	</table>
    </td>
  </tr>
</table>
    
</body>
</html>