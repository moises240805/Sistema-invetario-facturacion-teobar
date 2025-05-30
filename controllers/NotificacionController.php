<?php
require_once 'models/Notificacion.php';
require_once 'models/Bitacora.php';
require_once 'views/php/utils.php';
date_default_timezone_set('America/Caracas');
$controller = new Notificacion();
$bitacora = new Bitacora();

$action = isset($_GET['a']) ? $_GET['a'] : '';
switch ($action) {
    case 'consultar':
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultar($controller);
        }
    break;
    case 'open':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            Open($controller, $bitacora);
        }
    break;
    case 'close':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            Close($controller, $bitacora);
        }
    break;
    default:
        pagina($controller);
    break;
}
function consultar($controller){

    $notificacion=$controller->mostrarNotificacion();
    //require_once 'views/php/dashboard_notificacion.php';
    echo json_encode($notificacion);
    exit;
}

function pagina($controller){

    $notificacion=$controller->mostrarNotificacion();
    require_once 'views/php/dashboard_notificacion.php';
}
?>

