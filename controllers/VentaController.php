<?php
// Incluye el archivo del modelo venta
require_once "models/Venta.php";
require "models/Notificacion.php";
require "models/DetalleProducto.php";
$controller = new Venta();
$notificacion = new Notificacion();
$detalle_producto = new DetalleProducto();


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
    $venta = json_encode([
        'id_venta' => htmlspecialchars($_POST['id_venta']),
        'tipo_compra' => htmlspecialchars($_POST['tipo_compra']),
        'tlf' => htmlspecialchars($_POST['tlf']),
        'id_cliente' => htmlspecialchars($_POST['id_cliente']),
        'cantidad' => array_map('htmlspecialchars', $_POST['cantidad']),
        'fech_emision' => htmlspecialchars($_POST['fech_emision']),
        'id_modalidad_pago' => htmlspecialchars($_POST['id_modalidad_pago']),
        'monto' => htmlspecialchars($_POST['total']),
        'tipo_entrega' => htmlspecialchars($_POST['tipo_entrega']),
        'rif_banco' => htmlspecialchars($_POST['rif_banco']),
        'productos' => [
            'id_producto' => [],
            'id_medida' => []
        ]
    ]);

    // Procesar los productos
    $venta = json_decode($venta, true);
    $productos_vendidos = [];

    foreach ($_POST['id_producto'] as $item) {
        $producto = json_decode($item);
        
        $venta['productos']['id_producto'][] = $producto->id_producto;
        $venta['productos']['id_medida'][] = $producto->id_unidad_medida;
        
        // Guardamos info del producto con cantidad vendida
        $productos_vendidos[] = [
            'id_producto' => $producto->id_producto
        ];
    }

    // Convertir nuevamente a JSON
    $venta = json_encode($venta);
    $controller->setVentaData($venta);
        // Llama al método guardar venta del controlador y guarda el resultado en $message
    if($controller->Guardar_Venta($venta))
    {
        // Verificar stock después de la venta
        foreach ($productos_vendidos as $producto) {
            $stock_actual = $detalle_producto->obtenerStockProducto($producto['id_producto']);

            if ($stock_actual <= 0) {
                // Notificar al administrador
                $id_admin = $_SESSION['s_usuario']['id']; // Cambia esto si el admin tiene un ID diferente
                $mensaje = "El producto  se ha agotado.";
                $enlace = "index.php?action=producto&a=d";

                $notificacion->insert($enlace,$mensaje, $id_admin, "Sin leer");
            }
        }

        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "REGISTRADO CORRECTAMENTE";
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL REGISTRAR...";
    }
    header("Location: index.php?action=venta&a=v");
    exit();
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
  // Llama al método actualizar producto del controlador y guarda el resultado en $message 
elseif ($action == 'abono' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_cuenta = $_GET['id_cuenta'];
    // Llama al controlador para mostrar el formulario de modificación
} 
elseif ($action == "abonado" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    $venta = json_encode([
        'id_venta' => htmlspecialchars($_POST['id_cuenta']),
        'fech_emision' => htmlspecialchars($_POST['fecha']),
        'monto' => floatval($_POST['monto']) // Si es decimal, usa floatval()
        // 'monto' => intval($_POST['monto']) // Si es entero, usa intval()
    ]);
    

    $controller->setVentaData($venta);
    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if($controller->Actualizar_Venta())
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "ABONADO CORRECTAMENTE";
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL ABONAR...";
    }
    header("Location: index.php?action=venta&a=cobrar");
    exit();
}
elseif ($action == 'cobrar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    

    require_once "views/php/dashboard_cobrar.php";
    // Llama al controlador para mostrar el formulario de modificación

}
elseif ($action == 'v' && $_SERVER["REQUEST_METHOD"] == "GET") {

    require_once "views/php/dashboard_venta.php";
}
?>