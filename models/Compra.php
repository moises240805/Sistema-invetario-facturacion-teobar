<?php

require_once "Conexion.php";

class Compra extends Conexion{
    //Atributos
    private $id_compra;
    private $id_producto;
    private $id_proveedor;
    private $cantidad;
    private $fech_emision;
    private $id_modalidad_pago;
    private $monto;
    private $tipo_entrega;
    private $rif_banco;
    private $id_medida;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    private function setCompraData($compra) {
        if (is_string($compra)) {
            $compra = json_decode($compra, true);
        }

        // Expresiones regulares para validación
        $exp_id = "/^\d+$/";
        $exp_tipo_entrega = "/^(Directa|Delivery)$/i";
        $exp_rif_banco = "/^[A-Z0-9\-]+$/i";

        // Validar id_compra
        if (!isset($compra['id_compra']) || !preg_match($exp_id, $compra['id_compra'])) {
            return ['status' => false, 'msj' => 'ID de compra inválido'];
        }
        $this->id_compra = (int)$compra['id_compra'];

        // Validar productos (arrays)
        if (
            !isset($compra['productos']['id_producto']) ||
            !is_array($compra['productos']['id_producto']) ||
            empty($compra['productos']['id_producto'])
        ) {
            return ['status' => false, 'msj' => 'Productos no especificados'];
        }
        if (
            !isset($compra['productos']['id_medida']) ||
            !is_array($compra['productos']['id_medida']) ||
            empty($compra['productos']['id_medida'])
        ) {
            return ['status' => false, 'msj' => 'Medidas no especificadas'];
        }
        if (
            !isset($compra['cantidad']) ||
            !is_array($compra['cantidad']) ||
            empty($compra['cantidad'])
        ) {
            return ['status' => false, 'msj' => 'Cantidades no especificadas'];
        }

        // Validar cada id_producto
        foreach ($compra['productos']['id_producto'] as $id_producto) {
            if (!preg_match($exp_id, $id_producto)) {
                return ['status' => false, 'msj' => 'ID de producto inválido'];
            }
        }
        $this->id_producto = $compra['productos']['id_producto'];

        // Validar cada id_medida
        foreach ($compra['productos']['id_medida'] as $id_medida) {
            if (!preg_match($exp_id, $id_medida)) {
                return ['status' => false, 'msj' => 'ID de medida inválido'];
            }
        }
        $this->id_medida = $compra['productos']['id_medida'];

        // Validar cada cantidad
        foreach ($compra['cantidad'] as $cantidad) {
            if (!is_numeric($cantidad) || $cantidad <= 0) {
                return ['status' => false, 'msj' => 'Cantidad inválida'];
            }
        }
        $this->cantidad = $compra['cantidad'];

        // Validar id_proveedor
        if (!isset($compra['id_proveedor']) || !preg_match($exp_id, $compra['id_proveedor'])) {
            return ['status' => false, 'msj' => 'ID de proveedor inválido'];
        }
        $this->id_proveedor = (int)$compra['id_proveedor'];

        // Validar fecha de emisión
        $fech_emision = trim($compra['fech_emision'] ?? '');
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fech_emision) || !strtotime($fech_emision)) {
            return ['status' => false, 'msj' => 'Fecha de emisión inválida'];
        }
        $this->fech_emision = $fech_emision;

        // Validar id_modalidad_pago
        if (!isset($compra['id_modalidad_pago']) || !preg_match($exp_id, $compra['id_modalidad_pago'])) {
            return ['status' => false, 'msj' => 'ID de modalidad de pago inválido'];
        }
        $this->id_modalidad_pago = (int)$compra['id_modalidad_pago'];

        // Validar monto
        if (!isset($compra['monto']) || !is_numeric($compra['monto']) || $compra['monto'] <= 0) {
            return ['status' => false, 'msj' => 'Monto inválido'];
        }
        $this->monto = (float)$compra['monto'];

        // Validar tipo_entrega
        $tipo_entrega = trim($compra['tipo_entrega'] ?? '');
        if (!preg_match($exp_tipo_entrega, $tipo_entrega)) {
            return ['status' => false, 'msj' => 'Tipo de entrega inválido'];
        }
        $this->tipo_entrega = ucfirst(strtolower($tipo_entrega));

        // Validar rif_banco (opcional)
        $rif_banco = trim($compra['rif_banco'] ?? '');
        if ($rif_banco !== '' && !preg_match($exp_rif_banco, $rif_banco)) {
            return ['status' => false, 'msj' => 'RIF banco inválido'];
        }
        $this->rif_banco = $rif_banco !== '' ? strtoupper($rif_banco) : null;

        return ['status' => true, 'msj' => 'Datos de compra validados correctamente'];
    }


    private function setValideId($compra) {
        if (is_string($compra)) {
            $compra = json_decode($compra, true);
        }

        // Expresiones regulares para validación
        $exp_id = "/^\d+$/";


        // Validar id_compra
        if (!isset($compra['id_compra']) || !preg_match($exp_id, $compra['id_compra'])) {
            return ['status' => false, 'msj' => 'ID de compra inválido'];
        }
        $this->id_compra = (int)$compra['id_compra'];
        return ['status' => true, 'msj' => 'Datos de compra validados correctamente'];
    }
    

    // Getters
    public function getIdCompra() {
        return $this->id_compra;
    }

    public function getIdProducto() {
        return $this->id_producto;
    }

    public function getIdCliente() {
        return $this->id_cliente;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getFechEmision() {
        return $this->fech_emision;
    }

    public function getIdModalidadPago() {
        return $this->id_modalidad_pago;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function getTipoEntrega() {
        return $this->tipo_entrega;
    }

    public function getRifBanco() {
        return $this->rif_banco;
    }

    public function getIdMedida() {
        return $this->id_medida;
    }

    // Setters
    public function setIdCompra($id_compra) {
        $this->id_compra = $id_compra;
    }

    public function setIdProducto($id_producto) {
        $this->id_producto = $id_producto;
    }

    public function setIdCliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setFechEmision($fech_emision) {
        $this->fech_emision = $fech_emision;
    }

    public function setIdModalidadPago($id_modalidad_pago) {
        $this->id_modalidad_pago = $id_modalidad_pago;
    }

    public function setMonto($monto) {
        $this->monto = $monto;
    }

    public function setTipoEntrega($tipo_entrega) {
        $this->tipo_entrega = $tipo_entrega;
    }

    public function setRifBanco($rif_banco) {
        $this->rif_banco = $rif_banco;
    }

    public function setIdMedida($id_medida) {
        $this->id_medida = $id_medida;
    }

     //Metodos



    //Indiferentemente sea la accion primero la funcion manejar accion llama a la 
    //funcion setcliente data que validad todos los valores
    //luego de que todo los datos sean validados correctamente
    //verifica que la variable validacion que contiene el status de la funcion sea correcta 
    //si es incorrecta retorna el status de mensajes de errores 
    //si es correcta me llama la funcion correspondiente 
    public function manejarAccion($accion, $compra) {
        switch ($accion) {

            case 'agregar':
                $validacion=$this->setCompraData($compra);
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    return $this->Guardar_Compra();
                }
                break;

            case 'actualizar':


            case 'obtenerBancos':
                    return $this->obtenerBancos();
                
            case 'obtenerPagos':
                    return $this->obtenerPagos();
                
            case 'obtenerNumeroCompra':
                return $this->obtenerNumeroCompra();
                break;

            case 'eliminar':

                    return $this->Eliminar_Compra($compra);
                

            case 'consultar':
                return $this->Mostrar_Compra();
                break;
                case 'consultar_c':
                return $this->Mostrar_ComprasPagos($compra);
                break;
            default:
                return ['status' => false, 'msj' => 'Accion invalida'];
        }
    }


    private function Guardar_Compra() { 
        $this->closeConnection();
        try { 
            $conn=$this->getConnection();
            $this->conn->beginTransaction(); 

            // Registrar la compra 
                $stmt2 = $this->conn->prepare("INSERT INTO compra (id_compra, rif_proveedor, fecha, pago, monto, status) VALUES (:id_compra,  :id_proveedor,  :fech_emision, :id_modalidad_pago, :monto, 1)"); 
                $stmt2->bindParam(':id_compra', $this->id_compra);  
                $stmt2->bindParam(':id_proveedor', $this->id_proveedor); 
                $stmt2->bindParam(':fech_emision', $this->fech_emision); 
                $stmt2->bindParam(':id_modalidad_pago', $this->id_modalidad_pago); 
                $stmt2->bindParam(':monto', $this->monto); 
                $stmt2->execute(); 


            // Recorrer los arrays de productos y medidas
            for ($i = 0; $i < count($this->id_producto); $i++) {
                $producto_id = $this->id_producto[$i];
                $medida_id = $this->id_medida[$i];
                $cantidad = $this->cantidad[$i]; // Suponiendo que cantidad también es un array

                 // Obtener la equivalencia en kg del producto (ejemplo: 1 bulto = 12 kg)
            $stmtEquiv = $this->conn->prepare("SELECT equiv_kg FROM producto WHERE id_producto = :id_producto");
            $stmtEquiv->bindParam(':id_producto', $producto_id);
            $stmtEquiv->execute();
            $productoEquiv = $stmtEquiv->fetch(PDO::FETCH_ASSOC);

            // Si no se encuentra el producto, revertir y devolver error
            if (!$productoEquiv) {
                $this->conn->rollBack();
                return ['status' => false, 'msj' => "Producto no encontrado para equivalencia: ID $producto_id"];
            }

            $equiv_kg = $productoEquiv['equiv_kg']; // Valor de equivalencia (kg por bulto)


            $stmt3 = $this->conn->prepare("INSERT INTO detalle_compra_proveedor ( id_facturaProveedor, id_producto, cantidad_compra) VALUES ( :id_compra, :id_producto, :cantidad)"); 
                $stmt3->bindParam(':id_compra', $this->id_compra); 
                $stmt3->bindParam(':id_producto', $producto_id); 
                $stmt3->bindParam(':cantidad', $cantidad); 
                $stmt3->execute();
    
                // Obtener todas las filas de inventario para el producto, con sus unidades de medida
            $stmtCantidades = $this->conn->prepare("SELECT id_unidad_medida, cantidad FROM cantidad_producto WHERE id_producto = :id_producto");
            $stmtCantidades->bindParam(':id_producto', $producto_id);
            $stmtCantidades->execute();
            $cantidadesProducto = $stmtCantidades->fetchAll(PDO::FETCH_ASSOC);
        
               // Calcular la cantidad total a incrementar en kilogramos según la unidad de venta
            if ($medida_id == 3 ) { // Venta en bultos
                $cantidadDescontarKg = $cantidad * $equiv_kg; // Convertir bultos a kg
            } elseif ($medida_id == 7 ) { // Venta en kg
                $cantidadDescontarKg = $cantidad * $equiv_kg;; // Ya está en kg
            } elseif ($medida_id == 4) { // Venta en kg
                $cantidadDescontarKg = $cantidad * $equiv_kg;; // Ya está en kg
            } elseif ($medida_id == 1) { // Venta en kg
                $cantidadDescontarKg = $cantidad; // Ya está en kg
            } elseif ($medida_id == 5) { // Venta en kg
                $cantidadDescontarKg = $cantidad; // Ya está en kg
            } elseif ($medida_id == 2) { // Venta en gramos
                $cantidadDescontarKg = $cantidad / 1000; // Convertir gramos a kg
            } elseif ($medida_id == 6) { // Venta en gramos
                $cantidadDescontarKg = $cantidad / 1000; // Convertir gramos a kg
            }

            // Recorrer cada unidad de inventario y descontar la cantidad proporcional
            foreach ($cantidadesProducto as $fila) {
                $unidadMedida = $fila['id_unidad_medida']; // Unidad de medida en inventario
                $cantidadActual = $fila['cantidad'];       // Cantidad disponible en inventario
                $cantidadADescontar = 0;

                // Calcular la cantidad a descontar según la unidad de inventario
                if ($unidadMedida == 1) { // kg
                    $cantidadADescontar = $cantidadDescontarKg;
                } elseif ($unidadMedida == 5) { // l
                    $cantidadADescontar = $cantidadDescontarKg;
                } elseif ($unidadMedida == 2) { // gramos
                    $cantidadADescontar = $cantidadDescontarKg * 1000;
                } elseif ($unidadMedida == 6) { // ml
                    $cantidadADescontar = $cantidadDescontarKg * 1000;
                } elseif ($unidadMedida == 3) { // bulto
                    $cantidadADescontar = $cantidadDescontarKg / $equiv_kg;
                } elseif ($unidadMedida == 4) { // saco
                    $cantidadADescontar = $cantidadDescontarKg / $equiv_kg;
                } elseif ($unidadMedida == 7) { // galon
                    $cantidadADescontar = $cantidadDescontarKg / $equiv_kg;
                } else {
                    $cantidadADescontar = 0; // Otras unidades (puedes agregar lógica)
                }

                
                /*
                if ($cantidadActual < $cantidadADescontar) {
                    $this->conn->rollBack();
                    return ['status' => false, 'msj' => "Cantidad insuficiente para producto ID $producto_id en unidad de medida $unidadMedida"];
                }
                */

                // Calcular nueva cantidad en inventario después del descuento
                $nuevaCantidad = $cantidadActual + $cantidadADescontar;

                // Actualizar la cantidad en inventario para esa unidad
                $stmtUpdate = $this->conn->prepare("UPDATE cantidad_producto SET cantidad = :nueva_cantidad WHERE id_producto = :id_producto AND id_unidad_medida = :id_medida");
                $stmtUpdate->bindParam(':nueva_cantidad', $nuevaCantidad);
                $stmtUpdate->bindParam(':id_producto', $producto_id);
                $stmtUpdate->bindParam(':id_medida', $unidadMedida);
                $stmtUpdate->execute();
            }
        }
    
            $n = 5;
            $m = $this->id_modalidad_pago;
            if ($m == $n) {
                $stmt5 = $this->conn->prepare("INSERT INTO cuenta_por_pagar (id_cuentaPagar, id_compra, fecha_cuentaPagar, monto_cuentaPagar, status) VALUES (:id_cuentaCobrar, :id_compra, :fecha_cuentaCobrar, :monto_cuentaCobrar, 1)"); 
                $stmt5->bindParam(':id_compra', $this->id_compra); 
                $stmt5->bindParam(':id_cuentaCobrar', $this->id_compra);
                $stmt5->bindParam(':fecha_cuentaCobrar', $this->fech_emision); 
                $stmt5->bindParam(':monto_cuentaCobrar', $this->monto);  
                $stmt5->execute();  
            }
    
            $id_actualizacion = 0;
            $stmt6 = $this->conn->prepare("UPDATE producto SET id_motivoActualizacion = :id_actualizacion WHERE id_producto = :id_producto");
            $stmt6->bindParam(':id_actualizacion', $id_actualizacion); 
            $stmt6->bindParam(':id_producto', $producto_id); 
            $stmt6->execute(); 
    
            // Confirmar la transacción solo si todas las operaciones fueron exitosas
            if ($this->conn->inTransaction()) {
                $this->conn->commit(); 
            }
            
            return ['status' => true, 'msj' => 'Compra registrada correctamente']; 
    
        } catch (Exception $e) { 
            // Revertir la transacción en caso de error 
            if ($this->conn->inTransaction()) { 
                $this->conn->rollBack(); 
            } 
            return ['status' => false, 'msj' => 'Error al registrar la compra: ' . $e->getMessage()]; 
        } 
         finally {
            $this->closeConnection();
        }
    }
    
    

    // Método para obtener todas las venta de la base de datos
    private function Mostrar_Compra() {

        try{
            // Consulta SQL para seleccionar todos los registros de la tabla venta
            $conn=$this->getConnection();
            $query = "SELECT 
                        v.id_compra, 
                        v.fecha, 
                        c.nombre_proveedor AS nombre_cliente,
                        c.id_proveedor,
                        c.tipo_id,
                        c.tlf,
                        c.direccion,
                        p.nombre AS nombre,
                        m.nombre_modalidad,
                        v.monto,
                        GROUP_CONCAT(p.nombre SEPARATOR '\n ') AS nombre,
                        GROUP_CONCAT(dp.cantidad_compra SEPARATOR '\n ') AS cantidad
                    FROM 
                        compra v 
                    LEFT JOIN 
                        detalle_compra_proveedor dp ON dp.id_facturaProveedor = v.id_compra
                    LEFT JOIN 
                        producto p ON p.id_producto = dp.id_producto
                    LEFT JOIN 
                        proveedor c ON c.id_proveedor = v.rif_proveedor
                    LEFT JOIN 
                        modalidad_de_pago m ON m.id_modalidad_pago = v.pago
                    WHERE v.status=1
                    GROUP BY 
                        v.id_compra"; 
        
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) {
            // Deshacer la transacción en caso de excepción
            
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
         finally {
            $this->closeConnection();
        }
        
    }

    private function Mostrar_ComprasPagos($compra) {

        try{
            // Consulta SQL para seleccionar todos los registros de la tabla venta
            $conn=$this->getConnection();
            $query = "SELECT 
                        v.id_compra, 
                        v.fecha, 
                        c.nombre_proveedor AS nombre_cliente,
                        c.id_proveedor,
                        c.tipo_id,
                        c.tlf,
                        c.direccion,
                        p.nombre AS nombre,
                        m.nombre_modalidad,
                        v.monto,
                        GROUP_CONCAT(p.nombre SEPARATOR '\n ') AS nombre,
                        GROUP_CONCAT(dp.cantidad_compra SEPARATOR '\n ') AS cantidad
                    FROM 
                        compra v 
                    LEFT JOIN 
                        detalle_compra_proveedor dp ON dp.id_facturaProveedor = v.id_compra
                    LEFT JOIN 
                        producto p ON p.id_producto = dp.id_producto
                    LEFT JOIN 
                        proveedor c ON c.id_proveedor = v.rif_proveedor
                    LEFT JOIN 
                        modalidad_de_pago m ON m.id_modalidad_pago = v.pago
                    WHERE v.status=1 AND v.pago=$compra
                    GROUP BY 
                        v.id_compra"; 
        
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) {
            
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
         finally {
            $this->closeConnection();
        }
        
    }

    function Actualizar_Compra() {
        $this->closeConnection();
        try {
            $conn=$this->getConnection();
            // Iniciar la transacción
            $this->conn->beginTransaction();
            // Paso 1: Obtener el monto actual
            $querySelect = "SELECT monto_cuentaPagar FROM cuenta_por_pagar WHERE id_cuentaPagar = :id_compra";
            $stmtSelect = $this->conn->prepare($querySelect);
            $stmtSelect->bindParam(":id_compra", $this->id_compra);
            $stmtSelect->execute();
    
            if ($stmtSelect->rowCount() > 0) {
                $currentMonto = (float)$stmtSelect->fetchColumn();
                $montoArestar = (float)$this->monto;
    
                // Validar que el nuevo monto no sea negativo
                if ($currentMonto - $montoArestar < 0) {
                    echo "El monto a restar es mayor que el monto actual.";
                    return false;
                }
    
                $nuevoMonto = $currentMonto - $montoArestar;
    
                // Paso 4: Actualizar la tabla con el nuevo monto
                $queryUpdate = "UPDATE cuenta_por_pagar SET monto_cuentaPagar = :monto, fecha_cuentaPagar = :fech_emision WHERE id_cuentaPagar = :id_compra";
                $stmtUpdate = $this->conn->prepare($queryUpdate);
    
                // Vincula los parámetros
                $stmtUpdate->bindParam(":id_compra", $this->id_compra);
                $stmtUpdate->bindParam(":fech_emision", $this->fech_emision);
                $stmtUpdate->bindParam(":monto", $nuevoMonto);
    
                if ($stmtUpdate->execute()) {
                    // Confirmar la transacción
                    $this->conn->commit();
                    return true;
                } else {
                    // Deshacer la transacción en caso de error
                    $this->conn->rollBack();
                    echo "Error al actualizar el registro.";
                    return false;
                }
            } else {
                echo "No se encontró la venta con ID: " . $this->id_compra;
                return false;
            }
        } catch (PDOException $e) {
            // Deshacer la transacción en caso de excepción
            $this->conn->rollBack();
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
         finally {
            $this->closeConnection();
        }
    }

     function Eliminar_Compra($id_compra) {
        $this->closeConnection();
        try{
            $conn=$this->getConnection();
            $query = "UPDATE compra SET status = 0 WHERE id_compra = :id_compra";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_compra", $id_compra, PDO::PARAM_INT);
            if ($stmt->execute()) {
                    return ['status' => true, 'msj' => 'Compra eliminada correctamente'];
                } else {
                    return ['status' => false, 'msj' => 'Error al eliminar la compra'];
                }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function obtenerCuentas2() {
        $this->closeConnection();
        try{
        $conn=$this->getConnection();
        $query = "SELECT 
                    c.id_cuentaPagar, 
                    c.fecha_cuentaPagar, 
                    c.monto_cuentaPagar,
                    p.nombre_proveedor, 
                    v.rif_proveedor,
                    GROUP_CONCAT(v.id_compra SEPARATOR '\n ') AS id_venta,
                    GROUP_CONCAT(v.fecha SEPARATOR '\n ') AS fechas_ventas,
                    GROUP_CONCAT(v.monto SEPARATOR ' $ Bs\n ') AS montos_ventas
                  FROM 
                    cuenta_por_pagar c
                  LEFT JOIN 
                    compra v ON c.id_cuentaPagar = v.id_compra
                  LEFT JOIN proveedor p ON p.id_proveedor = v.rif_proveedor
                  GROUP BY 
                    c.id_cuentaPagar"; 
    
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function obtenerBancos() {
        $this->closeConnection();
        try{
            $conn=$this->getConnection();
            $query = "SELECT * FROM bancos";
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function obtenerPagos() {
        $this->closeConnection();
        try{
            $conn=$this->getConnection();
            $query = "SELECT * FROM modalidad_de_pago";
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }


       private function obtenerNumeroCompra() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            $query = "SELECT MAX(id_compra) as id_compra FROM compra LIMIT 1";
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}
?>