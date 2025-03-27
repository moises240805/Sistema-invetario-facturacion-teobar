<?php
require_once 'models/IngresoEgreso.php';
$controller = new IngresoEgreso();

$movimiento = $controller->Mostrar_IngresoEgreso();

require_once 'views/php/dashboard_manejo.php';


?> 