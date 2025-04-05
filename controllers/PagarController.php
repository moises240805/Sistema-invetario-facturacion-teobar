<?php
require_once "models/Pagar.php";
require_once 'models/Bitacora.php';
date_default_timezone_set('America/Caracas');

$bitacora = new Bitacora();
$controller = new Pagar();

$modulo = "Cuenta Pagar";
$a = isset($_GET['a']) ? $_GET['a'] : '';

if ($a == 'abono' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_cuenta = $_GET['id_cuenta'];
    $cuenta=$controller->obtenerCuentasID2($id_cuenta);
    echo json_encode($cuenta);
    // Llama al controlador para mostrar el formulario de modificación
} 
elseif ($a == "abonado" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    $cuenta = json_encode([
        'id_compra' => htmlspecialchars($_POST['id_cuenta']),
        'fech_emision' => htmlspecialchars($_POST['fecha']),
        'id_pago' => htmlspecialchars($_POST['id_pago']),
        'monto' => floatval($_POST['monto']) // Si es decimal, usa floatval()
        // 'monto' => intval($_POST['monto']) // Si es entero, usa intval()
    ]);
    

    $controller->setCompraData($cuenta);
    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if($controller->Actualizar_Cuenta())
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "ABONADO CORRECTAMENTE";

        $bitacora_data = json_encode([
            'id_admin' => $_SESSION['s_usuario']['id'],
            'movimiento' => 'Pagar',
            'fecha' => date('Y-m-d H:i:s'),
            'modulo' => $modulo,
            'descripcion' =>'El usuario: '.$_SESSION['s_usuario']['usuario']. " " . 'ha registrado un pago a proveedor de una cuanta a pagar pendiente'
            ]);
            $bitacora->setBitacoraData($bitacora_data);
            $bitacora->Guardar_Bitacora();
    } else {
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL ABONAR...";
    }
    header("Location: index.php?action=pagar&a=v");
    exit();
}elseif ($a == 'v' && $_SERVER["REQUEST_METHOD"] == "GET") {

    require_once "views/php/dashboard_pagar.php";
}

?>