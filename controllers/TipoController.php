<?php
// Incluye el archivo del modelo Producto
require_once "models/Tipo.php";
require_once 'models/Bitacora.php';

$controller = new Tipo();
$bitacora = new Bitacora();
$modulo = 'Tipo de Producto';
date_default_timezone_set('America/Caracas');



require_once "views/php/utils.php";

// Verifica si el usuario está logueado y tiene permisos
if (!isset($_SESSION['s_usuario']) || $_SESSION['s_usuario']['rol'] != 'Administrador') {
    setError("Acceso no autorizado");

}



$action = isset($_GET['a']) ? $_GET['a'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitiza y valida datos
    $tipo_producto = filter_input(INPUT_POST, 'tipo_producto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $presentacion = filter_input(INPUT_POST, 'presentacion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($tipo_producto) || empty($presentacion)) {
        setError("Todos los campos son requeridos");
        header("Location: index.php?action=tipo&a=t");
        exit();
    }

    if (strlen($tipo_producto) > 50 || strlen($presentacion) > 100) {
        setError("Límite de caracteres excedido");
        header("Location: index.php?action=tipo&a=t");
        exit();
    }


    $tipo = json_encode([
        'tipo_producto' => $tipo_producto,
        'presentacion' => $presentacion
    ]);
    $accion="agregar";
    $controller->manejarAccion($accion, $tipo);
    try {
        if ($controller) {
            setSuccess("REGISTRADO CORRECTAMENTE");
            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Agregar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Tipo producto: $tipo_producto Con presentacion: $presentacion"
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

    header("Location: index.php?action=tipo&a=t");
    exit();
}

elseif ($action == "mid_form" && $_SERVER["REQUEST_METHOD"] == "GET") {
    $id_presentacion = $_GET['id_presentacion'];
    if (!filter_var($id_presentacion, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=tipo&a=t");
        exit();
    }

    $accion="obtener";
    $tipo = $controller->manejarAccion($accion,$id_presentacion);
    echo json_encode($tipo);
}

else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitiza y valida datos
    $id_presentacion = filter_input(INPUT_POST, 'id_presentacion', FILTER_VALIDATE_INT);
    $tipo_producto = filter_input(INPUT_POST, 'tipo_producto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $presentacion = filter_input(INPUT_POST, 'presentacion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($tipo_producto) || empty($presentacion)) {
        setError("Todos los campos son requeridos");
        header("Location: index.php?action=tipo&a=t");
        exit();
    }

    if (strlen($tipo_producto) > 50 || strlen($presentacion) > 100) {
        setError("Límite de caracteres excedido");
        header("Location: index.php?action=tipo&a=t");
        exit();
    }


    $tipo = json_encode([
        'id_presentacion' => $id_presentacion,
        'tipo_producto' => $tipo_producto,
        'presentacion' => $presentacion
    ]);

    $accion="actualizar";
    $controller->manejarAccion($accion,$tipo);
    try {
        if ($controller) {
            setSuccess("ACTUALIZADO CORRECTAMENTE");
            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Modificar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Tipo producto: $tipo_producto Con presentacion: $presentacion"
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

    header("Location: index.php?action=tipo&a=t");
    exit();
}

elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    $id_presentacion = $_GET['id_presentacion'];
    if (!filter_var($id_presentacion, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=tipo&a=t");
        exit();
    }

    // Obtener los valores de tipo_producto y presentacion antes de eliminar
    $accion="obtener";
    $tipo = $controller->manejarAccion($accion,$id_presentacion);
    
    if (!$tipo) {
        setError("El registro no existe");
        header("Location: index.php?action=tipo&a=t");
        exit();
    }

    $tipo_producto = $tipo['tipo_producto'];
    $presentacion = $tipo['presentacion'];

    $accion="eliminar";
    $controller->manejarAccion($accion,$id_presentacion);
    try {
        if ($controller) {
            setSuccess("ELIMINADO CORRECTAMENTE");
            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Eliminar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Tipo producto: $tipo_producto Con presentacion: $presentacion"
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

    header("Location: index.php?action=tipo&a=t");
    exit();
}

elseif ($action == 't' && $_SERVER["REQUEST_METHOD"] == "GET") {
    require_once 'views/php/dashboard_tipo.php';
}
elseif ($action == 'd' && $_SERVER["REQUEST_METHOD"] == "GET") {

    $tipo =$controller->manejarAccion("consultar",null);

}
?>
