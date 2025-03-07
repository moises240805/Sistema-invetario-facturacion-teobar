<?php

require_once "Conexion.php";

class Cliente extends Conexion{
    //Atributos

    private $id_cliente;
    private $nombre_cliente;
    private $tlf_cliente;
    private $direccion_cliente;
    private $email_cliente;
    private $tipo;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    public function setClienteData($cliente) {
        if (is_string($cliente)) {
            $cliente = json_decode($cliente, true);
        }
    
        $this->id_cliente = $cliente['id_cliente'] ?? null;
        $this->tipo = $cliente['tipo_id'] ?? null;
        $this->nombre_cliente = $cliente['nombre_cliente'] ?? null;
        $this->tlf_cliente = $cliente['telefono'];
        $this->direccion_cliente = $cliente['direccion'];
        $this->email_cliente = $cliente['email'];
    }

    // Métodos set y get
    public function setIdCliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    public function getIdCliente() {
        return $this->id_cliente;
    }

    public function setNombreCliente($nombre_cliente) {
        $this->nombre_cliente = $nombre_cliente;
    }

    public function getNombreCliente() {
        return $this->nombre_cliente;
    }

    public function setTlfCliente($tlf_cliente) {
        $this->tlf_cliente = $tlf_cliente;
    }

    public function getTlfCliente() {
        return $this->tlf_cliente;
    }

    public function setDireccionCliente($direccion_cliente) {
        $this->direccion_cliente = $direccion_cliente;
    }

    public function getDireccionCliente() {
        return $this->direccion_cliente;
    }

    public function setEmailCliente($email_cliente) {
        $this->email_cliente = $email_cliente;
    }

    public function getEmailCliente() {
        return $this->email_cliente;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getTipo() {
        return $this->tipo;
    }

    //Metodos
    public function Guardar_Cliente()
    {
        try {
            // Consulta SQL para verificar si el cliente ya existe
            $query = "SELECT * FROM cliente WHERE id_cliente = :id_cliente";
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            // Vincula los parámetros con los valores
            $stmt->bindParam(":id_cliente", $this->id_cliente);
            // Ejecuta la consulta
            $stmt->execute();
    
            // Verifica si el cliente ya existe
            if($stmt->rowCount() == 0) {
                // Si no existe, procede a insertar un nuevo registro
                $query = "INSERT INTO cliente (id_cliente, nombre_cliente, tlf, direccion, email, tipo_id) 
                          VALUES (:id_cliente, :nombre_cliente, :tlf_cliente, :direccion_cliente, :email_cliente, :tipo)";
                // Prepara la consulta de inserción
                $stmt = $this->conn->prepare($query);
                // Vincula los parámetros con los valores
                $stmt->bindParam(":id_cliente", $this->id_cliente);
                $stmt->bindParam(":tipo", $this->tipo);
                $stmt->bindParam(":nombre_cliente", $this->nombre_cliente);
                $stmt->bindParam(":tlf_cliente", $this->tlf_cliente);
                $stmt->bindParam(":direccion_cliente", $this->direccion_cliente);
                $stmt->bindParam(":email_cliente", $this->email_cliente);
                // Ejecuta la consulta y retorna true si tiene éxito, false en caso contrario
                return $stmt->execute();
            } else {
                // Si el cliente ya existe, retorna false
                return false;
            }
        } catch(PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
   }    
}

    // Método para obtener todas las personas de la base de datos
    public function Mostrar_Cliente() {
        // Consulta SQL para seleccionar todos los registros de la tabla personas
        $query = "SELECT * FROM cliente";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Obtener_Cliente($id_cliente) {
        $query = "SELECT * FROM cliente WHERE id_cliente = :id_cliente";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function Actualizar_Cliente() {
        try {
            $query = "UPDATE cliente SET nombre_cliente = :nombre, tlf = :tlf, direccion = :direccion, email = :email_cliente, tipo_id = :tipo WHERE id_cliente = :id_cliente";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_cliente", $this->id_cliente, PDO::PARAM_INT);
            $stmt->bindParam(":tipo", $this->tipo_id, PDO::PARAM_STR); // Corregido aquí
            $stmt->bindParam(":nombre", $this->nombre_cliente, PDO::PARAM_STR);
            $stmt->bindParam(":tlf", $this->tlf_cliente, PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $this->direccion_cliente, PDO::PARAM_STR);
            $stmt->bindParam(":email_cliente", $this->email_cliente, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }
    

    public function Eliminar_Cliente($id_cliente) {
        $query = "DELETE FROM cliente WHERE id_cliente = :id_cliente";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}
?>