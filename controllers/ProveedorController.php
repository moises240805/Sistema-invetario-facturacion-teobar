<?php

require_once 'models/Proveedor.php';
require_once 'models/Bitacora.php';

$controller = new Proveedor();
$bitacora = new Bitacora();
$modulo = 'Proveedor';
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
    header("Location: index.php");
    exit();
}

$action = isset($_GET['a']) ? $_GET['a'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST") {
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

    $accion = "agregar";
    $controller->manejarAccion($accion, $proveedor);
    try {
        if ($controller) {
            setSuccess("REGISTRADO CORRECTAMENTE");
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
            setError("ERROR AL REGISTRAR...");
        }
    } catch (Exception $e) {
        error_log("Error al registrar: " . $e->getMessage());
        setError("Error en operación");
    }

    header("Location: index.php?action=proveedor&a=d");
    exit();
}

elseif ($action == 'mid_form' && $_SERVER["REQUEST_METHOD"] == "GET") {
    $id_proveedor = $_GET['id_proveedor'];
    if (!filter_var($id_proveedor, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=proveedor&a=d");
        exit();
    }

    $accion = "obtener";
    $proveedor = $controller->manejarAccion($accion, $id_proveedor);
    echo json_encode($proveedor);
}

else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
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

    $accion = "actualizar";
    $controller->manejarAccion($accion, $proveedor);
    try {
        if ($controller) {
            setSuccess("ACTUALIZADO CORRECTAMENTE");
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
            setError("ERROR AL ACTUALIZAR...");
        }
    } catch (Exception $e) {
        error_log("Error al actualizar: " . $e->getMessage());
        setError("Error en operación");
    }

    header("Location: index.php?action=proveedor&a=d");
    exit();
}

elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
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

    $accion = "eliminar";
    $controller->manejarAccion($accion, $id_proveedor);
    try {
        if ($controller) {
            setSuccess("ELIMINADO CORRECTAMENTE");
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
            setError("ERROR AL ELIMINAR...");
        }
    } catch (Exception $e) {
        error_log("Error al eliminar: " . $e->getMessage());
        setError("Error en operación");
    }

    header("Location: index.php?action=proveedor&a=d");
    exit();
}

if ($action == 'd') {
    require_once 'views/php/dashboard_proveedor.php';
}
?>
