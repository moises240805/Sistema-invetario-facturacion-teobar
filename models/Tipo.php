<?php

require_once "Conexion.php";

class Tipo extends Conexion{
    //Atributos
    private $id_presentacion;
    private $tipo_producto;
    private $presentacion;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    private function setPresentacionData($tipo) {
        if (is_string($tipo)) {
            $tipo = json_decode($tipo, true);
            
            
            // Validación adicional para tipo_producto y presentacion
            if (empty($tipo['tipo_producto']) || empty($tipo['presentacion'])) {
                throw new Exception("Todos los campos son requeridos");
            }
            
            $this->id_presentacion = $tipo['id_presentacion'] ?? null;
            $this->tipo_producto = $tipo['tipo_producto'];
            $this->presentacion = $tipo['presentacion'];
        } else {
            throw new Exception("Datos inválidos");
        }
    }

    // Getters
    public function getIdPresentacion() {
        return $this->id_presentacion;
    }

    public function getTipoProducto() {
        return $this->tipo_producto;
    }

    public function getPresentacion() {
        return $this->presentacion;
    }

    // Setters
    public function setIdPresentacion($id_presentacion) {
        $this->id_presentacion = $id_presentacion;
    }

    public function setTipoProducto($tipo_producto) {
        $this->tipo_producto = $tipo_producto;
    }

    public function setPresentacion($presentacion) {
        $this->presentacion = $presentacion;
    }

    //Metodos
    public function manejarAccion($accion, $tipo) {
        switch ($accion) {
            case 'agregar':
                $this->setPresentacionData($tipo);
                return $this->Guardar_Tipo($tipo);
            case 'actualizar':
                $this->setPresentacionData($tipo);
                return $this->Actualizar_Tipo();
            case 'obtener':
                return $this->Obtener_Tipo($tipo);
            case 'eliminar':
                return $this->Eliminar_Tipo($tipo);
            default:
                throw new Exception("Acción no válida");
        }
    }

    private function Guardar_Tipo()
    {
          // Consulta SQL para insertar un nuevo registro en la tabla producto 
    $query = "INSERT INTO presentacion (tipo_producto, presentacion) 
    VALUES ( :tipo_producto, :presentacion)"; 

    // Prepara la consulta 
    $stmt = $this->conn->prepare($query); 

    // Vincula los parámetros con los valores 

    $stmt->bindParam(":tipo_producto", $this->tipo_producto, PDO::PARAM_STR);  
    $stmt->bindParam(":presentacion", $this->presentacion, PDO::PARAM_STR);

    return $stmt->execute(); 

    }

    private function Obtener_Tipo($id_presentacion) {
        $query = "SELECT * FROM presentacion WHERE id_presentacion = :id_presentacion;";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_presentacion", $id_presentacion, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

     // Método para obtener todas las personas de la base de datos
     public function Mostrar_Tipo() { 
        // Consulta SQL para seleccionar todos los registros de la tabla producto
        $query = "SELECT * FROM presentacion"; 
    
        // Prepara la consulta 
        $stmt = $this->conn->prepare($query); 
        // Ejecuta la consulta 
        $stmt->execute(); 
        // Retorna los resultados como un arreglo asociativo 
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    private function Actualizar_Tipo() {
        try {
            $query = "UPDATE presentacion SET tipo_producto = :tipo_producto, presentacion = :presentacion WHERE id_presentacion = :id_presentacion;";
            $stmt = $this->conn->prepare($query);
            
            // Vincular parámetros
            $stmt->bindParam(":id_presentacion", $this->id_presentacion);
            $stmt->bindParam(":tipo_producto", $this->tipo_producto);
            $stmt->bindParam(":presentacion", $this->presentacion);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    private function Eliminar_Tipo($id_presentacion) {
        $query = "DELETE FROM presentacion WHERE id_presentacion = :id_presentacion";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_presentacion", $id_presentacion, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}
?>