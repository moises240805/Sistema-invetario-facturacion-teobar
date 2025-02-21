<?php
// Incluye el archivo del modelo Producto
require_once "models/Tipo.php";

$controller = new Tipo();

$message2="";
$message3="";

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST")
{ 
    $tipo_producto = htmlspecialchars($_POST['tipo_producto']);
    $presentacion = htmlspecialchars($_POST['presentacion']);


    $controller->setPresentacionData($id_presentacion, $tipo_producto, $presentacion);
    if($controller->Guardar_Tipo())
    {
        $message3 = "PRODUCTO REGISTRADO CORRECTAMENTE"; // Establece el mensaje de éxito
        echo "<script>
            if (confirm('$message3')) {
                // Si el usuario acepta, permanece en el formulario
                window.location.href = 'crud_tipo.php?action=formulario'; // Usar variable PHP
            } else {
                // Si el usuario cancela, redirige al dashboard
                window.location.href = 'crud_tipo.php'; // Usar variable PHP
            }
          </script>";
    } else {
        $message3 = "ERROR AL REGISTRAR EL PRODUCTO"; // Establece el mensaje de error
    }require_once "views/php/dashboard_tipo.php";
}
elseif($action == "formulario" && $_SERVER["REQUEST_METHOD"] == "GET")
{
    require_once 'views/php/form_tipo.php';
}
elseif($action == "mid_form" && $_SERVER["REQUEST_METHOD"] == "GET")
{
    $id_presentacion = $_GET['id_presentacion'];
    require_once 'views/php/form_mid_tipo.php';
    $tipo=$controller->Obtener_Tipo($id_presentacion);
}
else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario y los sanitiza
    $id_presentacion = htmlspecialchars($_POST['id_presentacion']); // Asegúrate de obtener el ID
    $tipo_producto = htmlspecialchars($_POST['tipo_producto']); 
    $presentacion = htmlspecialchars($_POST['presentacion']); 

    $controller->setPresentacionData($id_presentacion, $tipo_producto, $presentacion);
    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if ($controller->Actualizar_Tipo()) { 
        $message2 = "ACTUALIZADO CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $message2 = "ERROR AL ACTUALIZAR"; // Establece el mensaje de error
    }

    // Vuelve a cargar el formulario con el mensaje
    require_once "views/php/dashboard_tipo.php";
}
elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_presentacion = $_GET['id_presentacion'];

    $controller->setPresentacionData($id_presentacion, null, null);
    // Llama al controlador para mostrar el formulario de modificación
    $tipo=$controller->Eliminar_Tipo($id_presentacion);
    if($tipo) 
    { 
        $message = "ELIMINADO CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $message = "ERROR AL ELIMINAR"; // Establece el mensaje de error
    }
    require_once "views/php/dashboard_tipo.php";
}
else{
    require_once 'views/php/dashboard_tipo.php';
}
?>