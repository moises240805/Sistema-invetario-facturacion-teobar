<?php
// Incluye el archivo del modelo venta
require_once "models/Venta.php";
require_once "models/IngresoEgreso.php";
$ingreso = new IngresoEgreso();
$controller = new Venta();


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
    
    foreach ($_POST['id_producto'] as $item) {
        $producto = json_decode($item);
    
        $venta['productos']['id_producto'][] = $producto->id_producto;
        $venta['productos']['id_medida'][] = $producto->id_unidad_medida;

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
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "REGISTRADO CORRECTAMENTE";


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