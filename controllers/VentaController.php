<?php
// Incluye el archivo del modelo venta
require_once "models/Venta.php";
require_once "models/Producto.php";
require_once "models/Cliente.php";
require "models/Notificacion.php";
require_once "models/Manejo.php";
require_once 'models/Bitacora.php';
require_once 'models/Roles.php';
require_once 'views/php/utils.php';
date_default_timezone_set('America/Caracas');

$ingreso = new Manejo();
$modelo = new Venta();
$producto = new Producto();
$cliente = new Cliente();
$notificacion = new Notificacion();
$bitacora = new Bitacora();

$usuario = new Roles();


$modulo = 'Ventas';

$action = isset($_GET['a']) ? $_GET['a'] : '';

//Indiferentemente sea la accion por el post o get el switch llama a cada funcion 
switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregarVenta($modelo, $bitacora, $usuario, $modulo, $producto, $ingreso, $notificacion); 
        }
        break;
    case "eliminar":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            eliminaVenta($modelo, $bitacora, $usuario, $modulo);
        }
        break;
    case "v":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultarVenta($modelo, $bitacora, $usuario, $modulo, $cliente, $producto, $ingreso, $notificacion);
        }
        break;
    default:
        consultarVenta($modelo, $bitacora, $usuario, $modulo, $cliente, $producto, $ingreso, $notificacion);
        break;
}

// === FUNCIONES ===
// funcion para registrar una venta
function agregarVenta($modelo, $bitacora, $usuario, $modulo, $producto, $ingreso, $notificacion) {

    
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
        

        try {
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
                $ingreso->setIngresoEgresoData($ingreso_data);
                $ingreso->Guardar_IngresoEgreso($ingreso_data); 

                /*// Verificar stock después de la venta
                    $stock_actual = $producto->obtenerStockProducto($productos_vendidos);

                    if ($stock_actual <= 0) {
                        // Notificar al administrador
                        $id_admin = $_SESSION['s_usuario']['id']; // Cambia esto si el admin tiene un ID diferente
                        $mensaje = "El producto  se ha agotado.";
                        $enlace = "index.php?action=producto&a=d";

                        $notificacion->insert($enlace,$mensaje, $id_admin, "Sin leer");
                    }*/
                
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

        header("Location: index.php?action=venta&a=v"); // Redirect
        exit();
    }
    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida ");
    require_once 'views/php/dashboard_venta.php';
    exit();
}


function consultarVenta($modelo, $bitacora, $usuario, $modulo, $cliente, $producto, $ingreso, $notificacion) {


    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {            
        
        $venta = $modelo->manejarAccion("consultar",null);
        $clientes =$cliente->manejarAccion("consultar",null);
        $productos = $producto->manejarAccion("obtenerProductos",null);
        $bancos = $modelo->manejarAccion("obtenerBancos",null);
        $pagos = $modelo->manejarAccion("obtenerPagos",null);
        $numero_ventas = $modelo->manejarAccion("obtenerNumeroVenta", null);
        if(count($numero_ventas)>0){
            $numero_venta=$numero_ventas[0]['id_venta'];
        }else{
            $numero_venta=0;
        }
        $numero_venta++;
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