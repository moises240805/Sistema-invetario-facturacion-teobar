<?php
// Incluye el archivo del modelo Producto
require_once "models/Tipo.php";
require_once 'models/Bitacora.php';
require_once "models/Roles.php";
require_once "views/php/utils.php";

$controller = new Tipo();
$usuario = new Roles();
$bitacora = new Bitacora();
$modulo = 'Tipos';
$modulos = 'Tipo de producto';
date_default_timezone_set('America/Caracas');


$action = isset($_GET['a']) ? $_GET['a'] : '';
//Indiferentemente sea la accion por el post o get el switch llama a cada funcion 
switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregarTipo($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "mid_form":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            obtenerTipo($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "actualizar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            actualizarTipo($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "eliminar":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            eliminarTipo($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "t":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultarTipo($controller, $usuario, $modulo);
        }
        break;
    default:
        consultarTipo($controller, $usuario, $modulo);
        break;

}


    function agregarTipo($controller, $bitacora, $usuario, $modulo){


        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if ($usuario->verificarPermiso($modulo, $action, $_SESSION['s_usuario']['id_rol'])) {
            // Ejecutar acción permitida

            // Sanitiza y valida datos
            $tipo_producto = filter_input(INPUT_POST, 'tipo_producto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $presentacion = filter_input(INPUT_POST, 'presentacion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($tipo_producto) || empty($presentacion)) {
                setError("Todos los campos son requeridos");
                header("Location: index.php?action=tipo&a=t");
                exit();
            }

            if (strlen($tipo_producto) > 50 || strlen($presentacion) > 100) {
                setError("Límite de caracteres excedido");
                header("Location: index.php?action=tipo&a=t");
                exit();
            }


            $tipo = json_encode([
                'tipo_producto' => $tipo_producto,
                'presentacion' => $presentacion
            ]);


            try {

                // Llama a la funcion manejarAccion del modelo donde pasa el objeto producto y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
                $resultado = $controller->manejarAccion($action, $tipo);
            
    
                //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                if (isset($resultado['status']) && $resultado['status'] === true) {
    
                    //usar mensaje dinámico del modelo
                    setSuccess($resultado['msj']);

                    $bitacora_data = json_encode([
                        'id_admin' => $_SESSION['s_usuario']['id'],
                        'movimiento' => "Agregar",
                        'fecha' => date('Y-m-d H:i:s'),
                        'modulo' => $modulos,
                        'descripcion' => "Tipo producto: $tipo_producto Con presentacion: $presentacion"
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
            
            header("Location: index.php?action=tipo&a=t"); // Redirect
            exit();
    }
     //muestra un modal de info que dice acceso no permitido
     setError("Error accion no permitida ");
     require_once 'views/php/dashboard_tipo.php';
     exit();
}

    function obtenerTipo($controller, $bitacora, $usuario, $modulo) {
    $id_presentacion = $_GET['id_presentacion'];
    if (!filter_var($id_presentacion, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=tipo&a=t");
        exit();
    }

    $accion="obtener";
    $tipo = $controller->manejarAccion($accion,$id_presentacion);
    echo json_encode($tipo);
}

    function actualizarTipo($controller, $bitacora, $usuario, $modulo) {

            //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "Modificar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

            // Sanitiza y valida datos
            $id_presentacion = filter_input(INPUT_POST, 'id_presentacion', FILTER_VALIDATE_INT);
            $tipo_producto = filter_input(INPUT_POST, 'tipo_producto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $presentacion = filter_input(INPUT_POST, 'presentacion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($tipo_producto) || empty($presentacion)) {
                setError("Todos los campos son requeridos");
                header("Location: index.php?action=tipo&a=t");
                exit();
            }

            if (strlen($tipo_producto) > 50 || strlen($presentacion) > 100) {
                setError("Límite de caracteres excedido");
                header("Location: index.php?action=tipo&a=t");
                exit();
            }


            $tipo = json_encode([
                'id_presentacion' => $id_presentacion,
                'tipo_producto' => $tipo_producto,
                'presentacion' => $presentacion
            ]);

            try {

                // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
                $resultado = $controller->manejarAccion($action, $tipo);
                   
        
                //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    //usar mensaje dinámico del modelo
                    setSuccess($resultado['msj']);

                    $bitacora_data = json_encode([
                        'id_admin' => $_SESSION['s_usuario']['id'],
                        'movimiento' => "Modificar",
                        'fecha' => date('Y-m-d H:i:s'),
                        'modulo' => $modulos,
                        'descripcion' => "Tipo producto: $tipo_producto Con presentacion: $presentacion"
                    ]);
                    $bitacora->setBitacoraData($bitacora_data);
                    $bitacora->Guardar_Bitacora();
                } else {
            // Error: usar mensaje dinámico o genérico
            $mensajeError = $resultado['msj'] ?? "ERROR AL ACTUALIZAR...";
            setError($mensajeError);
        }
    } catch (Exception $e) {
        //mensajes del expcecion del pdo 
        error_log("Error al actualizar: " . $e->getMessage());
        setError("Error en operación");
    }

    header("Location: index.php?action=tipo&a=t");
    exit();
    }
    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida ");
    require_once 'views/php/dashboard_tipo.php';
    exit();
}

    function eliminarTipo($controller, $bitacora, $usuario, $modulo) {

            //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "Eliminar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

            $id_presentacion = $_GET['id_presentacion'];
            if (!filter_var($id_presentacion, FILTER_VALIDATE_INT)) {
                setError("ID inválido");
                header("Location: index.php?action=tipo&a=t");
                exit();
            }

            // Obtener los valores de tipo_producto y presentacion antes de eliminar
            $accion="obtener";
            $tipo = $controller->manejarAccion($accion,$id_presentacion);
            
            if (!$tipo) {
                setError("El registro no existe");
                header("Location: index.php?action=tipo&a=t");
                exit();
            }

            $tipo_producto = $tipo['tipo_producto'];
            $presentacion = $tipo['presentacion'];

            try {

                // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
                $resultado = $controller->manejarAccion($action, $id_presentacion);
                   
        
                //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    //usar mensaje dinámico del modelo
                    setSuccess($resultado['msj']);

                    $bitacora_data = json_encode([
                        'id_admin' => $_SESSION['s_usuario']['id'],
                        'movimiento' => "Eliminar",
                        'fecha' => date('Y-m-d H:i:s'),
                        'modulo' => $modulos,
                        'descripcion' => "Tipo producto: $tipo_producto Con presentacion: $presentacion"
                    ]);
                    $bitacora->setBitacoraData($bitacora_data);
                    $bitacora->Guardar_Bitacora();
                } else {
                    // Error: usar mensaje dinámico o genérico
                    $mensajeError = $resultado['msj'] ?? "ERROR AL ELIMINAR...";
                    setError($mensajeError);
                }
            } catch (Exception $e) {
                //mensajes del expcecion del pdo 
                error_log("Error al eliminar: " . $e->getMessage());
                setError("Error en operación");
            }
            
            header("Location: index.php?action=tipo&a=t");
            exit();
            }
            //muestra un modal de info que dice acceso no permitido
            setError("Error accion no permitida ");
            require_once 'views/php/dashboard_tipo.php';
            exit();
}

    function consultarTipo($controller, $usuario, $modulo) {

    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
 //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
 //action y el rol de usuario
 if ($usuario->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {

     // Ejecutar acción permitida
     $tipo =$controller->manejarAccion("consultar",null);
     require_once 'views/php/dashboard_tipo.php';
     exit();
 }
 else{

     //muestra un modal de info que dice acceso no permitido
     setError("Error accion no permitida ");
     require_once 'views/php/dashboard_tipo.php';
     exit(); 
 }
}
?>