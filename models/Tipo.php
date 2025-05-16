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
            if ($tipo === null) {
                return ['status' => false, 'msj' => 'JSON inválido'];
            }
        }
    
        // Validar que los campos obligatorios existan y no estén vacíos
        if (empty($tipo['tipo_producto'])) {
            return ['status' => false, 'msj' => 'El campo tipo_producto es obligatorio'];
        }
    
        if (empty($tipo['presentacion'])) {
            return ['status' => false, 'msj' => 'El campo presentacion es obligatorio'];
        }
    
        // Validar longitud máxima (por ejemplo, 50 caracteres)
        if (mb_strlen($tipo['tipo_producto']) > 50) {
            return ['status' => false, 'msj' => 'El campo tipo_producto no puede tener más de 50 caracteres'];
        }
    
        if (mb_strlen($tipo['presentacion']) > 50) {
            return ['status' => false, 'msj' => 'El campo presentacion no puede tener más de 50 caracteres'];
        }
    
        // Validar id_presentacion (opcional, debe ser entero si existe)
        if (isset($tipo['id_presentacion']) && !is_numeric($tipo['id_presentacion'])) {
            return ['status' => false, 'msj' => 'id_presentacion debe ser un número válido'];
        }
    
        // Asignar valores a los atributos
        $this->id_presentacion = isset($tipo['id_presentacion']) ? (int)$tipo['id_presentacion'] : null;
        $this->tipo_producto = trim($tipo['tipo_producto']);
        $this->presentacion = trim($tipo['presentacion']);
    
        return ['status' => true, 'msj' => 'Datos validados correctamente'];
    }
    

    private function setValideId($tipo){

        // Validar id_cliente y tipo_id como numéricos
    if (!is_numeric($tipo) ) {
        return ['status' => false, 'msj' => 'ID invalida'];
    }
    $this->id_presentacion = (int)$tipo;
    return ['status' => true, 'msj' => 'ID validado correctamente'];
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


        //Indiferentemente sea la accion primero la funcion manejar accion llama a la 
    //funcion setcliente data que validad todos los valores
    //luego de que todo los datos sean validados correctamente
    //verifica que la variable validacion que contiene el status de la funcion sea correcta 
    //si es incorrecta retorna el status de mensajes de errores 
    //si es correcta me llama la funcion correspondiente 
    public function manejarAccion($accion, $tipo) {
        switch ($accion) {
            case 'agregar':
                $validacion = $this->setPresentacionData($tipo);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Guardar_Tipo();
    
            case 'actualizar':
                $validacion = $this->setPresentacionData($tipo);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Actualizar_Tipo();
    
            case 'obtener':
                $validacion = $this->setValideId($tipo);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Obtener_Tipo($tipo);
    
            case 'eliminar':
                $validacion = $this->setValideId($tipo);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Eliminar_Tipo($tipo);
    
            case 'consultar':
                return $this->Mostrar_Tipo();
    
            default:
                return ['status' => false, 'msj' => 'Acción inválida'];
        }
    }
    

    private function Guardar_Tipo() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "INSERT INTO presentacion (tipo_producto, presentacion, status) 
                      VALUES (:tipo_producto, :presentacion, 1)";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(":tipo_producto", $this->tipo_producto, PDO::PARAM_STR);
            $stmt->bindParam(":presentacion", $this->presentacion, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Tipo guardado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al guardar el tipo'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function Obtener_Tipo($id_presentacion) {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "SELECT * FROM presentacion WHERE id_presentacion = :id_presentacion;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id_presentacion", $id_presentacion, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                return ['status' => false, 'msj' => 'Error al obtener el tipo'];
            }

            return $stmt->fetch(PDO::FETCH_ASSOC);
            //return ['status' => true, 'data' => $data];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function Mostrar_Tipo() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "SELECT * FROM presentacion WHERE status = 1";
            $stmt = $conn->prepare($query);

            if (!$stmt->execute()) {
                return ['status' => false, 'msj' => 'Error al obtener tipos'];
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            //return ['status' => true, 'data' => $data];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function Actualizar_Tipo() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "UPDATE presentacion SET tipo_producto = :tipo_producto, presentacion = :presentacion WHERE id_presentacion = :id_presentacion;";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(":id_presentacion", $this->id_presentacion);
            $stmt->bindParam(":tipo_producto", $this->tipo_producto);
            $stmt->bindParam(":presentacion", $this->presentacion);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Tipo actualizado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar el tipo'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function Eliminar_Tipo($id_presentacion) {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "UPDATE presentacion SET status = 0 WHERE id_presentacion = :id_presentacion";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id_presentacion", $id_presentacion, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Tipo eliminado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar el tipo'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}
?>