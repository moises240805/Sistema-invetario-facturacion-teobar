<?php

require_once "Conexion.php";

class Tasa extends Conexion{
    //Atributos
    private $valor;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    private function setTasaData($tasa) {
        if (is_string($tasa)) {
            $tasa = json_decode($tasa, true);
            if ($tasa === null) {
                return ['status' => false, 'msj' => 'JSON inválido'];
            }
        }
    
        
    
        // Validar id_presentacion (opcional, debe ser entero si existe)
        if (isset($tasa['valor']) && !is_numeric($tasa['valor'])) {
            return ['status' => false, 'msj' => ' debe ser un número válido'];
        }
    
        // Asignar valores a los atributos
        $this->valor = trim($tasa['valor']);
    
        return ['status' => true, 'msj' => 'Datos validados correctamente'];
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
    public function manejarAccion($accion, $tasa) {
        switch ($accion) {
            case 'agregar':
                $validacion = $this->setTasaData($tasa);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Guardar_Tasa();
    
            case 'obtener':
                return $this->Obtener_Tasa();
    
            case 'consultar':
                return $this->Mostrar_Tasa();
    
            default:
                return ['status' => false, 'msj' => 'Acción inválida'];
        }
    }
    

private function Guardar_Tasa() {
    $this->closeConnection();
    try {
        $conn = $this->getConnection();

        $query = "INSERT INTO tasa_dia (valor, fecha_valor, tipo_cambio) 
                  VALUES (:valor, :fecha, :cambio)";
        $stmt = $conn->prepare($query);

        $fecha = date('Y-m-d H:i:s');
        $cambio = 'Oficial';

        $stmt->bindParam(":valor", $this->valor, PDO::PARAM_INT);
        $stmt->bindParam(":fecha", $fecha);
        $stmt->bindParam(":cambio", $cambio, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return ['status' => true, 'msj' => 'Tasa guardada correctamente'];
        } else {
            return ['status' => false, 'msj' => 'Error al guardar la tasa'];
        }
    } catch (PDOException $e) {
        return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
    } finally {
        $this->closeConnection();
    }
}


    private function Obtener_Tasa() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "SELECT valor FROM tasa_dia WHERE ID = (SELECT MAX(ID) FROM tasa_dia)";
            $stmt = $conn->prepare($query);

            if (!$stmt->execute()) {
                return ['status' => false, 'msj' => 'Error al obtener la tasa'];
            }

            return $stmt->fetch(PDO::FETCH_ASSOC);
            //return ['status' => true, 'data' => $data];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function Mostrar_Tasa() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();

            $query = "SELECT * FROM tasa_dia";
            $stmt = $conn->prepare($query);

            if (!$stmt->execute()) {
                return ['status' => false, 'msj' => 'Error al obtener tasas'];
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            //return ['status' => true, 'data' => $data];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    

}
?>