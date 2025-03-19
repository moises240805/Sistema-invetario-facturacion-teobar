<?php

require_once 'models/Cliente.php';
require_once 'models/Bitacora.php';
$controller = new Cliente();
$bitacora = new Bitacora();
$modulo = 'Cliente';
date_default_timezone_set('America/Caracas');
$message="";
$message3="";
$message3="";

$action = isset($_GET['a']) ? $_GET['a'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    // Obtiene los valores del formulario y los sanitiza
    $cliente = json_encode([
        'id_cliente' => htmlspecialchars($_POST['id_cliente']),
        'tipo_id' => htmlspecialchars($_POST['tipo_cliente']),
        'nombre_cliente' => htmlspecialchars($_POST['nombre_cliente']),
        'telefono' => htmlspecialchars($_POST['codigo_tlf'] . $_POST['telefono']),
        'direccion' => htmlspecialchars($_POST['direccion']),
        'email' => htmlspecialchars($_POST['email'])
    ]);

    $controller->setClienteData($cliente);

    // Llama al método guardarPersona del controlador y guarda el resultado en $message
    if ($controller->Guardar_Cliente($cliente)) 
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "REGISTRADO CORRECTAMENTE";
        $bitacora->setBitacoraData($_SESSION['s_usuario']['id'], "Agregar", date('Y-m-d H:i:s'), $modulo, "Cliente con la cedula: ".$_POST['tipo_cliente']."". $_POST['id_cliente']);
        $bitacora->Guardar_Bitacora();
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL REGISTRAR...";
    }
    
    header("Location: index.php?action=cliente&a=d"); // Redirect
    exit();
}
elseif ($action == 'mid_form' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_cliente = $_GET['id_cliente'];
    // Llama al controlador para mostrar el formulario de modificación
    $cliente=$controller->Obtener_Cliente($id_cliente);
    echo json_encode($cliente);
}
else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario y los sanitiza 
    $cliente = json_encode([
        'id_cliente' => htmlspecialchars($_POST['id_cliente']),
        'tipo_id' => htmlspecialchars($_POST['tipo_id']),
        'nombre_cliente' => htmlspecialchars($_POST['nombre_cliente']),
        'telefono' => htmlspecialchars($_POST['codigo_tlf'] . $_POST['telefono']),
        'direccion' => htmlspecialchars($_POST['direccion']),
        'email' => htmlspecialchars($_POST['email'])
    ]);
    

    $controller->setClienteData($cliente);
    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if($controller->Actualizar_Cliente($cliente)) 
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "ACTUALIZADO CORRECTAMENTE";
        $bitacora->setBitacoraData($_SESSION['s_usuario']['id'], "Actualizar", date('Y-m-d H:i:s'), $modulo, "Cliente con la cedula: ".$_POST['tipo_id']."". $_POST['id_cliente']);
        $bitacora->Guardar_Bitacora();
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL ACTUALIZAR...";
    }

    header("Location: index.php?action=cliente&a=d"); // Redirect
    exit();
    
}
elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_cliente = $_GET['ID'];

    $controller->setClienteData($id_cliente, );
    // Llama al controlador para mostrar el formulario de modificación
    $cliente=$controller->Eliminar_Cliente($id_cliente);
    if($cliente) 
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "ELIMINADO CORRECTAMENTE";
        $bitacora->setBitacoraData($_SESSION['s_usuario']['id'], "Eliminar", date('Y-m-d H:i:s'), $modulo, "Cliente con el id: ".$_GET['ID']);
        $bitacora->Guardar_Bitacora();
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL ELIMINAR...";
    }
    
    header("Location: index.php?action=cliente&a=d"); // Redirect
    exit();
}
elseif ($action == 'd' && $_SERVER["REQUEST_METHOD"] == "GET") {

    require_once 'views/php/dashboard_cliente.php';
}

?>