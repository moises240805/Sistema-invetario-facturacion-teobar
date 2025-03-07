<?php

require_once 'models/Proveedor.php';
$controller = new Proveedor();

$message="";
$message2="";
$message3="";

$action = isset($_GET['a']) ? $_GET['a'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    // Obtiene los valores del formulario y los sanitiza
    $proveedor = json_encode([
        'id_proveedor' => htmlspecialchars($_POST['id']),
        'tipo' => htmlspecialchars($_POST['tipo']),
        'tipo2' => htmlspecialchars($_POST['tipo2']),
        'nombre_proveedor' => htmlspecialchars($_POST['nombre']),
        'direccion_proveedor' => htmlspecialchars($_POST['direccion']),
        'telefono_proveedor' => htmlspecialchars($_POST['codigo_tlf'] . $_POST['numero_tlf']),
        'id_representante_legal' => htmlspecialchars($_POST['id_representante']),
        'nombre_representante_legal' => htmlspecialchars($_POST['nombre_representante']),
        'telefono_representante_legal' => htmlspecialchars($_POST['codigo_tlf_representante'] . $_POST['numero_tlf_representante'])
    ]);
    

    $controller->setProveedorData($proveedor);
    // Llama al método guardarPersona del controlador y guarda el resultado en $message
    if($controller->Guardar_Proveedor($proveedor))
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "REGISTRADO CORRECTAMENTE";
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL REGISTRAR...";
    }
    
    header("Location: index.php?action=proveedor&a=d"); // Redirect
    exit();
}
elseif ($action == 'mid_form' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_proveedor = $_GET['id_proveedor'];
    // Llama al controlador para mostrar el formulario de modificación
    $proveedor=$controller->Obtener_Proveedor($id_proveedor);
    echo json_encode($proveedor);
}
else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario y los sanitiza 
    $proveedor = json_encode([
        'id_proveedor' => htmlspecialchars($_POST['id_proveedor']),
        'tipo' => htmlspecialchars($_POST['tipo']),
        'tipo2' => htmlspecialchars($_POST['tipo2']),
        'nombre_proveedor' => htmlspecialchars($_POST['nombre']),
        'direccion_proveedor' => htmlspecialchars($_POST['direccion']),
        'telefono_proveedor' => htmlspecialchars($_POST['codigo_tlf'] . $_POST['numero_tlf']),
        'id_representante_legal' => htmlspecialchars($_POST['id_representante']),
        'nombre_representante_legal' => htmlspecialchars($_POST['nombre_representante']),
        'telefono_representante_legal' => htmlspecialchars($_POST['codigo_tlf_representante'] . $_POST['numero_tlf_representante'])
    ]);

    $controller->setProveedorData($proveedor);

    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if($controller->Actualizar_Proveedor($proveedor)) 
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "ACTUALIZADO CORRECTAMENTE";
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL ACTUALIZAR...";
    }

    header("Location: index.php?action=proveedor&a=d"); // Redirect
    exit();
    
}
elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_proveedor = $_GET['ID'];

    $controller->setProveedorData($id_proveedor);

    if ($controller->Eliminar_Proveedor($id_proveedor))
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "ELIMINADO CORRECTAMENTE";
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL ELIMINAR...";
    }
    
    header("Location: index.php?action=proveedor&a-d"); // Redirect
    exit();
}
elseif ($action == 'd' && $_SERVER["REQUEST_METHOD"] == "GET") {
    require_once "views/php/dashboard_proveedor.php";
}
?>