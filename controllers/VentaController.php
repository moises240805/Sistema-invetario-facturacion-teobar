<?php
// Incluye el archivo del modelo venta
require_once "models/Venta.php";
require_once "models/Producto.php";
require_once "models/Cliente.php";
require_once "models/Notificacion.php";
require_once "models/Manejo.php";
require_once 'models/Bitacora.php';
require_once 'models/Roles.php';
require_once "models/Caja.php";
require_once 'views/php/utils.php';
require_once "ReportController.php";
date_default_timezone_set('America/Caracas');

$ingreso = new Manejo();
$modelo = new Venta();
$Producto = new Producto();
$cliente = new Cliente();
$notificacion = new Notificacion();
$bitacora = new Bitacora();
$caja = new Caja();

$usuario = new Roles();


$modulo = 'Ventas';

$action = isset($_GET['a']) ? $_GET['a'] : '';

//Indiferentemente sea la accion por el post o get el switch llama a cada funcion 
switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregarVenta($modelo, $bitacora, $usuario, $modulo, $Producto, $ingreso, $notificacion, $caja); 
        }
        break;
    case "mid_form":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            obtenerVenta($modelo); 
        }
        break;
    case "eliminar":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            eliminarVenta($modelo, $bitacora, $usuario, $modulo);
        }
        break;
    case "v":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultarVenta($modelo, $bitacora, $usuario, $modulo, $cliente, $Producto, $ingreso, $notificacion);
        }
        break;
    default:
        consultarVenta($modelo, $bitacora, $usuario, $modulo, $cliente, $Producto, $ingreso, $notificacion);
        break;
}

// === FUNCIONES ===
// funcion para registrar una venta
function obtenerVenta($modelo){

}



function agregarVenta($modelo, $bitacora, $usuario, $modulo, $Producto, $ingreso, $notificacion, $caja) {

    
    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "agregar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

        // Obtiene los valores del formulario y los sanitiza
        $id_venta = htmlspecialchars($_POST['id_venta']);
        $tipo_compra = htmlspecialchars($_POST['tipo_compra']);
        $tlf = htmlspecialchars($_POST['tlf']);
        $id_cliente = htmlspecialchars($_POST['id_cliente']);
        $cantidad = array_map('htmlspecialchars', $_POST['cantidad']);
        $fech_emision = htmlspecialchars($_POST['fech_emision']);
        $fech_vencimiento = htmlspecialchars($_POST['fech_vencimiento']);
        $id_modalidad_pago = htmlspecialchars($_POST['id_modalidad_pago']);
        $monto = htmlspecialchars($_POST['total']);
        $tipo_entrega = htmlspecialchars($_POST['tipo_entrega']);
        $rif_banco = htmlspecialchars($_POST['rif_banco']);
        $productos = [
            'id_producto' => [],
            'id_medida' => []
        ];


        $venta = json_encode([
            'id_venta' => $id_venta,
            'tipo_compra' => $tipo_compra,
            'tlf' => $tlf,
            'id_cliente' => $id_cliente,
            'cantidad' => $cantidad,
            'fech_emision' => $fech_emision,
            'fech_vencimiento' => $fech_vencimiento,
            'id_modalidad_pago' => $id_modalidad_pago,
            'monto' => $monto,
            'tipo_entrega' => $tipo_entrega,
            'rif_banco' => $rif_banco,
            'productos' => [
                'id_producto' => [],
                'id_medida' => []
            ]
        ]);

        // Procesar los productos
        $venta = json_decode($venta, true);
        $productos_vendidos = [];

        foreach ($_POST['id_producto'] as $item) {
            $producto = json_decode($item);
            
            $venta['productos']['id_producto'][] = $producto->id_producto;
            $venta['productos']['id_medida'][] = $producto->id_unidad_medida;
                    
            // Guardamos info del producto con cantidad vendida
            $productos_vendidos[] = [
                'id_producto' => $producto->id_producto
            ];
        }
        
        $id_modalidad_pago = $venta['id_modalidad_pago'];
        $fech_emision = $venta['fech_emision'];
        $fech_vencimiento = $venta['fech_vencimiento'];
        $monto = $venta['monto'];

        // Lógica de caja según modalidad de pago
        if ($id_modalidad_pago == 1 || $id_modalidad_pago == 2) {
            $id_cajas = 1;
        } else {
            $id_cajas = 2;
        }
        
        $ingreso_data = json_encode([
            'id_cajas' => $id_cajas,
            'movimiento' => "Ingreso",
            'fecha' => $fech_emision,
            'fechav' => $fech_vencimiento,
            'monto' => $monto,
            'id_pago' => $id_modalidad_pago,
            'descripcion' => "Venta de productos"
        ]);
        // Convertir nuevamente a JSON
        $venta = json_encode($venta);
        //echo $venta;
        

        try {
            $res = $caja->manejarAccion("status",null);
            if(isset($res['status']) && $res['status'] === true) {
                // print_r($_POST);
                // echo "<br><br>";
                // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
                $resultado = $modelo->manejarAccion("agregar", $venta);
                //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    //usar mensaje dinámico del modelo
                    setSuccess($resultado['msj']);

                    $bitacora_data = json_encode([
                        'id_admin' => $_SESSION['s_usuario']['id'],
                        'movimiento' => 'Agregar',
                        'fecha' => date('Y-m-d H:i:s'),
                        'modulo' => $modulo,
                        'descripcion' =>'El usuario: '.$_SESSION['s_usuario']['usuario']. " " . 'ha registrado una venta'
                    ]);
                    $bitacora->setBitacoraData($bitacora_data);
                    $bitacora->Guardar_Bitacora();
                    $ingreso->manejarAccion("agregar",$ingreso_data); 
                   // FacturaPDF($venta);

                    // Verificar stock después de la venta
                        $stock_actual = $Producto->manejarAccion("stock",null);

                        if ($stock_actual['cantidad'] <= 20) {
                            // Notificar al administrador
                            $id_admin = $_SESSION['s_usuario']['id']; // Cambia esto si el admin tiene un ID diferente
                            $mensaje = "El producto se esta agotando.";
                            $enlace = "index.php?action=producto&a=d";
                            $status = 1;

                            $notificacion->insert($mensaje, $id_admin, $status);
                        }
                    
                }
                else {
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

        header("Location: index.php?action=venta&a=v"); // Redirect
        exit();
    }
    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida ");
    require_once 'views/php/dashboard_venta.php';
    exit();
}



function eliminarVenta($modelo, $bitacora, $usuario, $modulo){
    
    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {            
                   
        $id_venta = $_GET['id_venta'];
            if (!filter_var($id_venta, FILTER_VALIDATE_INT)) {
                setError("ID inválido");
                header("Location: index.php?action=venta&a=v");
                exit();
            }

            // Obtener los valores de tipo_producto y presentacion antes de eliminar
            $accion="obtener";
            $res = $modelo->manejarAccion($accion,$id_presentacion);
            
            if (!$res) {
                setError("El registro no existe");
                header("Location: index.php?action=venta&a=v");
                exit();
            }

            try {

                // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
                $resultado = $modelo->manejarAccion('eliminar', $id_venta);
                   
        
                //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    //usar mensaje dinámico del modelo
                    setSuccess($resultado['msj']);

                    $bitacora_data = json_encode([
                        'id_admin' => $_SESSION['s_usuario']['id'],
                        'movimiento' => "Eliminar",
                        'fecha' => date('Y-m-d H:i:s'),
                        'modulo' => $modulo,
                        'descripcion' => "Eliminao una venta"
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
            
            header("Location: index.php?action=venta&a=v");
            exit();
            }
            //muestra un modal de info que dice acceso no permitido
            setError("Error accion no permitida ");
            require_once 'views/php/dashboard_venta.php';
            exit();
}


function consultarVenta($modelo, $bitacora, $usuario, $modulo, $cliente, $Producto, $ingreso, $notificacion) {


    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {            
        
        $venta = $modelo->manejarAccion("consultar",null);
        $clientes =$cliente->manejarAccion("consultar",null);
        $productos = $Producto->manejarAccion("obtenerProductos",null);
        $bancos = $modelo->manejarAccion("obtenerBancos",null);
        $pagos = $modelo->manejarAccion("obtenerPagos",null);
        $numero_ventas = $modelo->manejarAccion("obtenerNumeroVenta", null);
        if(count($numero_ventas)>0){
            $numero_venta=$numero_ventas[0]['id_venta'];
        }else{
            $numero_venta=0;
        }
        $numero_venta++;
        // Agrupa ventas por mes
        $ventasPorMes = [];
        foreach ($venta as $v) {
            $mes = date('F', strtotime($v['fech_emision'])); // Ejemplo: "January"
            if (!isset($ventasPorMes[$mes])) {
                $ventasPorMes[$mes] = 0;
            }
            $ventasPorMes[$mes] += $v['monto'];
        }

        // Prepara los datos para JS
        $labels = array_keys($ventasPorMes);
        $data = array_values($ventasPorMes);

        // 2. Ventas por cliente
        $ventasPorCliente = [];
        foreach ($venta as $v) {
            $cliente = $v['nombre_cliente'];
            if (!isset($ventasPorCliente[$cliente])) {
                $ventasPorCliente[$cliente] = 0;
            }
            $ventasPorCliente[$cliente] += $v['monto'];
        }
        $labelsCliente = array_keys($ventasPorCliente);
        $dataCliente = array_values($ventasPorCliente);

        // 3. Ventas por modalidad de pago
        $ventasPorModalidad = [];
        foreach ($venta as $v) {
            $modalidad = $v['nombre_modalidad'];
            if (!isset($ventasPorModalidad[$modalidad])) {
                $ventasPorModalidad[$modalidad] = 0;
            }
            $ventasPorModalidad[$modalidad] += $v['monto'];
        }
        $labelsModalidad = array_keys($ventasPorModalidad);
        $dataModalidad = array_values($ventasPorModalidad);
        
        // 4. Ventas por producto
        $ventasPorProducto = [];
        foreach ($venta as $v) {
            $producto = $v['nombre']; // nombre del producto
            if (!isset($ventasPorProducto[$producto])) {
                $ventasPorProducto[$producto] = 0;
            }
            $ventasPorProducto[$producto] += $v['monto'];
        }
        $labelsProducto = array_keys($ventasPorProducto);
        $dataProducto = array_values($ventasPorProducto);
        require_once "views/php/dashboard_venta.php";
    }
    else{

            //muestra un modal de info que dice acceso no permitido
            setError("Error accion no permitida ");
            require_once 'views/php/dashboard_venta.php';
            exit(); 
    }
}
?>