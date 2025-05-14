<?php
require_once "models/Cobrar.php";
require_once 'models/Bitacora.php';
require_once 'models/Roles.php';
require_once 'views/php/utils.php';
date_default_timezone_set('America/Caracas');

$controller = new Cobrar();
$bitacora = new Bitacora();
$roles = new Roles();

$modulo = 'Cobrar';
$a = isset($_GET['a']) ? $_GET['a'] : '';

//Indiferentemente sea la accion por el post o get el switch llama a cada funcion 
switch ($action) {
    case "abonado":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregar($controller, $bitacora, $roles, $modulo);
        }
        break;

    case "abono":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            obtener($controller);
        }
        break;

    case "v":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultar($controller, $roles, $modulo);
        }
        break;
    default:
        consultar($controller, $roles, $modulo);
        break;

}




function obtener($controller){
    header('Content-Type: application/json; charset=utf-8');

    $id_cuenta = $_GET['id_cuenta'] ?? null;
    if (!$id_cuenta) {
        setError("ID de cuenta no proporcionado");
        exit();
    }

    $cuenta = $controller->manejarAccion("obtener", $id_cuenta);

    // Si hay error en la obtención, también responde como JSON
    if (!$cuenta || (is_array($cuenta) && isset($cuenta['status']) && $cuenta['status'] === false)) {
        setError("Cuenta no encontrada o inválida");
        exit();
    }

    echo json_encode($cuenta);
    exit(); 
}



    function agregar($controller, $bitacora, $roles, $modulo)
{
    // Verifica si el usuario tiene permiso para realizar la acción
    if ($roles->verificarPermiso($modulo, "agregar", $_SESSION['s_usuario']['id_rol'])) {
        // Obtiene y sanitiza los valores del formulario
        $id_cuenta = filter_input(INPUT_POST, 'id_cuenta', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fech_emision = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id_pago = filter_input(INPUT_POST, 'id_pago', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $monto_raw = filter_input(INPUT_POST, 'monto', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Verifica que todos los campos requeridos existan y no estén vacíos
        if (empty($id_cuenta) || empty($fech_emision) || empty($id_pago) || $monto_raw === null || $monto_raw === '') {
            setError("Todos los campos son requeridos");
            header("Location: index.php?action=cobrar&a=v");
            exit();
        }

        // Convierte monto a float
        $monto = floatval($monto_raw);

        // Crea el objeto JSON de cuenta con los valores necesarios
        $cuenta = json_encode([
            'id_cuenta' => $id_cuenta,
            'fech_emision' => $fech_emision,
            'id_pago' => $id_pago,
            'monto' => $monto
        ]);
        

        try {

            // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
            $resultado = $controller->manejarAccion("agregar", $cuenta);
        

            //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
            if (isset($resultado['status']) && $resultado['status'] === true) {
                //usar mensaje dinámico del modelo
                setSuccess($resultado['msj']);
                
                //se crea un json de los datos qe tendra la bitacora
            $bitacora_data = json_encode([
            'id_admin' => $_SESSION['s_usuario']['id'],
            'movimiento' => 'Abono',
            'fecha' => date('Y-m-d H:i:s'),
            'modulo' => $modulo,
            'descripcion' =>'El usuario: '.$_SESSION['s_usuario']['usuario']. " " . 'ha registrado un pago de una cuenta a cobrar pendiente'
            ]);
            $bitacora->setBitacoraData($bitacora_data);
            $bitacora->Guardar_Bitacora();

            } 
            else {
                // Error: usar mensaje dinámico o genérico
                $mensajeError = $resultado['msj'] ?? "ERROR AL REGISTRAR...";
                setError($mensajeError);
            }
        } catch (Exception $e) {
            //mensajes del expcecion del pdo 
            error_log("Error al registrar: " . $e->getMessage());
            setError("Error en operación");
        }
        
    header("Location: index.php?action=cobrar&a=v");
    exit();
    }
}



    function consultar($controller, $roles, $modulo){

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($roles->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {

        // Ejecutar acción permitida
        $cuenta =$controller->manejarAccion("consultar",null);
        require_once "views/php/dashboard_cobrar.php";
        exit();
    }
    setError("Error accion no permitida");
    require_once "views/php/dashboard_cobrar.php";
    exit();
}

?>