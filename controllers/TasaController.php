<?php
// Incluye el archivo del modelo Producto
require_once "models/Tasa.php";
require_once 'models/Bitacora.php';
require_once "models/Roles.php";
require_once "views/php/utils.php";

$controller = new Tasa();
$usuario = new Roles();
$bitacora = new Bitacora();
$modulo = 'Tasa';
$modulos = 'Tasa del $';
date_default_timezone_set('America/Caracas');


$action = isset($_GET['a']) ? $_GET['a'] : '';
//Indiferentemente sea la accion por el post o get el switch llama a cada funcion 
switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregar($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "mid_form":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            obtener($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultar($controller, $usuario, $modulo);
        }
        break;
    default:
        consultar($controller, $usuario, $modulo);
        break;

}


    function agregar($controller, $bitacora, $usuario, $modulo){


        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if ($usuario->verificarPermiso($modulo, "agregar", $_SESSION['s_usuario']['id_rol'])) {
            // Ejecutar acción permitida

            // Sanitiza y valida datos
            $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($valor)){
                setError("Todos los campos son requeridos");
                header("Location: index.php?action=tasa");
                exit();
            }


            $valor = json_encode([
                'valor' => $valor
            ]);


            try {

                // Llama a la funcion manejarAccion del modelo donde pasa el objeto producto y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
                $resultado = $controller->manejarAccion("agregar", $valor);
            
    
                //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                if (isset($resultado['status']) && $resultado['status'] === true) {
    
                    //usar mensaje dinámico del modelo
                    setSuccess($resultado['msj']);

                    $bitacora_data = json_encode([
                        'id_admin' => $_SESSION['s_usuario']['id'],
                        'movimiento' => "Agregar",
                        'fecha' => date('Y-m-d H:i:s'),
                        'modulo' => $modulos,
                        'descripcion' => "El usuario registro la siguiente tasa del dia con el siguiente valor: $valor"
                    ]);
                    $bitacora->setBitacoraData($bitacora_data);
                    $bitacora->Guardar_Bitacora();
                } else {
                    // Error: usar mensaje dinámico o genérico
                    $mensajeError = $resultado['msj'] ?? "ERROR AL REGISTRAR...";
                    setError($mensajeError);
                }
            } catch (Exception $e) {
                //mensajes del expcecion del pdo 
                error_log("Error al registrar: " . $e->getMessage());
                setError("Error en operación");
            }
            
            header("Location: index.php?action=tasa"); // Redirect
            exit();
    }
     //muestra un modal de info que dice acceso no permitido
     setError("Error accion no permitida ");
     require_once 'views/php/dashboard_tasa.php';
     exit();
}

    function obtener($controller, $bitacora, $usuario, $modulo) {
    

    $accion="obtener";
    $tasa = $controller->manejarAccion($accion,null);
    echo json_encode($tasa);
}

    
    function consultar($controller, $usuario, $modulo) {

    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
 //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
 //action y el rol de usuario
 if ($usuario->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {

     // Ejecutar acción permitida
     $tasa =$controller->manejarAccion("consultar",null);
     require_once 'views/php/dashboard_tasa.php';
     exit();
 }
 else{

     //muestra un modal de info que dice acceso no permitido
     setError("Error accion no permitida ");
     require_once 'views/php/dashboard_tasa.php';
     exit(); 
 }
}
?>