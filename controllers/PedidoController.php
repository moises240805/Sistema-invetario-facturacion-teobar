<?php
require_once 'models/Pedido.php';
$controller = new Pedido();

$action = isset($_GET['a']) ? $_GET['a'] : '';

switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregar($controller);
        }
        break;
    // Otros casos...
}

function agregar($controller){
    $json = file_get_contents('php://input');
    $pedidoData = json_decode($json, true);

    if ($pedidoData === null) {
        http_response_code(400);
        echo json_encode(['status' => false, 'msj' => 'JSON inválido']);
        exit;
    }

    $resultado = $controller->Guardar_Pedido($pedidoData);

    if ($resultado['status']) {
        echo json_encode(['success' => true, 'message' => $resultado['msj'], 'monto_total' => $resultado['monto_total']]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $resultado['msj']]);
    }
}
?>