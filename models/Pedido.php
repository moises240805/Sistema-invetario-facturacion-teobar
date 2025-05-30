<?php

require_once "Conexion.php";

class Pedido extends Conexion {
    // Atributos
    private $id_pedido;
    private $id_producto;
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
    private $portal;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    // Establecer datos desde el JSON recibido
    private function setPedidoData($pedido) {
        if (is_string($pedido)) {
            $pedido = json_decode($pedido, true);
        }

        // Validar campos obligatorios
        if (!isset($pedido['cedula']) || empty($pedido['cedula'])) {
            return ['status' => false, 'msj' => 'Cédula requerida'];
        }
        if (!isset($pedido['modalidad_pago']) || empty($pedido['modalidad_pago'])) {
            return ['status' => false, 'msj' => 'Modalidad de pago requerida'];
        }
        if (!isset($pedido['tlf']) || empty($pedido['tlf'])) {
            return ['status' => false, 'msj' => 'Teléfono requerido'];
        }
        if (!isset($pedido['total']) || !is_numeric($pedido['total'])) {
            return ['status' => false, 'msj' => 'Total inválido'];
        }
        if (!isset($pedido['productos']) || !is_array($pedido['productos']) || empty($pedido['productos'])) {
            return ['status' => false, 'msj' => 'Productos requeridos'];
        }

        // Asignar datos generales
        $this->id_cliente = $pedido['cedula'];
        $this->id_modalidad_pago = $pedido['modalidad_pago'];
        $this->tlf = $pedido['tlf'];
        $this->rif_banco = $pedido['rif_banco'];
        $this->monto = $pedido['total'];
        $this->fech_emision = date('Y-m-d');
        $this->fech_vencimiento = date('Y-m-d', strtotime('+7 days')); // Ejemplo: 7 días de validez

        // Procesar productos
        $this->id_producto = [];
        $this->id_medida = [];
        $this->cantidad = [];
        foreach ($pedido['productos'] as $prod) {
            if (!isset($prod['id']) || !isset($prod['cantidad']) || !isset($prod['unidad_seleccionada'])) {
                return ['status' => false, 'msj' => 'Datos de producto incompletos'];
            }
            $this->id_producto[] = $prod['id'];
            $this->cantidad[] = $prod['cantidad'];
            $this->id_medida[] = $prod['unidad_seleccionada'];
        }

        return ['status' => true, 'msj' => 'Datos de pedido validados correctamente'];
    }

    // Getters y setters (solo los principales)
    public function getIdPedido() { return $this->id_pedido; }
    public function getIdProducto() { return $this->id_producto; }
    public function getIdMedida() { return $this->id_medida; }
    public function getCantidad() { return $this->cantidad; }
    public function getMonto() { return $this->monto; }
    public function getIdCliente() { return $this->id_cliente; }
    public function getTlf() { return $this->tlf; }
    public function getIdModalidadPago() { return $this->id_modalidad_pago; }
    public function getFechEmision() { return $this->fech_emision; }
    public function getFechVencimiento() { return $this->fech_vencimiento; }

    // Setters (puedes agregar más si los necesitas)
    public function setIdPedido($id_pedido) { $this->id_pedido = $id_pedido; }

    // Método principal para manejar acciones
    public function manejarAccion($accion, $pedido) {
        switch ($accion) {
            case 'agregar':
                $validacion = $this->setPedidoData($pedido);
                if (!$validacion['status']) {
                    return $validacion;
                } else {
                    return $this->Guardar_Pedido();
                }
                break;
            // ...otros casos como actualizar, eliminar, consultar, etc.
            default:
                return ['status' => false, 'msj' => 'Acción inválida'];
        }
    }

    // Guardar el pedido y sus productos
    private function Guardar_Pedido() {
        $this->closeConnection();

        try {
            $conn = $this->getConnection();
            $conn->beginTransaction();

            // Obtener el siguiente id_pedido (puedes cambiar esto por autoincrement si lo prefieres)
            $stmtId = $conn->prepare("SELECT MAX(id_venta) AS next_id FROM venta");
            $stmtId->execute();
            $row = $stmtId->fetch(PDO::FETCH_ASSOC);
            $this->id_pedido = $row['next_id'] + 1 ;
            $this->portal='Tienda';

            // Insertar el pedido
            $stmtPedido = $conn->prepare("INSERT INTO venta (id_venta, id_cliente, fech_emision, id_modalidad_pago, monto, rif_banco, tlf, portal, status)
                                                    VALUES (:id_pedido, :id_cliente, :fech_emision, :id_modalidad_pago, :monto, :rif_banco, :tlf, :portal, 1)");
            $stmtPedido->bindParam(':id_pedido', $this->id_pedido);
            $stmtPedido->bindParam(':id_cliente', $this->id_cliente);
            $stmtPedido->bindParam(':fech_emision', $this->fech_emision);
            $stmtPedido->bindParam(':id_modalidad_pago', $this->id_modalidad_pago);
            $stmtPedido->bindParam(':monto', $this->monto);
            $stmtPedido->bindParam(':rif_banco', $this->rif_banco);
            $stmtPedido->bindParam(':tlf', $this->tlf);
            $stmtPedido->bindParam(':portal', $this->portal);
            $stmtPedido->execute();


            
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




                $stmtDetalle = $conn->prepare("INSERT INTO detalle_producto (id_venta, id_producto, cantidad_producto, id_medida_especifica, precio) 
                                               VALUES (:id_pedido, :id_producto, :cantidad, :id_medida, :monto)");
                $stmtDetalle->bindParam(':id_pedido', $this->id_pedido);
                $stmtDetalle->bindParam(':id_producto', $this->id_producto[$i]);
                $stmtDetalle->bindParam(':cantidad', $this->cantidad[$i]);
                $stmtDetalle->bindParam(':id_medida', $this->id_medida[$i]);
                $stmtDetalle->bindParam(':monto', $this->monto);
                $stmtDetalle->execute();


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
            

            //$conn->commit();
            return ['status' => true, 'msj' => 'Pedido guardado correctamente', 'id_pedido' => $this->id_pedido];
        } catch (PDOException $e) {
            if ($conn->inTransaction()) $conn->rollBack();
            return ['status' => false, 'msj' => 'Error al guardar pedido: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}
