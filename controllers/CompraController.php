<?php
// Incluye el archivo del modelo venta
require_once "models/Compra.php";
require_once "models/Producto.php";
require_once "models/Proveedor.php";
require_once "models/Notificacion.php";
require_once "models/Manejo.php";
require_once 'models/Bitacora.php';
require_once 'models/Roles.php';
require_once 'views/php/utils.php';
date_default_timezone_set('America/Caracas');

$ingreso = new Manejo();
$modelo = new Compra();
$producto = new Producto();
$proveedor = new Proveedor();
$notificacion = new Notificacion();
$bitacora = new Bitacora();
$usuario = new Roles();

$modulo = 'Compras';

$action = isset($_GET['a']) ? $_GET['a'] : '';

// Switch de acciones Indiferentemente sea la accion por el post o get el switch 
// llama a cada funcion 
switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregarCompra($modelo, $bitacora, $usuario, $modulo, $producto, $ingreso, $notificacion);
        }
        break;
    case "eliminar":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            eliminaCompra($modelo, $bitacora, $usuario, $modulo);
        }
        break;
    case "c":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultarCompra($modelo, $bitacora, $usuario, $modulo, $proveedor, $producto, $ingreso, $notificacion);
        }
        break;
    default:
        consultarCompra($modelo, $bitacora, $usuario, $modulo, $proveedor, $producto, $ingreso, $notificacion);
        break;
}

// === FUNCIONES ===

// funcion para registrar una compra
function agregarCompra($modelo, $bitacora, $usuario, $modulo, $producto, $ingreso, $notificacion) {
    
    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "agregar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

        // Sanitizar los datos del formulario
        $id_compra = htmlspecialchars($_POST['id_compra']);
        $id_proveedor = htmlspecialchars($_POST['id_proveedor']);
        $cantidad = array_map('htmlspecialchars', $_POST['cantidad']);
        $fech_emision = htmlspecialchars($_POST['fech_emision']);
        $id_modalidad_pago = htmlspecialchars($_POST['id_modalidad_pago']);
        $monto = htmlspecialchars($_POST['total']);
        $tipo_entrega = htmlspecialchars($_POST['tipo_entrega']);
        $rif_banco = htmlspecialchars($_POST['rif_banco']);
        $productos = [
            'id_producto' => [],
            'id_medida' => []
        ];

        // Armar array de productos 
        foreach ($_POST['id_producto'] as $item) {
            $prod = json_decode($item);
            $productos['id_producto'][] = $prod->id_producto;
            $productos['id_medida'][] = $prod->id_unidad_medida;
        }

        $compra = [
            'id_compra' => $id_compra,
            'id_proveedor' => $id_proveedor,
            'cantidad' => $cantidad,
            'fech_emision' => $fech_emision,
            'id_modalidad_pago' => $id_modalidad_pago,
            'monto' => $monto,
            'tipo_entrega' => $tipo_entrega,
            'rif_banco' => $rif_banco,
            'productos' => $productos
        ];

        // Lógica de caja según modalidad de pago
        $id_cajas = ($id_modalidad_pago == 1 || $id_modalidad_pago == 2) ? 1 : 2;

        $egreso_data = [
            'id_cajas' => $id_cajas,
            'movimiento' => "Egreso",
            'fecha' => $fech_emision,
            'monto' => $monto,
            'id_pago' => $id_modalidad_pago,
            'descripcion' => "Compra de productos"
        ];

        try {

            // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
            $resultado = $modelo->manejarAccion("agregar", json_encode($compra));

            //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
            if (isset($resultado['status']) && $resultado['status'] === true) {
                //usar mensaje dinámico del modelo
                setSuccess($resultado['msj']);

                $bitacora_data = json_encode([
                    'id_admin' => $_SESSION['s_usuario']['id'],
                    'movimiento' => 'Agregar',
                    'fecha' => date('Y-m-d H:i:s'),
                    'modulo' => $modulo,
                    'descripcion' =>'El usuario: '.$_SESSION['s_usuario']['usuario']. " ha registrado una compra"
                ]);
                $bitacora->setBitacoraData($bitacora_data);
                $bitacora->Guardar_Bitacora();

                $ingreso->setIngresoEgresoData(json_encode($egreso_data));
                $ingreso->Guardar_IngresoEgreso(json_encode($egreso_data));

                // Aquí notificación 

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

        header("Location: index.php?action=compra&a=c");// Redirect
        exit();
    }
    //muestra un modal de info que dice acceso no permitido
    setError("Error acción no permitida");
    require_once 'views/php/dashboard_compra.php';
    exit();
}


// funcion para consultar compras
function consultarCompra($modelo, $bitacora, $usuario, $modulo, $proveedor, $producto, $ingreso, $notificacion) {
    
    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {
        
        $compras = $modelo->manejarAccion("consultar", null);
        $proveedores = $proveedor->manejarAccion("consultar", null);
        $productos = $producto->manejarAccion("obtenerProductos", null);
        $bancos = $modelo->manejarAccion("obtenerBancos", null);
        $pagos = $modelo->manejarAccion("obtenerPagos", null);
        require_once "views/php/dashboard_compra.php";
    } else {
        //muestra un modal de info que dice acceso no permitido
        setError("Error acción no permitida");
        require_once 'views/php/dashboard_compra.php';
        exit();
    }
}

function eliminaCompra($modelo, $bitacora, $usuario, $modulo) {
    // Implementa la lógica para eliminar compras si la necesitas
    setError("Funcionalidad de eliminar compra no implementada.");
    header("Location: index.php?action=compra&a=v");
    exit();
}
?>
