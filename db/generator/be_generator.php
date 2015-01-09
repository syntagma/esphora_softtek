<?php
if (!defined("ESPHORA")) die ("No puede tener acceso directo a este archivo");

require_once("dal/DBFacade.php");
require_once("DB/Table/Generator.php");

// Instantiate a Generator object
try{
	echo "LOG<ol>";
	$dbf=new DBFacade();
	echo "<li>DBFacade Instanciada</li>";
	 
	$generator = new DB_Table_Generator($dbf->getConnection(), $dbf->getDBName());
	echo "<li>Generator Instanciada</li>";
	
	// Choose a directory for the generated code
	$generator->class_write_path = 'db/';
	echo "<li>Directorio Seteado</li>";
	// Generate DB_Table subclass definition files 
	//print_r($generator);
	
	$generator->tables = array('detalle_retencion');
	
	
	$generator->generateTableClassFiles();
	echo "<li>Tablas Generada</li>";
	//Generar los datos adicionales
	//public $sql = array('all' => array('select' => '*'));
    //public $fetchmode = DB_FETCHMODE_ASSOC;
	// directory path can be either absolute or relative

	// open the specified directory and check if it's opened successfully
	if ($handle = opendir($generator->class_write_path)) {
	
	   // keep reading the directory entries 'til the end
	   while (false !== ($file = readdir($handle))) {
	
	      // just skip the reference to current and parent directory
	      if ($file != "." && $file != "..") {
	         if (!is_dir($generator->class_write_path."/$file")) {	            	            	            
	            $lines = file($generator->class_write_path."/$file");
	            $fp=fopen($generator->class_write_path."/$file.new", "w+") or die ("no se puede abrir $file");
	            foreach($lines as $line) {
	            	fwrite ($fp, $line);
	            	if (substr($line, 0, 5) == "class") {
	            		fwrite($fp, "public \$sql = array ('all' => array ('select' => '*'));\n");
	            		fwrite($fp, "public \$fetchmode = MDB2_FETCHMODE_ASSOC;\n");
	            	}
	            }
	         }
	      }
	   }
	
	   // ALWAYS remember to close what you opened
	   closedir($handle);
	}
	echo "<li>Archivos Generados</li>";
	// Generate the 'Database.php' file
	//$generator->generateDatabaseFile();
}
catch(Exception $ex) {
	die ($ex->getMessage());
}
echo "</ol>";
echo "Entidades generadas exitosamente"
?>