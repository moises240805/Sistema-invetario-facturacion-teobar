<?php

require_once "Conexion.php";

class Caja extends Conexion{
    //Atributos

    private $id_cajas;
    private $nombre_caja;
    private $saldo_caja;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    private function setCajaData($data) {
    if (is_string($data)) {
        $data = json_decode($data, true);
    }

    // Expresiones regulares y validaciones
    $exp_id = "/^\d+$/";
    $exp_movimiento = "/^(ingreso|egreso)$/i";
    $exp_fecha = "/^\d{4}-\d{2}-\d{2}( \d{2}:\d{2}(:\d{2})?)?$/"; // YYYY-MM-DD o YYYY-MM-DD HH:MM[:SS]
    $exp_monto = "/^\d+(\.\d{1,2})?$/";
    $exp_descripcion = "/^[\w\s\.,#\-]{0,100}$/u";

    // Validar id_cajas
    if (!isset($data['id_cajas']) || !preg_match($exp_id, $data['id_cajas'])) {
        return ['status' => false, 'msj' => 'ID de caja inválido'];
    }
    $this->id_cajas = (int)$data['id_cajas'];

    // Validar id_pago
    if (!isset($data['id_pago']) || !preg_match($exp_id, $data['id_pago'])) {
        return ['status' => false, 'msj' => 'ID de pago inválido'];
    }
    $this->id_pago = (int)$data['id_pago'];

    // Validar movimiento (ingreso o egreso)
    $movimiento = strtolower(trim($data['movimiento'] ?? ''));
    if (!preg_match($exp_movimiento, $movimiento)) {
        return ['status' => false, 'msj' => 'Movimiento inválido (debe ser ingreso o egreso)'];
    }
    $this->movimiento = $movimiento;

    // Validar fecha
    $fecha = trim($data['fecha'] ?? '');
    if (!preg_match($exp_fecha, $fecha)) {
        return ['status' => false, 'msj' => 'Fecha inválida'];
    }
    $this->fecha = $fecha;

    // Validar monto
    $monto = trim($data['monto'] ?? '');
    if (!preg_match($exp_monto, $monto) || $monto <= 0) {
        return ['status' => false, 'msj' => 'Monto inválido'];
    }
    $this->monto = (float)$monto;

    // Validar descripción (opcional)
    $descripcion = trim($data['descripcion'] ?? '');
    if ($descripcion !== '' && !preg_match($exp_descripcion, $descripcion)) {
        return ['status' => false, 'msj' => 'Descripción inválida'];
    }
    $this->descripcion = $descripcion;

    return ['status' => true, 'msj' => 'Datos de caja validados correctamente'];
}


    // Métodos set y get
    public function setIdBitacora($id_cajas) {
        $this->id_cajas = $id_cajas;
    }

    public function getIdBitacora() {
        return $this->id_cajas;
    }

    public function setIdPago($id_paago) {
        $this->id_pago = $id_pago;
    }

    public function getIdPago() {
        return $this->id_pago;
    }


    public function setMovimiento($movimiento) {
        $this->movimiento = $movimiento;
    }

    public function getMovisetMovimiento() {
        return $this->movimiento;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setMonto($monto) {
        $this->monto = $monto;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }


     //Metodos

    //Indiferentemente sea la accion primero la funcion manejar accion llama a la 
    //funcion setcliente data que validad todos los valores
    //luego de que todo los datos sean validados correctamente
    //verifica que la variable validacion que contiene el status de la funcion sea correcta 
    //si es incorrecta retorna el status de mensajes de errores 
    //si es correcta me llama la funcion correspondiente 
    public function manejarAccion($accion, $caja) {
        switch ($accion) {

            case 'agregar':
                $validacion=$this->setIngresoEgresoData($caja);
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    return $this->Guardar_Caja();
                }
                break;

            case 'consultar':

                    return $this->Mostrar_Caja();
                
            default:
                return ['status' => false, 'msj' => 'Accion invalida'];
        }
    }

    public function Update_SaldoCaja()
    {
        $this->closeConnection();
        try {
            $conn=$this->getConnection();
            $query = "UPDATE cajas SET ID=id_cajas";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":monto", $this->monto);
            
            // Ejecutar y retornar resultado
            return $stmt->execute();
            
        } catch(PDOException $e) {
            error_log("Error en Ingreso Egreso: " . $e->getMessage()); // Mejor que echo
            return false;
        }    
        $this->closeConnection();
    }


    private function Mostrar_Caja() {
        
        try{
            $conn=$this->getConnection();
            // Consulta SQL para seleccionar todos los registros de la tabla bitacora
            $query = "SELECT * FROM cajas ";
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            error_log("Error en Ingreso Egreso: " . $e->getMessage()); // Mejor que echo
            return false;
        }    
        $this->closeConnection();
    }
}   
?>