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

// Convertir nuevamente a JSON
$compra = json_encode($compra);

$controller->setCompraData($compra);
// Llama al método guardar compra del controlador y guarda el resultado en $message
if ($controller->Guardar_Compra($compra)) {
    $_SESSION['message_type'] = 'success';  // Set success flag
    $_SESSION['message'] = "REGISTRADA CORRECTAMENTE";
} else {
    $_SESSION['message_type'] = 'danger'; // Set error flag
    $_SESSION['message'] = "ERROR AL REGISTRAR...";
}
header("Location: index.php?action=compra");
exit();
}
elseif ($action == 'abono' && $_SERVER["REQUEST_METHOD"] == "GET") {
    $id_cuenta = $_GET['id_cuenta'];
    // Llama al controlador para mostrar el formulario de modificación
} elseif ($action == "abonado" && $_SERVER["REQUEST_METHOD"] == "POST") {
    $compra = json_encode([
        'id_compra' => htmlspecialchars($_POST['id_cuenta']),
        'fech_emision' => htmlspecialchars($_POST['fecha']),
        'monto' => floatval($_POST['monto']) // Si es decimal, usa floatval()
        // 'monto' => intval($_POST['monto']) // Si es entero, usa intval()
    ]);

    $controller->setCompraData($compra);
    // Llama al método actualizar compra del controlador y guarda el resultado en $message
    if ($controller->Actualizar_Compra()) {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "ABONADO CORRECTAMENTE";
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL ABONAR...";
    }
    header("Location: index.php?action=compra&a=pagar");
    exit();
} elseif ($action == 'pagar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    require_once "views/php/dashboard_pagar.php";
} else {
    require_once "views/php/dashboard_compra.php";
}