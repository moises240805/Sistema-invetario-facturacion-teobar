<?php
//Se llama al modelo cliente , bitacoras y usuarios
require_once 'models/Cliente.php';
require_once 'models/Bitacora.php';
require_once 'models/Roles.php';
require_once 'views/php/utils.php';

//Se instancia los modelos
$controller = new Cliente();
$bitacora = new Bitacora();
$usuario = new Roles();

//esta variables es para definir el modulo en la bitacora para cuando se cree el json 
$modulo = 'Clientes';
date_default_timezone_set('America/Caracas');//Zona horaria


//Esta variable manejara de forma dinamica las solicitudes http ya sean post o get
$action = isset($_GET['a']) ? $_GET['a'] : '';


//Indiferentemente sea la accion por el post o get el switch llama a cada funcion 
switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregarCliente($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "mid_form":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            obtenerCliente($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "actualizar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            actualizarCliente($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "eliminar":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            eliminarCliente($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "d":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultarCliente($controller, $usuario, $modulo);
        }
        break;
    default:
        consultarCliente($controller, $usuario, $modulo);
        break;
}



// Función para agregar un cliente
function agregarCliente($controller, $bitacora, $usuario, $modulo) {

    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "agregar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida
    
        // Obtiene los valores del formulario y los sanitiza
        $tipo_id = filter_input(INPUT_POST, 'tipo_cliente', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id_cliente = filter_input(INPUT_POST, 'id_cliente', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $nombre_cliente = filter_input(INPUT_POST, 'nombre_cliente', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $telefono = filter_input(INPUT_POST, 'codigo_tlf', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        //Verifica si todos los campos existen y no esta vacios
        if (empty($tipo_id) || empty($id_cliente) || empty($nombre_cliente) || empty($telefono) || empty($direccion) || empty($email)) {
            setError("Todos los campos son requeridos");
            header("Location: index.php?action=cliente&a=d");
            exit();
        }

        //Se crea el objeto json de cliente con todos los valores necesarios
        $cliente = json_encode([
            'tipo_id' => $tipo_id,
            'id_cliente' => $id_cliente,
            'nombre_cliente' => $nombre_cliente,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'email' => $email
        ]);


        try {

            // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
            $resultado = $controller->manejarAccion("agregar", $cliente);
        

            //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
            if (isset($resultado['status']) && $resultado['status'] === true) {
                //usar mensaje dinámico del modelo
                setSuccess($resultado['msj']);
                
                //se crea un json de los datos qe tendra la bitacora
                $bitacora_data = json_encode([
                    'id_admin' => $_SESSION['s_usuario']['id'],
                    'movimiento' => "Agregar",
                    'fecha' => date('Y-m-d H:i:s'),
                    'modulo' => $modulo,
                    'descripcion' => "Cliente con la cedula: " . ($_POST['tipo_cliente'] ?? '') . " " . ($_POST['id_cliente'] ?? '')
                ]);
                //Llama las funciones para registrar la bitacora
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
        
        header("Location: index.php?action=cliente&a=d"); // Redirect
        exit();
    }
    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida ");
    require_once 'views/php/dashboard_cliente.php';
    exit();
}



// Función para obtener un cliente
function obtenerCliente($controller, $bitacora, $usuario, $modulo) {
    
    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    //if ($usuario->verificarPermiso($modulo, "Consultar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

        $id_cliente = $_GET['id_cliente'];
        if (!filter_var($id_cliente, FILTER_VALIDATE_INT)) {
            setError("ID inválido");
            header("Location: index.php?action=cliente&a=d");
            exit();
        }

        $accion="obtener";
        $cliente=$controller->manejarAccion("obtener",$id_cliente);
        echo json_encode($cliente);
    //}
    //muestra un modal de info que dice acceso no permitido
    //setError("Error accion no permitida ");
    //require_once 'views/php/dashboard_cliente.php';
    //exit();
}




// Función para actualizar un cliente
function actualizarCliente($controller, $bitacora, $usuario, $modulo) {

    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "Modificar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

    // Obtiene los valores del formulario y los sanitiza 
    $id_cliente = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
    $tipo_id = filter_input(INPUT_POST, 'tipo_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombre_cliente = filter_input(INPUT_POST, 'nombre_cliente', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $telefono = filter_input(INPUT_POST, 'codigo_tlf', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($nombre_cliente) || empty($telefono) || empty($direccion) || empty($email)) {
        setError("Todos los campos son requeridos");
        header("Location: index.php?action=cliente&a=d");
        exit();
    }

    $cliente = json_encode([
        'id_cliente' => $id_cliente,
        'tipo_id' => $tipo_id,
        'nombre_cliente' => $nombre_cliente,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'email' => $email
    ]);
    

    try {

        // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
        $resultado = $controller->manejarAccion("actualizar", $cliente);
           

        //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
        if (isset($resultado['status']) && $resultado['status'] === true) {
            //usar mensaje dinámico del modelo
            setSuccess($resultado['msj']);

            //se crea un json de los datos qe tendra la bitacora
            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Modificar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Cliente con la cedula: $tipo_id $id_cliente"
            ]);

            //Llama las funciones para registrar la bitacora
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

    header("Location: index.php?action=cliente&a=d");
    exit();
    }
    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida ");
    require_once 'views/php/dashboard_cliente.php';
    exit();
}


// Función para eliminar un cliente
function eliminarCliente($controller, $bitacora, $usuario, $modulo) {

    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "Eliminar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

    $id_cliente = $_GET['ID'];
    if (!filter_var($id_cliente, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=cliente&a=d");
        exit();
    }

    $accion = "obtener";
    $cliente = $controller->manejarAccion($accion, $id_cliente);
    
    if (!$cliente) {
        setError("El registro no existe");
        header("Location: index.php?action=cliente&a=d");
        exit();
    }

    $tipo_id = $cliente['tipo_id'];
    $nombre_cliente = $cliente['nombre_cliente'];


    try {

        // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
        $resultado = $controller->manejarAccion("eliminar", $id_cliente);
           

        //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
        if (isset($resultado['status']) && $resultado['status'] === true) {
            //usar mensaje dinámico del modelo
            setSuccess($resultado['msj']);

            //se crea un json de los datos qe tendra la bitacora
            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Eliminar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Cliente con la cedula: $tipo_id $id_cliente"
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
    
    header("Location: index.php?action=cliente&a=d");
    exit();
    }
    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida ");
    require_once 'views/php/dashboard_cliente.php';
    exit();
}


// Función para consultar clientes
function consultarCliente($controller, $usuario, $modulo) {

    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {

        // Ejecutar acción permitida
        $clientes =$controller->manejarAccion("consultar",null);
        require_once 'views/php/dashboard_cliente.php';
        exit();
    }
    else{

        //muestra un modal de info que dice acceso no permitido
        setError("Error accion no permitida ");
        require_once 'views/php/dashboard_cliente.php';
        exit(); 
    }

}
?>