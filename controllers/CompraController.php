<?php
// Incluye el archivo del modelo venta
require_once "models/Compra.php";
$controller = new Compra();

$message2="";
$message3="";
$message4="";

$message="";//inicializa la varable donde se almasenara la el mensage error o succes
//aqui realiza las operacion resividas de las vista donde dependiendo
//del action realiza las llamadas al los controladores y trae las vistas
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    // Obtiene los valores del formulario y los sanitiza
    $id_compra = htmlspecialchars($_POST['id_venta']);
    $id_cliente = htmlspecialchars($_POST['id_cliente']);
    $cantidad = array_map('htmlspecialchars', $_POST['cantidad']);
    $fech_emision = htmlspecialchars($_POST['fech_emision']);
    $id_modalidad_pago = htmlspecialchars($_POST['id_modalidad_pago']);
    $monto = htmlspecialchars($_POST['total']);
    $tipo_entrega = htmlspecialchars($_POST['tipo_entrega']);
    $rif_banco = htmlspecialchars($_POST['rif_banco']);
    $valor = $_POST['id_producto'];
    $tipo_compra="";
    $tlf="";
    $id_producto = [];
$id_medida = [];

// Iterate through the original array
foreach ($valor as $item) {
    $producto=json_decode($item);

    $id_producto[] = $producto->id_producto;
    $id_medida[] = $producto->id_unidad_medida;
}



    //print_r($valor);
    $controller->setVentaData($id_compra, $id_producto, $tipo_compra, $tlf, $id_cliente, $cantidad, $fech_emision, $id_modalidad_pago, $monto, $tipo_entrega, $rif_banco, $id_medida);
    // Llama al método guardar venta del controlador y guarda el resultado en $message
    if($controller->Guardar_Compra())
    {
        $message3 = "COMPRA REGISTRADA Y CANTIDAD ACTUALIZADA CORRECTAMENTE"; // Establece el mensaje de éxito
        echo "<script>
            if (confirm('$message3')) {
                // Si el usuario acepta, permanece en el formulario
                window.location.href = 'crud_Compra.php?action=formulario';
            } else {
                // Si el usuario cancela, redirige al dashboard
                window.location.href = 'crud_Compra.php'; // Usar variable PHP
            }
          </script>";
    } else {
        $message = "No hay suficiente cantidad del producto disponible."; // Establece el mensaje de error
    }
}
elseif ($action == "formulario" && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    require_once "views/php/form_Compra.php";
    
}elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_compra = $_GET['ID'];

    $controller->setVentaData($id_compra, null, null, null, null, null, null, null, null, null, null,null);
    // Llama al controlador para eliminar el formulario de modificación
    $compra=$controller->Eliminar_Compra($id_compra);
    if($compra) 
    { 
        $message = "COMPRA ELIMINADA CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $message = "ERROR AL ELIMINAR LA COMPRA"; // Establece el mensaje de error
    }
    require_once "views/php/dashboard_Compra.php";
}
elseif ($action == 'abono' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_cuenta = $_GET['id_cuenta'];
    // Llama al controlador para mostrar el formulario de modificación
    require_once "views/php/form_pagar.php";
} 
elseif ($action == "abonado" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    $id_compra = htmlspecialchars($_POST['id_cuenta']);
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

    $controller->setVentaData($id_compra, $id_producto, $tipo_compra, $tlf, $id_cliente, $cantidad, $fech_emision, $id_modalidad_pago, $monto, $tipo_entrega, $rif_banco, $id_medida);
    if($controller->Actualizar_Compra())
    { 
        $message = "ABONADO CORRECTAMENTE"; // Establece el mensaje de éxito
        require_once "views/php/dashboard_pagar.php";
    } else {
        $message = "ERROR "; // Establece el mensaje de error
    }
}
elseif ($action == "pagar" && $_SERVER["REQUEST_METHOD"] == "GET"){
    require_once "views/php/dashboard_pagar.php";
}
else
{
    require_once "views/php/dashboard_compra.php";
}
?>