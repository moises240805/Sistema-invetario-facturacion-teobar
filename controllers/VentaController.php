<?php
// Incluye el archivo del modelo venta
require_once "models/Venta.php";

$controller = new Venta();


$message2="";
$message3="";
$message4="";

$message="";//inicializa la varable donde se almasenara la el mensage error o succes
//aqui realiza las operacion resividas de las vista donde dependiendo
//del action realiza las llamadas al los controladores y trae las vistas
$action = isset($_GET['a']) ? $_GET['a'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    // Obtiene los valores del formulario y los sanitiza
    $id_venta = htmlspecialchars($_POST['id_venta']);
    $tipo_compra = htmlspecialchars($_POST['tipo_compra']);
    $tlf = htmlspecialchars($_POST['tlf']);
    $id_cliente = htmlspecialchars($_POST['id_cliente']);
    $cantidad = array_map('htmlspecialchars', $_POST['cantidad']);
    $fech_emision = htmlspecialchars($_POST['fech_emision']);
    $id_modalidad_pago = htmlspecialchars($_POST['id_modalidad_pago']);
    $monto = htmlspecialchars($_POST['total']);
    $tipo_entrega = htmlspecialchars($_POST['tipo_entrega']);
    $rif_banco = htmlspecialchars($_POST['rif_banco']);
    $valor = $_POST['id_producto'];
    //$data = json_decode($valor);
    //$id_producto = $data['id_producto'];
    //$id_medida = $data['id_unidad_medida'];
    $id_producto = [];
$id_medida = [];

// Iterate through the original array
foreach ($valor as $item) {
    $producto=json_decode($item);

    $id_producto[] = $producto->id_producto;
    $id_medida[] = $producto->id_unidad_medida;
}

    $controller->setVentaData($id_venta, $id_producto, $tipo_compra, $tlf, $id_cliente, $cantidad, $fech_emision, $id_modalidad_pago, $monto, $tipo_entrega, $rif_banco, $id_medida);
    // Llama al método guardar venta del controlador y guarda el resultado en $message
    if($controller->Guardar_Venta())
    {
        $message = "VENTA REGISTRADA Y CANTIDAD ACTUALIZADA CORRECTAMENTE"; // Establece el mensaje de éxito
        echo "<script>
            if (confirm('$message')) {
                // Si el usuario acepta, permanece en el formulario
                window.location.href = 'crud_venta.php?action=formulario'; // Usar variable PHP
            } else {
                // Si el usuario cancela, redirige al dashboard
                window.location.href = 'crud_venta.php'; // Usar variable PHP
            }
          </script>";
    } else {
        $message = "No hay suficiente cantidad del producto disponible."; // Establece el mensaje de error
    }require_once "views/php/dashboard_venta.php";
}
elseif ($action == "formulario" && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    require_once "views/php/form_venta.php";
    
}
elseif ($action == 'mid_form' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_venta = $_GET['id_venta'];
    // Llama al controlador para mostrar el formulario de modificación
    require_once "views/php/form_mid_venta.php";
    $venta=$controller->Obtener_Venta($id_venta);
}
else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario y los sanitiza 
    $id_venta = htmlspecialchars($_POST['id_venta']);
    $id_producto = htmlspecialchars($_POST['id_producto']);
    $id_cliente = htmlspecialchars($_POST['id_cliente']);
    $cantidad = htmlspecialchars($_POST['cantidad']);
    $fech_emision = htmlspecialchars($_POST['fech_emision']);
    $id_modalidad_pago = htmlspecialchars($_POST['id_modalidad_pago']);
    $monto = htmlspecialchars($_POST['monto']);
    $tipo_entrega = htmlspecialchars($_POST['tipo_entrega']);
    $rif_banco = htmlspecialchars($_POST['rif_banco']);

    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if($controller->Actualizar_Venta()) 
    { 
        $message = "VENTA ACTUALIZADA CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $message = "ERROR AL ACTUALIZAR LA VENTA"; // Establece el mensaje de error
    }

    // Vuelve a cargar el formulario con el mensaje
    require_once "views/php/form_mid_venta.php";
    
}
elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_venta = $_GET['ID'];

    $controller->setVentaData($id_venta, null, null, null, null, null, null, null, null, null, null, null);
    // Llama al controlador para eliminar el formulario de modificación
    $venta=$controller->Eliminar_Venta($id_venta);
    if($venta) 
    { 
        $message = "VENTA ELIMINADA CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $message = "ERROR AL ELIMINAR LA VENTA"; // Establece el mensaje de error
    }
    require_once "views/php/dashboard_venta.php";
}
elseif ($action == 'abono' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_cuenta = $_GET['id_cuenta'];
    // Llama al controlador para mostrar el formulario de modificación
    require_once "views/php/form_cobrar.php";
} 
elseif ($action == "abonado" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    $id_venta = htmlspecialchars($_POST['id_cuenta']);
    $fech_emision = htmlspecialchars($_POST['fecha']);
    $monto = htmlspecialchars($_POST['monto']);
    $id_producto="";
    $id_cliente="";
    $cantidad="";
    $id_modalidad_pago="";
    $tipo_entrega="";
    $rif_banco="";
    $tipo_compra="";
    $tlf="";
    $id_medida="";

    $controller->setVentaData($id_venta, null, null, null, null, null, $fech_emision, null, $monto, null, null, null);
    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if($controller->Actualizar_Venta())
    { 
        $message3 = "ABONADO CORRECTAMENTE"; // Establece el mensaje de éxito
        require_once "views/php/dashboard_cobrar.php";
    } else {
        $message = "ERROR "; // Establece el mensaje de error
    }
}
elseif ($action == 'cobrar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    

    require_once "views/php/dashboard_cobrar.php";
    // Llama al controlador para mostrar el formulario de modificación

}
else
{
    require_once "views/php/dashboard_venta.php";
}
?>