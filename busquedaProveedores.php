<?php
define("ESPHORA", true);
require_once 'config/globals.php';
require_once 'dal/ProveedorFacade.php';
require_once 'ui/PantallaDecorator.php';

$pf = new ProveedorFacade();		
PantallaSingleton::agregaLista($pf->fetchSelectList($_GET['patron']), 'id_proveedor', 'descripcion_proveedor', 'lista_proveedores');
?>