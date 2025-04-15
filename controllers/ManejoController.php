<?php
require_once 'models/Manejo.php';
$controller = new Manejo();

$movimiento = $controller->Mostrar_Movimiento();

require_once 'views/php/dashboard_manejo.php';


?> 