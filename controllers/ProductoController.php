<?php
// Incluye el archivo del modelo Producto
require_once "models/Producto.php";

$controller = new Producto();

$message2="";
$message3="";

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    // Obtiene los valores del formulario y los sanitiza
    $id_producto = htmlspecialchars($_POST['id_producto']);
    $nombre_producto = htmlspecialchars($_POST['nombre']);
    $fecha_registro = htmlspecialchars($_POST['fecha_registro']);
    $presentacion = htmlspecialchars($_POST['presentacion']);
    $fech_vencimiento = htmlspecialchars($_POST['fech_venci']);
    $cantidad_producto = htmlspecialchars($_POST['cantidad']);
    $cantidad_producto2 = htmlspecialchars($_POST['cantidad2']);
    $cantidad_producto3 = htmlspecialchars($_POST['cantidad3']);
    $precio_producto = htmlspecialchars($_POST['precio']);
    $precio_producto2 = htmlspecialchars($_POST['precio2']);
    $precio_producto3 = htmlspecialchars($_POST['precio3']);
    $uni_medida = htmlspecialchars($_POST['uni_medida']);
    $uni_medida2 = htmlspecialchars($_POST['uni_medida2']);
    $uni_medida3 = htmlspecialchars($_POST['uni_medida3']);
    $peso = htmlspecialchars($_POST['peso']);
    $peso2 = $peso / $peso;
    $peso3 = htmlspecialchars($_POST['peso3']);

    $controller->setProductoData($id_producto, $nombre_producto, $presentacion, $fech_vencimiento, $fecha_registro, $cantidad_producto, $cantidad_producto2, $cantidad_producto3, $precio_producto, $precio_producto2, $precio_producto3, $uni_medida, $uni_medida2, $uni_medida3, $id_actualizacion, $peso, $peso2, $peso3);
    // Llama al método guardarPersona del controlador y guarda el resultado en $message
    if($controller->Guardar_Producto())
    {
        $message3 = "PRODUCTO AGREGADO CORRECTAMENTE"; // Establece el mensaje de éxito
        echo "<script>
            if (confirm('$message3')) {
                // Si el usuario acepta, permanece en el formulario
                window.location.href = 'crud_producto.php?action=formulario'; // Usar variable PHP
            } else {
                // Si el usuario cancela, redirige al dashboard
                window.location.href = 'crud_producto.php'; // Usar variable PHP
            }
          </script>";
    } else {
        $message3 = "ERROR AL AGREGAR EL PRODUCTO"; // Establece el mensaje de error
    }require_once "views/php/dashboard_producto.php";
}
elseif ($action == "formulario" && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    require_once "views/php/form_producto.php";
    
}
elseif ($action == "formulario2" && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    require_once "views/php/form2__producto.php";
    
}
elseif ($action == 'mid_form' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_producto = $_GET['id_producto'];
    require_once "views/php/form_mid_producto.php";
    // Llama al controlador para mostrar el formulario de modificación
    $producto=$controller->Obtener_Producto($id_producto);
}
else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario y los sanitiza 
    $id_producto = htmlspecialchars($_POST['id_producto']);
    $nombre_producto = htmlspecialchars($_POST['nombre']);
    $presentacion = htmlspecialchars($_POST['presentacion']);
    $fech_vencimiento = htmlspecialchars($_POST['fecha_vencimiento']);
    $cantidad_producto = htmlspecialchars($_POST['cantidad']);
    $cantidad_producto2 = htmlspecialchars($_POST['cantidad2']);
    $cantidad_producto3 = htmlspecialchars($_POST['cantidad3']);
    $precio_producto = htmlspecialchars($_POST['precio']);
    $precio_producto2 = htmlspecialchars($_POST['precio2']);
    $precio_producto3 = htmlspecialchars($_POST['precio3']);
    $uni_medida = htmlspecialchars($_POST['uni_medida']);
    $uni_medida2 = htmlspecialchars($_POST['uni_medida2']);
    $uni_medida3 = htmlspecialchars($_POST['uni_medida3']);
    $id_actualizacion = htmlspecialchars($_POST['id_actualizacion']);
    $peso = htmlspecialchars($_POST['peso']);
    $peso2 = $peso / $peso;
    $peso3 = $peso2 * 1000;

    $controller->setProductoData($id_producto, $nombre_producto, $presentacion, $fech_vencimiento, null, $cantidad_producto, $cantidad_producto2, $cantidad_producto3, $precio_producto, $precio_producto2, $precio_producto3, $uni_medida, $uni_medida2, $uni_medida3, $id_actualizacion, $peso, $peso2, $peso3);
    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if($controller->Actualizar_Producto()) 
    { 
        $message2 = "PRODUCTO ACTUALIZADO CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $message2 = "ERROR AL ACTUALIZAR EL PRODUCTO"; // Establece el mensaje de error
    }

    // Vuelve a cargar el formulario con el mensaje
    require_once "views/php/dashboard_producto.php";
    
}
elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_producto = $_GET['id_producto'];

    $controller->setProductoData($id_producto, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null,null);
    // Llama al controlador para mostrar el formulario de modificación
    $producto=$controller->Eliminar_Producto($id_producto);
    if($producto) 
    { 
        $message = "PRODUCTO ELIMINADO CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $message = "ERROR AL ELIMINAR EL PRODUCTO"; // Establece el mensaje de error
    }
    require_once "views/php/dashboard_producto.php";
}
else
{
    require_once "views/php/dashboard_producto.php";
}

?>