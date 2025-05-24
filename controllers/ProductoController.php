<?php
// Incluye el archivo del modelo Producto
require_once "models/Producto.php";
require_once "models/Proveedor.php";
require_once 'models/Tipo.php';
require_once 'models/Marca.php';
require_once 'models/Categoria.php';
require_once 'models/Bitacora.php';
require_once 'models/Roles.php';
require_once 'views/php/utils.php';


//Se instancia los modelos
$controller = new Producto();
$tipo = new Tipo();
$proveedor = new Proveedor();
$marca = new Marca();
$bitacora = new Bitacora();
$usuario = new Roles();
$categoria = new Categoria();

//esta variables es para definir el modulo en la bitacora para cuando se cree el json 
$modulo = 'Productos';
date_default_timezone_set('America/Caracas');

$action = isset($_GET['a']) ? $_GET['a'] : '';


//Indiferentemente sea la accion por el post o get el switch llama a cada funcion 
switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregarProducto($controller, $tipo, $bitacora, $usuario, $modulo);
        }
        case "agregar2":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregarProducto2($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "mid_form":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            obtenerProducto($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "actualizar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            actualizarProducto($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "eliminar":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            eliminarProducto($controller, $bitacora, $usuario, $modulo);
        }
        break;
    case "d":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultarProducto($controller, $usuario, $modulo, $tipo, $categoria, $marca, $proveedor);
        }
        break;
    //default:
    //    consultarProducto($controller, $usuario, $modulo);
    //    break;
}

// Función para agregar un Producto
function agregarProducto($controller, $tipo, $bitacora, $usuario, $modulo) {

    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "agregar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

        // Sanitiza y valida
        $nombre_producto = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $marca = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $proveedor = filter_input(INPUT_POST, 'proveedor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $presentacion = filter_input(INPUT_POST, 'presentacion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fecha_registro = filter_input(INPUT_POST, 'fecha_registro', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fecha_vencimiento = filter_input(INPUT_POST, 'fecha_vencimiento', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cantidad_producto = filter_input(INPUT_POST, 'cantidad', FILTER_SANITIZE_NUMBER_INT);
        $cantidad_producto2 = filter_input(INPUT_POST, 'cantidad2', FILTER_SANITIZE_NUMBER_INT);
        $cantidad_producto3 = filter_input(INPUT_POST, 'cantidad3', FILTER_SANITIZE_NUMBER_INT);
        $precio_producto = filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $precio_producto2 = filter_input(INPUT_POST, 'precio2', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $precio_producto3 = filter_input(INPUT_POST, 'precio3', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $uni_medida = filter_input(INPUT_POST, 'uni_medida', FILTER_SANITIZE_NUMBER_INT);
        $uni_medida2 = filter_input(INPUT_POST, 'uni_medida2', FILTER_SANITIZE_NUMBER_INT);
        $uni_medida3 = filter_input(INPUT_POST, 'uni_medida3', FILTER_SANITIZE_NUMBER_INT);
        $peso = filter_input(INPUT_POST, 'peso', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $imagen = $_FILES['imagen'];

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $imagen = $_FILES['imagen'];

                // Validación básica de la imagen
                $tipoArchivo = pathinfo($imagen['name'], PATHINFO_EXTENSION);
                $tiposPermitidos = array('jpg', 'jpeg', 'png', 'gif');

                if (!in_array(strtolower($tipoArchivo), $tiposPermitidos)) {
                    setError("Sólo se permiten archivos de tipo JPG, JPEG, PNG y GIF.");
                    header("Location: index.php?action=producto&a=d");
                    exit();
                }
            


                // Validación básica de la imagen
                if (!empty($imagen['name'])) {
                    $tipoArchivo = pathinfo($imagen['name'], PATHINFO_EXTENSION);
                    $tiposPermitidos = array('jpg', 'jpeg', 'png', 'gif');
            
                    if (!in_array(strtolower($tipoArchivo), $tiposPermitidos)) {
                        setError("Sólo se permiten archivos de tipo JPG, JPEG, PNG y GIF.");
                        header("Location: index.php?action=producto&a=d");
                        exit();
                    }
                }

            // Subir la imagen al directorio destino
            $directorioSubida = 'views/img/productos/'; // Asegúrate de que este directorio exista y tenga permisos de escritura
        
            if (!empty($imagen['name'])) {
                $nombreArchivo = basename($imagen['name']);
                $rutaSubida = $directorioSubida . $nombreArchivo;
        
                if (move_uploaded_file($imagen['tmp_name'], $rutaSubida)) {
                    // La imagen se ha subido correctamente
                    $imagenProducto = $rutaSubida; // Guarda el nombre de la imagen para usarlo en la base de datos
                } else {
                    setError("Error al subir la imagen.");
                    header("Location: index.php?action=producto&a=d");
                    exit();
                }
            } 
            } else {
                $imagenProducto = ''; // Si no se sube imagen, deja este campo vacío
            }


        // Validar que los campos obligatorios no estén vacíos
        if (empty($nombre_producto) || empty($presentacion) || empty($categoria) || empty($marca)  || empty($proveedor)|| empty($fecha_vencimiento) || empty($fecha_registro) || empty($cantidad_producto) || empty($precio_producto) || empty($uni_medida)) {
            setError("Todos los campos son requeridos");
            header("Location: index.php?action=producto&a=d");
            exit();
        }
        
        // Validar que los valores numéricos sean válidos
        if (!is_numeric($cantidad_producto) || !is_numeric($precio_producto)) {
            setError("La cantidad y el precio deben ser valores numéricos válidos");
            header("Location: index.php?action=producto&a=d");
            exit();
        }

        // Obtiene los valores del formulario y los sanitiza
        $peso = htmlspecialchars($_POST['peso']);
        $peso2 = $peso / $peso;
        $peso3 = $peso2 * 1000;

        $producto = json_encode([
            'nombre_producto' => $nombre_producto,
            'presentacion' => $presentacion,
            'categoria' => $categoria,
            'fecha_registro' => $fecha_registro,
            'fecha_vencimiento' => $fecha_vencimiento,
            'cantidad_producto' => $cantidad_producto,
            'cantidad2' => $cantidad_producto2,
            'cantidad3' => $cantidad_producto3,
            'precio_producto' => $precio_producto,
            'precio2' => $precio_producto2,
            'precio3' => $precio_producto3,
            'uni_medida' => $uni_medida,
            'uni_medida2' => $uni_medida2,
            'uni_medida3' => $uni_medida3,
            'peso' => $peso,
            'peso2' => $peso2,
            'peso3' => $peso3,
            'imagen' => $rutaSubida,
            'id_marca' => $marca,
            'id_proveedor' => $proveedor
        ]);

        try {

            // Llama a la funcion manejarAccion del modelo donde pasa el objeto producto y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
            $resultado = $controller->manejarAccion('agregar', $producto);
        

            //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
            if (isset($resultado['status']) && $resultado['status'] === true) {

                //usar mensaje dinámico del modelo
                setSuccess($resultado['msj']);

                $bitacora_data = json_encode([
                    'id_admin' => $_SESSION['s_usuario']['id'],
                    'movimiento' => "Agregar",
                    'fecha' => date('Y-m-d H:i:s'),
                    'modulo' => $modulo,
                    'descripcion' => "Producto: $nombre_producto"
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
            
            header("Location: index.php?action=producto&a=d"); // Redirect
            exit();
    }
     //muestra un modal de info que dice acceso no permitido
     setError("Error accion no permitida ");
     require_once 'views/php/dashboard_producto.php';
     exit();
}


// Función para agregar un Producto
function agregarProducto2($controller, $bitacora, $usuario, $modulo) {


    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, 'agregar', $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

            // Sanitiza y valida datos
        $nombre_producto = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $marca = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $proveedor = filter_input(INPUT_POST, 'proveedor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $presentacion = filter_input(INPUT_POST, 'presentacion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fecha_registro = filter_input(INPUT_POST, 'fecha_registro', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fecha_vencimiento = filter_input(INPUT_POST, 'fecha_vencimiento', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cantidad_producto = filter_input(INPUT_POST, 'cantidad', FILTER_SANITIZE_NUMBER_INT);
        $precio_producto = filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $uni_medida = filter_input(INPUT_POST, 'uni_medida', FILTER_SANITIZE_NUMBER_INT);
        $imagen = $_FILES['imagen'];

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $imagen = $_FILES['imagen'];

                // Validación básica de la imagen
                $tipoArchivo = pathinfo($imagen['name'], PATHINFO_EXTENSION);
                $tiposPermitidos = array('jpg', 'jpeg', 'png', 'gif');

                if (!in_array(strtolower($tipoArchivo), $tiposPermitidos)) {
                    setError("Sólo se permiten archivos de tipo JPG, JPEG, PNG y GIF.");
                    header("Location: index.php?action=producto&a=d");
                    exit();
                }
            


                // Validación básica de la imagen
                if (!empty($imagen['name'])) {
                    $tipoArchivo = pathinfo($imagen['name'], PATHINFO_EXTENSION);
                    $tiposPermitidos = array('jpg', 'jpeg', 'png', 'gif');
            
                    if (!in_array(strtolower($tipoArchivo), $tiposPermitidos)) {
                        setError("Sólo se permiten archivos de tipo JPG, JPEG, PNG y GIF.");
                        header("Location: index.php?action=producto&a=d");
                        exit();
                    }
                }

            // Subir la imagen al directorio destino
            $directorioSubida = 'views/img/productos/'; // Asegúrate de que este directorio exista y tenga permisos de escritura
        
            if (!empty($imagen['name'])) {
                $nombreArchivo = basename($imagen['name']);
                $rutaSubida = $directorioSubida . $nombreArchivo;
        
                if (move_uploaded_file($imagen['tmp_name'], $rutaSubida)) {
                    // La imagen se ha subido correctamente
                    $imagenProducto = $rutaSubida; // Guarda el nombre de la imagen para usarlo en la base de datos
                } else {
                    setError("Error al subir la imagen.");
                    header("Location: index.php?action=producto&a=d");
                    exit();
                }
            } 
            } else {
                $imagenProducto = ''; // Si no se sube imagen, deja este campo vacío
            }

            if (empty($nombre_producto) || empty($presentacion) || empty($categoria) || empty($marca) || empty($proveedor) || empty($fecha_vencimiento) || empty($cantidad_producto) || empty($precio_producto) || empty($uni_medida)) {
                setError("Todos los campos son requeridos");
                header("Location: index.php?action=producto&a=d");
                exit();
            }

            $producto = json_encode([
                'nombre_producto' => $nombre_producto,
                'fecha_registro' => $fecha_registro,
                'presentacion' => $presentacion,
                'categoria' => $categoria,
                'fecha_vencimiento' => $fecha_vencimiento,
                'cantidad_producto' => $cantidad_producto,
                'precio_producto' => $precio_producto,
                'uni_medida' => $uni_medida,
                'imagen' => $rutaSubida,
                'id_marca' => $marca,
                'id_proveedor' => $proveedor
            ]);//echo $producto;
        try {

                    // Llama a la funcion manejarAccion del modelo donde pasa el objeto producto y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
                    $resultado = $controller->manejarAccion('agregar2', $producto);
                

                    //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        //usar mensaje dinámico del modelo
                        setSuccess($resultado['msj']);

                        $bitacora_data = json_encode([
                            'id_admin' => $_SESSION['s_usuario']['id'],
                            'movimiento' => "Agregar",
                            'fecha' => date('Y-m-d H:i:s'),
                            'modulo' => $modulo,
                            'descripcion' => "Producto: $nombre_producto"
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
                    
                    header("Location: index.php?action=producto&a=d"); // Redirect
                    exit();
    }
     //muestra un modal de info que dice acceso no permitido
     setError("Error accion no permitida ");
     require_once 'views/php/dashboard_producto.php';
     exit();

}

// Función para obtener un Producto
function obtenerProducto($controller, $bitacora, $usuario, $modulo) {
    $id_producto = $_GET['id_producto'];
    if (!filter_var($id_producto, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=producto&a=d");
        exit();
    }

    $accion = "obtener";
    $producto = $controller->manejarAccion('obtener', $id_producto);
    echo json_encode($producto);
}


// Función para actualizar un Producto
function actualizarProducto($controller, $bitacora, $usuario, $modulo) {


    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "Modificar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

    // Sanitiza y valida datos
        $id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
        $nombre_producto = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $marca = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $proveedor = filter_input(INPUT_POST, 'proveedor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $presentacion = filter_input(INPUT_POST, 'presentacion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fecha_registro = filter_input(INPUT_POST, 'fecha_registro', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fecha_vencimiento = filter_input(INPUT_POST, 'fecha_vencimiento', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cantidad_producto = filter_input(INPUT_POST, 'cantidad', FILTER_SANITIZE_NUMBER_INT);
        $cantidad_producto2 = filter_input(INPUT_POST, 'cantidad2', FILTER_SANITIZE_NUMBER_INT);
        $cantidad_producto3 = filter_input(INPUT_POST, 'cantidad3', FILTER_SANITIZE_NUMBER_INT);
        $precio_producto = filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $precio_producto2 = filter_input(INPUT_POST, 'precio2', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $precio_producto3 = filter_input(INPUT_POST, 'precio3', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $uni_medida = filter_input(INPUT_POST, 'uni_medida', FILTER_SANITIZE_NUMBER_INT);
        $uni_medida2 = filter_input(INPUT_POST, 'uni_medida2', FILTER_SANITIZE_NUMBER_INT);
        $uni_medida3 = filter_input(INPUT_POST, 'uni_medida3', FILTER_SANITIZE_NUMBER_INT);
        $peso = filter_input(INPUT_POST, 'peso', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $id_actualizacion = filter_input(INPUT_POST, 'id_actualizacion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //$imagen = $_FILES['imagen'];

    if (empty($nombre_producto) || empty($presentacion) || empty($categoria) || empty($proveedor) || empty($marca) || empty($fecha_vencimiento) || empty($cantidad_producto) || empty($precio_producto) || empty($uni_medida)) {
        setError("Todos los campos son requeridos");
        header("Location: index.php?action=producto&a=d");
        exit();
    }


     // Obtiene los valores del formulario y los sanitiza
        $peso = htmlspecialchars($_POST['peso']);
        $peso2 = $peso / $peso;
        $peso3 = $peso2 * 1000;

    $producto = json_encode([
            'id_producto' => $id_producto,
            'nombre_producto' => $nombre_producto,
            'presentacion' => $presentacion,
            'categoria' => $categoria,
            'fecha_registro' => $fecha_registro,
            'fecha_vencimiento' => $fecha_vencimiento,
            'cantidad_producto' => $cantidad_producto,
            'cantidad2' => $cantidad_producto2,
            'cantidad3' => $cantidad_producto3,
            'precio_producto' => $precio_producto,
            'precio2' => $precio_producto2,
            'precio3' => $precio_producto3,
            'uni_medida' => $uni_medida,
            'uni_medida2' => $uni_medida2,
            'uni_medida3' => $uni_medida3,
            'peso' => $peso,
            'peso2' => $peso2,
            'peso3' => $peso3,
            'id_marca' => $marca,
            'id_proveedor' => $proveedor,
            'id_actualizacion' => $id_actualizacion
        ]);//echo $producto;

    try {

        // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
        $resultado = $controller->manejarAccion('actualizar', $producto);
           

        //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
        if (isset($resultado['status']) && $resultado['status'] === true) {
            //usar mensaje dinámico del modelo
            setSuccess($resultado['msj']);

            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Modificar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Producto: $nombre_producto"
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

        //require_once 'views/php/dashboard_producto.php';
    header("Location: index.php?action=producto&a=d");
    exit();
    }
    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida ");
    require_once 'views/php/dashboard_producto.php';
    exit();
}


// Función para eliminar un Producto
function eliminarProducto($controller, $bitacora, $usuario, $modulo) {

    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "Eliminar", $_SESSION['s_usuario']['id_rol'])) {
        // Ejecutar acción permitida

    $id_producto = $_GET['id_producto'];
    if (!filter_var($id_producto, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?action=producto&a=d");
        exit();
    }

    // Obtener los valores de nombre_producto antes de eliminar
    $accion = "obtener";
    $producto = $controller->manejarAccion($accion, $id_producto);
    
    if (!$producto) {
        setError("El registro no existe");
        header("Location: index.php?action=producto&a=d");
        exit();
    }

    $nombre_producto = $producto['nombre'];

        try {

        // Llama a la funcion manejarAccion del modelo donde pasa el objeto cliente y la accion  y Capturar el resultado de manejarAccion en lo que pasa en el modelo
        $resultado = $controller->manejarAccion("eliminar", $id_producto);
           

        //verifica si esta definida y no es null el status de la captura resultado y comopara si ses true
        if (isset($resultado['status']) && $resultado['status'] === true) {
            //usar mensaje dinámico del modelo
            setSuccess($resultado['msj']);

            $bitacora_data = json_encode([
                'id_admin' => $_SESSION['s_usuario']['id'],
                'movimiento' => "Eliminar",
                'fecha' => date('Y-m-d H:i:s'),
                'modulo' => $modulo,
                'descripcion' => "Producto: $nombre_producto"
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
    
    header("Location: index.php?action=producto&a=d");
    exit();
    }
    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida ");
    require_once 'views/php/dashboard_producto.php';
    exit();
}


// Función para consultar Productos
function consultarProducto($controller, $usuario, $modulo, $tipo, $categoria, $marca, $proveedor) {


    //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
    //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
    //action y el rol de usuario
    if ($usuario->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {

        // Ejecutar acción permitida
        $producto =$controller->manejarAccion("consultar",null);
        $tipos =$tipo->manejarAccion("consultar",null);
        $categorias =$categoria->manejarAccion("consultar",null);
        $marcas =$marca->manejarAccion("consultar",null);
        $proveedores =$proveedor->manejarAccion("consultar",null);
        require_once 'views/php/dashboard_producto.php';
        exit();
    }
    else{

        //muestra un modal de info que dice acceso no permitido
        setError("Error accion no permitida ");
        require_once 'views/php/dashboard_producto.php';
        exit(); 
    }
    
}
?>