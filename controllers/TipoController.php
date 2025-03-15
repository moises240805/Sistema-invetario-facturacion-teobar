<?php
// Incluye el archivo del modelo Producto
require_once "models/Tipo.php";

$controller = new Tipo();

$message2="";
$message3="";

$action = isset($_GET['a']) ? $_GET['a'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST")
{ 
    $tipo = json_encode([
        'tipo_producto' => htmlspecialchars($_POST['tipo_producto']),
        'presentacion' => htmlspecialchars($_POST['presentacion'])
    ]);


    $controller->setPresentacionData($tipo);
    if($controller->Guardar_Tipo($tipo))
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "REGISTRADO CORRECTAMENTE";
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL REGISTRAR...";
    }
    
    header("Location: index.php?action=tipo&a=t"); // Redirect
    exit();
}
elseif($action == "mid_form" && $_SERVER["REQUEST_METHOD"] == "GET")
{
    $id_presentacion = $_GET['id_presentacion'];
    $tipo=$controller->Obtener_Tipo($id_presentacion);
    echo json_encode($tipo);
}
else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario y los sanitiza
    $tipo = json_encode([
        'id_presentacion' => htmlspecialchars($_POST['id_presentacion']),
        'tipo_producto' => htmlspecialchars($_POST['tipo_producto']),
        'presentacion' => htmlspecialchars($_POST['presentacion'])
    ]);

    $controller->setPresentacionData($tipo);
    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if ($controller->Actualizar_Tipo($tipo))
        {
            $_SESSION['message_type'] = 'success';  // Set success flag
            $_SESSION['message'] = "ACTUALIZADO CORRECTAMENTE";
        } else {
            $_SESSION['message_type'] = 'danger'; // Set error flag
            $_SESSION['message'] = "ERROR AL ACTUALIZAR...";
        }
        
        header("Location: index.php?action=tipo&a=t"); // Redirect
        exit();
}
elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_presentacion = $_GET['id_presentacion'];

    $controller->setPresentacionData($id_presentacion);
    // Llama al controlador para mostrar el formulario de modificación
    $tipo=$controller->Eliminar_Tipo($id_presentacion);
    if($tipo) 
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "ELIMINADO CORRECTAMENTE";
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL ELIMINAR...";
    }
    
    header("Location: index.php?action=tipo&a=t"); // Redirect
    exit();
}
if ($action == 't') {

    require_once 'views/php/dashboard_tipo.php';
}
?>