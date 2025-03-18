<?php
// Incluye el archivo del modelo Producto
require_once "models/Tipo.php";
require_once 'models/Bitacora.php';

$controller = new Tipo();
$bitacora = new Bitacora();
$message2="";
$message3="";

$modulo = 'Tipo de Producto';
date_default_timezone_set('America/Caracas');
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
        $bitacora->setBitacoraData($_SESSION['s_usuario']['id'], "Agregar", date('Y-m-d H:i:s'), $modulo, "Tipo de producto: ".$_POST['tipo_producto']." con presentacion: ".$_POST['presentacion']);
        $bitacora->Guardar_Bitacora();
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL REGISTRAR...";
    }
    
    header("Location: index.php?action=tipo&a=d"); // Redirect
    exit();
}
elseif($action == "formulario" && $_SERVER["REQUEST_METHOD"] == "GET")
{
    require_once 'views/php/form_tipo.php';
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
            $bitacora->setBitacoraData($_SESSION['s_usuario']['id'], "Actualizar", date('Y-m-d H:i:s'), $modulo, "Tipo de producto: ".$_POST['tipo_producto']." con id: ".$_POST['id_presentacion']);  
            $bitacora->Guardar_Bitacora();
            
        } else {
            $_SESSION['message_type'] = 'danger'; // Set error flag
            $_SESSION['message'] = "ERROR AL ACTUALIZAR...";
        }
        
        header("Location: index.php?action=tipo&a=d"); // Redirect
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
        $bitacora->setBitacoraData($_SESSION['s_usuario']['id'], "Eliminar", date('Y-m-d H:i:s'), $modulo, "Tipo de producto con el id: ".$_GET['id_presentacion']);
        $bitacora->Guardar_Bitacora();
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL ELIMINAR...";
    }
    
    header("Location: index.php?action=tipo&a=d"); // Redirect
    exit();
}
elseif ($action == 'd' && $_SERVER["REQUEST_METHOD"] == "GET") {

    require_once 'views/php/dashboard_tipo.php';
}
?>