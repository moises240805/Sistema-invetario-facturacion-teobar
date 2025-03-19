<?php
require_once 'models/Bitacora.php';
$bitacora = new Bitacora();

$message="";
$message3="";
$message3="";
$lista_bitacora = $bitacora->Mostrar_Bitacora();

require_once 'views/php/dashboard_bitacora.php';


?> 