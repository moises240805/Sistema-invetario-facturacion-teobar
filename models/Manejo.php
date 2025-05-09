<?php

require_once "Conexion.php";

class Manejo extends Conexion{
    //Atributos

    private $id;
    private $id_cajas;
    private $movimiento;
    private $fecha;
    private $monto;
    private $id_pago;
    private $descripcion;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    public function setIngresoEgresoData($ingreso_data) {
        if (is_string($ingreso_data)) {
            $ingreso_data = json_decode($ingreso_data, true);
        }
    
        $this->id_cajas = $ingreso_data['id_cajas'] ?? null;
        $this->id_pago = $ingreso_data['id_pago'] ?? null;
        $this->movimiento = $ingreso_data['movimiento'] ?? null;
        $this->fecha = $ingreso_data['fecha'] ?? null;
        $this->monto = $ingreso_data['monto'] ?? null;
        $this->descripcion = $ingreso_data['descripcion'] ?? null;
    }

    // Métodos set y get
    public function setIdBitacora($id_cajas) {
        $this->id_cajas = $id_cajas;
    }

    public function getIdBitacora() {
        return $this->id_cajas;
    }

    public function setIdPago($id_paago) {
        $this->id_pago = $id_pago;
    }

    public function getIdPago() {
        return $this->id_pago;
    }


    public function setMovimiento($movimiento) {
        $this->movimiento = $movimiento;
    }

    public function getMovisetMovimiento() {
        return $this->movimiento;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setMonto($monto) {
        $this->monto = $monto;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }



    public function Guardar_IngresoEgreso()
    {
        try {
            // Iniciar transacción
            $this->conn->beginTransaction();
    
            // Insertar el movimiento en la tabla movimientos_caja
            $query = "INSERT INTO movimientos_caja (id_cajas, tipo_movimiento, monto_movimiento, concepto, fecha, id_pago)
                      VALUES (:id_cajas, :movimiento, :monto, :descripcion, :fecha, :id_pago)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_cajas", $this->id_cajas);
            $stmt->bindParam(":movimiento", $this->movimiento);
            $stmt->bindParam(":monto", $this->monto);
            $stmt->bindParam(":descripcion", $this->descripcion);
            $stmt->bindParam(":fecha", $this->fecha);
            $stmt->bindParam(":id_pago", $this->id_pago);
            if (!$stmt->execute()) {
                $this->conn->rollBack();
                return false;
            }
    
            // Obtener todos los movimientos de la caja para el id_pago actual
            $query2 = "SELECT tipo_movimiento, monto_movimiento FROM movimientos_caja WHERE id_pago = :id_pago";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(":id_pago", $this->id_pago, PDO::PARAM_INT);
            $stmt2->execute();
            $movimientos = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
            // Calcular el saldo total
            $saldo = 0;
            foreach ($movimientos as $mov) {
                if (strtolower($mov['tipo_movimiento']) == 'ingreso') {
                    $saldo += $mov['monto_movimiento'];
                } else if (strtolower($mov['tipo_movimiento']) == 'egreso') {
                    $saldo -= $mov['monto_movimiento'];
                }
            }
    
            // Actualizar el saldo en la tabla cajas
            $query3 = "UPDATE cajas SET saldo_caja = :saldo WHERE ID = :id_cajas";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(":saldo", $saldo);
            $stmt3->bindParam(":id_cajas", $this->id_cajas);
            if (!$stmt3->execute()) {
                $this->conn->rollBack();
                return false;
            }
    
            // Confirmar transacción
            $this->conn->commit();
            return true;
    
        } catch(PDOException $e) {
            // Rollback en caso de error
            $this->conn->rollBack();
            error_log("Error en Guardar_IngresoEgreso: " . $e->getMessage());
            return false;
        }
    }
    
    


    public function Mostrar_Movimiento() {
        // Consulta SQL para seleccionar todos los registros de la tabla bitacora
        $query = "SELECT * FROM movimientos_caja m
        LEFT JOIN cajas c ON m.id_cajas=c.ID
        LEFT JOIN modalidad_de_pago p ON m.id_pago=p.id_modalidad_pago";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}   
?>