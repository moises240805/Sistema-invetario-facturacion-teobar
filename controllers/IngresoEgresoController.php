<?php
require_once 'models/IngresoEgreso.php';
$controller = new IngresoEgreso();


//Esta variable manejara de forma dinamica las solicitudes http ya sean post o get
$action = isset($_GET['a']) ? $_GET['a'] : '';


//Indiferentemente sea la accion por el post o get el switch llama a cada funcion 
switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregarIngresoEgreso($controller);
        }
    case "":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultarIngresoEgreso($controller);
        }
        break;
    default:
        consultarIngresoEgreso($controller);
        break;

}


    function agregarIngresoEgreso($controller){
        $controller->Guardar_IngresoEgreso();
    }

    function consultarIngresoEgreso($controller){
        require_once 'views/php/dashboard_manejo.php';
    }


?>