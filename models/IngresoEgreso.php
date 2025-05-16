<?php

require_once "Conexion.php";

class IngresoEgreso extends Conexion{
    //Atributos

    private $id;
    private $nombre;
    private $id_movimiento;
    private $monto;
    private $descripcion;

    // Constructor
    public function __construct() {
        parent::__construct();
    }


    private function setIngresoEgresoData($ingreso_data) {
    if (is_string($ingreso_data)) {
        $ingreso_data = json_decode($ingreso_data, true);
    }

    // Expresiones regulares y validaciones
    $exp_id = "/^\d+$/";
    $exp_nombre = "/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]+\.?(( |\-)[a-zA-ZÀ-ÖØ-öø-ÿ\s]+\.?)*$/u"; // Similar a setClienteData
    $exp_monto = "/^\d+(\.\d{1,2})?$/";
    $exp_descripcion = "/^[\w\s\.,#\-]{0,100}$/u";

    // Validar id
    if (!isset($ingreso_data['id']) || !preg_match($exp_id, $ingreso_data['id'])) {
        return ['status' => false, 'msj' => 'ID inválido'];
    }
    $this->id = (int)$ingreso_data['id'];

    // Validar id_movimiento
    if (!isset($ingreso_data['id_movimiento']) || !preg_match($exp_id, $ingreso_data['id_movimiento'])) {
        return ['status' => false, 'msj' => 'ID de movimiento inválido'];
    }
    $this->id_movimiento = (int)$ingreso_data['id_movimiento'];

    // Validar nombre (máximo 50 caracteres para mayor flexibilidad)
    $nombre = trim($ingreso_data['nombre'] ?? '');
    if (!preg_match($exp_nombre, $nombre) || mb_strlen($nombre) > 50) {
        return ['status' => false, 'msj' => 'Nombre inválido'];
    }
    $this->nombre = $nombre;

    // Validar monto (positivo, hasta 2 decimales)
    $monto = trim($ingreso_data['monto'] ?? '');
    if (!preg_match($exp_monto, $monto) || $monto <= 0) {
        return ['status' => false, 'msj' => 'Monto inválido'];
    }
    $this->monto = (float)$monto;

    // Validar descripción (opcional, máximo 100 caracteres)
    $descripcion = trim($ingreso_data['descripcion'] ?? '');
    if ($descripcion !== '' && !preg_match($exp_descripcion, $descripcion)) {
        return ['status' => false, 'msj' => 'Descripción inválida'];
    }
    $this->descripcion = $descripcion;

    return ['status' => true, 'msj' => 'Datos validados correctamente'];
}




         //Metodos

    //Indiferentemente sea la accion primero la funcion manejar accion llama a la 
    //funcion setcliente data que validad todos los valores
    //luego de que todo los datos sean validados correctamente
    //verifica que la variable validacion que contiene el status de la funcion sea correcta 
    //si es incorrecta retorna el status de mensajes de errores 
    //si es correcta me llama la funcion correspondiente 
    public function manejarAccion($accion, $ingreso_data) {
        switch ($accion) {

            case 'agregar':
                $validacion=$this->setIngresoEgresoData($ingreso_data);
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    return $this->Guardar_IngresoEgreso();
                }
                break;

            case 'consultar':

                    return $this->Mostrar_IngresoEgreso();
                
            default:
                return ['status' => false, 'msj' => 'Accion invalida'];
        }
    }

    private function Mostrar_IngresoEgreso() {
        $this->closeConnection();
        try{
            $conn=$this->getConnection();
            // Consulta SQL para seleccionar todos los registros de la tabla bitacora
            $query = "SELECT * FROM ingresos
                    UNION ALL
                    SELECT * FROM egresos";
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

}   
?>