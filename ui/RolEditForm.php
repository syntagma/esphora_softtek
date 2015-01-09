    <?php
		if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");
		require_once 'bc/RolController.php';
		require_once 'be/Rol.php';
		
		$oRolController = new RolController();
		$oRolController->getForm()->display();
		$oRol = new Rol();
		
		if ($_POST)
		{
			$oRol->map($_POST);
			$oRolController->guardarRol($oRol);	
			//print_r($oRol);
		}
	?>