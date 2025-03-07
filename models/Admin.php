<?php

require_once "Conexion.php";

class Admin extends Conexion {
    // Atributos
    private $username;
    private $pw;
    private $id;
    private $rol;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    public function setUserData($user) {
        $user = json_decode($user, true);
        $this->username = $user['username'];
        $this->pw = $user['pw'];
        $this->rol = $user['rol'];
        $this->id = $user['id'] ?? null;
    }

    // Métodos Getter y Setter
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->pw;
    }

    public function setPassword($pw) {
        $this->pw = $pw; // Considera agregar hashing aquí si es necesario
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    // Métodos
    public function Guardar_Usuario() {
        try {
            // Consulta para verificar si el nombre de usuario ya existe
            $query = "SELECT * FROM admin WHERE usuario=:username";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $this->username);
            $stmt->execute();
            
            // Verifica si el nombre de usuario ya está en uso
            if ($stmt->rowCount() == 0) {
                // Hash de la contraseña antes de almacenarla
                $hashedPassword = password_hash($this->pw, PASSWORD_DEFAULT);
                
                // Consulta SQL para insertar un nuevo registro en la tabla admin
                $query = "INSERT INTO admin (usuario, pw, rol) VALUES (:username, :pw, :rol)";
                // Prepara la consulta
                $stmt = $this->conn->prepare($query);
                // Vincula los parámetros con los valores
                $stmt->bindParam(":username", $this->username);
                $stmt->bindParam(":pw", $hashedPassword); // Usa el hash de la contraseña
                $stmt->bindParam(":rol", $this->rol);
                
                // Ejecuta la consulta y retorna true si tiene éxito, false en caso contrario
                return $stmt->execute();
            } else {
                return false; // Usuario ya existe
            }
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }

    // Método para obtener todas las personas de la base de datos
    public function Mostrar_Usuario() {
        // Consulta SQL para seleccionar todos los registros de la tabla admin
        $query = "SELECT * FROM admin";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Obtener_Usuario($id) {
        try {
            $query = "SELECT * FROM admin WHERE ID = :ID";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":ID", $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            return null; // No se encontró usuario
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return null;
        }
    }

    public function Actualizar_Usuario($user) {
        try {

            // Consulta SQL para actualizar los datos del usuario
            $query = "UPDATE admin SET usuario = :username, pw = :pw, rol = :rol WHERE ID = :id";
            
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            
            // Hash de la nueva contraseña si se está actualizando
            $hashedPassword = password_hash($this->pw, PASSWORD_DEFAULT);
            
            // Vincula los parámetros con los valores
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":pw", $hashedPassword); // Usa el hash de la nueva contraseña
            $stmt->bindParam(":rol", $this->rol);
            $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
            // Ejecuta la consulta y retorna true si tiene éxito, false en caso contrario
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }

   public function Eliminar_Usuario($id) { 
       try { 
           $query = "DELETE FROM admin WHERE ID = :ID"; 
           $stmt = $this->conn->prepare($query); 
           $stmt->bindParam(":ID", $id, PDO::PARAM_INT); 
           $stmt->execute(); 
           return true; 
       } catch (PDOException $e) { 
           echo "Error en la consulta: " . $e->getMessage(); 
           return false; 
       } 
   }

   public function Iniciar_Sesion($username) {
    // Asegúrate de que la sesión esté iniciada
    // Consulta SQL para seleccionar el registro del usuario
    $query = "SELECT * FROM admin WHERE usuario = :username";
    // Prepara la consulta
    $stmt = $this->conn->prepare($query);
    
    // Vincula el parámetro con el valor
    $stmt->bindParam(":username", $username);
    
    // Ejecuta la consulta
    $stmt->execute();

    // Verifica si se encontró el usuario
    if ($stmt->rowCount() === 1) {
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna los datos del usuario
    }
    
    return null; // Retorna null si no se encontró el usuario
}
}
?>