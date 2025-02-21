<?php

require_once 'models/Proveedor.php';
$controller = new Proveedor();

$message="";
$message2="";
$message3="";

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    // Obtiene los valores del formulario y los sanitiza
    $id_proveedor = htmlspecialchars($_POST['id']);
    $tipo = htmlspecialchars($_POST['tipo']);
    $tipo2 = htmlspecialchars($_POST['tipo2']);
    $nombre_proveedor = htmlspecialchars($_POST['nombre']);
    $direccion_proveedor = htmlspecialchars($_POST['direccion']);
    $codigo = htmlspecialchars($_POST["codigo_tlf"]);
    $numero = htmlspecialchars($_POST["numero_tlf"]);
    $tlf_proveedor = $codigo . $numero;
    $id_representante_legal = htmlspecialchars($_POST['id_representante']);
    $nombre_representante_legal = htmlspecialchars($_POST['nombre_representante']);
    $codigo2 = htmlspecialchars($_POST['codigo_tlf_representante']);
    $numero2 = htmlspecialchars($_POST['numero_tlf_representante']);
    $tlf_representante_legal = $codigo2 . $numero2;

    $controller->setProveedorData($id_proveedor,$nombre_proveedor,$direccion_proveedor, $tlf_proveedor,$id_representante_legal,$nombre_representante_legal, $tlf_representante_legal, $tipo, $tipo2);
    // Llama al método guardarPersona del controlador y guarda el resultado en $message
    if($controller->Guardar_Proveedor())
    {
        $message3 = "PROVEEDOR AGREGADO CORRECTAMENTE"; // Establece el mensaje de éxito
        echo "<script>
            if (confirm('$message3')) {
                // Si el usuario acepta, permanece en el formulario
                window.location.href = 'crud_proveedor.php?action=formulario'; // Usar variable PHP
            } else {
                // Si el usuario cancela, redirige al dashboard
                window.location.href = 'crud_proveedor.php'; // Usar variable PHP
            }
          </script>";
    } else {
        $message3 = "ERROR AL AGREGAR EL PROVEEDOR.... RIF EXISTENTE"; // Establece el mensaje de error
    }require_once "views/php/dashboard_proveedor.php";
}
elseif ($action == "formulario" && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    require_once "views/php/form_proveedor.php";
    
}
elseif ($action == 'mid_form' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_proveedor = $_GET['id_proveedor'];
    require_once "views/php/form_mid_proveedor.php";
    // Llama al controlador para mostrar el formulario de modificación
    $proveedor=$controller->Obtener_Proveedor($id_proveedor);
}
else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario y los sanitiza 
    $id_proveedor = htmlspecialchars($_POST['id_proveedor']);
    $tipo = htmlspecialchars($_POST['tipo']);
    $tipo2 = htmlspecialchars($_POST['tipo2']);
    $nombre_proveedor = htmlspecialchars($_POST['nombre']);
    $direccion_proveedor = htmlspecialchars($_POST['direccion']);
    $codigo = htmlspecialchars($_POST["codigo_tlf"]);
    $numero = htmlspecialchars($_POST["numero_tlf"]);
    $tlf_proveedor = $codigo . $numero;
    $id_representante_legal = htmlspecialchars($_POST['id_representante']);
    $nombre_representante_legal = htmlspecialchars($_POST['nombre_representante']);
    $codigo2 = htmlspecialchars($_POST['codigo_tlf_representante']);
    $numero2 = htmlspecialchars($_POST['numero_tlf_representante']);
    $tlf_representante_legal = $codigo2 . $numero2;

    $controller->setProveedorData($id_proveedor,$nombre_proveedor,$direccion_proveedor, $tlf_proveedor,$id_representante_legal,$nombre_representante_legal, $tlf_representante_legal, $tipo, $tipo2);

    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if($controller->Actualizar_Proveedor($id_proveedor, $nombre_proveedor,
    $direccion_proveedor, $tlf_proveedor, $id_representante_legal, 
    $nombre_representante_legal, $tlf_representante_legal,$tipo,$tipo2)) 
    { 
        $message2 = "PROVEEDOR ACTUALIZADO CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $message2 = "ERROR AL ACTUALIZAR EL PROVEEDOR"; // Establece el mensaje de error
    }

    // Vuelve a cargar el formulario con el mensaje
    require_once "views/php/dashboard_proveedor.php";
    
}
elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_proveedor = $_GET['ID'];

    $controller->setProveedorData($id_proveedor,null,null,null,null,null,null,null,null,null);

    if ($controller->Eliminar_Proveedor($id_proveedor))
    { 
        $message = "PROVEEDOR ELIMINADO CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $message = "ERROR AL ELIMINAR EL PROVEEDOR"; // Establece el mensaje de error
    }
    require_once "views/php/dashboard_proveedor.php";
}
else
{
    require_once "views/php/dashboard_proveedor.php";
}
?>