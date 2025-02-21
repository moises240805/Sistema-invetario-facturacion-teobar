<?php
// Incluye el archivo del modelo Producto
require_once "models/Admin.php";

$controller = new Admin();

$message="";

$action = isset($_GET['action']) ? $_GET['action'] : '';

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
                "usuario" => $usuario['usuario'],
                "rol" => $usuario['rol'],
            ];
            
            header("Location: pag_inic.php");
            exit(); // Asegúrate de salir después de redirigir
        } else {
            echo '<script type="text/javascript">
                alert("ERROR...!! DATOS INCORRECTOS. VUELVA A INTRODUCIR LOS DATOS");
                window.location.href="index.php";
                </script>';
        }
    } else {
        echo '<script type="text/javascript">
            alert("ERROR...!! USUARIO NO ENCONTRADO");
            window.location.href="index.php";
            </script>';
    }
}
elseif ($action == "agregar" && $_SERVER["REQUEST_METHOD"] == "POST")
{
    // Obtiene los valores del formulario y los sanitiza
    $username = htmlspecialchars($_POST['username']);
    $pw = htmlspecialchars($_POST['pw']);
    $rol = htmlspecialchars($_POST['rol']);

    $controller->setUserData($username, $pw, $id, $rol);
    // Llama al método guardarPersona del controlador y guarda el resultado en $message
    if($controller->Guardar_Usuario($username, $pw, $rol))
    {
        $message3 = "USUARIO REGISTRADO CORRECTAMENTE"; // Establece el mensaje de éxito
        echo "<script>
            if (confirm('$message3')) {
                // Si el usuario acepta, permanece en el formulario
                window.location.href = 'crud_admin.php?action=formulario'; // Usar variable PHP
            } else {
                // Si el usuario cancela, redirige al dashboard
                window.location.href = 'crud_admin.php?action=d'; // Usar variable PHP
            }
          </script>";
    } else {
        $message3 = "ERROR AL REGISTRAR EL USUARIO... USUARIO EXISTENTE"; // Establece el mensaje de error
    }require_once "views/php/dashboard_admin.php";
}
elseif ($action == "formulario" && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    require_once "views/php/form_admin.php";
    
}
elseif ($action == 'mid_form' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id= $_GET['ID'];
    require_once "views/php/form_mid_admin.php";
    // Llama al controlador para mostrar el formulario de modificación
    $admin=$controller->Obtener_Usuario($id);
}
else if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario y los sanitiza 
    $username = htmlspecialchars($_POST['usuario']); 
    $pw = htmlspecialchars($_POST['pw']); 
    $id = htmlspecialchars($_POST['id']);
    $rol = htmlspecialchars($_POST['rol']);

    $controller->setUserData($username, $pw, $id, $rol);
    // Llama al método actualizar producto del controlador y guarda el resultado en $message 
    if($controller->Actualizar_Usuario($username, $pw,$id,$rol)) 
    { 
        $message2 = "USUARIO ACTUALIZADO CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $message2 = "ERROR AL ACTUALIZAR EL CLIENTE"; // Establece el mensaje de error
    }

    // Vuelve a cargar el formulario con el mensaje
    require_once "views/php/dashboard_admin.php";
    
}
elseif ($action == 'eliminar' && $_SERVER["REQUEST_METHOD"] == "GET") {
    
    $username = $_GET['ID'];
    // Llama al controlador para mostrar el formulario de modificación
    $admin=$controller->Eliminar_Usuario($username);
    if($admin) 
    { 
        $message = "USUARIO ELIMINADO CORRECTAMENTE"; // Establece el mensaje de éxito
    } else {
        $message = "ERROR AL ELIMINAR EL USUARIO"; // Establece el mensaje de error
    }
    require_once "views/php/dashboard_admin.php";
}
elseif ($action == 'd' && $_SERVER["REQUEST_METHOD"] == "GET") {
    require_once "views/php/dashboard_admin.php";
}
else{
    require_once "views/php/login.php";
}
?>