<?php
require_once 'models/Pedido.php';
require_once 'models/Producto.php';
require_once 'models/Roles.php';
require_once "models/Manejo.php";
require_once 'views/php/utils.php';
date_default_timezone_set('America/Caracas');
$controller = new Pedido();
$producto = new Producto();
$ingreso = new Manejo();
$usuario = new Roles();

$modulo = 'Pedidos';
$action = isset($_GET['a']) ? $_GET['a'] : '';

switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregar($controller,$ingreso,$usuario,$modulo);
        }
    case 'ecommerce':
        ecommerce($producto);
        break;
    default:
        pagina();
    // Otros casos...
}





function agregar($controller,$ingreso,$usuario,$modulo){


    if ($usuario->verificarPermiso($modulo, "agregar", $_SESSION['s_usuario']['id_rol'])) {

        $json = file_get_contents('php://input');
        $pedido = json_decode($json, true);


        if ($pedido === null) {
            http_response_code(400);
            echo json_encode(['status' => false, 'msj' => 'JSON inválido']);
            exit;
        }

        // Lógica de caja según modalidad de pago
            
            $fech_emision = date('Y-m-d');
            $fech_vencimiento = date('Y-m-d', strtotime('+7 days'));
            $ingreso_data = json_encode([
                'id_cajas' => 2,
                'movimiento' => "Ingreso",
                'fecha' => $fech_emision,
                'fechav' => $fech_vencimiento,
                'monto' => $pedido['total'],
                'id_pago' => $pedido['modalidad_pago'],
                'descripcion' => "Venta de productos"
            ]);
        
        

        $resultado = $controller->manejarAccion('agregar',$json);

         if (isset($resultado['status']) && $resultado['status'] === true) {
                    //usar mensaje dinámico del modelo
                    $ingreso->manejarAccion("agregar",$ingreso_data); 
                    echo json_encode(['success' => true, 'message' => 'Pedido registrado correctamente']);
                    exit;
        } 
        else {
        echo json_encode(['error' => false, 'message' => 'Error']);
        exit;}
    } else {
        echo json_encode(['error' => false, 'message' => 'Acceso no permitido']);
        exit;
    }
        //error_log($json);
        //echo $json;
}

function ecommerce($producto){
    $productos=$producto->manejarAccion('consultar',null);

    // Agrupar productos por categoría
    $productos_por_categoria = [];
foreach ($productos as $producto) {
    $cat = $producto['nombre_categoria'];
    if (!isset($productos_por_categoria[$cat])) {
        $productos_por_categoria[$cat] = [];
    }
    $productos_por_categoria[$cat][] = $producto;
}

    require_once 'views/php/ecommerce.php';
}



function pagina(){
    require_once 'views/php/pagina.php';
}
?>