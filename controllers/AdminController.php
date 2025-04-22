<?php
// Incluye el archivo del modelo Producto
require_once "models/Admin.php";
require_once 'models/Bitacora.php';
$controller = new Admin();
$bitacora = new Bitacora();
$modulo = 'Usuario';
date_default_timezone_set('America/Caracas');

$action = isset($_GET['a']) ? $_GET['a'] : '';

if ($action == 'ingresar' && $_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Obtiene los valores del formulario y los sanitiza
    $username = htmlspecialchars($_POST['usuario']);
    $pw = htmlspecialchars($_POST['pw']);

    // Obtiene los datos del usuario desde el modelo
    $usuario = $controller->Iniciar_Sesion($username);

    if ($usuario) {
        // Verifica la contraseña utilizando password_verify
        if (password_verify($pw, $usuario['pw'])) {
            // Asegúrate de que la sesión esté iniciada
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
elseif ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    $user = json_encode([
        'username' => htmlspecialchars($_POST['username']),
        'pw' => htmlspecialchars($_POST['pw']),
        'rol' => htmlspecialchars($_POST['rol'])
    ]);

    // Envía el JSON al modelo
    $controller->setUserData($user);

    // Llama al método guardarPersona del controlador y guarda el resultado en $message
    if($controller->Guardar_Usuario($user))
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "USUARIO REGISTRADO CORRECTAMENTE";


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
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL REGISTRAR EL USUARIO... USUARIO EXISTENTE";
    }
    
    header("Location: index.php?action=usuario&a=d"); // Redirect
    exit();
}

elseif ($action == 'mid_form' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id= $_GET['ID'];
    // Llama al controlador para mostrar el formulario de modificación
    $admin=$controller->Obtener_Usuario($id);
    header('Content-Type: application/json');
    echo json_encode($admin);
}
else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario y los sanitiza 
    $user = json_encode([
        'username' => htmlspecialchars($_POST['usuario']),
        'pw' => htmlspecialchars($_POST['clave']),
        'rol' => htmlspecialchars($_POST['roles']),
        'id' => htmlspecialchars($_POST['id'])
    ]);

    $controller->setUserData($user);
    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if($controller->Actualizar_Usuario($user)) 
    {
        $_SESSION['message_type'] = 'success';  // Set success flag
        $_SESSION['message'] = "USUARIO ACTUALIZADO CORRECTAMENTE";


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
        $_SESSION['message_type'] = 'danger'; // Set error flag
        $_SESSION['message'] = "ERROR AL ACTUALIZAR EL USUARIO";
    }

    // Vuelve a cargar el formulario con el mensaje
    header("Location: index.php?action=usuario&a=d"); // Redirect
    exit();
    
}
elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $username = $_GET['ID'];
    // Llama al controlador para mostrar el formulario de modificación
    $admin=$controller->Eliminar_Usuario($username);
    if($admin) 
    { 
        $_SESSION['message_type'] = 'success';
        $_SESSION['message'] = "USUARIO ELIMINADO CORRECTAMENTE";
        $_SESSION['modal_title'] = "Eliminación Exitosa"; //New

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
        $_SESSION['message_type'] = 'danger';
        $_SESSION['message'] = "ERROR AL ELIMINAR EL USUARIO";
        $_SESSION['modal_title'] = "Error de Eliminación"; //New
    }
    header("Location: index.php?action=usuario&a=d");
    exit();
}
elseif ($action == 'd' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    if($_SESSION["s_usuario"]["rol"]=="Usuario"){
        header("Location: index.php?action=pagina");
        exit(); // Asegúrate de salir después de redirigir 
        }
        else
        {
            require_once "views/php/dashboard_admin.php";
        }
}
else{
    //require_once "views/php/login.php";
}
?>