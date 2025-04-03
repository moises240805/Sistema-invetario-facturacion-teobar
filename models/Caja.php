<?php

require_once "Conexion.php";

class Caja extends Conexion{
    //Atributos

    private $id_cajas;
    private $nombre_caja;
    private $saldo_caja;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    public function setCajaData($data) {
        if (is_string($data)) {
            $data = json_decode($data, true);
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
    public function Update_SaldoCaja()
    {
        try {
            $query = "UPDATE cajas SET ID=id_cajas";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":monto", $this->monto);
            
            // Ejecutar y retornar resultado
            return $stmt->execute();
            
        } catch(PDOException $e) {
            error_log("Error en Ingreso Egreso: " . $e->getMessage()); // Mejor que echo
            return false;
        }    
    }


    public function Mostrar_Caja() {
        // Consulta SQL para seleccionar todos los registros de la tabla bitacora
        $query = "SELECT * FROM cajas ";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}   
?>