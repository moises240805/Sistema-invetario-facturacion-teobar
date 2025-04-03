<?php

require_once "Conexion.php";

class Pagar extends Conexion{

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

    function Actualizar_Cuenta() {
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