<?php

require_once "Conexion.php";

class Venta extends Conexion{
    //Atributos
    private $id_venta;
    private $id_producto;
    private $tipo_compra;
    private $tlf;
    private $id_cliente;
    private $cantidad;
    private $fech_emision;
    private $fech_vencimiento;
    private $id_modalidad_pago;
    private $monto;
    private $tipo_entrega;
    private $rif_banco;
    private $id_medida;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    private function setVentaData($venta) {
        if (is_string($venta)) {
            $venta = json_decode($venta, true);
        }
    
        // Expresiones regulares para validar campos específicos
        $exp_id = "/^\d+$/"; // solo números para ids
        $exp_tipo_compra = "/^(5|6)$/i"; // ejemplo: tipos permitidos
        $exp_tlf = "/^\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/";
        $exp_tipo_entrega = "/^(Directa|Delivery)$/i"; // ejemplo: tipos permitidos
        $exp_rif_banco = "/^[A-Z0-9\-]+$/i"; // ejemplo: caracteres permitidos para rif banco
    
        // Validar id_venta (único)
        if (!isset($venta['id_venta']) || !preg_match($exp_id, $venta['id_venta'])) {
            return ['status' => false, 'msj' => 'ID de venta inválido'];
        }
        $this->id_venta = (int)$venta['id_venta'];

        // Validar productos (arrays)
        if (
            !isset($venta['productos']['id_producto']) || 
            !is_array($venta['productos']['id_producto']) || 
            empty($venta['productos']['id_producto'])
        ) {
            return ['status' => false, 'msj' => 'Productos no especificados'];
        }
        if (
            !isset($venta['productos']['id_medida']) || 
            !is_array($venta['productos']['id_medida']) || 
            empty($venta['productos']['id_medida'])
        ) {
            return ['status' => false, 'msj' => 'Medidas no especificadas'];
        }
        if (
            !isset($venta['cantidad']) || 
            !is_array($venta['cantidad']) || 
            empty($venta['cantidad'])
        ) {
            return ['status' => false, 'msj' => 'Cantidades no especificadas'];
        }

        // Validar cada id_producto
        foreach ($venta['productos']['id_producto'] as $id_producto) {
            if (!preg_match($exp_id, $id_producto)) {
                return ['status' => false, 'msj' => 'ID de producto inválido'];
            }
        }
        $this->id_producto = $venta['productos']['id_producto'];

        // Validar cada id_medida
        foreach ($venta['productos']['id_medida'] as $id_medida) {
            if (!preg_match($exp_id, $id_medida)) {
                return ['status' => false, 'msj' => 'ID de medida inválido'];
            }
        }
        $this->id_medida = $venta['productos']['id_medida'];

        // Validar cada cantidad
        foreach ($venta['cantidad'] as $cantidad) {
            if (!is_numeric($cantidad) || $cantidad <= 0) {
                return ['status' => false, 'msj' => 'Cantidad inválida'];
            }
        }
        $this->cantidad = $venta['cantidad'];
    
        // Validar tipo_compra
        $tipo_compra = trim($venta['tipo_compra'] ?? '');
        if (!preg_match($exp_tipo_compra, $tipo_compra)) {
            return ['status' => false, 'msj' => 'Tipo de compra inválido'];
        }
        $this->tipo_compra = strtolower($tipo_compra);
    
        // Validar teléfono
        $tlf = trim($venta['tlf'] ?? '');
        if($tlf!=""){
            if (!preg_match($exp_tlf, $tlf)) {
                return ['status' => false, 'msj' => 'Teléfono inválido'];
            }
        }
        $this->tlf = $tlf;
    
        // Validar id_cliente
        if (!isset($venta['id_cliente']) || !preg_match($exp_id, $venta['id_cliente'])) {
            return ['status' => false, 'msj' => 'ID de cliente inválido'];
        }
        $this->id_cliente = (int)$venta['id_cliente'];
    
        // Validar fecha de emisión (formato YYYY-MM-DD)
        $fech_emision = trim($venta['fech_emision'] ?? '');
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fech_emision) || !strtotime($fech_emision)) {
            return ['status' => false, 'msj' => 'Fecha de emisión inválida'];
        }
        $this->fech_emision = $fech_emision;

        // Validar fecha de emisión (formato YYYY-MM-DD)
        $fech_vencimiento = trim($venta['fech_vencimiento'] ?? '');
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fech_vencimiento) || !strtotime($fech_vencimiento)) {
            return ['status' => false, 'msj' => 'Fecha de vencimiento inválida'];
        }
        $this->fech_vencimiento = $fech_vencimiento;
    
        // Validar id_modalidad_pago
        if($venta['id_modalidad_pago']!=""){
            if (!isset($venta['id_modalidad_pago']) || !preg_match($exp_id, $venta['id_modalidad_pago'])) {
                return ['status' => false, 'msj' => 'ID de modalidad de pago inválido'];
            }
        }
        $this->id_modalidad_pago = (int)$venta['id_modalidad_pago'];
    
        // Validar monto (numérico y mayor que 0)
        if (!isset($venta['monto']) || !is_numeric($venta['monto']) || $venta['monto'] <= 0) {
            return ['status' => false, 'msj' => 'Monto inválido'];
        }
        $this->monto = (float)$venta['monto'];
    
        // Validar tipo_entrega
        $tipo_entrega = trim($venta['tipo_entrega'] ?? '');
        if($tipo_entrega!=""){
            if (!preg_match($exp_tipo_entrega, $tipo_entrega)) {
                return ['status' => false, 'msj' => 'Tipo de entrega inválido'];
            }
        }
        $this->tipo_entrega = ucwords(mb_strtolower($tipo_entrega));
    
        // Validar rif_banco (puede ser opcional, validar si existe)
        $rif_banco = trim($venta['rif_banco'] ?? '');
        if ($rif_banco !== '' && !preg_match($exp_rif_banco, $rif_banco)) {
            return ['status' => false, 'msj' => 'RIF banco inválido'];
        }
        $this->rif_banco = $rif_banco !== '' ? strtoupper($rif_banco) : null;
    
        return ['status' => true, 'msj' => 'Datos de venta validados correctamente'];
    }

    private function setValideId($venta) {
        if (is_string($venta)) {
            $venta = json_decode($venta, true);
        }
    
        // Expresiones regulares para validar campos específicos
        $exp_id = "/^\d+$/"; // solo números para ids
    
        // Validar id_venta
        if (!isset($venta['id_venta']) || !preg_match($exp_id, $venta['id_venta'])) {
            return ['status' => false, 'msj' => 'ID de venta inválido'];
        }
        $this->id_venta = (int)$venta['id_venta'];
        return ['status' => true, 'msj' => 'Datos de venta validados correctamente'];
    }
    
    

    // Getters
    public function getIdVenta() {
        return $this->id_venta;
    }

    public function getIdProducto() {
        return $this->id_producto;
    }

    public function getTipoCompra() {
        return $this->tipo_compra;
    }

    public function getTlf() {
        return $this->tlf;
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

    public function getFechVencimiento() {
        return $this->fech_vencimiento;
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
    public function setIdVenta($id_venta) {
        $this->id_venta = $id_venta;
    }

    public function setIdProducto($id_producto) {
        $this->id_producto = $id_producto;
    }

    public function setTipoCompra($tipo_compra) {
        $this->tipo_compra = $tipo_compra;
    }

    public function setTlf($tlf) {
        $this->tlf = $tlf;
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

    public function setFechVencimiento($fech_vencimiento) {
        $this->fech_vencimiento = $fech_vencimiento;
        
    }

    public function setIdModalidadPago($id_modalidad_pago) {
        $this->id_modalidad_pago = $id_modalidad_pago;
    }

    public function setMonto($monto) {
        $this->monto = $monto;
    }

    public function setTipoEntrega($tipo_entrega) {
        $this->tipo_entrega =  $tipo_entrega; 
    }

    public function setRifBanco($rif_banco) { 
        $this->$rif_banco= $rif_banco;  
    }

    public function setIdMedida($id_medida) { 
        $this->$id_medida= $id_medida;  
    }

    //Metodos



    //Indiferentemente sea la accion primero la funcion manejar accion llama a la 
    //funcion setcliente data que validad todos los valores
    //luego de que todo los datos sean validados correctamente
    //verifica que la variable validacion que contiene el status de la funcion sea correcta 
    //si es incorrecta retorna el status de mensajes de errores 
    //si es correcta me llama la funcion correspondiente 
    public function manejarAccion($accion, $venta) {
        switch ($accion) {

            case 'agregar':
                $validacion=$this->setVentaData($venta);
                // print_r($validacion);
                // die();
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    // echo "Guardar";
                    return $this->Guardar_Venta();
                }
                break;

            case 'actualizar':


            case 'obtenerBancos':
                return $this->obtenerBancos();
                break;
                
            case 'obtenerPagos':
                return $this->obtenerPagos();
                break;
            
            case 'obtenerNumeroVenta':
                return $this->obtenerNumeroVenta();
                break;

            case 'eliminar':
                return $this->Eliminar_Venta($venta);
                break;

            case 'consultar':
                return $this->Mostrar_Venta();
                break;
            case 'consultar_v':
                return $this->Mostrar_VentasPagos($venta);
                break;
            default:
                return ['status' => false, 'msj' => 'Accion invalida'];
        }
    }



  private function Guardar_Venta() 
{ 
    // Cerrar conexión previa para evitar conflictos
    $this->closeConnection();

    try {
        // Abrir nueva conexión a la base de datos
        $conn = $this->getConnection(); 

        // Iniciar transacción para asegurar integridad de datos
        $this->conn->beginTransaction();

        $stmttasa = $this->conn->prepare("SELECT MAX(ID) AS ID FROM tasa_dia");
        $stmttasa->execute();
        $tasa = $stmttasa->fetch(PDO::FETCH_ASSOC);
        
         // Registrar la venta en la tabla 'venta'
            $stmt2 = $this->conn->prepare("INSERT INTO venta (id_venta, id_cliente,  fech_emision, fech_vencimiento, id_modalidad_pago, monto, tipo_entrega, rif_banco, tipo_compra, id_tasa, tlf, status) 
                                                      VALUES (:id_venta, :id_cliente,  :fech_emision, :fech_vencimiento, :id_modalidad_pago, :monto, :tipo_entrega, :rif_banco, :tipo_compra, :tasa,:tlf, 1)");
            
            $stmt2->bindParam(':id_venta', $this->id_venta);
            $stmt2->bindParam(':tipo_compra', $this->tipo_compra);
            $stmt2->bindParam(':tlf', $this->tlf);
            $stmt2->bindParam(':id_cliente', $this->id_cliente);
            $stmt2->bindParam(':fech_emision', $this->fech_emision);
            $stmt2->bindParam(':fech_vencimiento', $this->fech_vencimiento);
            $stmt2->bindParam(':id_modalidad_pago', $this->id_modalidad_pago);
            $stmt2->bindParam(':monto', $this->monto);
            $stmt2->bindParam(':tasa', $tasa['ID']);
            $stmt2->bindParam(':tipo_entrega', $this->tipo_entrega);
            $stmt2->bindParam(':rif_banco', $this->rif_banco);
            $stmt2->execute();
        
        // Recorrer todos los productos que se están vendiendo
        for ($i = 0; $i < count($this->id_producto); $i++) {
            $producto_id = $this->id_producto[$i];   // ID del producto actual
            $medida_id = $this->id_medida[$i];       // Unidad de medida de la venta (bulto, kg, gramos)
            $cantidad = $this->cantidad[$i];         // Cantidad vendida en esa unidad

            // Obtener la cantidad del producto
            $stmtcant = $this->conn->prepare("SELECT cantidad FROM cantidad_producto WHERE id_producto = :id_producto");
            $stmtcant->bindParam(':id_producto', $producto_id);
            $stmtcant->execute();
            $productocant = $stmtcant->fetch(PDO::FETCH_ASSOC);

            // Si no se encuentra el producto, revertir y devolver error
            if ($cantidad>$productocant['cantidad']) {
                $this->conn->rollBack();
                return ['status' => false, 'msj' => "Cantidad insuficiente"];
            }

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


            
            // Registrar el detalle de la venta en 'detalle_producto'
            $stmt3 = $this->conn->prepare("INSERT INTO detalle_producto ( id_venta, id_producto, cantidad_producto, id_medida_especifica, precio) VALUES ( :id_venta, :id_producto, :cantidad, :id_medida, :monto)");
            $stmt3->bindParam(':id_venta', $this->id_venta);
            $stmt3->bindParam(':id_producto', $producto_id);
            $stmt3->bindParam(':id_medida', $medida_id);
            $stmt3->bindParam(':cantidad', $cantidad);
 // Aquí usas id_venta como id_detalle_producto (podría mejorarse)
            $stmt3->bindParam(':monto', $this->monto);
            $stmt3->execute();

            // Obtener todas las filas de inventario para el producto, con sus unidades de medida
            $stmtCantidades = $this->conn->prepare("SELECT id_unidad_medida, cantidad FROM cantidad_producto WHERE id_producto = :id_producto");
            $stmtCantidades->bindParam(':id_producto', $producto_id);
            $stmtCantidades->execute();
            $cantidadesProducto = $stmtCantidades->fetchAll(PDO::FETCH_ASSOC);

            // Calcular la cantidad total a descontar en kilogramos según la unidad de venta
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
                $nuevaCantidad = $cantidadActual - $cantidadADescontar;

                // Actualizar la cantidad en inventario para esa unidad
                $stmtUpdate = $this->conn->prepare("UPDATE cantidad_producto SET cantidad = :nueva_cantidad WHERE id_producto = :id_producto AND id_unidad_medida = :id_medida");
                $stmtUpdate->bindParam(':nueva_cantidad', $nuevaCantidad);
                $stmtUpdate->bindParam(':id_producto', $producto_id);
                $stmtUpdate->bindParam(':id_medida', $unidadMedida);
                $stmtUpdate->execute();
            }
        }

        // Si la modalidad de compra es tipo 5, registrar cuenta por cobrar
        if ($this->tipo_compra == 5) {
            $stmt5 = $this->conn->prepare("INSERT INTO cuenta_por_cobrar (id_cuentaCobrar, id_venta, fecha_cuentaCobrar, monto_cuentaCobrar, status) VALUES (:id_cuentaCobrar, :id_venta, :fecha_cuentaCobrar, :monto_cuentaCobrar,1)");
            $stmt5->bindParam(':id_venta', $this->id_venta);
            $stmt5->bindParam(':id_cuentaCobrar', $this->id_venta);
            $stmt5->bindParam(':fecha_cuentaCobrar', $this->fech_emision);
            $stmt5->bindParam(':monto_cuentaCobrar', $this->monto);
            $stmt5->execute();
        }

        // Actualizar motivo de actualización del producto (marca que se actualizó inventario)
        $id_actualizacion = 1;
        $stmt6 = $this->conn->prepare("UPDATE producto SET id_motivoActualizacion = :id_actualizacion WHERE id_producto = :id_producto");
        $stmt6->bindParam(':id_actualizacion', $id_actualizacion);
        $stmt6->bindParam(':id_producto', $producto_id);
        $stmt6->execute();

        // Confirmar la transacción si todo fue exitoso
        if ($this->conn->inTransaction()) {
            $this->conn->commit();
        }

        // Retornar éxito
        return ['status' => true, 'msj' => 'Venta registrada correctamente'];

    } catch (Exception $e) {
        // En caso de error, revertir transacción
        if ($this->conn->inTransaction()) {
            $this->conn->rollBack();
        }
        // Retornar error con mensaje
        return ['status' => false, 'msj' => 'Error al registrar la venta: ' . $e->getMessage()];
    } finally {
        // Cerrar conexión al finalizar
        $this->closeConnection();
    }
}


    
    

    // Método para obtener todas las venta de la base de datos
    private function Mostrar_Venta() {
        $this->closeConnection();
        try {
        $conn = $this->getConnection();
        // Consulta SQL para seleccionar todos los registros de la tabla venta
        $query = "SELECT 
                    v.*,
                    dp.id_venta, 
                    dp.id_producto,
                    dp.cantidad_producto,
                    v.fech_emision, 
                    c.nombre_cliente AS nombre_cliente,
                    c.id_cliente,
                    c.tipo_id,
                    c.tlf,
                    c.direccion,
                    v.tipo_entrega,
                    b.nombre_banco,
                    m.nombre_modalidad,
                    v.monto,
                    v.tlf,
                    p.nombre,
                    GROUP_CONCAT(p.nombre SEPARATOR '\n ') AS nombres,
                    GROUP_CONCAT(dp.cantidad_producto SEPARATOR '\n ') AS cantidad
                  FROM 
                    venta v 
                  LEFT JOIN 
                    detalle_producto dp ON dp.id_venta = v.id_venta
                LEFT JOIN 
                    producto p ON p.id_producto = dp.id_producto
                  LEFT JOIN 
                    cliente c ON c.id_cliente = v.id_cliente
                  LEFT JOIN 
                    bancos b ON b.rif_banco = v.rif_banco
                  LEFT JOIN 
                    modalidad_de_pago m ON m.id_modalidad_pago = v.id_modalidad_pago
                  WHERE v.status = 1 
                  GROUP BY 
                    v.id_venta"; 
    
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

    private function Mostrar_VentasPagos($venta) {
        $this->closeConnection();
        try {
        $conn = $this->getConnection();
        // Consulta SQL para seleccionar todos los registros de la tabla venta
        $query = "SELECT 
                    v.*,
                    dp.id_venta, 
                    dp.id_producto,
                    dp.cantidad_producto,
                    v.fech_emision, 
                    c.nombre_cliente AS nombre_cliente,
                    c.id_cliente,
                    c.tipo_id,
                    c.tlf,
                    c.direccion,
                    v.tipo_entrega,
                    b.nombre_banco,
                    m.nombre_modalidad,
                    v.monto,
                    v.tlf,
                    p.nombre,
                    GROUP_CONCAT(p.nombre SEPARATOR '\n ') AS nombres,
                    GROUP_CONCAT(dp.cantidad_producto SEPARATOR '\n ') AS cantidad
                  FROM 
                    venta v 
                  LEFT JOIN 
                    detalle_producto dp ON dp.id_venta = v.id_venta
                LEFT JOIN 
                    producto p ON p.id_producto = dp.id_producto
                  LEFT JOIN 
                    cliente c ON c.id_cliente = v.id_cliente
                  LEFT JOIN 
                    bancos b ON b.rif_banco = v.rif_banco
                  LEFT JOIN 
                    modalidad_de_pago m ON m.id_modalidad_pago = v.id_modalidad_pago
                  WHERE v.status = 1 AND v.id_modalidad_pago=$venta 
                  GROUP BY 
                    v.id_venta"; 
    
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

    private function Obtener_Venta($id_venta) {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            $query = "SELECT * FROM venta WHERE id_venta = :id_venta";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_venta", $id_venta, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) {
            // Deshacer la transacción en caso de excepción
            $this->conn->rollBack();
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        } 
        finally {
            $this->closeConnection();
        }
    }

    private function Actualizar_Venta() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            // Iniciar la transacción
            $this->conn->beginTransaction();
            // Paso 1: Obtener el monto actual
            $querySelect = "SELECT monto_cuentaCobrar FROM cuenta_por_cobrar WHERE id_cuentaCobrar = :id_venta";
            $stmtSelect = $this->conn->prepare($querySelect);
            $stmtSelect->bindParam(":id_venta", $this->id_venta);
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
                $queryUpdate = "UPDATE cuenta_por_cobrar SET monto_cuentaCobrar = :monto, fecha_cuentaCobrar = :fech_emision WHERE id_cuentaCobrar = :id_venta";
                $stmtUpdate = $this->conn->prepare($queryUpdate);
    
                // Vincula los parámetros
                $stmtUpdate->bindParam(":id_venta", $this->id_venta);
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
                echo "No se encontró la venta con ID: " . $this->id_venta;
                return false;
            }
        } catch (PDOException $e) {
            // Deshacer la transacción en caso de excepción
            $this->conn->rollBack();
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        } finally {
            $this->closeConnection();
        }
    }
    
    private function Eliminar_Venta($id_venta) {
        $this->closeConnection();
        try {
        $conn = $this->getConnection();
        $query = "UPDATE venta SET status = 0 WHERE id_venta = :id_venta";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_venta", $id_venta, PDO::PARAM_INT);
        if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Venta eliminada correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar la venta'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    public function obtenerCuentas() {
        $this->closeConnection();
        try {
        $conn = $this->getConnection();
        $query = "SELECT 
                    c.id_cuentaCobrar, 
                    c.fecha_cuentaCobrar, 
                    c.monto_cuentaCobrar, 
                    s.nombre_cliente,
                    v.id_cliente,
                    GROUP_CONCAT(v.id_venta SEPARATOR '\n ') AS id_venta,
                    GROUP_CONCAT(v.fech_emision SEPARATOR '\n ') AS fechas_ventas,
                    GROUP_CONCAT(v.monto SEPARATOR ' $ Bs\n ') AS montos_ventas
                  FROM 
                    cuenta_por_cobrar c
                  LEFT JOIN 
                    venta v ON c.id_cuentaCobrar = v.id_venta
                    LEFT JOIN cliente s ON s.id_cliente = v.id_cliente
                  GROUP BY 
                    c.id_cuentaCobrar"; 
    
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
        try {
            $conn = $this->getConnection();
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
        try {
            $conn = $this->getConnection();
            $query = "SELECT * FROM modalidad_de_pago";
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

    private function obtenerNumeroVenta() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            $query = "SELECT MAX(id_venta) as id_venta FROM venta LIMIT 1";
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