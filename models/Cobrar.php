<?php

require_once "Conexion.php";

class Cobrar extends Conexion{

    private $id_cuenta;
    private $tlf;
    private $id_cliente;
    private $fech_emision;
    private $monto;
    private $id_modalidad_pago;
    private $rif_banco;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    public function setVentaData($cuenta) {
        if (is_string($cuenta)) {
            $cuenta = json_decode($cuenta, true);
        }
    
        $this->id_cuenta = $cuenta['id_cuenta'] ?? null;
        $this->tlf = $cuenta['tlf'] ?? null;
        $this->id_cliente = $cuenta['id_cliente'] ?? null;
        $this->fech_emision = $cuenta['fech_emision'] ?? null;
        $this->id_modalidad_pago = $cuenta['id_modalidad_pago'] ?? null;
        $this->monto = $cuenta['monto'] ?? null;
        $this->rif_banco = $cuenta['rif_banco'] ?? null;
    }
    

    // Getters
    public function getIdCuenta() {
        return $this->id_cuenta;
    }

    public function getIdProducto() {
        return $this->id_producto;
    }



    public function getTlf() {
        return $this->tlf;
    }

    public function getIdCliente() {
        return $this->id_cliente;
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



    public function getRifBanco() {
        return $this->rif_banco;
    }



    // Setters
    public function setIdCuenta($id_cuenta) {
        $this->id_cuenta = $id_cuenta;
    }



    public function setTlf($tlf) {
        $this->tlf = $tlf;
    }

    public function setIdCliente($id_cliente) {
        $this->id_cliente = $id_cliente;
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



    public function setRifBanco($rif_banco) { 
        $this->$rif_banco= $rif_banco;  
    }





    public function obtenerCuentas() {
        $query = "SELECT 
                    c.id_cuentaCobrar, 
                    c.fecha_cuentaCobrar, 
                    c.monto_cuentaCobrar, 
                    s.nombre_cliente,
                    v.id_cliente,
                    GROUP_CONCAT(v.id_venta SEPARATOR '\n ') AS id_cuenta,
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
    }

    function Actualizar_Cuenta() {
        try {
            // Iniciar la transacción
            $this->conn->beginTransaction();
            // Paso 1: Obtener el monto actual
            $querySelect = "SELECT monto_cuentaCobrar FROM cuenta_por_cobrar WHERE id_cuentaCobrar = :id_cuenta";
            $stmtSelect = $this->conn->prepare($querySelect);
            $stmtSelect->bindParam(":id_cuenta", $this->id_cuenta);
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
                $queryUpdate = "UPDATE cuenta_por_cobrar SET monto_cuentaCobrar = :monto, fecha_cuentaCobrar = :fech_emision WHERE id_cuentaCobrar = :id_cuenta";
                $stmtUpdate = $this->conn->prepare($queryUpdate);
    
                // Vincula los parámetros
                $stmtUpdate->bindParam(":id_cuenta", $this->id_cuenta);
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
                echo "No se encontró la venta con ID: " . $this->id_cuenta;
                return false;
            }
        } catch (PDOException $e) {
            // Deshacer la transacción en caso de excepción
            $this->conn->rollBack();
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }
}
    ?>