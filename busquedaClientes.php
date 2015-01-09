<?php
define("ESPHORA", true);
require_once 'config/globals.php';
require_once 'dal/ClienteFacade.php';
require_once 'ui/PantallaDecorator.php';

$cf = new ClienteFacade();		
PantallaSingleton::agregaLista($cf->fetchSelectList($_GET['patron']), 'id_cliente', 'descripcion_cliente', 'lista_clientes');
?>