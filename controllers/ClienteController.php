<?php

require_once 'models/Cliente.php';
require_once 'models/Bitacora.php';
$controller = new Cliente();

$bitacora = new Bitacora();
$modulo = 'Cliente';
date_default_timezone_set('America/Caracas');

// Función para generar mensaje de error
function setError($message) {
    $_SESSION['message_type'] = 'danger';
    $_SESSION['message'] = $message;
}

// Función para generar mensaje de éxito
function setSuccess($message) {
    $_SESSION['message_type'] = 'success';
    $_SESSION['message'] = $message;
}

// Verifica si el usuario está logueado y tiene permisos
if (!isset($_SESSION['s_usuario']) || $_SESSION['s_usuario']['rol'] != 'Administrador') {
    setError("Acceso no autorizado");

}

$action = isset($_GET['a']) ? $_GET['a'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    // Obtiene los valores del formulario y los sanitiza
    $tipo_id = filter_input(INPUT_POST, 'tipo_cliente', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id_cliente = filter_input(INPUT_POST, 'id_cliente', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombre_cliente = filter_input(INPUT_POST, 'nombre_cliente', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $telefono = filter_input(INPUT_POST, 'codigo_tlf', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($tipo_id) || empty($id_cliente) || empty($nombre_cliente) || empty($telefono) || empty($direccion) || empty($email)) {
        setError("Todos los campos son requeridos");
        header("Location: index.php?action=cliente&a=d");
        exit();
    }

    $cliente = json_encode([
        'tipo_id' => $tipo_id,
        'id_cliente' => $id_cliente,
        'nombre_cliente' => $nombre_cliente,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'email' => $email
    ]);
    $accion = "agregar";
    $controller->manejarAccion($accion, $cliente);
    try {
        if ($controller) {
            setSuccess("REGISTRADO CORRECTAMENTE");
            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Agregar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Cliente con la cedula: ".$_POST['tipo_cliente']." ".$_POST['id_cliente']
            ]);
            $bitacora->setBitacoraData($bitacora_data);
            $bitacora->Guardar_Bitacora();            
        } else {
           setError("ERROR AL REGISTRAR...");
        }
    } catch (Exception $e) {
        error_log("Error al registrar: " . $e->getMessage());
        setError("Error en operación");
    }
    
    header("Location: index.php?action=cliente&a=d"); // Redirect
    exit();
}
elseif ($action == 'mid_form' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_cliente = $_GET['id_cliente'];
    if (!filter_var($id_cliente, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=cliente&a=d");
        exit();
    }

    $accion="obtener";
    $cliente=$controller->manejarAccion($accion,$id_cliente);
    echo json_encode($cliente);
}
else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario y los sanitiza 
    $id_cliente = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
    $tipo_id = filter_input(INPUT_POST, 'tipo_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombre_cliente = filter_input(INPUT_POST, 'nombre_cliente', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $telefono = filter_input(INPUT_POST, 'codigo_tlf', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($nombre_cliente) || empty($telefono) || empty($direccion) || empty($email)) {
        setError("Todos los campos son requeridos");
        header("Location: index.php?action=cliente&a=d");
        exit();
    }

    if (strlen($nombre_cliente) > 30 || strlen($telefono) > 12 || strlen($direccion) > 200 || strlen($email) > 100) {
        setError("Límite de caracteres excedido");
        header("Location: index.php?action=cliente&a=d");
        exit();
    }

    $cliente = json_encode([
        'id_cliente' => $id_cliente,
        'tipo_id' => $tipo_id,
        'nombre_cliente' => $nombre_cliente,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'email' => $email
    ]);
    
    $accion = "actualizar";
    $controller->manejarAccion($accion, $cliente);
    try {
        if ($controller->manejarAccion($accion, $cliente)) {
            setSuccess("ACTUALIZADO CORRECTAMENTE");
            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Modificar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Cliente con la cedula: $tipo_id $id_cliente"
            ]);
            $bitacora->setBitacoraData($bitacora_data);
            $bitacora->Guardar_Bitacora();
        } else {
            setError("ERROR AL ACTUALIZAR...");
        }
    } catch (Exception $e) {
        error_log("Error al actualizar: " . $e->getMessage());
        setError("Error en operación");
    }

    header("Location: index.php?action=cliente&a=d");
    exit();
}

elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_cliente = $_GET['ID'];
    if (!filter_var($id_cliente, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=cliente&a=d");
        exit();
    }

    $accion = "obtener";
    $cliente = $controller->manejarAccion($accion, $id_cliente);
    
    if (!$cliente) {
        setError("El registro no existe");
        header("Location: index.php?action=cliente&a=d");
        exit();
    }

    $tipo_id = $cliente['tipo_id'];
    $nombre_cliente = $cliente['nombre_cliente'];

    $accion = "eliminar";
    $controller->manejarAccion($accion, $id_cliente);
    try {
        if ($controller) {
            setSuccess("ELIMINADO CORRECTAMENTE");
            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Eliminar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Cliente con la cedula: $tipo_id $id_cliente"
            ]);
            $bitacora->setBitacoraData($bitacora_data);
            $bitacora->Guardar_Bitacora();            
        } else {
            setError("ERROR AL ELIMINAR...");
        }
    } catch (Exception $e) {
        error_log("Error al eliminar: " . $e->getMessage());
        setError("Error en operación");
    }
    
    header("Location: index.php?action=cliente&a=d");
    exit();
}
elseif ($action == 'd' && $_SERVER["REQUEST_METHOD"] == "GET") {

    require_once 'views/php/dashboard_cliente.php';
}

?>