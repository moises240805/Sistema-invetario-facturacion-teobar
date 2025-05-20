<?php
require_once 'models/Pedido.php';
require_once 'models/Producto.php';
$controller = new Pedido();
$producto = new Producto();

$action = isset($_GET['a']) ? $_GET['a'] : '';

switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregar($controller);
        }
    case 'ecommerce':
        ecommerce($producto);
        break;
    default:
        pagina();
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

function ecommerce($producto){
    $productos=$producto->manejarAccion('consultar',null);
    require_once 'views/php/ecommerce.php';
}



function pagina(){
    require_once 'views/php/pagina.php';
}
?>