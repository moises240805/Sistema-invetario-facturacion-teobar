<?php

require_once "Conexion.php";

class IngresoEgreso extends Conexion{
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
            $query = "INSERT INTO movimientos_caja (id_cajas, tipo_movimiento, monto_movimiento, concepto, fecha, id_pago)
                      VALUES (:id_cajas, :movimiento, :monto, :descripcion, :fecha, :id_pago)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_cajas", $this->id_cajas);
            $stmt->bindParam(":movimiento", $this->movimiento);
            $stmt->bindParam(":monto", $this->monto);
            $stmt->bindParam(":descripcion", $this->descripcion);
            $stmt->bindParam(":fecha", $this->fecha);
            $stmt->bindParam(":id_pago", $this->id_pago);
            
            if ($stmt->execute()) {
                // Obtener montos de ingresos
                $montosIngresos = $this->ObtenerMontosIngresos($this->id_pago);

                if($this->movimiento=="Ingreso"){

                if ($montosIngresos !== false) {
                    // Calcular monto total
                    $montoTotal = $this->CalcularMontoTotal($montosIngresos);
                    
                    // Actualizar saldo de caja
                    return $this->Update_SaldoCaja($montoTotal);
                } else {
                    return false;
                }
            }
            if ($this->movimiento=="Egreso"){
                if ($montosIngresos !== false) {
                    // Calcular monto total final restando el egreso
                    $montoTotalFinal = $this->CalcularMontoTotal2($montosIngresos, $this->monto);
                    
                    // Actualizar saldo de caja
                    return $this->Update_SaldoCaja($montoTotalFinal);
                } else {
                    return false;
                }
            }
            
            else {
                return false;
            }
        }
            
        } catch(PDOException $e) {
            error_log("Error en Ingreso Egreso: " . $e->getMessage());
            return false;
        }
    }
    


    public function Mostrar_IngresoEgreso() {
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


    public function ObtenerMontosIngresos($id_pago)
    {
        try {
            $query = "SELECT monto_movimiento FROM movimientos_caja WHERE tipo_movimiento = 'ingreso' AND id_pago = :id_pago";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_pago", $id_pago, PDO::PARAM_INT); // Vincular el parámetro id_pago
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los resultados como un array asociativo
            
        } catch(PDOException $e) {
            error_log("Error al obtener montos de ingresos: " . $e->getMessage());
            return false;
        }
    }



public function CalcularMontoTotal($montosIngresos)
{
    $montoTotal = 0;
    foreach ($montosIngresos as $ingreso) {
        $montoTotal += $ingreso['monto_movimiento'];
    }
    return $montoTotal;
}

public function CalcularMontoTotal2($montosIngresos, $montoEgreso)
{
    // Calcular monto total de ingresos
    $montoTotalIngresos = $this->CalcularMontoTotal($montosIngresos);
    
    // Restar el monto del egreso del total de ingresos
    $montoTotalFinal = $montoTotalIngresos - $montoEgreso;
    
    return $montoTotalFinal;
}

public function Update_SaldoCaja($montoTotal)
{
    try {
        $query = "UPDATE cajas SET saldo_caja = :monto WHERE ID = :id_cajas";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":monto", $montoTotal);
        $stmt->bindParam(":id_cajas", $this->id_cajas);
        
        // Ejecutar y retornar resultado
        return $stmt->execute();
        
    } catch(PDOException $e) {
        error_log("Error al actualizar saldo de caja: " . $e->getMessage());
        return false;
    }
}
}   
?>