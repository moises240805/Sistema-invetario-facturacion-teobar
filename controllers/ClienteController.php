<?php

require_once 'models/Cliente.php';
$controller = new Cliente();

$message="";
$message3="";
$message3="";

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    // Obtiene los valores del formulario y los sanitiza
    $id_cliente = htmlspecialchars($_POST['id']);
    $tipo = htmlspecialchars($_POST['tipo']);
    $nombre_cliente = htmlspecialchars($_POST['nombre']);
    $codigo = htmlspecialchars($_POST['codigo_tlf']);
    $numero = htmlspecialchars($_POST['numero_tlf']);
    $tlf_cliente = $codigo . $numero;
    $direccion_cliente = htmlspecialchars($_POST['direccion']);
    $email_cliente = htmlspecialchars($_POST['email']);

    $controller->setClienteData($id_cliente, $nombre_cliente, $direccion_cliente, 
                               $tlf_cliente, $email_cliente, $tipo);

    // Llama al método guardarPersona del controlador y guarda el resultado en $message
    if ($controller->Guardar_Cliente()) {
        $message3 = "CLIENTE AGREGADO CORRECTAMENTE"; 
        echo "<script>
                if (confirm('$message3')) {
                    // Si el usuario acepta, permanece en el formulario
                    window.location.href = 'crud_cliente.php?action=formulario'; // Usar variable PHP
                } else {
                    // Si el usuario cancela, redirige al dashboard
                    window.location.href = 'crud_cliente.php'; // Usar variable PHP
                }
            </script>";
    }  else {
            $message3 = "ERROR AL AGREGAR EL CLIENTE... RIF O CEDULA EXISTENTE"; // Establece el mensaje de error
        }require_once "views/php/dashboard_cliente.php";
}
elseif ($action == "formulario" && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    require_once "views/php/form_cliente.php";
    
}
elseif ($action == 'mid_form' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_cliente = $_GET['id_cliente'];
    require_once "views/php/form_mid_cliente.php";
    // Llama al controlador para mostrar el formulario de modificación
    $cliente=$controller->Obtener_Cliente($id_cliente);
}
else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario y los sanitiza 
    $id_cliente = htmlspecialchars($_POST['id_cliente']);
    $tipo = htmlspecialchars($_POST['tipo']); 
    $nombre_cliente = htmlspecialchars($_POST['nombre']); 
    $codigo = htmlspecialchars($_POST['codigo_tlf']);
    $numero = htmlspecialchars($_POST['numero_tlf']);
    $tlf_cliente = $codigo . $numero;
    $direccion_cliente = htmlspecialchars($_POST['direccion']);
    $email_cliente = htmlspecialchars($_POST['email']);

    $controller->setClienteData($id_cliente, $nombre_cliente, $direccion_cliente, 
    $tlf_cliente, $email_cliente, $tipo);
    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if($controller->Actualizar_Cliente($id_cliente, $nombre_cliente,
    $tlf_cliente, $direccion_cliente,$email_cliente,$tipo)) 
    { 
        $message2 = "CLIENTE ACTUALIZADO CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $message2 = "ERROR AL ACTUALIZAR EL CLIENTE"; // Establece el mensaje de error
    }

    // Vuelve a cargar el formulario con el mensaje
    require_once "views/php/dashboard_cliente.php";
    
}
elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_cliente = $_GET['ID'];

    $controller->setClienteData($id_cliente, null, null, 
    null, null, null);
    // Llama al controlador para mostrar el formulario de modificación
    $cliente=$controller->Eliminar_Cliente($id_cliente);
    if($cliente) 
    { 
        $message = "CLIENTE ELIMINADO CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $message = "ERROR AL ELIMINAR EL CLIENTE"; // Establece el mensaje de error
    }
    require_once "views/php/dashboard_cliente.php";
}
else
{
    require_once "views/php/dashboard_cliente.php";
}

?>