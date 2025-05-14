<?php

require_once "Conexion.php";

class Producto extends Conexion{
    //Atributos
    private $id_producto;
    private $nombre_producto;
    private $presentacion;
    private $fech_vencimiento;
    private $fecha_registro;
    private $cantidad_producto;
    private $cantidad_producto2;
    private $cantidad_producto3;
    private $precio_producto;
    private $precio_producto2;
    private $precio_producto3;
    private $uni_medida;
    private $uni_medida2;
    private $uni_medida3;
    private $id_actualizacion;
    private $peso;
    private $peso2;
    private $peso3;
    private $imagen;
    private $marca;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    private function setProductoData($producto) {
        if (is_string($producto)) {
            $producto = json_decode($producto, true);
            if ($producto === null) {
                return ['status' => false, 'msj' => 'JSON inválido'];
            }
        }
    
        // Expresiones regulares y validaciones
        $exp_nombre_marca = "/^.{1,30}$/u"; // Cualquier caracter, máximo 30
        $exp_fecha = "/^\d{4}-\d{2}-\d{2}$/"; // Formato YYYY-MM-DD
        $exp_decimal = "/^\d+(\.\d+)?$/"; // Números enteros o decimales positivos
        $exp_entero = "/^\d+$/"; // Números enteros positivos
    
        // Validar nombre_producto (obligatorio, max 30 caracteres)
        $nombre = trim($producto['nombre_producto'] ?? '');
        if ($nombre === '' || !preg_match($exp_nombre_marca, $nombre)) {
            return ['status' => false, 'msj' => 'Nombre de producto inválido o demasiado largo (máx 30 caracteres)'];
        }
        $this->nombre_producto = $nombre;
    
        // Validar marca (opcional, si existe validar max 30 caracteres)
        $marca = trim($producto['marca'] ?? '');
        if ($marca !== '' && !preg_match($exp_nombre_marca, $marca)) {
            return ['status' => false, 'msj' => 'Marca inválida o demasiado larga (máx 30 caracteres)'];
        }
        $this->marca = $marca;
    
        // Validar presentacion (obligatorio, entero positivo)
        $presentacion = $producto['presentacion'] ?? null;
        if ($presentacion === null || !preg_match($exp_entero, strval($presentacion))) {
            return ['status' => false, 'msj' => 'Presentación inválida'];
        }
        $this->presentacion = (int)$presentacion;
    
        // Validar fechas (opcional, si existen validar formato)
        $fecha_venc = $producto['fecha_vencimiento'] ?? null;
        if ($fecha_venc !== null && $fecha_venc !== '') {
            if (!preg_match($exp_fecha, $fecha_venc) || !strtotime($fecha_venc)) {
                return ['status' => false, 'msj' => 'Fecha de vencimiento inválida (debe ser YYYY-MM-DD)'];
            }
            $this->fech_vencimiento = $fecha_venc;
        } else {
            $this->fech_vencimiento = null;
        }
    
        $fecha_reg = $producto['fecha_registro'] ?? null;
        if ($fecha_reg !== null && $fecha_reg !== '') {
            if (!preg_match($exp_fecha, $fecha_reg) || !strtotime($fecha_reg)) {
                return ['status' => false, 'msj' => 'Fecha de registro inválida (debe ser YYYY-MM-DD)'];
            }
            $this->fecha_registro = $fecha_reg;
        } else {
            $this->fecha_registro = null;
        }
    
        // Validar cantidades (obligatorio, entero positivo)
        $cant1 = $producto['cantidad_producto'] ?? null;
        if ($cant1 === null || !preg_match($exp_entero, strval($cant1))) {
            return ['status' => false, 'msj' => 'Cantidad de producto inválida'];
        }
        $this->cantidad_producto = (int)$cant1;
    
        // Cantidades opcionales
        $cant2 = $producto['cantidad_producto2'] ?? null;
        $this->cantidad_producto2 = ($cant2 !== null && preg_match($exp_entero, strval($cant2))) ? (int)$cant2 : null;
    
        $cant3 = $producto['cantidad_producto3'] ?? null;
        $this->cantidad_producto3 = ($cant3 !== null && preg_match($exp_entero, strval($cant3))) ? (int)$cant3 : null;
    
        // Validar precios (obligatorio, decimal positivo)
        $precio1 = $producto['precio_producto'] ?? null;
        if ($precio1 === null || !preg_match($exp_decimal, strval($precio1))) {
            return ['status' => false, 'msj' => 'Precio de producto inválido'];
        }
        $this->precio_producto = (float)$precio1;
    
        // Precios opcionales
        $precio2 = $producto['precio_producto2'] ?? null;
        $this->precio_producto2 = ($precio2 !== null && preg_match($exp_decimal, strval($precio2))) ? (float)$precio2 : null;
    
        $precio3 = $producto['precio_producto3'] ?? null;
        $this->precio_producto3 = ($precio3 !== null && preg_match($exp_decimal, strval($precio3))) ? (float)$precio3 : null;
    
        // Validar unidades de medida (obligatorio entero positivo)
        $uni1 = $producto['uni_medida'] ?? null;
        if ($uni1 === null || !preg_match($exp_entero, strval($uni1))) {
            return ['status' => false, 'msj' => 'Unidad de medida inválida'];
        }
        $this->uni_medida = (int)$uni1;
    
        // Unidades opcionales
        $uni2 = $producto['uni_medida2'] ?? null;
        $this->uni_medida2 = ($uni2 !== null && preg_match($exp_entero, strval($uni2))) ? (int)$uni2 : null;
    
        $uni3 = $producto['uni_medida3'] ?? null;
        $this->uni_medida3 = ($uni3 !== null && preg_match($exp_entero, strval($uni3))) ? (int)$uni3 : null;
    
        // Validar id_actualizacion (opcional entero positivo)
        $id_actualizacion = $producto['id_actualizacion'] ?? null;
        $this->id_actualizacion = ($id_actualizacion !== null && preg_match($exp_entero, strval($id_actualizacion))) ? (int)$id_actualizacion : null;
    
        // Validar pesos (opcionales, decimales positivos)
        $peso1 = $producto['peso'] ?? null;
        $this->peso = ($peso1 !== null && preg_match($exp_decimal, strval($peso1))) ? (float)$peso1 : null;
    
        $peso2 = $producto['peso2'] ?? null;
        $this->peso2 = ($peso2 !== null && preg_match($exp_decimal, strval($peso2))) ? (float)$peso2 : null;
    
        $peso3 = $producto['peso3'] ?? null;
        $this->peso3 = ($peso3 !== null && preg_match($exp_decimal, strval($peso3))) ? (float)$peso3 : null;
    
        // Imagen y marca (opcional, sin validación específica aquí)
        $this->imagen = $producto['imagen'] ?? null;
    
        // Todo validado y asignado correctamente
        return ['status' => true, 'msj' => 'Datos validados correctamente'];
    }
    

    private function setValideId($producto){

        // Validar id_cliente y tipo_id como numéricos
    if (!is_numeric($producto) ) {
        return ['status' => false, 'msj' => 'ID invalida'];
    }
    $this->id_producto = (int)$producto;
    return ['status' => true, 'msj' => 'ID validado correctamente'];
}


    // Getters
    public function getIdProducto() {
        return $this->id_producto;
    }

    public function getMarcaProducto() {
        return $this->marca;
    }

    public function getImg() {
        return $this->imagen;
    }

    public function getNombreProducto() {
        return $this->nombre_producto;
    }

    public function getPresentacion() {
        return $this->presentacion;
    }

    public function getFechVencimiento() {
        return $this->fech_vencimiento;
    }

    public function getFechaRegistro() {
        return $this->fecha_registro;
    }

    public function getCantidadProducto() {
        return $this->cantidad_producto;
    }

    public function getCantidadProducto2() {
        return $this->cantidad_producto2;
    }

    public function getCantidadProducto3() {
        return $this->cantidad_producto3;
    }

    public function getPrecioProducto() {
        return $this->precio_producto;
    }

    public function getPrecioProducto2() {
        return $this->precio_producto2;
    }

    public function getPrecioProducto3() {
        return $this->precio_producto3;
    }

    public function getUniMedida() {
        return  $this->uni_medida; 
    }

    public function getUniMedida2() {
        return $this->uni_medida2; 
    }

    public function getUniMedida3() {
        return $this->uni_medida3; 
    }

    public function getIdActualizacion() {
        return $this->id_actualizacion; 
    }

    public function getPeso() {
        return $this->peso; 
    }

    public function getPeso2() {
        return $this->peso2; 
    }

    public function getPeso3() {
        return $this->peso3; 
    }

    // Setters
    public function setIdProducto($id_producto) {
        $this->id_producto =  $id_producto;  
    }

    public function setImg($imagen) {
        $this->imagen =  $imagen;  
    }

    public function setMarca($marca) {
        $this->marca =  $marca;  
    }

    public function setNombreProducto($nombre_producto) {
        $this->nombre_producto =  $nombre_producto;  
    }

    public function setPresentacion($presentacion) {
        $this->presentacion =  $presentacion;  
    }

    public function setFechVencimiento($fech_vencimiento) {
        $this->fech_vencimiento =  $fech_vencimiento;  
    }

    public function setFechaRegistro($fecha_registro) {
        $this->fecha_registro =  $fecha_registro;  
    }

    public function setCantidadProducto($cantidad_producto) {
        $this->cantidad_producto =  $cantidad_producto;  
    }

    public function setCantidadProducto2($cantidad_producto2) {
        $this->cantidad_producto2 =  $cantidad_producto2;  
    }

    public function setCantidadProducto3($cantidad_producto3) {
        $this->cantidad_producto3 =  $cantidad_producto3;  
    }

    public function setPrecioProducto($precio_producto) {
        $this->precio_producto=  $precio_producto;  
    }

    public function setPrecioProducto2($precio_producto_2) { 
        $this->precio_producto_2= $precio_producto_2;  
    }
    
    public function setPrecioProducto3($precio_producto_3) { 
        $this->precio_producto_3= $precio_producto_3;  
    }
    
    public function setUniMedida($uni_medida) { 
        $this->uni_medida= $uni_medida;  
    }
    
    public function setUniMedida2($uni_medida_2) { 
        $this->uni_medida_2= $uni_medida_2;  
    }
    
    public function setUniMedida3($uni_medida_3) { 
        $this->uni_medida_3= $uni_medida_3;  
    }
    
    public function setIdActualizacion($id_actualizacion) { 
        $this->id_actualizacion= $id_actualizacion;  
    }
    
    public function setPeso($peso) { 
        $this->peso= $peso;  
    }
    
    public function setPeso2($peso_2) { 
        $this->peso_2= $peso_2;  
    }
    
    public function setPeso3($peso_3) { 
        $this->peso_3= $peso_3;  
    }

    //Metodos


        //Indiferentemente sea la accion primero la funcion manejar accion llama a la 
    //funcion setcliente data que validad todos los valores
    //luego de que todo los datos sean validados correctamente
    //verifica que la variable validacion que contiene el status de la funcion sea correcta 
    //si es incorrecta retorna el status de mensajes de errores 
    //si es correcta me llama la funcion correspondiente 
    public function manejarAccion($accion, $producto) {
        switch ($accion) {
            case 'agregar':
                $validacion = $this->setProductoData($producto);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Guardar_Producto();
    
            case 'agregar2':
                $validacion = $this->setProductoData($producto);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Guardar_Producto2();
    
            case 'actualizar':
                $validacion = $this->setProductoData($producto);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Actualizar_Producto();
    
            case 'obtener':
                $validacion = $this->setValideId($producto);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Obtener_Producto($producto);

            case 'obtenerProductos':
                return $this->Mostrar_Producto2();

    
            case 'eliminar':
                $validacion = $this->setValideId($producto);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Eliminar_Producto($producto);
    
            case 'consultar':
                return $this->Mostrar_Producto();
    
            default:
                return ['status' => false, 'msj' => 'Acción inválida'];
        }
    }
    

    private function Guardar_Producto() {
        $conn = null;
        try {
            $conn = $this->getConnection();
            $conn->beginTransaction();

            $query = "INSERT INTO producto (id_producto, nombre, marca, fecha_vencimiento, fecha_registro, id_presentacion, enlace, status) 
                      VALUES (:id_producto, :nombre_producto, :marca, :fech_venci, :fecha_registro, :presentacion, :imagen, 1)";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(":id_producto", $this->id_producto, PDO::PARAM_INT);
            $stmt->bindParam(":nombre_producto", $this->nombre_producto, PDO::PARAM_STR);
            $stmt->bindParam(":fech_venci", $this->fech_vencimiento);
            $stmt->bindParam(":fecha_registro", $this->fecha_registro);
            $stmt->bindParam(":presentacion", $this->presentacion, PDO::PARAM_STR);
            $stmt->bindParam(":imagen", $this->imagen);
            $stmt->bindParam(":marca", $this->marca);

            if (!$stmt->execute()) {
                $conn->rollBack();
                return ['status' => false, 'msj' => 'Error al guardar el producto'];
            }

            $query = "INSERT INTO cantidad_producto (id_producto, cantidad, precio, id_unidad_medida, peso)  
                      VALUES (:id_producto, :cantidad_producto, :precio_producto, :uni_medida, :peso),
                             (:id_producto, :cantidad_producto2, :precio_producto2, :uni_medida2, :peso2),
                             (:id_producto, :cantidad_producto3, :precio_producto3, :uni_medida3, :peso3)";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(":id_producto", $this->id_producto);
            $stmt->bindParam(":cantidad_producto", $this->cantidad_producto, PDO::PARAM_INT);
            $stmt->bindParam(":precio_producto", $this->precio_producto);
            $stmt->bindParam(":uni_medida", $this->uni_medida, PDO::PARAM_INT);
            $stmt->bindParam(":peso", $this->peso);

            $stmt->bindParam(":cantidad_producto2", $this->cantidad_producto2, PDO::PARAM_INT);
            $stmt->bindParam(":precio_producto2", $this->precio_producto2);
            $stmt->bindParam(":uni_medida2", $this->uni_medida2, PDO::PARAM_INT);
            $stmt->bindParam(":peso2", $this->peso2);

            $stmt->bindParam(":cantidad_producto3", $this->cantidad_producto3, PDO::PARAM_INT);
            $stmt->bindParam(":precio_producto3", $this->precio_producto3);
            $stmt->bindParam(":uni_medida3", $this->uni_medida3, PDO::PARAM_INT);
            $stmt->bindParam(":peso3", $this->peso3);

            if (!$stmt->execute()) {
                $conn->rollBack();
                return ['status' => false, 'msj' => 'Error al guardar cantidades del producto'];
            }

            $conn->commit();
            return ['status' => true, 'msj' => 'Producto guardado correctamente'];

        } catch (PDOException $e) {
            if ($conn && $conn->inTransaction()) {
                $conn->rollBack();
            }
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }

    public function Guardar_Producto2() {
        $conn = null;
        try {
            $conn = $this->getConnection();
            $conn->beginTransaction();

            $query = "INSERT INTO producto (id_producto, nombre, marca, fecha_vencimiento, fecha_registro, id_presentacion, enlace, status) 
                      VALUES (:id_producto, :nombre_producto, :marca, :fech_venci, :fecha_registro, :presentacion, :imagen, 1)";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(":id_producto", $this->id_producto, PDO::PARAM_INT);
            $stmt->bindParam(":nombre_producto", $this->nombre_producto, PDO::PARAM_STR);
            $stmt->bindParam(":fech_venci", $this->fech_vencimiento);
            $stmt->bindParam(":fecha_registro", $this->fecha_registro);
            $stmt->bindParam(":presentacion", $this->presentacion, PDO::PARAM_STR);
            $stmt->bindParam(":imagen", $this->imagen);
            $stmt->bindParam(":marca", $this->marca);

            if (!$stmt->execute()) {
                $conn->rollBack();
                return ['status' => false, 'msj' => 'Error al guardar el producto'];
            }

            $query = "INSERT INTO cantidad_producto (id_producto, cantidad, precio, id_unidad_medida)  
                      VALUES (:id_producto, :cantidad_producto, :precio_producto, :uni_medida)";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(":id_producto", $this->id_producto);
            $stmt->bindParam(":cantidad_producto", $this->cantidad_producto, PDO::PARAM_INT);
            $stmt->bindParam(":precio_producto", $this->precio_producto);
            $stmt->bindParam(":uni_medida", $this->uni_medida, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                $conn->rollBack();
                return ['status' => false, 'msj' => 'Error al guardar cantidad del producto'];
            }

            $conn->commit();
            return ['status' => true, 'msj' => 'Producto guardado correctamente'];

        } catch (PDOException $e) {
            if ($conn && $conn->inTransaction()) {
                $conn->rollBack();
            }
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }

    private function Mostrar_Producto() {
        $conn = null;
        try {
            $conn = $this->getConnection();

            $query = "SELECT 
                        p.*, 
                        MAX(p.fecha_vencimiento) AS fecha_vencimiento, 
                        GROUP_CONCAT(cp.cantidad SEPARATOR '\n ') AS cantidad, 
                        GROUP_CONCAT(cp.precio SEPARATOR ' $ Bs\n ') AS precio, 
                        GROUP_CONCAT(cp.peso SEPARATOR '\n ') AS peso,
                        GROUP_CONCAT(m.nombre_medida SEPARATOR '\n ') AS nombre_medida, 
                        a.nombre_motivo,
                        s.presentacion
                      FROM producto p  
                      LEFT JOIN motivo_actualizacion a ON p.id_motivoActualizacion = a.id_motivoActualizacion   
                      LEFT JOIN cantidad_producto cp ON p.id_producto = cp.id_producto  
                      LEFT JOIN unidades_de_medida m ON cp.id_unidad_medida = m.id_unidad_medida
                      LEFT JOIN presentacion s ON s.id_presentacion = p.id_presentacion
                      WHERE p.status=1 GROUP BY p.id_producto ";

            $stmt = $conn->prepare($query);
            if (!$stmt->execute()) {
                return ['status' => false, 'msj' => 'Error al obtener productos'];
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            //return ['status' => true, 'data' => $result];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }

    public function Mostrar_ProductoE() {
        $conn = null;
        try {
            $conn = $this->getConnection();

            $query = "SELECT 
                        p.*, 
                        MAX(p.fecha_vencimiento) AS fecha_vencimiento, 
                        GROUP_CONCAT(cp.cantidad SEPARATOR '\n ') AS cantidad, 
                        GROUP_CONCAT(cp.precio SEPARATOR ' $ Bs\n ') AS precio, 
                        GROUP_CONCAT(cp.peso SEPARATOR '\n ') AS peso,
                        GROUP_CONCAT(m.nombre_medida SEPARATOR '\n ') AS nombre_medida, 
                        GROUP_CONCAT(cp.id_unidad_medida SEPARATOR '\n ') AS id_medida, 
                        a.nombre_motivo,
                        s.presentacion
                      FROM producto p  
                      LEFT JOIN motivo_actualizacion a ON p.id_motivoActualizacion = a.id_motivoActualizacion   
                      LEFT JOIN cantidad_producto cp ON p.id_producto = cp.id_producto  
                      LEFT JOIN unidades_de_medida m ON cp.id_unidad_medida = m.id_unidad_medida
                      LEFT JOIN presentacion s ON s.id_presentacion = p.id_presentacion
                      WHERE p.status=1 GROUP BY p.id_producto ";

            $stmt = $conn->prepare($query);
            if (!$stmt->execute()) {
                return ['status' => false, 'msj' => 'Error al obtener productos'];
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            //return ['status' => true, 'data' => $result];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }


    private function Mostrar_Producto2() {
        $conn = null;
        try {
            $conn = $this->getConnection();

            $query = "SELECT *
                      FROM producto p 
                      LEFT JOIN motivo_actualizacion a ON p.id_motivoActualizacion = a.id_motivoActualizacion  
                      LEFT JOIN cantidad_producto cp ON p.id_producto = cp.id_producto 
                      LEFT JOIN unidades_de_medida m ON cp.id_unidad_medida = m.id_unidad_medida
                      LEFT JOIN presentacion s ON s.id_presentacion = p.id_presentacion WHERE p.status=1";

            $stmt = $conn->prepare($query);
            if (!$stmt->execute()) {
                return ['status' => false, 'msj' => 'Error al obtener productos'];
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            //return ['status' => true, 'data' => $result];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }

    public function Obtener_Producto($id_producto) {
        $conn = null;
        try {
            $conn = $this->getConnection();

            $query = "SELECT p.*, a.nombre_motivo, cp.cantidad AS cantidad, cp.precio, cp.peso, s.presentacion, m.nombre_medida AS nombre_medida 
                      FROM producto p  
                      LEFT JOIN motivo_actualizacion a ON p.id_motivoActualizacion = a.id_motivoActualizacion   
                      LEFT JOIN cantidad_producto cp ON p.id_producto = cp.id_producto  
                      LEFT JOIN unidades_de_medida m ON cp.id_unidad_medida = m.id_unidad_medida  
                      LEFT JOIN presentacion s ON s.id_presentacion = p.id_presentacion
                      WHERE cp.id_producto = :id_producto;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                return ['status' => false, 'msj' => 'Error al obtener producto'];
            }

            return $stmt->fetch(PDO::FETCH_ASSOC);
            //return ['status' => true, 'data' => $result];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }

    private function Actualizar_Producto() {
        $conn = null;
        try {
            $conn = $this->getConnection();

            $query = "UPDATE producto SET nombre = :nombre, marca = :marca, id_presentacion = :presentacion, fecha_vencimiento = :fecha_vencimiento, id_motivoActualizacion = :id_actualizacion WHERE id_producto = :id_producto;";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(":id_producto", $this->id_producto);
            $stmt->bindParam(":nombre", $this->nombre_producto);
            $stmt->bindParam(":marca", $this->marca);
            $stmt->bindParam(":fecha_vencimiento", $this->fech_vencimiento);
            $stmt->bindParam(":id_actualizacion", $this->id_actualizacion);
            $stmt->bindParam(":presentacion", $this->presentacion);

            $success1 = $stmt->execute();

            $query3 = "UPDATE cantidad_producto SET 
                cantidad = CASE 
                    WHEN id_unidad_medida = :uni_medida THEN :cantidad_producto
                    WHEN id_unidad_medida = :uni_medida2 THEN :cantidad_producto2
                    WHEN id_unidad_medida = :uni_medida3 THEN :cantidad_producto3
                    ELSE cantidad 
                END,
                precio = CASE 
                    WHEN id_unidad_medida = :uni_medida THEN :precio_producto
                    WHEN id_unidad_medida = :uni_medida2 THEN :precio_producto2
                    WHEN id_unidad_medida = :uni_medida3 THEN :precio_producto3
                    ELSE precio 
                END,
                peso = CASE 
                    WHEN id_unidad_medida = :uni_medida THEN :peso
                    WHEN id_unidad_medida = :uni_medida2 THEN :peso2
                    WHEN id_unidad_medida = :uni_medida3 THEN :peso3
                    ELSE peso 
                END
                WHERE id_producto = :id_producto AND id_unidad_medida IN (:uni_medida, :uni_medida2, :uni_medida3);";

            $stmt3 = $conn->prepare($query3);

            $stmt3->bindParam(":id_producto", $this->id_producto);
            $stmt3->bindParam(":cantidad_producto", $this->cantidad_producto);
            $stmt3->bindParam(":cantidad_producto2", $this->cantidad_producto2);
            $stmt3->bindParam(":cantidad_producto3", $this->cantidad_producto3);
            $stmt3->bindParam(":precio_producto", $this->precio_producto);
            $stmt3->bindParam(":precio_producto2", $this->precio_producto2);
            $stmt3->bindParam(":precio_producto3", $this->precio_producto3);
            $stmt3->bindParam(":uni_medida", $this->uni_medida);
            $stmt3->bindParam(":uni_medida2", $this->uni_medida2);
            $stmt3->bindParam(":uni_medida3", $this->uni_medida3);
            $stmt3->bindParam(":peso", $this->peso);
            $stmt3->bindParam(":peso2", $this->peso2);
            $stmt3->bindParam(":peso3", $this->peso3);

            $success3 = $stmt3->execute();

            if ($success1 && $success3) {
                return ['status' => true, 'msj' => 'Producto actualizado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar el producto'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }

    public function obtenerStockProducto($id_producto) {
        $conn = null;
        try {
            $conn = $this->getConnection();

            $sql = "SELECT GROUP_CONCAT(cp.cantidad SEPARATOR '\n ') AS cantidad
                    FROM producto p  
                    LEFT JOIN motivo_actualizacion a ON p.id_motivoActualizacion = a.id_motivoActualizacion   
                    LEFT JOIN cantidad_producto cp ON p.id_producto = cp.id_producto  
                    LEFT JOIN unidades_de_medida m ON cp.id_unidad_medida = m.id_unidad_medida
                    LEFT JOIN presentacion s ON s.id_presentacion = p.id_presentacion
                    WHERE p.id_producto = :id_producto";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id_producto", $id_producto);
            $stmt->execute();

            $cantidad = $stmt->fetchColumn();
            return ['status' => true, 'data' => $cantidad];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }

    private function Eliminar_Producto($id_producto) {
        $conn = null;
        try {
            $conn = $this->getConnection();
            $conn->beginTransaction();
    
            $query = "UPDATE producto SET status = 0 WHERE id_producto = :id_producto";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
            $stmt->execute();

            $query2 = "DELETE FROM cantidad_producto WHERE id_producto = :id_producto";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
            $stmt2->execute();
    
            $conn->commit();
            return ['status' => true, 'msj' => 'Producto eliminado correctamente'];
        } catch (PDOException $e) {
            if ($conn) {
                $conn->rollBack();
            }
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }
    
}
?>