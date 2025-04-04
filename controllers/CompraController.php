<?php
// Incluye el archivo del modelo venta
require_once "models/Compra.php";
require_once "models/IngresoEgreso.php";
require_once 'models/Bitacora.php';
date_default_timezone_set('America/Caracas');
$bitacora = new Bitacora();
$ingreso = new IngresoEgreso();
$controller = new Compra();

$modulo = 'Compra';


$action = isset($_GET['a']) ? $_GET['a'] : '';

if ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST")
{
   // Obtiene los valores del formulario y los sanitiza
   $compra = json_encode([
    'id_compra' => htmlspecialchars($_POST['id_venta']),
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
$compra = json_decode($compra, true);

foreach ($_POST['id_producto'] as $item) {
    $producto = json_decode($item);

    $compra['productos']['id_producto'][] = $producto->id_producto;
    $compra['productos']['id_medida'][] = $producto->id_unidad_medida;
}

$id_modalidad_pago = $compra['id_modalidad_pago'];
$fech_emision = $compra['fech_emision'];
$monto = $compra['monto'];

if ($id_modalidad_pago == 1 || $id_modalidad_pago == 2) {
    $id_cajas = 1;
} else {
    $id_cajas = 2;
}

$ingreso_data = json_encode([
    'id_cajas' => $id_cajas,
    'movimiento' => "Egreso",
    'fecha' => $fech_emision,
    'monto' => $monto,
    'id_pago' => $id_modalidad_pago,
    'descripcion' => "Compra de productos de productos"
]);

// Convertir nuevamente a JSON
$compra = json_encode($compra);

$controller->setCompraData($compra);
$ingreso->setIngresoEgresoData($ingreso_data);
// Llama al método guardar compra del controlador y guarda el resultado en $message
if ($controller->Guardar_Compra($compra)) {
    $_SESSION['message_type'] = 'success';  // Set success flag
    $_SESSION['message'] = "REGISTRADA CORRECTAMENTE";

    $bitacora_data = json_encode([
        'id_admin' => $_SESSION['s_usuario']['id'],
        'movimiento' => 'Abono',
        'fecha' => date('Y-m-d H:i:s'),
        'modulo' => $modulo,
        'descripcion' =>'El usuario: '.$_SESSION['s_usuario']['usuario']. " " . 'ha registrado una compra de producto'
        ]);
        $bitacora->setBitacoraData($bitacora_data);
        $bitacora->Guardar_Bitacora();


    $ingreso->Guardar_IngresoEgreso($ingreso_data); 
} else {
    $_SESSION['message_type'] = 'danger'; // Set error flag
    $_SESSION['message'] = "ERROR AL REGISTRAR...";
}
header("Location: index.php?action=compra");
exit();
} elseif ($action == 'pagar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    require_once "views/php/dashboard_pagar.php";
} else {
    require_once "views/php/dashboard_compra.php";
}