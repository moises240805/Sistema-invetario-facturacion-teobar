<?php

require_once 'config/Config.php';
// Define la clase Conexion
class Conexion {
    protected $conn; // Propiedad para almacenar la conexión PDO

    // Constructor de la clase
    public function __construct() {
        $this->getConnection(); // Llama al método getConnection al crear una instancia de la clase
    }

    // Método para obtener la conexión a la base de datos
    protected function getConnection() {
        $this->conn = null; // Inicializa la propiedad conn en null
        try {
            // Crea una nueva conexión PDO
            $this->conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
        return $this->conn;
    }
}
?>