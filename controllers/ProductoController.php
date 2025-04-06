<?php
// Incluye el archivo del modelo Producto
require_once "models/Producto.php";
require_once 'models/Bitacora.php';

$controller = new Producto();
$bitacora = new Bitacora();
$modulo = 'Producto';
date_default_timezone_set('America/Caracas');

require_once "views/php/utils.php";

// Verifica si el usuario está logueado y tiene permisos
/*if (!isset($_SESSION['s_usuario'])) {
    setError("Acceso no autorizado");
    header("Location: index.php");
    exit();
}*/

$action = isset($_GET['a']) ? $_GET['a'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitiza y valida datos
    $id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombre_producto = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $presentacion = filter_input(INPUT_POST, 'presentacion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fecha_vencimiento = filter_input(INPUT_POST, 'fecha_vencimiento', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cantidad_producto = filter_input(INPUT_POST, 'cantidad', FILTER_SANITIZE_NUMBER_INT);
    $precio_producto = filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $uni_medida = filter_input(INPUT_POST, 'uni_medida', FILTER_SANITIZE_NUMBER_INT);
    $uni_medida2 = filter_input(INPUT_POST, 'uni_medida2', FILTER_SANITIZE_NUMBER_INT);
    $uni_medida3 = filter_input(INPUT_POST, 'uni_medida3', FILTER_SANITIZE_NUMBER_INT);
    $peso = filter_input(INPUT_POST, 'peso', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $imagen = $_FILES['imagen'];
    
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];

        // Validación básica de la imagen
        $tipoArchivo = pathinfo($imagen['name'], PATHINFO_EXTENSION);
        $tiposPermitidos = array('jpg', 'jpeg', 'png', 'gif');

        if (!in_array(strtolower($tipoArchivo), $tiposPermitidos)) {
            setError("Sólo se permiten archivos de tipo JPG, JPEG, PNG y GIF.");
            header("Location: index.php?action=producto&a=d");
            exit();
        }
    


        // Validación básica de la imagen
        if (!empty($imagen['name'])) {
            $tipoArchivo = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $tiposPermitidos = array('jpg', 'jpeg', 'png', 'gif');
    
            if (!in_array(strtolower($tipoArchivo), $tiposPermitidos)) {
                setError("Sólo se permiten archivos de tipo JPG, JPEG, PNG y GIF.");
                header("Location: index.php?action=producto&a=d");
                exit();
            }
        }

     // Subir la imagen al directorio destino
     $directorioSubida = 'views/img/productos/'; // Asegúrate de que este directorio exista y tenga permisos de escritura
 
     if (!empty($imagen['name'])) {
         $nombreArchivo = basename($imagen['name']);
         $rutaSubida = $directorioSubida . $nombreArchivo;
 
         if (move_uploaded_file($imagen['tmp_name'], $rutaSubida)) {
             // La imagen se ha subido correctamente
             $imagenProducto = $rutaSubida; // Guarda el nombre de la imagen para usarlo en la base de datos
         } else {
             setError("Error al subir la imagen.");
             header("Location: index.php?action=producto&a=d");
             exit();
         }
     } 
    } else {
         $imagenProducto = ''; // Si no se sube imagen, deja este campo vacío
     }

    // Validar que los campos obligatorios no estén vacíos
    if (empty($nombre_producto) || empty($presentacion) || empty($fecha_vencimiento) || empty($cantidad_producto) || empty($precio_producto) || empty($uni_medida)) {
        setError("Todos los campos son requeridos");
        header("Location: index.php?action=producto&a=d");
        exit();
    }
    
    // Validar que los valores numéricos sean válidos
    if (!is_numeric($cantidad_producto) || !is_numeric($precio_producto)) {
        setError("La cantidad y el precio deben ser valores numéricos válidos");
        header("Location: index.php?action=producto&a=d");
        exit();
    }

    // Obtiene los valores del formulario y los sanitiza
    $peso = htmlspecialchars($_POST['peso']);
    $peso2 = $peso / $peso;
    $peso3 = $peso2 * 1000;

    $producto = json_encode([
        'id_producto' => $id_producto,
        'nombre_producto' => $nombre_producto,
        'presentacion' => $presentacion,
        'fecha_vencimiento' => $fecha_vencimiento,
        'cantidad_producto' => $cantidad_producto,
        'precio_producto' => $precio_producto,
        'uni_medida' => $uni_medida,
        'uni_medida2' => $uni_medida2,
        'uni_medida3' => $uni_medida3,
        'peso' => $peso,
        'peso2' => $peso2,
        'peso3' => $peso3,
        'imagen' => $rutaSubida
    ]);
    echo $producto;
    $accion = "agregar";
    $controller->manejarAccion($accion, $producto);
    try {
        if ($controller) {
            setSuccess("REGISTRADO CORRECTAMENTE");
            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Agregar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Producto: $nombre_producto"
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

    header("Location: index.php?action=producto&a=d");
    exit();
}
elseif ($action == "agregar2" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitiza y valida datos
    $id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombre_producto = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fecha_registro = filter_input(INPUT_POST, 'fecha_registro', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $presentacion = filter_input(INPUT_POST, 'presentacion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fecha_vencimiento = filter_input(INPUT_POST, 'fecha_vencimiento', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cantidad_producto = filter_input(INPUT_POST, 'cantidad', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $precio_producto = filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $uni_medida = filter_input(INPUT_POST, 'uni_medida', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $imagen = $_FILES['imagen'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];

        // Validación básica de la imagen
        $tipoArchivo = pathinfo($imagen['name'], PATHINFO_EXTENSION);
        $tiposPermitidos = array('jpg', 'jpeg', 'png', 'gif');

        if (!in_array(strtolower($tipoArchivo), $tiposPermitidos)) {
            setError("Sólo se permiten archivos de tipo JPG, JPEG, PNG y GIF.");
            header("Location: index.php?action=producto&a=d");
            exit();
        }
    


        // Validación básica de la imagen
        if (!empty($imagen['name'])) {
            $tipoArchivo = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $tiposPermitidos = array('jpg', 'jpeg', 'png', 'gif');
    
            if (!in_array(strtolower($tipoArchivo), $tiposPermitidos)) {
                setError("Sólo se permiten archivos de tipo JPG, JPEG, PNG y GIF.");
                header("Location: index.php?action=producto&a=d");
                exit();
            }
        }

     // Subir la imagen al directorio destino
     $directorioSubida = 'views/img/productos/'; // Asegúrate de que este directorio exista y tenga permisos de escritura
 
     if (!empty($imagen['name'])) {
         $nombreArchivo = basename($imagen['name']);
         $rutaSubida = $directorioSubida . $nombreArchivo;
 
         if (move_uploaded_file($imagen['tmp_name'], $rutaSubida)) {
             // La imagen se ha subido correctamente
             $imagenProducto = $rutaSubida; // Guarda el nombre de la imagen para usarlo en la base de datos
         } else {
             setError("Error al subir la imagen.");
             header("Location: index.php?action=producto&a=d");
             exit();
         }
     } 
    } else {
         $imagenProducto = ''; // Si no se sube imagen, deja este campo vacío
     }

    if (empty($nombre_producto) || empty($presentacion) || empty($fecha_vencimiento) || empty($cantidad_producto) || empty($precio_producto) || empty($uni_medida)) {
        setError("Todos los campos son requeridos");
        header("Location: index.php?action=producto&a=d");
        exit();
    }

    $producto = json_encode([
        'id_producto' => $id_producto,
        'nombre_producto' => $nombre_producto,
        'fecha_registro' => $fecha_registro,
        'presentacion' => $presentacion,
        'fecha_vencimiento' => $fecha_vencimiento,
        'cantidad_producto' => $cantidad_producto,
        'precio_producto' => $precio_producto,
        'uni_medida' => $uni_medida,
        'imagen' => $rutaSubida
    ]);

    $accion = "agregar2";
    $controller->manejarAccion($accion, $producto);
    try {
        if ($controller) {
            setSuccess("REGISTRADO CORRECTAMENTE");
            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Agregar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Producto: $nombre_producto"
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

    header("Location: index.php?action=producto&a=d");
    exit();

}

elseif ($action == 'mid_form' && $_SERVER["REQUEST_METHOD"] == "GET") {
    $id_producto = $_GET['id_producto'];
    if (!filter_var($id_producto, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=producto&a=d");
        exit();
    }

    $accion = "obtener";
    $producto = $controller->manejarAccion($accion, $id_producto);
    echo json_encode($producto);
}

else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitiza y valida datos
    $id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
    $nombre_producto = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $presentacion = filter_input(INPUT_POST, 'presentacion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fecha_vencimiento = filter_input(INPUT_POST, 'fecha_vencimiento', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cantidad_producto = filter_input(INPUT_POST, 'cantidad', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $precio_producto = filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $uni_medida = filter_input(INPUT_POST, 'uni_medida', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id_actualizacion = filter_input(INPUT_POST, 'id_actualizacion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $peso = filter_input(INPUT_POST, 'peso', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($nombre_producto) || empty($presentacion) || empty($fecha_vencimiento) || empty($cantidad_producto) || empty($precio_producto) || empty($uni_medida)) {
        setError("Todos los campos son requeridos");
        header("Location: index.php?action=producto&a=d");
        exit();
    }

    $producto = json_encode([
        'id_producto' => $id_producto,
        'nombre_producto' => $nombre_producto,
        'presentacion' => $presentacion,
        'fecha_vencimiento' => $fecha_vencimiento,
        'cantidad_producto' => $cantidad_producto,
        'precio_producto' => $precio_producto,
        'uni_medida' => $uni_medida,
        'id_actualizacion' => $id_actualizacion,
        'peso' => $peso
    ]);

    $accion = "actualizar";
    $controller->manejarAccion($accion, $producto);
    try {
        if ($controller) {
            setSuccess("ACTUALIZADO CORRECTAMENTE");
            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Modificar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Producto: $nombre_producto"
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

    header("Location: index.php?action=producto&a=d");
    exit();
}

elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    $id_producto = $_GET['id_producto'];
    if (!filter_var($id_producto, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=producto&a=d");
        exit();
    }

    // Obtener los valores de nombre_producto antes de eliminar
    $accion = "obtener";
    $producto = $controller->manejarAccion($accion, $id_producto);
    
    if (!$producto) {
        setError("El registro no existe");
        header("Location: index.php?action=producto&a=d");
        exit();
    }

    $nombre_producto = $producto['nombre'];

    $accion = "eliminar";
    $controller->manejarAccion($accion, $id_producto);
    try {
        if ($controller) {
            setSuccess("ELIMINADO CORRECTAMENTE");
            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Eliminar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Producto: $nombre_producto"
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

    header("Location: index.php?action=producto&a=d");
    exit();
}

if ($action == 'd') {
    require_once 'views/php/dashboard_producto.php';
}
?>