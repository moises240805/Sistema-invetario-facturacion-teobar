<?php

require_once "Conexion.php";

class Categoria extends Conexion{
    //Atributos
    private $id_categoria;
    private $categoria;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    private function setCategoriaData($categorias) {
        if (is_string($categorias)) {
            $categorias = json_decode($categorias, true);
            if ($categorias === null) {
                return ['status' => false, 'msj' => 'JSON inválido'];
            }
        }
    
        // Validar que los campos obligatorios existan y no estén vacíos
        if (empty($categorias['id_categoria'])) {
            return ['status' => false, 'msj' => 'El ID es obligatorio'];
        }
    
        if (empty($categorias['categoria'])) {
            return ['status' => false, 'msj' => 'El campo categoria es obligatorio'];
        }
    
        // Validar longitud máxima (por ejemplo, 50 caracteres)
        if (mb_strlen($categorias['categoria']) > 70) {
            return ['status' => false, 'msj' => 'El campo no puede tener más de 70 caracteres'];
        }
    
        // Validar id_presentacion (opcional, debe ser entero si existe)
        if (isset($categorias['id_categoria']) && !is_numeric($categorias['id_categoria'])) {
            return ['status' => false, 'msj' => 'id debe ser un número válido'];
        }
    
        // Asignar valores a los atributos
        $this->id_categoria = isset($categorias['id_categoria']) ? (int)$categorias['id_categoria'] : null;
        $this->categoria = trim($categorias['categoria']);
    
        return ['status' => true, 'msj' => 'Datos validados correctamente'];
    }
    

    private function setValideId($id_categoria){

        // Validar id_cliente y tipo_id como numéricos
    if (!is_numeric($id_categoria) ) {
        return ['status' => false, 'msj' => 'ID invalida'];
    }
    $this->id_categoria = (int)$id_categoria;
    return ['status' => true, 'msj' => 'ID validado correctamente'];
}

    private function setValide($categorias){
        if (is_string($categorias)) {
            $categorias = json_decode($categorias, true);
            if ($categorias === null) {
                return ['status' => false, 'msj' => 'JSON inválido'];
            }
        }

        // Validar id_cliente y tipo_id como numéricos
    if (empty($categorias['categoria'])) {
            return ['status' => false, 'msj' => 'El campo categoria es obligatorio'];
        }
    if (mb_strlen($categorias['categoria']) > 70) {
            return ['status' => false, 'msj' => 'El campo no puede tener más de 70 caracteres'];
        }
    $this->categoria = trim($categorias['categoria']);
    return ['status' => true, 'msj' => 'Validado correctamente'];
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
    public function manejarAccion($accion, $categorias) {
        switch ($accion) {
            case 'agregar':
                $validacion = $this->setValide($categorias);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Guardar_Categoria();
    
            case 'actualizar':
                $validacion = $this->setCategoriaData($categorias);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Actualizar_Categoria();
    
            case 'obtener':
                $validacion = $this->setValideId($categorias);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Obtener_Categoria($categorias);
    
            case 'eliminar':
                $validacion = $this->setValideId($categorias);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Eliminar_Categoria($categorias);
    
            case 'consultar':
                return $this->Mostrar_Categoria();
    
            default:
                return ['status' => false, 'msj' => 'Acción inválida'];
        }
    }
    

    private function Guardar_Categoria() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "INSERT INTO categoria (nombre_categoria, status) 
                      VALUES (:categoria, 1)";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(":categoria", $this->categoria, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Categoria guardada correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al guardar la categoria'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function Obtener_Categoria($id_categoria) {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "SELECT * FROM categoria WHERE ID = :id_categoria";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                return ['status' => false, 'msj' => 'Error al obtener la categoria'];
            }

            return $stmt->fetch(PDO::FETCH_ASSOC);
            //return ['status' => true, 'data' => $data];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function Mostrar_Categoria() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "SELECT * FROM categoria WHERE status = 1";
            $stmt = $conn->prepare($query);

            if (!$stmt->execute()) {
                return ['status' => false, 'msj' => 'Error al obtener categorias'];
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            //return ['status' => true, 'data' => $data];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function Actualizar_Categoria() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "UPDATE categoria SET nombre_categoria = :categoria WHERE ID = :id_categoria";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(":id_categoria", $this->id_categoria);
            $stmt->bindParam(":categoria", $this->categoria);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Categoria actualizada correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar la categoria'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function Eliminar_Categoria($id_categoria) {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "UPDATE categoria SET status = 0 WHERE ID = :id_categoria";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Categoria eliminada correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar la categoria'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}
?>