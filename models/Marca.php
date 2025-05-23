<?php

require_once "Conexion.php";

class Marca extends Conexion{
    //Atributos
    private $id_marca;
    private $marca;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    private function setMarcaData($marcas) {
        if (is_string($marcas)) {
            $marcas = json_decode($marcas, true);
            if ($marcas === null) {
                return ['status' => false, 'msj' => 'JSON inválido'];
            }
        }
    
        // Validar que los campos obligatorios existan y no estén vacíos
        if (empty($marcas['id_marca'])) {
            return ['status' => false, 'msj' => 'El ID es obligatorio'];
        }
    
        if (empty($marcas['marca'])) {
            return ['status' => false, 'msj' => 'El campo marca es obligatorio'];
        }
    
        // Validar longitud máxima (por ejemplo, 50 caracteres)
        if (mb_strlen($marcas['marca']) > 70) {
            return ['status' => false, 'msj' => 'El campo no puede tener más de 70 caracteres'];
        }
    
        // Validar id_presentacion (opcional, debe ser entero si existe)
        if (isset($marcas['id_marca']) && !is_numeric($marcas['id_marca'])) {
            return ['status' => false, 'msj' => 'id debe ser un número válido'];
        }
    
        // Asignar valores a los atributos
        $this->id_marca = isset($marcas['id_marca']) ? (int)$marcas['id_marca'] : null;
        $this->marca = trim($marcas['marca']);
    
        return ['status' => true, 'msj' => 'Datos validados correctamente'];
    }
    

    private function setValideId($id_marca){

        // Validar id_cliente y tipo_id como numéricos
    if (!is_numeric($id_marca) ) {
        return ['status' => false, 'msj' => 'ID invalida'];
    }
    $this->id_marca = (int)$id_marca;
    return ['status' => true, 'msj' => 'ID validado correctamente'];
}

    private function setValide($marcas){
        if (is_string($marcas)) {
            $marcas = json_decode($marcas, true);
            if ($marcas === null) {
                return ['status' => false, 'msj' => 'JSON inválido'];
            }
        }

        // Validar id_cliente y tipo_id como numéricos
    if (empty($marcas['marca'])) {
            return ['status' => false, 'msj' => 'El campo marca es obligatorio'];
        }
    if (mb_strlen($marcas['marca']) > 70) {
            return ['status' => false, 'msj' => 'El campo no puede tener más de 70 caracteres'];
        }
    $this->marca = trim($marcas['marca']);
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
    public function manejarAccion($accion, $marcas) {
        switch ($accion) {
            case 'agregar':
                $validacion = $this->setValide($marcas);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Guardar_Marca();
    
            case 'actualizar':
                $validacion = $this->setMarcaData($marcas);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Actualizar_Marca();
    
            case 'obtener':
                $validacion = $this->setValideId($marcas);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Obtener_Marca($marcas);
    
            case 'eliminar':
                $validacion = $this->setValideId($marcas);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Eliminar_Marca($marcas);
    
            case 'consultar':
                return $this->Mostrar_Marca();
    
            default:
                return ['status' => false, 'msj' => 'Acción inválida'];
        }
    }
    

    private function Guardar_Marca() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "INSERT INTO marca (nombre_marca, status) 
                      VALUES (:marca, 1)";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(":marca", $this->marca, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Marca guardada correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al guardar la marca'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function Obtener_Marca($id_marca) {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "SELECT * FROM marca WHERE ID = :id_marca";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id_marca", $id_marca, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                return ['status' => false, 'msj' => 'Error al obtener la marca'];
            }

            return $stmt->fetch(PDO::FETCH_ASSOC);
            //return ['status' => true, 'data' => $data];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function Mostrar_Marca() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "SELECT * FROM marca WHERE status = 1";
            $stmt = $conn->prepare($query);

            if (!$stmt->execute()) {
                return ['status' => false, 'msj' => 'Error al obtener marcas'];
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            //return ['status' => true, 'data' => $data];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function Actualizar_Marca() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "UPDATE marca SET nombre_marca = :marca WHERE ID = :id_marca";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(":id_marca", $this->id_marca);
            $stmt->bindParam(":marca", $this->marca);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Marca actualizada correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar la marca'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function Eliminar_Marca($id_marca) {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "UPDATE marca SET status = 0 WHERE ID = :id_marca";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id_marca", $id_marca, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Marca eliminada correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar la marca'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}
?>