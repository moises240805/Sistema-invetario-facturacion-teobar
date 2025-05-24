<?php
require_once 'models/Manejo.php';
require_once 'models/IngresoEgreso.php';
require_once 'models/Caja.php';
require_once 'models/Bitacora.php';
require_once 'models/Roles.php';
require_once 'views/php/utils.php';

$controller = new Manejo();
$ingresoegreso = new IngresoEgreso();
$cajas = new Caja();
$roles = new Roles();
$bitacora = new Bitacora();


//esta variables es para definir el modulo en la bitacora para cuando se cree el json 
$modulo = 'Caja';
date_default_timezone_set('America/Caracas');//Zona horaria


//Esta variable manejara de forma dinamica las solicitudes http ya sean post o get
$action = isset($_GET['a']) ? $_GET['a'] : '';


//Indiferentemente sea la accion por el post o get el switch llama a cada funcion 
switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregarManejo($controller);
        }
        break;
    case "mid_form":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            obtenerManejo($controller);
        }
        break;
    case "":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultarManejo($controller, $ingresoegreso, $cajas, $roles, $modulo);
        }
        break;
    default:
        consultarManejo($controller, $ingresoegreso, $cajas, $roles, $modulo);
        break;
}



    function obtenerManejo($controller) {
    $id = $_GET['ID'];
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?actio=movimiento");
        exit();
    }

    $accion="obtener";
    $movimiento = $controller->manejarAccion($accion,$id);
    header('Content-Type: application/json');
    echo json_encode($movimiento);
}


    function consultarManejo($controller, $ingresoegreso, $cajas, $roles, $modulo){

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if ($roles->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {

            // Ejecutar acción permitida
            $movimiento = $controller->manejarAccion("consultar",null);
            $ingresosegresos = $ingresoegreso->manejarAccion("consultar",null);
            $caja = $cajas->manejarAccion("consultar",null);
            $status = $cajas->manejarAccion("movimiento",null);
            require_once 'views/php/dashboard_manejo.php';
            exit();
            }
        else{

            //muestra un modal de info que dice acceso no permitido
            setError("Error accion no permitida ");
            require_once 'views/php/dashboard_manejo.php';
            exit(); 
        }
    }

?> 