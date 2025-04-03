<?php
require_once "models/Pagar.php";

$controller = new Pagar();
$a = isset($_GET['a']) ? $_GET['a'] : '';

if ($a == 'abono' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_cuenta = $_GET['id_cuenta'];
    // Llama al controlador para mostrar el formulario de modificación
} 
elseif ($a == "abonado" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    $cuenta = json_encode([
        'id_compra' => htmlspecialchars($_POST['id_cuenta']),
        'fech_emision' => htmlspecialchars($_POST['fecha']),
        'monto' => floatval($_POST['monto']) // Si es decimal, usa floatval()
        // 'monto' => intval($_POST['monto']) // Si es entero, usa intval()
    ]);
    

    $controller->setCompraData($cuenta);
    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if($controller->Actualizar_Cuenta())
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "ABONADO CORRECTAMENTE";
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