<?php

require_once "Conexion.php";

class Pedido extends Conexion{

public function Guardar_Pedido(array $pedidoData)
{
    $this->closeConnection();
        try{
        $conn=$this->getConnection();
        $this->conn->beginTransaction();

        // Datos generales
        $cedula = $pedidoData['cedula'] ?? null;
        $id_modalidad_pago = $pedidoData['modalidad_pago'] ?? null;
        $telefono = $pedidoData['tlf'] ?? null;
        $productos = $pedidoData['productos'] ?? [];

        if (!$cedula || !$id_modalidad_pago || empty($productos)) {
            throw new Exception("Datos insuficientes para guardar el pedido");
        }

        // Aquí deberías obtener el id_cliente a partir de la cédula, ejemplo:
        $stmtCliente = $this->conn->prepare("SELECT id_cliente FROM cliente WHERE id_cedula = :cedula");
        $stmtCliente->bindParam(':cedula', $cedula);
        $stmtCliente->execute();
        $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {
            throw new Exception("Cliente no encontrado con cédula $cedula");
        }

        $id_cliente = $cliente['id_cliente'];

        // Generar un nuevo id_pedido (puede ser autoincremental o generado aquí)
        // Ejemplo simple usando uniqid (mejor usar autoincrement en BD)
        $id_pedido = uniqid();

        $fecha_emision = date('Y-m-d H:i:s');
        $fecha_vencimiento = null; // Puedes definir según lógica
        $tipo_entrega = null;      // Puedes definir según lógica
        $rif_banco = null;         // Puedes definir según lógica
        $tipo_compra = null;       // Puedes definir según lógica

        $monto_total = 0;

        foreach ($productos as $item) {
            $producto_id = $item['id'];
            $medida_id = $item['medida'];
            $cantidad = $item['cantidad'];
            $precio = $item['precio'];

            // Verificar cantidad disponible
            $stmt = $this->conn->prepare("SELECT cantidad FROM cantidad_producto WHERE id_producto = :id_producto AND id_unidad_medida = :id_medida");
            $stmt->bindParam(':id_producto', $producto_id);
            $stmt->bindParam(':id_medida', $medida_id);
            $stmt->execute();
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$producto) {
                $this->conn->rollBack();
                return ['status' => false, 'msj' => "Producto no encontrado: ID $producto_id"];
            }

            if ($producto['cantidad'] < $cantidad) {
                $this->conn->rollBack();
                return ['status' => false, 'msj' => "Cantidad insuficiente para el producto ID $producto_id"];
            }

            // Insertar pedido
            $stmt2 = $this->conn->prepare("INSERT INTO pedido (id_pedido, id_producto, id_cliente, cantidad, id_modalidad_pago, monto, telefono, status) VALUES (:id_pedido, :id_producto, :id_cliente, :cantidad, :id_modalidad_pago, :monto, :telefono, 1)");
            $stmt2->bindParam(':id_pedido', $id_pedido);
            $stmt2->bindParam(':id_producto', $producto_id);
            $stmt2->bindParam(':id_cliente', $id_cliente);
            $stmt2->bindParam(':cantidad', $cantidad);
            $stmt2->bindParam(':id_modalidad_pago', $id_modalidad_pago);
            $stmt2->bindParam(':monto', $precio);
            $stmt2->bindParam(':telefono', $telefono);
            $stmt2->execute();


            // Actualizar cantidad disponible
            $nueva_cantidad = $producto['cantidad'] - $cantidad;
            $stmt4 = $this->conn->prepare("UPDATE cantidad_producto SET cantidad = :nueva_cantidad WHERE id_producto = :id_producto AND id_unidad_medida = :id_medida");
            $stmt4->bindParam(':nueva_cantidad', $nueva_cantidad);
            $stmt4->bindParam(':id_producto', $producto_id);
            $stmt4->bindParam(':id_medida', $medida_id);
            $stmt4->execute();

            $monto_total += $precio * $cantidad;
        }

        // Aquí puedes insertar en cuenta_por_cobrar si aplica, o cualquier otra lógica

        $this->conn->commit();

        return ['status' => true, 'msj' => 'Pedido guardado correctamente', 'monto_total' => $monto_total];

    } catch (Exception $e) {
        if ($this->conn->inTransaction()) {
            $this->conn->rollBack();
        }
        return ['status' => false, 'msj' => 'Error al guardar el pedido: ' . $e->getMessage()];
    } finally {
        $this->closeConnection();
    }
    }


}
?>