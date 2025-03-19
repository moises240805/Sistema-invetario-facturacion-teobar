<?php

require_once "Conexion.php";

class Proveedor extends Conexion{
    //Atributos
    private $id_proveedor;
    private $nombre_proveedor;
    private $direccion_proveedor;
    private $tlf_proveedor;
    private $id_representante_legal;
    private $nombre_representante_legal;
    private $tlf_representante_legal;
    private $tipo;
    private $tipo2;

    //constuctor
    public function __construct()
    {
        parent::__construct();
    }

    private function setProveedorData($proveedor) {
        if (is_string($proveedor)) {
            $proveedor = json_decode($proveedor, true);
        }


        $this->id_proveedor = $proveedor['id_proveedor'] ?? null;
        $this->nombre_proveedor = $proveedor['nombre_proveedor'];
        $this->direccion_proveedor = $proveedor['direccion_proveedor'];
        $this->tlf_proveedor = $proveedor['telefono_proveedor'];
        $this->id_representante_legal = $proveedor['id_representante_legal'] ?? null;
        $this->nombre_representante_legal = $proveedor['nombre_representante_legal'];
        $this->tlf_representante_legal = $proveedor['telefono_representante_legal'] ?? null;
        $this->tipo = $proveedor['tipo'] ?? null;
        $this->tipo2 = $proveedor['tipo2'] ?? null;
    }
    

        // Getters
        public function getIdProveedor() {
            return $this->id_proveedor;
        }
    
        public function getNombreProveedor() {
            return $this->nombre_proveedor;
        }
    
        public function getDireccionProveedor() {
            return $this->direccion_proveedor;
        }
    
        public function getTlfProveedor() {
            return $this->tlf_proveedor;
        }
    
        public function getIdRepresentanteLegal() {
            return $this->id_representante_legal;
        }
    
        public function getNombreRepresentanteLegal() {
            return $this->nombre_representante_legal;
        }
    
        public function getTlfRepresentanteLegal() {
            return $this->tlf_representante_legal;
        }
    
        public function getTipo() {
            return $this->tipo;
        }
    
        public function getTipo2() {
            return $this->tipo2;
        }
    
        // Setters
        public function setIdProveedor($id_proveedor) {
            $this->id_proveedor = $id_proveedor;
        }
    
        public function setNombreProveedor($nombre_proveedor) {
            $this->nombre_proveedor = $nombre_proveedor;
        }
    
        public function setDireccionProveedor($direccion_proveedor) {
            $this->direccion_proveedor = $direccion_proveedor;
        }
    
        public function setTlfProveedor($tlf_proveedor) {
            $this->tlf_proveedor = $tlf_proveedor;
        }
    
        public function setIdRepresentanteLegal($id_representante_legal) {
            $this->id_representante_legal = $id_representante_legal;
        }
    
        public function setNombreRepresentanteLegal($nombre_representante_legal) {
            $this->nombre_representante_legal = $nombre_representante_legal;
        }
    
        public function setTlfRepresentanteLegal($tlf_representante_legal) {
            $this->tlf_representante_legal = $tlf_representante_legal;
        }
    
        public function setTipo($tipo) {
            $this->tipo = $tipo;
        }
    
        public function setTipo2($tipo2) {
            $this->tipo2 = $tipo2;
        }

    //Metodos
    public function manejarAccion($accion, $proveedor) {
        switch ($accion) {
            case 'agregar':
                $this->setProveedorData($proveedor);
                return $this->Guardar_Proveedor();
            case 'actualizar':
                $this->setProveedorData($proveedor);
                return $this->Actualizar_Proveedor();
            case 'obtener':
                return $this->Obtener_Proveedor($proveedor);
            case 'eliminar':
                return $this->Eliminar_Proveedor($proveedor);
            default:
                throw new Exception("Acción no válida");
        }
    }

    private function Guardar_Proveedor()
    {
        try {
            // Consulta SQL para verificar si el proveedor ya existe
            $query = "SELECT * FROM proveedor WHERE id_proveedor = :id_proveedor";
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            // Vincula los parámetros con los valores
            $stmt->bindParam(":id_proveedor", $this->id_proveedor);
            // Ejecuta la consulta
            $stmt->execute();
            // Verifica si el proveedor ya existe
            if ($stmt->rowCount() == 0) {
                // Si no existe, procede a insertar un nuevo registro
                $query = "INSERT INTO proveedor (id_proveedor, nombre_proveedor, direccion, 
                          tlf, id_representante, nombre_representante, tlf_representante, tipo_id, tipo_id2) 
                          VALUES (:id_proveedor, :nombre_proveedor, :direccion_proveedor, 
                          :tlf_proveedor, :id_representante_legal, :nombre_representante_legal, 
                          :tlf_representante_legal, :tipo, :tipo2)";
                // Prepara la consulta de inserción
                $stmt = $this->conn->prepare($query);
                // Vincula los parámetros con los valores
                $stmt->bindParam(":id_proveedor", $this->id_proveedor);
                $stmt->bindParam(":tipo", $this->tipo);
                $stmt->bindParam(":tipo2", $this->tipo2);
                $stmt->bindParam(":nombre_proveedor", $this->nombre_proveedor);
                $stmt->bindParam(":direccion_proveedor", $this->direccion_proveedor);
                $stmt->bindParam(":tlf_proveedor", $this->tlf_proveedor);
                $stmt->bindParam(":id_representante_legal", $this->id_representante_legal);
                $stmt->bindParam(":nombre_representante_legal", $this->nombre_representante_legal);
                $stmt->bindParam(":tlf_representante_legal", $this->tlf_representante_legal);
                // Ejecuta la consulta y retorna true si tiene éxito, false en caso contrario
                return $stmt->execute();
            } else {
                // Si el proveedor ya existe, retorna false
                return false;
            }
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }

    // Método para obtener todas las personas de la base de datos
    public function Mostrar_Proveedor() {
        // Consulta SQL para seleccionar todos los registros de la tabla personas
        $query = "SELECT * FROM proveedor";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function Obtener_Proveedor($id_proveedor) {
        $query = "SELECT * FROM proveedor WHERE id_proveedor = :id_proveedor";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_proveedor", $id_proveedor, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function Actualizar_Proveedor() {
        try {
            $query = "UPDATE proveedor
                    SET nombre_proveedor = :nombre,
                        direccion = :direccion,
                        tlf = :tlf,
                        id_representante = :id_representante,
                        nombre_representante = :nombre_representante,
                        tlf_representante = :tlf_representante,
                        tipo_id = :tipo,
                        tipo_id2 = :tipo2
                    WHERE id_proveedor = :id_proveedor";
            $stmt = $this->conn->prepare($query);
    
            // Enlazar valores con tipos de datos adecuados
            $stmt->bindParam(":id_proveedor", $this->id_proveedor, PDO::PARAM_INT);
            $stmt->bindParam(":tipo", $this->tipo, PDO::PARAM_STR);
            $stmt->bindParam(":tipo2", $this->tipo2, PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $this->nombre_proveedor, PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $this->direccion_proveedor, PDO::PARAM_STR);
            $stmt->bindParam(":tlf", $this->tlf_proveedor, PDO::PARAM_INT);
            $stmt->bindParam(":id_representante", $this->id_representante_legal, PDO::PARAM_INT);
            $stmt->bindParam(":nombre_representante", $this->nombre_representante_legal, PDO::PARAM_STR);
            $stmt->bindParam(":tlf_representante", $this->tlf_representante_legal, PDO::PARAM_STR);
            // Ejecutar la consulta
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }
    

    private function Eliminar_Proveedor($id_proveedor) {
        $query = "DELETE FROM proveedor WHERE id_proveedor = :id_proveedor";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_proveedor", $id_proveedor, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}
?>