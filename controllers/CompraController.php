<?php
// Incluye el archivo del modelo venta
require_once "models/Compra.php";
require_once "models/Producto.php";
require_once "models/Proveedor.php";
require_once "models/Notificacion.php";
require_once "models/Manejo.php";
require_once 'models/Bitacora.php';
require_once 'models/Roles.php';
require_once "models/Caja.php";
require_once 'views/php/utils.php';
date_default_timezone_set('America/Caracas');

$ingreso = new Manejo();
$modelo = new Compra();
$producto = new Producto();
$proveedor = new Proveedor();
$notificacion = new Notificacion();
$bitacora = new Bitacora();
$usuario = new Roles();
$caja = new Caja();

$modulo = 'Compras';

$action = isset($_GET['a']) ? $_GET['a'] : '';

// Switch de acciones Indiferentemente sea la accion por el post o get el switch 
// llama a cada funcion 
switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregarCompra($modelo, $bitacora, $usuario, $modulo, $producto, $ingreso, $notificacion, $caja);
        }
        break;
    case "eliminar":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            eliminarCompra($modelo, $bitacora, $usuario, $modulo);
        }
    case "obtener_proveedor":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            obtenerProveedor($producto, $bitacora, $usuario, $modulo);
        }
        break;
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
function agregarCompra($modelo, $bitacora, $usuario, $modulo, $producto, $ingreso, $notificacion, $caja) {
    
    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "agregar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

        // Sanitizar los datos del formulario
        // Sanitizar los datos del formulario
$id_compra = htmlspecialchars($_POST['id_compra']);
$id_proveedor = htmlspecialchars($_POST['id_proveedor']);
$cantidad = array_map('htmlspecialchars', $_POST['cantidad']);
$fech_emision = htmlspecialchars($_POST['fech_emision']);
$id_modalidad_pago = htmlspecialchars($_POST['id_modalidad_pago']);
$monto = htmlspecialchars($_POST['total']);
$tipo_entrega = htmlspecialchars($_POST['tipo_entrega']);
$rif_banco = htmlspecialchars($_POST['rif_banco']);
$fech_vencimiento = isset($_POST['fecha_caducidad']) ? htmlspecialchars($_POST['fecha_caducidad']) : null;

// Inicializa el array productos vacío
$productos = [
    'id_producto' => [],
    'id_medida' => []
];

// Recorre los productos enviados desde el formulario y llena el array productos
foreach ($_POST['id_producto'] as $item) {
    $producto = json_decode($item);
    if (isset($producto->id_producto) && isset($producto->id_unidad_medida) 
        && !empty($producto->id_producto) && !empty($producto->id_unidad_medida)) {
        $productos['id_producto'][] = (int)$producto->id_producto;
        $productos['id_medida'][] = (int)$producto->id_unidad_medida;
    }
}

// Arma el array completo de compra con los productos ya llenados
$compra = [
    'id_compra' => $id_compra,
    'id_proveedor' => $id_proveedor,
    'cantidad' => $cantidad,
    'fech_emision' => $fech_emision,
    'fech_vencimiento' => $fech_vencimiento,
    'id_modalidad_pago' => $id_modalidad_pago,
    'monto' => $monto,
    'tipo_entrega' => $tipo_entrega,
    'rif_banco' => $rif_banco,
    'productos' => $productos
];

// Lógica de caja según modalidad de pago
if ($id_modalidad_pago == 1 || $id_modalidad_pago == 2) {
    $id_cajas = 1;
} else {
    $id_cajas = 2;
}

$ingreso_data = json_encode([
    'id_cajas' => $id_cajas,
    'movimiento' => "egreso",
    'fecha' => $fech_emision,
    'fechav' => $fech_vencimiento,
    'monto' => $monto,
    'id_pago' => $id_modalidad_pago,
    'descripcion' => "Compra de productos"
]);

// Codifica el array compra a JSON para su procesamiento posterior
$compra_json = json_encode($compra);

// Para depuración:
//print_r($_POST['id_producto']);
//print_r($productos);
//echo $compra_json;

        try {
            $res = $caja->manejarAccion("status",null);
            if(isset($res['status']) && $res['status'] === true) {
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
                    $ingreso->manejarAccion("agregar",$ingreso_data);

                    // Aquí notificación 

                } else {
                    // Error: usar mensaje dinámico o genérico
                    $mensajeError = $resultado['msj'] ?? "ERROR AL REGISTRAR...";
                    setError($mensajeError);
                }
            }
            else{
                setError($res["msj"]);
            }
            } catch (Exception $e) {
                //mensajes del expcecion del pdo
                error_log("Error al registrar: " . $e->getMessage());
                //setError("Error en operación");
            }

            header("Location: index.php?action=compra&a=c");// Redirect
            exit();
        }
    //muestra un modal de info que dice acceso no permitido
    setError("Error acción no permitida");
    require_once 'views/php/dashboard_compra.php';
    exit();
}



function eliminarCompra($modelo, $bitacora, $usuario, $modulo){
    
    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {            
                   
        $id_compra = $_GET['id_compra'];
            if (!filter_var($id_compra, FILTER_VALIDATE_INT)) {
                setError("ID inválido");
                header("Location: index.php?action=compra&a=c");
                exit();
            }

            // Obtener los valores de tipo_producto y presentacion antes de eliminar
            $accion="obtener";
            $res = $modelo->manejarAccion($accion,$id_presentacion);
            
            if (!$res) {
                setError("El registro no existe");
                header("Location: index.php?action=compra&a=c");
                exit();
            }

            try {

                // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
                $resultado = $modelo->manejarAccion('eliminar', $id_compra);
                   
        
                //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    //usar mensaje dinámico del modelo
                    setSuccess($resultado['msj']);

                    $bitacora_data = json_encode([
                        'id_admin' => $_SESSION['s_usuario']['id'],
                        'movimiento' => "Eliminar",
                        'fecha' => date('Y-m-d H:i:s'),
                        'modulo' => $modulo,
                        'descripcion' => "Eliminao una compra"
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
            
            header("Location: index.php?action=compra&a=c");
            exit();
            }
            //muestra un modal de info que dice acceso no permitido
            setError("Error accion no permitida ");
            require_once 'views/php/dashboard_compra.php';
            exit();
}


function obtenerProveedor($producto, $bitacora, $usuario, $modulo) {
    $id_proveedor = $_GET['id_proveedor'];
    if (!filter_var($id_proveedor, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=compra&a=c");
        exit();
    }

    $accion = "obtener";
    $producto = $producto->manejarAccion('obtener2', $id_proveedor);
    echo json_encode($producto);
}


// funcion para consultar compras
function consultarCompra($modelo, $bitacora, $usuario, $modulo, $proveedor, $producto, $ingreso, $notificacion) {
    if ($usuario->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {

        $compras = $modelo->manejarAccion("consultar", null);
        $proveedores = $proveedor->manejarAccion("consultar", null);
        $productos = $producto->manejarAccion("obtenerProductos", null);
        $bancos = $modelo->manejarAccion("obtenerBancos", null);
        $pagos = $modelo->manejarAccion("obtenerPagos", null);
        $numero_compras = $modelo->manejarAccion("obtenerNumeroCompra", null);
        if(count($numero_compras)>0){
            $numero_compra=$numero_compras[0]['id_compra'];
        }else{
            $numero_compra=0;
        }
        $numero_compra++;

        // 1. Compras por mes
        $comprasPorMes = [];
        foreach ($compras as $c) {
            $mes = date('F', strtotime($c['fecha'])); // Ejemplo: "January"
            if (!isset($comprasPorMes[$mes])) {
                $comprasPorMes[$mes] = 0;
            }
            $comprasPorMes[$mes] += $c['monto'];
        }
        $labelsCompra = array_keys($comprasPorMes);
        $dataCompra = array_values($comprasPorMes);

        // 2. Compras por proveedor
        $comprasPorProveedor = [];
        foreach ($compras as $c) {
            $proveedor = $c['nombre_cliente'];
            if (!isset($comprasPorProveedor[$proveedor])) {
                $comprasPorProveedor[$proveedor] = 0;
            }
            $comprasPorProveedor[$proveedor] += $c['monto'];
        }
        $labelsProveedor = array_keys($comprasPorProveedor);
        $dataProveedor = array_values($comprasPorProveedor);

        // 3. Compras por modalidad de pago
        $comprasPorModalidad = [];
        foreach ($compras as $c) {
            $modalidad = $c['nombre_modalidad']; // Ajusta el campo si es necesario
            if (!isset($comprasPorModalidad[$modalidad])) {
                $comprasPorModalidad[$modalidad] = 0;
            }
            $comprasPorModalidad[$modalidad] += $c['monto'];
        }
        $labelsModalidadCompra = array_keys($comprasPorModalidad);
        $dataModalidadCompra = array_values($comprasPorModalidad);

        // 4. Compras por producto
        $comprasPorProducto = [];
        foreach ($compras as $c) {
            $producto = $c['nombre']; // nombre del producto
            if (!isset($comprasPorProducto[$producto])) {
                $comprasPorProducto[$producto] = 0;
            }
            $comprasPorProducto[$producto] += $c['monto'];
        }
        $labelsProductoCompra = array_keys($comprasPorProducto);
        $dataProductoCompra = array_values($comprasPorProducto);

        require_once "views/php/dashboard_compra.php";
    } else {
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
