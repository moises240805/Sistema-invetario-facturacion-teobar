<?php
require_once 'models/Caja.php';
require_once 'models/Bitacora.php';
require_once 'views/php/utils.php';
date_default_timezone_set('America/Caracas');
$controller = new Caja();
$bitacora = new Bitacora();

$action = isset($_GET['a']) ? $_GET['a'] : '';
switch ($action) {
    case 'consultar':
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultar($controller);
        }
    break;
    case 'open':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            Open($controller, $bitacora);
        }
    break;
    case 'close':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            Close($controller, $bitacora);
        }
    break;
    default:
        consultar($controller);
    break;
}

    function consultar($controller){
        $caja = $controller->manejarAccion("consultar");
    }

    function Open($controller, $bitacora){

    if (!estaDentroHorarioLaboral()) {
        setError("No se puede aperturar la caja fuera del horario laboral (Lun-Vie 8:00 - 17:00).");
        header("Location: index.php?action=movimientos");
        exit();
    }
        $confirm = $_POST["status"];

        try {

            // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
            $resultado = $controller->manejarAccion("open",$confirm);

            //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
            if (isset($resultado['status']) && $resultado['status'] === true) {

                //usar mensaje dinámico del modelo
                setSuccess($resultado['msj']);

                $bitacora_data = json_encode([
                    'id_admin' => $_SESSION['s_usuario']['id'],
                    'movimiento' => 'Apertura',
                    'fecha' => date('Y-m-d H:i:s'),
                    'modulo' => 'Ingreso Egreso Caja',
                    'descripcion' =>'El usuario: '.$_SESSION['s_usuario']['usuario']. " " . 'ha aperturado las cajas'
                ]);
                $bitacora->setBitacoraData($bitacora_data);
                $bitacora->Guardar_Bitacora();
            } 
            else {
                // Error: usar mensaje dinámico o genérico
                $mensajeError = $resultado['msj'] ?? "ERROR AL ABRIR...";
                setError($mensajeError);
            }
        } catch (Exception $e) {
            //mensajes del expcecion del pdo 
            error_log("Error al abrir: " . $e->getMessage());
            setError("Error en operación");
        }
        
        header("Location: index.php?action=movimientos"); // Redirect
        exit();
    }

    function Close($controller, $bitacora){

        if (!estaDentroHorarioLaboral()) {
        setError("No se puede cerrar la caja fuera del horario laboral (Lun-Vie 8:00 - 17:00).");
        header("Location: index.php?action=movimientos");
        exit();
    }

        try {

            // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
            $resultado = $controller->manejarAccion("close",null);

            //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
            if (isset($resultado['status']) && $resultado['status'] === true) {

                //usar mensaje dinámico del modelo
                setSuccess($resultado['msj']);

                $bitacora_data = json_encode([
                    'id_admin' => $_SESSION['s_usuario']['id'],
                    'movimiento' => 'Cierre',
                    'fecha' => date('Y-m-d H:i:s'),
                    'modulo' => 'Ingreso Egreso Caja',
                    'descripcion' =>'El usuario: '.$_SESSION['s_usuario']['usuario']. " " . 'ha cerrado las cajas'
                ]);
                $bitacora->setBitacoraData($bitacora_data);
                $bitacora->Guardar_Bitacora();
            } 
            else {
                // Error: usar mensaje dinámico o genérico
                $mensajeError = $resultado['msj'] ?? "ERROR AL CERRAR...";
                setError($mensajeError);
            }
        } catch (Exception $e) {
            //mensajes del expcecion del pdo 
            error_log("Error al cerrar: " . $e->getMessage());
            setError("Error en operación");
        }
        
        header("Location: index.php?action=movimientos"); // Redirect
        exit();
    }

function estaDentroHorarioLaboral() {
    // Zona horaria ya configurada con date_default_timezone_set('America/Caracas');

    $diaSemana = date('N'); // 1 (lunes) a 7 (domingo)
    $horaActual = date('H:i');

    // Definir horario laboral
    $horaInicio = '08:00';
    $horaFin = '17:00';

    // Verificar día (lunes a viernes)
    if ($diaSemana >= 1 && $diaSemana <= 5) {
        // Verificar hora
        if ($horaActual >= $horaInicio && $horaActual <= $horaFin) {
            return true;
        }
    }
    return false;
}

?> 