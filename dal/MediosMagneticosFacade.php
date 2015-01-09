<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");
require_once("File.php");
require_once ("dal/CondicionIvaFacade.php");
require_once ("dal/PuntoVentaFacade.php");
require_once ("dal/MonedaFacade.php");

class MediosMagneticosFacade {
	
	public function grabarArchivo($nombre, $lineas){
		//print_r($lineas);
		if ($lineas == array())
		{
			File::writeChar("import/" . $nombre, null, FILE_MODE_WRITE);	
		}
		else 
		{
			foreach ($lineas as $linea)
			{
				 File::writeLine("import/" . $nombre, $linea, FILE_MODE_WRITE, "\x0D" . "\x0A");
			}
			File::close("import/" . $nombre, FILE_MODE_WRITE);			
		}
		
	}
	
	
}
?>