<?php
session_start();
$controlador = isset($_GET['action']) ? $_GET['action'] : '';
$action = isset($_GET['a']) ? $_GET['a'] : '';
require_once 'config/Route.php';
if (!isset($_SESSION["s_usuario"]) && $controlador != 'usuario' && $action != 'ingresar' && $action != 'registrar' && $controlador != '') {
    // Si no está iniciada y no es la acción de inicio de sesión, redirige a la página de inicio de sesión
    require_once "views/php/login.php";
    exit(); // Asegúrate de que el script termine aquí
}
if ($controlador == '') {
    require_once "views/php/pagina.php";
} else {
    if (isset($rutas[$controlador])) {
        require_once $rutas[$controlador];
        
        } else {
                    //require_once 'controllers/AdminController.php';
                }
            
        }


?>