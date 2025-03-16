<?php
// Incluye el archivo del modelo Producto
require_once "models/Producto.php";

$controller = new Producto();

$message2="";
$message3="";

$action = isset($_GET['a']) ? $_GET['a'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    // Obtiene los valores del formulario y los sanitiza
    $peso = htmlspecialchars($_POST['peso']);
    $peso2 = $peso / $peso;
    $peso3 = $peso2 * 1000;
    $producto = json_encode([
        'id_producto' => htmlspecialchars($_POST['id_producto']),
        'nombre_producto' => htmlspecialchars($_POST['nombre']),
        'fecha_registro' => htmlspecialchars($_POST['fecha_registro']),
        'presentacion' => htmlspecialchars($_POST['presentacion']),
        'fecha_vencimiento' => htmlspecialchars($_POST['fecha_vencimiento']),
        'cantidad_producto' => htmlspecialchars($_POST['cantidad']),
        'cantidad_producto2' => htmlspecialchars($_POST['cantidad2']),
        'cantidad_producto3' => htmlspecialchars($_POST['cantidad3']),
        'precio_producto' => htmlspecialchars($_POST['precio']),
        'precio_producto2' => htmlspecialchars($_POST['precio2']),
        'precio_producto3' => htmlspecialchars($_POST['precio3']),
        'uni_medida' => htmlspecialchars($_POST['uni_medida']),
        'uni_medida2' => htmlspecialchars($_POST['uni_medida2']),
        'uni_medida3' => htmlspecialchars($_POST['uni_medida3']),
        'peso' => htmlspecialchars($_POST['peso']),
        'peso2' => htmlspecialchars($peso2),
        'peso3' => htmlspecialchars($_POST['peso3'])
    ]);

    $controller->setProductoData($producto);
    // Llama al método guardarPersona del controlador y guarda el resultado en $message
    if($controller->Guardar_Producto($producto))
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "REGISTRADO CORRECTAMENTE";
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL REGISTRAR... USUARIO EXISTENTE";
    }    header("Location: index.php?action=producto&a=d"); // Redirect
    exit();
}
elseif ($action == "agregar2" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    // Obtiene los valores del formulario y los sanitiza
    $producto = json_encode([
        'id_producto' => htmlspecialchars($_POST['id_producto']),
        'nombre_producto' => htmlspecialchars($_POST['nombre']),
        'fecha_registro' => htmlspecialchars($_POST['fecha_registro']),
        'presentacion' => htmlspecialchars($_POST['presentacion']),
        'fecha_vencimiento' => htmlspecialchars($_POST['fecha_vencimiento']),
        'cantidad_producto' => htmlspecialchars($_POST['cantidad']),
        'precio_producto' => htmlspecialchars($_POST['precio']),
        'uni_medida' => htmlspecialchars($_POST['uni_medida']),

    ]);

    $controller->setProductoData($producto);
    // Llama al método guardarPersona del controlador y guarda el resultado en $message
    if($controller->Guardar_Producto2($producto))
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "REGISTRADO CORRECTAMENTE";
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL REGISTRAR... USUARIO EXISTENTE";
    }    header("Location: index.php?action=producto&a=d"); // Redirect
    exit();
}
elseif ($action == 'mid_form' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_producto = $_GET['id_producto'];
    // Llama al controlador para mostrar el formulario de modificación
    $producto=$controller->Obtener_Producto($id_producto);
    header('Content-Type: application/json');
    echo json_encode($producto);
}
else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario y los sanitiza 
    $producto = json_encode([
        'id_producto' => htmlspecialchars($_POST['id_producto']),
        'nombre_producto' => htmlspecialchars($_POST['nombre']),
        'presentacion' => htmlspecialchars($_POST['presentacion']),
        'fecha_vencimiento' => htmlspecialchars($_POST['fecha_vencimiento']),
        'cantidad_producto' => htmlspecialchars($_POST['cantidad']),
        'cantidad_producto2' => htmlspecialchars($_POST['cantidad2']),
        'cantidad_producto3' => htmlspecialchars($_POST['cantidad3']),
        'precio_producto' => htmlspecialchars($_POST['precio']),
        'precio_producto2' => htmlspecialchars($_POST['precio2']),
        'precio_producto3' => htmlspecialchars($_POST['precio3']),
        'uni_medida' => htmlspecialchars($_POST['uni_medida']),
        'uni_medida2' => htmlspecialchars($_POST['uni_medida2']),
        'uni_medida3' => htmlspecialchars($_POST['uni_medida3']),
        'id_actualizacion' => htmlspecialchars($_POST['id_actualizacion']),
        'peso' => htmlspecialchars($_POST['peso']),
        'peso2' => htmlspecialchars($_POST['peso'] / $_POST['peso']),
        'peso3' => htmlspecialchars($_POST['peso3'])
    ]);

    $controller->setProductoData($producto);
    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if($controller->Actualizar_Producto()) 
    { 
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "ACTUALIZADO CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL ACTUALIZAR EL PRODUCTO"; // Establece el mensaje de error
    }
     header("Location: index.php?action=producto&a=d"); // Redirect
    exit();
    
}
elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_producto = $_GET['id_producto'];
    // Llama al controlador para mostrar el formulario de modificación
    $producto=$controller->Eliminar_Producto($id_producto);
    if($producto) 
    { 
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "ELIMINADO CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL ELIMINAR EL PRODUCTO"; // Establece el mensaje de error
    }
     header("Location: index.php?action=producto&a=d"); // Redirect
    exit();
}
elseif ($action == 'd' && $_SERVER["REQUEST_METHOD"] == "GET") {

    require_once 'views/php/dashboard_producto.php';
}

?>