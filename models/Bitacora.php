<?php

require_once "Conexion.php";

class Bitacora extends Conexion{
    //Atributos

    private $id;
    private $id_admin;
    private $movimiento;
    private $fecha;
    private $modulo;
    private $descripcion;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    public function setBitacoraData($id_admin, $movimiento, $fecha, $modulo, $descripcion) {
        $this->id_admin = $id_admin;
        $this->movimiento = $movimiento;
        $this->fecha = $fecha;
        $this->modulo = $modulo;
        $this->descripcion = $descripcion;
    }


    // Métodos set y get
    public function setIdBitacora($id) {
        $this->id = $id;
    }

    public function getIdBitacora() {
        return $this->id;
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
                // Si no existe, procede a insertar un nuevo registro
                $query = "INSERT INTO bitacora (id_admin, movimiento, fecha, modulo, descripcion) 
                          VALUES (:id_admin, :movimiento, :fecha, :modulo, :descripcion)";
                // Prepara la consulta de inserción
                $stmt = $this->conn->prepare($query);
                // Vincula los parámetros con los valores
                $stmt->bindParam(":id_admin", $this->id_admin);
                $stmt->bindParam(":movimiento", $this->movimiento);
                $stmt->bindParam(":fecha", $this->fecha);
                $stmt->bindParam(":modulo", $this->modulo);
                $stmt->bindParam(":descripcion", $this->descripcion);
                // Ejecuta la consulta y retorna true si tiene éxito, false en caso contrario
                return $stmt->execute();
        } catch(PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
   }    
}

    // Método para obtener la bitacora de la base de datos
    public function Mostrar_Bitacora() {
        // Consulta SQL para seleccionar todos los registros de la tabla bitacora
        $query = "SELECT b.fecha, b.movimiento, b.modulo, b.descripcion, a.usuario as administrador FROM bitacora b INNER JOIN admin a ON a.ID=b.id_admin ORDER BY b.fecha DESC;";  
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}   
?>