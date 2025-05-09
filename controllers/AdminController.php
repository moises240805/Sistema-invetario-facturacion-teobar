<?php
// Incluye el archivo del modelo admin y bitacora
require_once "models/Admin.php";
require_once 'models/Bitacora.php';
require_once 'models/Roles.php';
require_once 'views/php/utils.php';

//se instancia los objetos admin y bitacora
$controller = new Admin();
$permiso = new Roles();
$bitacora = new Bitacora();

//se defini en modulo se esta trabajando
$modulo = 'Usuarios';

//zona horaria
date_default_timezone_set('America/Caracas');

//esta variable se utilizara para trabajar la peticiones https dinamicamente ya sea por post o get
$action = isset($_GET['a']) ? $_GET['a'] : '';

//Indiferentemente sea la accion por el post o get el switch llama a cada funcion 
switch ($action) {
    case "ingresar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            iniciarSesion($controller, $bitacora, $usuario, $modulo);
        }
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregarUsuario($controller, $bitacora, $permiso, $modulo);
        }
        break;
    case "mid_form":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            obtenerUsuario($controller, $bitacora, $permiso, $modulo);
        }
        break;
    case "actualizar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            actualizarUsuario($controller, $bitacora, $permiso, $modulo);
        }
        break;
    case "eliminar":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            eliminarUsuario($controller, $bitacora, $permiso, $modulo);
        }
        break;
    case "d":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultarUsuario($controller, $modulo, $permiso);
        }
    case "cerrar":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            cerrarSesion();
        }
        break;
    default:
        consultarUsuario($controller, $modulo, $permiso);
        break;
}

    function iniciarSesion($controller, $bitacora, $usuario, $modulo)
{
    // Obtiene los valores del formulario y los sanitiza
    $username = htmlspecialchars($_POST['usuario']);
    $pw = htmlspecialchars($_POST['pw']);

    //Verifica si todos los campos existen y no esta vacios
    if (empty($username) || empty($pw)) {
        setError("Todos los campos son requeridos");
        header("Location: index.php?action=usuario&a=d");
        exit();
    }

    // Obtiene los datos del usuario desde el modelo
    $usuario = $controller->Iniciar_Sesion($username);

    if ($usuario) {
        // Verifica la contraseña utilizando password_verify
        if (password_verify($pw, $usuario['pw'])) {
            // Asegúra de que la sesión esté iniciada
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Inicializa las variables de sesión
            $_SESSION["s_usuario"] = [
                "id" => $usuario['ID'],
                "usuario" => $usuario['usuario'],
                "id_rol" => $usuario['id_rol'],
                "rol" => $usuario['nombre_rol'],
            ];

            $bitacora_data = json_encode([
            'id_admin' => $_SESSION['s_usuario']['id'],
            'movimiento' => 'Iniciar Sesion',
            'fecha' => date('Y-m-d H:i:s'),
            'modulo' => $modulo,
            'descripcion' =>'El usuario: '.$username. " " . 'ha iniciado session'
            ]);
            $bitacora->setBitacoraData($bitacora_data);
            $bitacora->Guardar_Bitacora();

            if($usuario["nombre_rol"]=="Superusuario"){
            header("Location: index.php?action=dashboard");
            exit(); // Asegúrate de salir después de redirigir 
            }
            if($usuario["nombre_rol"]=="Administrador"){
            header("Location: index.php?action=dashboard");
            exit(); // Asegúrate de salir después de redirigir 
            }
            if($usuario["nombre_rol"]=="Vendedor"){
                header("Location: index.php?action=venta&a=v");
                exit(); // Asegúrate de salir después de redirigir 
                }
            if($usuario["nombre_rol"]=="Usuario"){
                header("Location: index.php?action=pagina");
                exit(); // Asegúrate de salir después de redirigir 
                }
        } else {
            echo '<script type="text/javascript">
                alert("ERROR...!! DATOS INCORRECTOS. VUELVA A INTRODUCIR LOS DATOS");
            window.location.href="index.php?action=login";
                </script>';
        }
    } else {
        echo '<script type="text/javascript">
            alert("ERROR...!! USUARIO NO ENCONTRADO");
            window.location.href="index.php?action=login";
            </script>';
    }
}
// Función para agregar un Usuario
function agregarUsuario($controller, $bitacora, $usuario, $modulo) 
{
    
        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($permiso->verificarPermiso($modulo, $action, $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida
    
        $user = json_encode([
            'username' => htmlspecialchars($_POST['username']),
            'pw' => htmlspecialchars($_POST['pw']),
            'rol' => htmlspecialchars($_POST['rol'])
        ]);

        try {

            // Llama a la funcion manejarAccion del modelo donde pasa el objeto Usuario y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
            $resultado = $controller->manejarAccion('agregar', $user);
        

            //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
            if (isset($resultado['status']) && $resultado['status'] === true) {
                //usar mensaje dinámico del modelo
                setSuccess($resultado['msj']);


                $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => 'Agregar',
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' =>'El usuario: '.$username. " " . 'ha agregado un nuevo usuario'
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

        header("Location: index.php?action=usuario&a=d"); // Redirect
        exit();
    }
    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida ");
    require_once 'views/php/dashboard_admin.php';
    exit();
    
}

// Función para obtener un Usuario
function obtenerUsuario($controller, $bitacora, $usuario, $modulo) {
    

    
    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($permiso=$controller->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

        $id= $_GET['ID'];
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            setError("ID inválido");
            header("Location: index.php?action=usuario&a=d");
            exit();
        }

        // Llama al controlador para mostrar el formulario de modificación
        $accion="obtener";
        $admin=$controller->manejarAccion($accion,$id);
        header('Content-Type: application/json');
        echo json_encode($admin);
        exit();
    }else{
    setError("Error accion no permitida ");
    //require_once 'views/php/dashboard_admin.php';
    exit();
    }
}
// Función para actualizar un Usuario
function actualizarUsuario($controller, $bitacora, $usuario, $modulo) {

    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($permiso->verificarPermiso($modulo, "Modificar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

        // Obtiene los valores del formulario y los sanitiza 
        $user = json_encode([
            'username' => htmlspecialchars($_POST['usuario']),
            'pw' => htmlspecialchars($_POST['clave']),
            'rol' => htmlspecialchars($_POST['roles']),
            'id' => htmlspecialchars($_POST['id'])
        ]);

        try {

            // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
            $resultado = $controller->manejarAccion('obtener', $user);
        

            //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
            if (isset($resultado['status']) && $resultado['status'] === true) {
                //usar mensaje dinámico del modelo
                setSuccess($resultado['msj']);


                $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => 'Modificar',
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' =>'El usuario: '.$username. " " . 'ha modificado un usuario'
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

        header("Location: index.php?action=usuario&a=d"); // Redirect
        exit();
    }
    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida ");
    require_once 'views/php/dashboard_admin.php';
    exit();
    
}
// Función para eliminar un Usuario
function eliminarUsuario($controller, $bitacora, $usuario, $modulo) {

    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($permiso->verificarPermiso($modulo, "Eliminar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida
    
        $id= $_GET['ID'];
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            setError("ID inválido");
            header("Location: index.php?action=usuario&a=d");
            exit();
        }


        try {

        $resultado=$controller->manejarAccion('eliminar',$id);
        
                //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    //usar mensaje dinámico del modelo
                    setSuccess($resultado['msj']);

            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => 'Eliminar',
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' =>'El usuario: '.$username. " " . 'elimino un usuario'
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
        header("Location: index.php?action=usuario&a=d");
        exit();
    }
    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida ");
    require_once 'views/php/dashboard_admin.php';
    exit();
}
// Función para consultar usuarios
function consultarUsuario($controller, $modulo, $permiso) {

    // Verifica si el usuario está logueado y tiene permisos
if (!isset($_SESSION['s_usuario'])) {
    //setError("Acceso no autorizado");
    header("Location: index.php?action=login");
    exit();
}
    
    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($permiso->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {

        // Ejecutar acción permitida
        $admin =$controller->manejarAccion("consultar",null);
        require_once 'views/php/dashboard_admin.php';
        exit();
    }
    else{

        //muestra un modal de info que dice acceso no permitido
        setError("Error accion no permitida ");
        require_once 'views/php/dashboard_admin.php';
        exit(); 
    }
}
    function cerrarSesion()
    {
        
    # Initialize the session
    session_start();

    # Unset all session variables

    # Destroy the session
    session_destroy();

    # Redirect to login page
    header('location:index.php');
    exit();
}
?>