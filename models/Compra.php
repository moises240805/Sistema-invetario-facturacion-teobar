<?php

require_once "Conexion.php";

class Compra extends Conexion{
    //Atributos
    private $id_compra;
    private $id_producto;
    private $id_cliente;
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

    public function setCompraData($venta) {
        if (is_string($venta)) {
            $venta = json_decode($venta, true);
        }
    
        $this->id_compra = $venta['id_compra'] ?? null; // Cambiado de id_venta a id_compra
        $this->id_producto = $venta['productos']['id_producto'] ?? null;
        $this->id_medida = $venta['productos']['id_medida'] ?? null;
        $this->tipo_compra = $venta['tipo_compra'] ?? null;
        $this->tlf = $venta['tlf'] ?? null;
        $this->id_cliente = $venta['id_cliente'] ?? null;
        $this->cantidad = $venta['cantidad'] ?? null;
        $this->fech_emision = $venta['fech_emision'] ?? null;
        $this->id_modalidad_pago = $venta['id_modalidad_pago'] ?? null;
        $this->monto = $venta['monto'] ?? null;
        $this->tipo_entrega = $venta['tipo_entrega'] ?? null;
        $this->rif_banco = $venta['rif_banco'] ?? null;
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
    public function Guardar_Compra() 
    { 
        try { 
            $this->conn->beginTransaction(); 
            
            // Recorrer los arrays de productos y medidas
            for ($i = 0; $i < count($this->id_producto); $i++) {
                $producto_id = $this->id_producto[$i];
                $medida_id = $this->id_medida[$i];
                $cantidad = $this->cantidad[$i]; // Suponiendo que cantidad también es un array
    
                // Verificar la cantidad disponible del producto 
                $stmt = $this->conn->prepare("SELECT cantidad FROM cantidad_producto WHERE id_producto = :id_producto AND id_unidad_medida = :id_medida"); 
                $stmt->bindParam(':id_producto', $producto_id); 
                $stmt->bindParam(':id_medida', $medida_id); 
                $stmt->execute(); 
                
                $producto = $stmt->fetch(PDO::FETCH_ASSOC); 
                
                // Verificar si se encontró el producto
                if (!$producto) {
                    echo "Producto no encontrado: ID " . $producto_id;
                    continue; // Saltar a la siguiente iteración si no se encuentra el producto
                }

        
                // Registrar la venta 
                $stmt2 = $this->conn->prepare("INSERT INTO compra (id_compra, id_producto, rif_proveedor, cantidad_compra, fecha, pago,monto) VALUES (:id_compra, :id_producto, :id_cliente, :cantidad, :fech_emision, :id_modalidad_pago, :monto)"); 
                $stmt2->bindParam(':id_compra', $this->id_compra); 
                $stmt2->bindParam(':id_producto', $producto_id); 
                $stmt2->bindParam(':id_cliente', $this->id_cliente); 
                $stmt2->bindParam(':cantidad', $cantidad); 
                $stmt2->bindParam(':fech_emision', $this->fech_emision); 
                $stmt2->bindParam(':id_modalidad_pago', $this->id_modalidad_pago); 
                $stmt2->bindParam(':monto', $this->monto); 
                $stmt2->execute(); 

                $stmt3 = $this->conn->prepare("INSERT INTO detalle_compra_proveedor (id_detalleCompraProveedor, id_facturaProveedor, id_producto, cantidad_compra) VALUES (:id_detalleproducto, :id_compra, :id_producto, :cantidad)"); 
                $stmt3->bindParam(':id_compra', $this->id_compra); 
                $stmt3->bindParam(':id_producto', $producto_id); 
                $stmt3->bindParam(':cantidad', $cantidad); 
                $stmt3->bindParam(':id_detalleproducto', $this->id_compra); 
                $stmt3->execute(); 
        
            // Sumar la cantidad al stock del producto
            $nueva_cantidad = $producto['cantidad'] + $cantidad; 
            $stmt4 = $this->conn->prepare("UPDATE cantidad_producto SET cantidad = :nueva_cantidad WHERE id_producto = :id_producto AND id_unidad_medida = :id_medida"); 
            $stmt4->bindParam(':nueva_cantidad', $nueva_cantidad); 
            $stmt4->bindParam(':id_producto', $producto_id); 
            $stmt4->bindParam(':id_medida', $medida_id); 
            $stmt4->execute(); 
        }

            $n=5;
            $m=$this->id_modalidad_pago;
            if($m==$n)
            {
                $stmt5 = $this->conn->prepare("INSERT INTO cuenta_por_pagar (id_cuentaPagar, id_compra, fecha_cuentaPagar, monto_cuentaPagar) VALUES (:id_cuentaCobrar, :id_compra, :fecha_cuentaCobrar, :monto_cuentaCobrar)"); 
                $stmt5->bindParam(':id_compra', $this->id_compra); 
                $stmt5->bindParam(':id_cuentaCobrar', $this->id_compra);
                $stmt5->bindParam(':fecha_cuentaCobrar', $this->fech_emision); 
                $stmt5->bindParam(':monto_cuentaCobrar', $this->monto); // Asegúrate de que el monto sea correcto para cada producto 
                $stmt5->execute();  
            }

            $id_actualizacion=0;
            $stmt6 = $this->conn->prepare("UPDATE producto SET id_motivoActualizacion = :id_actualizacion WHERE id_producto = :id_producto");
            $stmt6->bindParam(':id_actualizacion', $id_actualizacion); 
            $stmt6->bindParam(':id_producto', $producto_id); 
            $stmt6->execute(); 
    
            // Confirmar la transacción solo si todas las operaciones fueron exitosas
            if ($this->conn->inTransaction()) {
                $this->conn->commit(); 
            }
            
            return true; 
    
        } catch (Exception $e) { 
            // Revertir la transacción en caso de error 
            if ($this->conn->inTransaction()) { 
                $this->conn->rollBack(); 
            } 
            echo "Error al registrar la compra: " . $e->getMessage(); 
        } 
    }
    

    // Método para obtener todas las venta de la base de datos
    public function Mostrar_Compra() {
        // Consulta SQL para seleccionar todos los registros de la tabla venta
        $query = "SELECT 
                    v.id_compra, 
                    v.fecha, 
                    c.nombre_proveedor AS nombre_cliente,
                    c.id_proveedor,
                    c.tipo_id,
                    p.nombre AS nombre,
                    m.nombre_modalidad,
                    v.monto,
                    GROUP_CONCAT(p.nombre SEPARATOR '\n ') AS nombre,
                    GROUP_CONCAT(v.cantidad_compra SEPARATOR '\n ') AS cantidad
                  FROM 
                    compra v 
                  LEFT JOIN 
                    producto p ON p.id_producto = v.id_producto
                  LEFT JOIN 
                    proveedor c ON c.id_proveedor = v.rif_proveedor
                  LEFT JOIN 
                    modalidad_de_pago m ON m.id_modalidad_pago = v.pago
                  GROUP BY 
                    v.id_compra"; 
    
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function Actualizar_Compra() {
        try {
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
    }

     function Eliminar_Compra($id_compra) {
        $query = "DELETE FROM compra WHERE id_compra = :id_compra";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_compra", $this->id_compra, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }

    public function obtenerCuentas2() {
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
    }
}
?>