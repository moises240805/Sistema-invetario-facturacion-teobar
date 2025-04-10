<?php
// Incluye el archivo del modelo venta
require_once "models/Venta.php";
require "models/Notificacion.php";
require "models/Producto.php";
require_once "models/IngresoEgreso.php";
require_once 'models/Bitacora.php';
date_default_timezone_set('America/Caracas');

$ingreso = new IngresoEgreso();
$controller = new Venta();
$notificacion = new Notificacion();
$bitacora = new Bitacora();
$detalle_producto = new Producto();

$modulo = 'Venta';


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
    
    $id_modalidad_pago = $venta['id_modalidad_pago'];
    $fech_emision = $venta['fech_emision'];
    $monto = $venta['monto'];

    if ($id_modalidad_pago == 1 || $id_modalidad_pago == 2) {
        $id_cajas = 1;
    } else {
        $id_cajas = 2;
    }
    
    $ingreso_data = json_encode([
        'id_cajas' => $id_cajas,
        'movimiento' => "Ingreso",
        'fecha' => $fech_emision,
        'monto' => $monto,
        'id_pago' => $id_modalidad_pago,
        'descripcion' => "Venta de productos"
    ]);
    // Convertir nuevamente a JSON
    $venta = json_encode($venta);
    

    $controller->setVentaData($venta);
    
    $ingreso->setIngresoEgresoData($ingreso_data);
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

        $bitacora_data = json_encode([
            'id_admin' => $_SESSION['s_usuario']['id'],
            'movimiento' => 'Agregar',
            'fecha' => date('Y-m-d H:i:s'),
            'modulo' => $modulo,
            'descripcion' =>'El usuario: '.$_SESSION['s_usuario']['usuario']. " " . 'ha registrado una venta'
            ]);
            $bitacora->setBitacoraData($bitacora_data);
            $bitacora->Guardar_Bitacora();


        $ingreso->Guardar_IngresoEgreso($ingreso_data); 
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL REGISTRAR...";
    }
    header("Location: index.php?action=venta&a=v");
    exit();
}


elseif ($action == 'v' && $_SERVER["REQUEST_METHOD"] == "GET") {

    require_once "views/php/dashboard_venta.php";
}
?>