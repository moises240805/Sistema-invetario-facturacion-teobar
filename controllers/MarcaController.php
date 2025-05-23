<?php
// Incluye el archivo del modelo Producto
require_once "models/Marca.php";
require_once 'models/Bitacora.php';
require_once "models/Roles.php";
require_once "views/php/utils.php";

$controller = new Marca();
$usuario = new Roles();
$bitacora = new Bitacora();
$modulo = 'Marcas';
$modulos = 'Marcas de producto';
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
    case "actualizar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            actualizar($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "eliminar":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            eliminar($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "t":
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
            $marca = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($marca)){
                setError("Todos los campos son requeridos");
                header("Location: index.php?action=categoria");
                exit();
            }


            $marcas = json_encode([
                'marca' => $marca
            ]);


            try {

                // Llama a la funcion manejarAccion del modelo donde pasa el objeto producto y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
                $resultado = $controller->manejarAccion("agregar", $marcas);
            
    
                //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                if (isset($resultado['status']) && $resultado['status'] === true) {
    
                    //usar mensaje dinámico del modelo
                    setSuccess($resultado['msj']);

                    $bitacora_data = json_encode([
                        'id_admin' => $_SESSION['s_usuario']['id'],
                        'movimiento' => "Agregar",
                        'fecha' => date('Y-m-d H:i:s'),
                        'modulo' => $modulos,
                        'descripcion' => "El usuario registro la siguiente marca: $marca"
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
            
            header("Location: index.php?action=marca"); // Redirect
            exit();
    }
     //muestra un modal de info que dice acceso no permitido
     setError("Error accion no permitida ");
     require_once 'views/php/dashboard_marca.php';
     exit();
}

    function obtener($controller, $bitacora, $usuario, $modulo) {
    $id_marca = $_GET['ID'];
    if (!filter_var($id_marca, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=marca");
        exit();
    }

    $accion="obtener";
    $marca = $controller->manejarAccion($accion,$id_marca);
    echo json_encode($marca);
}

    function actualizar($controller, $bitacora, $usuario, $modulo) {

            //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "Modificar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

            // Sanitiza y valida datos
            $id_marca = filter_input(INPUT_POST, 'id_marca', FILTER_VALIDATE_INT);
            $marca = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($id_marca) || empty($marca)) {
                setError("Todos los campos son requeridos");
                header("Location: index.php?action=marca");
                exit();
            }



            $marcas = json_encode([
                'id_marca' => $id_marca,
                'marca' => $marca
            ]);

            try {

                // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
                $resultado = $controller->manejarAccion("actualizar", $marcas);
                   
        
                //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    //usar mensaje dinámico del modelo
                    setSuccess($resultado['msj']);

                    $bitacora_data = json_encode([
                        'id_admin' => $_SESSION['s_usuario']['id'],
                        'movimiento' => "Modificar",
                        'fecha' => date('Y-m-d H:i:s'),
                        'modulo' => $modulos,
                        'descripcion' => "El usuario modifico la siguiente marca: $marca"
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

    header("Location: index.php?action=marca");
    exit();
    }
    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida ");
    require_once 'views/php/dashboard_marca.php';
    exit();
}

    function eliminar($controller, $bitacora, $usuario, $modulo) {

            //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "Eliminar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

            $id_marca = $_GET['ID'];
            if (!filter_var($id_marca, FILTER_VALIDATE_INT)) {
                setError("ID inválido");
                header("Location: index.php?action=marca");
                exit();
            }

            // Obtener los valores de tipo_producto y presentacion antes de eliminar
            $accion="obtener";
            $marcas = $controller->manejarAccion($accion,$id_marca);
            
            if (!$marcas) {
                setError("El registro no existe");
                header("Location: index.php?action=marca");
                exit();
            }

            
            $marca = $marcas["nombre_marca"];
            try {

                // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
                $resultado = $controller->manejarAccion("eliminar", $id_marca);
                   
        
                //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    //usar mensaje dinámico del modelo
                    setSuccess($resultado['msj']);

                    $bitacora_data = json_encode([
                        'id_admin' => $_SESSION['s_usuario']['id'],
                        'movimiento' => "Eliminar",
                        'fecha' => date('Y-m-d H:i:s'),
                        'modulo' => $modulos,
                        'descripcion' => "El usuario elimino la siguiente marca: $marca"
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
            
            header("Location: index.php?action=marca");
            exit();
            }
            //muestra un modal de info que dice acceso no permitido
            setError("Error accion no permitida ");
            require_once 'views/php/dashboard_marca.php';
            exit();
}

    function consultar($controller, $usuario, $modulo) {

    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
 //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
 //action y el rol de usuario
 if ($usuario->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {

     // Ejecutar acción permitida
     $marcas =$controller->manejarAccion("consultar",null);
     require_once 'views/php/dashboard_marca.php';
     exit();
 }
 else{

     //muestra un modal de info que dice acceso no permitido
     setError("Error accion no permitida ");
     require_once 'views/php/dashboard_marca.php';
     exit(); 
 }
}
?>