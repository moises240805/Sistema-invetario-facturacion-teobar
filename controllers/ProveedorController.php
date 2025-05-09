<?php

require_once 'models/Proveedor.php';
require_once 'models/Bitacora.php';
require_once 'models/Roles.php';
require 'views/php/utils.php';

//Se instancia los modelos
$controller = new Proveedor();
$bitacora = new Bitacora();
$usuario = new Roles();

//esta variables es para definir el modulo en la bitacora para cuando se cree el json 
$modulo = 'Proveedores';
date_default_timezone_set('America/Caracas');

$action = isset($_GET['a']) ? $_GET['a'] : '';

//Indiferentemente sea la accion por el post o get el switch llama a cada funcion 
switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregarProveedor($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "mid_form":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            obtenerProveedor($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "actualizar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            actualizarProveedor($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "eliminar":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            eliminarProveedor($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "d":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultarProveedor($controller, $usuario, $modulo);
        }
        break;
    default:
        consultarProveedor($controller, $usuario, $modulo);
        break;
}

// Función para agregar un Proveedor
function agregarProveedor($controller, $bitacora, $usuario, $modulo){
        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, $action, $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

    // Sanitiza y valida datos
    $id_proveedor = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tipo2 = filter_input(INPUT_POST, 'tipo2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombre_proveedor = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $direccion_proveedor = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $telefono_proveedor = filter_input(INPUT_POST, 'codigo_tlf', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . filter_input(INPUT_POST, 'numero_tlf', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id_representante_legal = filter_input(INPUT_POST, 'id_representante', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombre_representante_legal = filter_input(INPUT_POST, 'nombre_representante', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $telefono_representante_legal = filter_input(INPUT_POST, 'codigo_tlf_representante', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . filter_input(INPUT_POST, 'numero_tlf_representante', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($nombre_proveedor) || empty($direccion_proveedor) || empty($telefono_proveedor) || empty($nombre_representante_legal)) {
        setError("Todos los campos son requeridos");
        header("Location: index.php?action=proveedor&a=d");
        exit();
    }

    if (strlen($nombre_proveedor) > 100 || strlen($direccion_proveedor) > 200 || strlen($telefono_proveedor) > 20 || strlen($nombre_representante_legal) > 100) {
        setError("Límite de caracteres excedido");
        header("Location: index.php?action=proveedor&a=d");
        exit();
    }

    $proveedor = json_encode([
        'id_proveedor' => $id_proveedor,
        'tipo' => $tipo,
        'tipo2' => $tipo2,
        'nombre_proveedor' => $nombre_proveedor,
        'direccion_proveedor' => $direccion_proveedor,
        'telefono_proveedor' => $telefono_proveedor,
        'id_representante_legal' => $id_representante_legal,
        'nombre_representante_legal' => $nombre_representante_legal,
        'telefono_representante_legal' => $telefono_representante_legal
    ]);

            try {

            // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
            $resultado = $controller->manejarAccion('agregar', $proveedor);
        

            //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
            if (isset($resultado['status']) && $resultado['status'] === true) {
                //usar mensaje dinámico del modelo
                setSuccess($resultado['msj']);

            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Agregar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Proveedor: $nombre_proveedor"
            ]);
            $bitacora->setBitacoraData($bitacora_data);
            $bitacora->Guardar_Bitacora();
        } else {
            // Error: usar mensaje dinámico o genérico
            $mensajeError = $resultado['msj'] ?? "ERROR AL REGISTRAR...";
            setError($mensajeError);
        }
    } catch (Exception $e) {
        //mensajes del expcecion del pdo 
        error_log("Error al registrar: " . $e->getMessage());
        setError("Error en operación");
    }
    
    header("Location: index.php?action=proveedor&a=d"); // Redirect
    exit();
}
// Función para obtener un Proveedor
 {
    
    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    //if ($usuario->verificarPermiso($modulo, "Consultar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

        $id_proveedor = $_GET['id_proveedor'];
        if (!filter_var($id_Proveedor, FILTER_VALIDATE_INT)) {
            setError("ID inválido");
            header("Location: index.php?action=proveedor&a=d");
            exit();
        }

        $accion="obtener";
        $proveedor=$controller->manejarAccion("obtener",$id_proveedor);
        echo json_encode($proveedor);
    //}
    //muestra un modal de info que dice acceso no permitido
    //setError("Error accion no permitida ");
    //require_once 'views/php/dashboard_Proveedor.php';
    //exit();
}
//muestra un modal de info que dice acceso no permitido
setError("Error accion no permitida ");
require_once 'views/php/dashboard_proveedor.php';
exit();
}

function obtenerProveedor($controller, $bitacora, $usuario, $modulo) {
    $id_proveedor = $_GET['id_proveedor'];
    if (!filter_var($id_proveedor, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=proveedor&a=d");
        exit();
    }

    $accion = "obtener";
    $proveedor = $controller->manejarAccion('obtener', $id_proveedor);
    echo json_encode($proveedor);
}

function actualizarCliente($controller, $bitacora, $usuario, $modulo) {

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "Modificar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

    // Sanitiza y valida datos
    $id_proveedor = filter_input(INPUT_POST, 'id_proveedor', FILTER_VALIDATE_INT);
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tipo2 = filter_input(INPUT_POST, 'tipo2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombre_proveedor = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $direccion_proveedor = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $telefono_proveedor = filter_input(INPUT_POST, 'codigo_tlf', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . filter_input(INPUT_POST, 'numero_tlf', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id_representante_legal = filter_input(INPUT_POST, 'id_representante', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombre_representante_legal = filter_input(INPUT_POST, 'nombre_representante', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $telefono_representante_legal = filter_input(INPUT_POST, 'codigo_tlf_representante', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . filter_input(INPUT_POST, 'numero_tlf_representante', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($nombre_proveedor) || empty($direccion_proveedor) || empty($telefono_proveedor) || empty($nombre_representante_legal)) {
        setError("Todos los campos son requeridos");
        header("Location: index.php?action=proveedor&a=d");
        exit();
    }

    if (strlen($nombre_proveedor) > 100 || strlen($direccion_proveedor) > 200 || strlen($telefono_proveedor) > 20 || strlen($nombre_representante_legal) > 100) {
        setError("Límite de caracteres excedido");
        header("Location: index.php?action=proveedor&a=d");
        exit();
    }

    $proveedor = json_encode([
        'id_proveedor' => $id_proveedor,
        'tipo' => $tipo,
        'tipo2' => $tipo2,
        'nombre_proveedor' => $nombre_proveedor,
        'direccion_proveedor' => $direccion_proveedor,
        'telefono_proveedor' => $telefono_proveedor,
        'id_representante_legal' => $id_representante_legal,
        'nombre_representante_legal' => $nombre_representante_legal,
        'telefono_representante_legal' => $telefono_representante_legal
    ]);

    try {

        // Llama a la funcion manejarAccion del modelo donde pasa el objeto Proveedor y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
        $resultado = $controller->manejarAccion('actualizar', $proveedor);
           

        //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
        if (isset($resultado['status']) && $resultado['status'] === true) {
            //usar mensaje dinámico del modelo
            setSuccess($resultado['msj']);
            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Modificar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Proveedor: $nombre_proveedor"
            ]);
            $bitacora->setBitacoraData($bitacora_data);
            $bitacora->Guardar_Bitacora();
        } else {
            // Error: usar mensaje dinámico o genérico
            $mensajeError = $resultado['msj'] ?? "ERROR AL ACTUALIZAR...";
            setError($mensajeError);
        }
    } catch (Exception $e) {
        //mensajes del expcecion del pdo 
        error_log("Error al actualizar: " . $e->getMessage());
        setError("Error en operación");
    }

    header("Location: index.php?action=proveedor&a=d");
    exit();
}
}

// Función para eliminar un cliente
function eliminarProveedor($controller, $bitacora, $usuario, $modulo) {

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "Eliminar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

    $id_proveedor = $_GET['ID'];
    if (!filter_var($id_proveedor, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=proveedor&a=d");
        exit();
    }

    // Obtener los valores de proveedor antes de eliminar
    $accion = "obtener";
    $proveedor = $controller->manejarAccion($accion, $id_proveedor);
    
    if (!$proveedor) {
        setError("El registro no existe");
        header("Location: index.php?action=proveedor&a=d");
        exit();
    }

    $nombre_proveedor = $proveedor['nombre_proveedor'];

try {

        // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
        $resultado = $controller->manejarAccion('eliminar', $id_proveedor);
           

        //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
        if (isset($resultado['status']) && $resultado['status'] === true) {
            //usar mensaje dinámico del modelo
            setSuccess($resultado['msj']);

            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Eliminar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Proveedor: $nombre_proveedor"
            ]);
            $bitacora->setBitacoraData($bitacora_data);
            $bitacora->Guardar_Bitacora();
        } else {
            // Error: usar mensaje dinámico o genérico
            $mensajeError = $resultado['msj'] ?? "ERROR AL ELIMINAR...";
            setError($mensajeError);
        }
    } catch (Exception $e) {
        //mensajes del expcecion del pdo 
        error_log("Error al eliminar: " . $e->getMessage());
        setError("Error en operación");
    }
    
    header("Location: index.php?proveedor&a=d");
    exit();
    }
}
// Función para consultar proveedores
function consultarProveedor($controller, $usuario, $modulo) {

    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {

        // Ejecutar acción permitida
        $proveedor =$controller->manejarAccion("consultar",null);
        require_once 'views/php/dashboard_proveedor.php';
        exit();
    }
    else{

        //muestra un modal de info que dice acceso no permitido
        setError("Error accion no permitida ");
        require_once 'views/php/dashboard_proveedor.php';
        exit(); 
    } 
}
?>
