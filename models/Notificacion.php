<?php

require_once "Conexion.php";

class Notificacion extends Conexion {
    //atributos
    public $id_notificacion;
    public $fecha;
    public $id_admin;
    public $mensaje;
    public $enlace;
    public $id_estatus;
    
    public function __construct() {
        parent::__construct();
    }

    //Metodos set y get
    public function setNotificacionData($notificacion) {    
        if (is_string($notificacion)) {
            $notificacion = json_decode($notificacion, true);
        }
        $this->id_notificacion = $notificacion['id_notificacion'];
        $this->mensaje = $notificacion['mensaje'];
        $this->enlace = $notificacion['enlace'];
        $this->fecha = $notificacion['fecha'];
        $this->id_admin = $notificacion['id_admin'];
        $this->estatus = $notificacion['estatus'];
    }

    public function setId($id) {
        $this->id_notificacion = $id;
    }

    public function getId() {
        return $this->id_notificacion;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setEnlace($enlace) {
        $this->enlace = $enlace;
    }

    public function getEnlace() {
        return $this->enlace;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setIdAdmin($id_admin) {
        $this->id_admin = $id_admin;
    }

    public function getIdAdmin() {
        return $this->id_admin;
    }
    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }
    public function getEstatus() {
        return $this->estatus;
    }

    public function obtenerNotificacion($id) {
        $sql = "SELECT * FROM notificacion WHERE id_notifiacion = :id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mostrarNotificacion() {
        $sql = "SELECT * FROM notificacion";
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($mensaje, $id_admin, $estatus)
    {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            $query = "INSERT INTO notificacion (titulo, id_admin, status) VALUES ( :mensaje, :id_admin, :estatus)";
            $stmt = $this->conn->prepare($query);
            //$stmt->bindParam(":enlace", $enlace);
            $stmt->bindParam(":mensaje", $mensaje);
            $stmt->bindParam(":id_admin", $id_admin);
            $stmt->bindParam(":estatus", $estatus);
            
            // Ejecutar y retornar resultado
            return $stmt->execute();
            
        } catch(PDOException $e) {
            error_log("Error en notificacion: " . $e->getMessage()); // Mejor que echo
            return false;
        }    
    }

    public function delete($id) {
        $sql = "DELETE FROM notificacion WHERE id = :id";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':id', $id);  
        $query->execute();
        return $query->fetch();
    }

    private function Eliminar_notificacion($id_notificacion) {
        $query = "DELETE FROM notificacion WHERE id_notificacion = :id_notificacion";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_notificacion", $id_notificacion, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}
?>