<?php
require_once 'models/Notificacion.php';
$Controller = new Notificacion();
$notificaciones = $Controller->mostrarNotificacion();
require_once 'views/php/dashboard_notificacion.php'
?>

