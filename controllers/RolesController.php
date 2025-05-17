<?php

// Incluye el archivo del modelo 
require_once 'models/Roles.php';
require_once 'views/php/utils.php';

$permiso = new Roles();

//Esta variable manejara de forma dinamica las solicitudes http ya sean post o get
$action = isset($_GET['a']) ? $_GET['a'] : '';
switch ($action) {
    case 'consultar':
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultar($permiso);
        }
    break;
    case 'agregar':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregar($permiso);
        }
    break;
    case 'actualizar':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            actualizar($permiso);
        }
    break;
    case 'eliminar':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            eliminar($permiso);
        }
    break;
    default:
        consultar($permiso);
    break;
}



function agregar($permiso){
    $rol = filter_input(INPUT_POST, 'rol', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if(empty($rol)){
        setError('Todos los campos son requerido');
    }
    try 
    {
        $resultado=$permiso->manejarAccion('agregar',$rol);
        //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
        if (isset($resultado['status']) && $resultado['status'] === true) {

            //usar mensaje dinámico del modelo
            setSuccess($resultado['msj']);
        }
        else {
            // Error: usar mensaje dinámico o genérico
            $mensajeError = $resultado['msj'] ?? "ERROR AL Registrar...";
            setError($mensajeError);
        }
    } catch (Exception $e) {
        //mensajes del expcecion del pdo 
        error_log("Error al abrir: " . $e->getMessage());
        setError("Error en operación");
    }
    
    header("Location: index.php?action=roles"); // Redirect
    exit();
}

function consultar($permiso)
{
    $datos=$permiso->manejarAccion('consultar',null);
    $roles = [];
    $permisos = [];
    $modulos = [];
    $estatusTabla = [];
    require_once "views/php/dashboard_roles.php";
}



function actualizar($permiso)
{


// actualizar_estatus.php
header('Content-Type: application/json');

// Leer JSON enviado por fetch
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}


$roles=$permiso->manejarAccion('actualizar',$data);


}


function eliminar($permiso){
    $id_rol = filter_input(INPUT_POST, 'id_rol', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if(empty($id_rol)){
        setError('Todos los campos son requerido');
    }
    try 
    {
        $resultado=$permiso->manejarAccion('eliminar',$id_rol);
        //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
        if (isset($resultado['status']) && $resultado['status'] === true) {

            //usar mensaje dinámico del modelo
            setSuccess($resultado['msj']);
        }
        else {
            // Error: usar mensaje dinámico o genérico
            $mensajeError = $resultado['msj'] ?? "ERROR AL eliminar...";
            setError($mensajeError);
        }
    } catch (Exception $e) {
        //mensajes del expcecion del pdo 
        error_log("Error al eliminar: " . $e->getMessage());
        setError("Error en operación");
    }
    
    header("Location: index.php?action=roles"); // Redirect
    exit();
}

?>