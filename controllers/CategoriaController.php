<?php
// Incluye el archivo del modelo Producto
require_once "models/Categoria.php";
require_once 'models/Bitacora.php';
require_once "models/Roles.php";
require_once "views/php/utils.php";

$controller = new Categoria();
$usuario = new Roles();
$bitacora = new Bitacora();
$modulo = 'Categorias';
$modulos = 'Categorias de producto';
date_default_timezone_set('America/Caracas');


$action = isset($_GET['a']) ? $_GET['a'] : '';
//Indiferentemente sea la accion por el post o get el switch llama a cada funcion 
switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregarCategoria($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "mid_form":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            obtenerCategoria($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "actualizar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            actualizarCategoria($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "eliminar":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            eliminarCategoria($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "t":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultarCategoria($controller, $usuario, $modulo);
        }
        break;
    default:
        consultarCategoria($controller, $usuario, $modulo);
        break;

}


    function agregarCategoria($controller, $bitacora, $usuario, $modulo){


        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if ($usuario->verificarPermiso($modulo, "agregar", $_SESSION['s_usuario']['id_rol'])) {
            // Ejecutar acción permitida

            // Sanitiza y valida datos
            $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($categoria)){
                setError("Todos los campos son requeridos");
                header("Location: index.php?action=categoria");
                exit();
            }

            if (strlen($categoria) > 70) {
                setError("Límite de caracteres excedido");
                header("Location: index.php?action=categoria");
                exit();
            }


            $categorias = json_encode([
                'categoria' => $categoria
            ]);


            try {

                // Llama a la funcion manejarAccion del modelo donde pasa el objeto producto y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
                $resultado = $controller->manejarAccion("agregar", $categorias);
            
    
                //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                if (isset($resultado['status']) && $resultado['status'] === true) {
    
                    //usar mensaje dinámico del modelo
                    setSuccess($resultado['msj']);

                    $bitacora_data = json_encode([
                        'id_admin' => $_SESSION['s_usuario']['id'],
                        'movimiento' => "Agregar",
                        'fecha' => date('Y-m-d H:i:s'),
                        'modulo' => $modulos,
                        'descripcion' => "El usuario registro la siguiente categotia: $categoria"
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
            
            header("Location: index.php?action=categoria"); // Redirect
            exit();
    }
     //muestra un modal de info que dice acceso no permitido
     setError("Error accion no permitida ");
     require_once 'views/php/dashboard_categoria.php';
     exit();
}

    function obtenerCategoria($controller, $bitacora, $usuario, $modulo) {
    $id_categoria = $_GET['ID'];
    if (!filter_var($id_categoria, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=categoria");
        exit();
    }

    $accion="obtener";
    $categoria = $controller->manejarAccion($accion,$id_categoria);
    echo json_encode($categoria);
}

    function actualizarCategoria($controller, $bitacora, $usuario, $modulo) {

            //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "Modificar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

            // Sanitiza y valida datos
            $id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_VALIDATE_INT);
            $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($id_categoria) || empty($categoria)) {
                setError("Todos los campos son requeridos");
                header("Location: index.php?action=categoria");
                exit();
            }

            if (strlen($categoria) > 70) {
                setError("Límite de caracteres excedido");
                header("Location: index.php?action=categoria");
                exit();
            }


            $categorias = json_encode([
                'id_categoria' => $id_categoria,
                'categoria' => $categoria
            ]);

            try {

                // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
                $resultado = $controller->manejarAccion("actualizar", $categorias);
                   
        
                //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    //usar mensaje dinámico del modelo
                    setSuccess($resultado['msj']);

                    $bitacora_data = json_encode([
                        'id_admin' => $_SESSION['s_usuario']['id'],
                        'movimiento' => "Modificar",
                        'fecha' => date('Y-m-d H:i:s'),
                        'modulo' => $modulos,
                        'descripcion' => "El usuario modifico la siguiente categoria: $categoria"
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

    header("Location: index.php?action=categoria");
    exit();
    }
    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida ");
    require_once 'views/php/dashboard_categoria.php';
    exit();
}

    function eliminarCategoria($controller, $bitacora, $usuario, $modulo) {

            //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "Eliminar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

            $id_categoria = $_GET['ID'];
            if (!filter_var($id_categoria, FILTER_VALIDATE_INT)) {
                setError("ID inválido");
                header("Location: index.php?action=categoria");
                exit();
            }

            // Obtener los valores de tipo_producto y presentacion antes de eliminar
            $accion="obtener";
            $categorias = $controller->manejarAccion($accion,$id_categoria);
            
            if (!$categorias) {
                setError("El registro no existe");
                header("Location: index.php?action=categoria");
                exit();
            }

            
            $categoria = $categorias["nombre_categoria"];
            try {

                // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
                $resultado = $controller->manejarAccion("eliminar", $id_categoria);
                   
        
                //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    //usar mensaje dinámico del modelo
                    setSuccess($resultado['msj']);

                    $bitacora_data = json_encode([
                        'id_admin' => $_SESSION['s_usuario']['id'],
                        'movimiento' => "Eliminar",
                        'fecha' => date('Y-m-d H:i:s'),
                        'modulo' => $modulos,
                        'descripcion' => "El usuario elimino la siguiente categoria: $categoria"
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
            
            header("Location: index.php?action=categoria");
            exit();
            }
            //muestra un modal de info que dice acceso no permitido
            setError("Error accion no permitida ");
            require_once 'views/php/dashboard_categoria.php';
            exit();
}

    function consultarCategoria($controller, $usuario, $modulo) {

    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
 //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
 //action y el rol de usuario
 if ($usuario->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {

     // Ejecutar acción permitida
     $categorias =$controller->manejarAccion("consultar",null);
     require_once 'views/php/dashboard_categoria.php';
     exit();
 }
 else{

     //muestra un modal de info que dice acceso no permitido
     setError("Error accion no permitida ");
     require_once 'views/php/dashboard_categoria.php';
     exit(); 
 }
}
?>