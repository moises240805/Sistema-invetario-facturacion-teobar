<?php

require_once "Conexion.php";

class Bitacora extends Conexion{
    //Atributos

    private $id_bitacora;
    private $id_admin;
    private $movimiento;
    private $fecha;
    private $modulo;
    private $descripcion;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    public function setBitacoraData($bitacora_data) {
        if (is_string($bitacora_data)) {
            $bitacora_data = json_decode($bitacora_data, true);
        }

        $this->id_bitacora = $bitacora_data['id_bitacora'] ?? null;
        $this->id_admin = $bitacora_data['id_admin'] ?? null;
        $this->movimiento = $bitacora_data['movimiento'] ?? null;
        $this->fecha = $bitacora_data['fecha'] ?? null;
        $this->modulo = $bitacora_data['modulo'] ?? null;
        $this->descripcion = $bitacora_data['descripcion'] ?? null;
    }

    // Métodos set y get
    public function setIdBitacora($id_bitacora) {
        $this->id_bitacora = $id_bitacora;
    }

    public function getIdBitacora() {
        return $this->id_bitacora;
    }

    public function setIdAdmin($id_admin) {
        $this->id_admin = $id_admin;
    }

    public function getIdAdmin() {
        return $this->id_admin;
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

    public function setModulo($modulo) {
        $this->modulo = $modulo;
    }

    public function getModulo() {
        return $this->modulo;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    //Metodos
    public function Guardar_Bitacora()
    {
        try {
            $query = "INSERT INTO bitacora (id_admin, movimiento, fecha, modulo, descripcion) 
                      VALUES (:id_admin, :movimiento, :fecha, :modulo, :descripcion)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_admin", $this->id_admin);
            $stmt->bindParam(":movimiento", $this->movimiento);
            $stmt->bindParam(":fecha", $this->fecha);
            $stmt->bindParam(":modulo", $this->modulo);
            $stmt->bindParam(":descripcion", $this->descripcion);
            
            // Ejecutar y retornar resultado
            return $stmt->execute();
            
        } catch(PDOException $e) {
            error_log("Error en bitácora: " . $e->getMessage()); // Mejor que echo
            return false;
        }    
    }

    // Método para obtener la bitacora de la base de datos
    public function Mostrar_Bitacora() {
        // Consulta SQL para seleccionar todos los registros de la tabla bitacora
        $query = "SELECT * FROM bitacora b 
        LEFT JOIN admin a ON b.id_admin=a.ID";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}   
?>