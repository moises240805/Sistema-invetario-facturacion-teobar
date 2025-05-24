<?php

require_once "Conexion.php";

class Manejo extends Conexion{
    //Atributos

    private $id;
    private $id_cajas;
    private $movimiento;
    private $fecha;
    private $fechav;
    private $monto;
    private $id_pago;
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
        $exp_movimiento = "/^(ingreso|egreso)$/i";
        $exp_fecha = "/^\d{4}-\d{2}-\d{2}( \d{2}:\d{2}(:\d{2})?)?$/"; // Formato YYYY-MM-DD o YYYY-MM-DD HH:MM[:SS]
        $exp_monto = "/^\d+(\.\d{1,2})?$/";
        $exp_descripcion = "/^[\w\s\.,#\-]{0,100}$/u";
    
        // Validar id_cajas
        if (!isset($ingreso_data['id_cajas']) || !preg_match($exp_id, $ingreso_data['id_cajas'])) {
            return ['status' => false, 'msj' => 'ID de caja inválido'];
        }
        $this->id_cajas = (int)$ingreso_data['id_cajas'];
    
        // Validar id_pago
        if (!isset($ingreso_data['id_pago']) || !preg_match($exp_id, $ingreso_data['id_pago'])) {
            return ['status' => false, 'msj' => 'ID de pago inválido'];
        }
        $this->id_pago = (int)$ingreso_data['id_pago'];
    
        // Validar movimiento (solo 'ingreso' o 'egreso')
        $movimiento = strtolower(trim($ingreso_data['movimiento'] ?? ''));
        if (!preg_match($exp_movimiento, $movimiento)) {
            return ['status' => false, 'msj' => 'Movimiento inválido (debe ser ingreso o egreso)'];
        }
        $this->movimiento = $movimiento;
    
        // Validar fecha (YYYY-MM-DD o YYYY-MM-DD HH:MM[:SS])
        $fecha = trim($ingreso_data['fecha'] ?? '');
        if (!preg_match($exp_fecha, $fecha)) {
            return ['status' => false, 'msj' => 'Fecha inválida'];
        }
        $this->fecha = $fecha;
    
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
    
        return ['status' => true, 'msj' => 'Datos de ingreso/egreso validados correctamente'];
    }
    


    private function setValideId($ingreso_data){

            // Validar id_cliente y tipo_id como numéricos
        if (!is_numeric($ingreso_data) ) {
            return ['status' => false, 'msj' => 'ID invalida'];
        }
        $this->id = (int)$ingreso_data;
        return ['status' => true, 'msj' => 'ID validado correctamente'];
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
                    return $this->Guardar_Movimiento();
                }
                break;
            case 'obtener':
                $validacion=$this->setValideId($ingreso_data);
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    return $this->Obtener_Movimiento($ingreso_data);
                }
                break;

            case 'consultar':

                    return $this->Mostrar_Movimiento();
                
            default:
                return ['status' => false, 'msj' => 'Accion invalida'];
        }
    }





    private function Guardar_Movimiento()
    {
        $this->closeConnection();
        try{
            $conn=$this->getConnection();
    
            // Insertar el movimiento en la tabla movimientos_caja
            $query = "INSERT INTO movimientos_caja (id_cajas, tipo_movimiento, monto_movimiento, concepto, fecha, id_pago)
                      VALUES (:id_cajas, :movimiento, :monto, :descripcion, :fecha, :id_pago)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_cajas", $this->id_cajas);
            $stmt->bindParam(":movimiento", $this->movimiento);
            $stmt->bindParam(":monto", $this->monto);
            $stmt->bindParam(":descripcion", $this->descripcion);
            $stmt->bindParam(":fecha", $this->fecha);
            $stmt->bindParam(":id_pago", $this->id_pago);
            if (!$stmt->execute()) {
                $this->conn->rollBack();
                return false;
            }
    
            // Obtener todos los movimientos de la caja para el id_pago actual
            $query2 = "SELECT tipo_movimiento, monto_movimiento FROM movimientos_caja WHERE id_pago = :id_pago";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(":id_pago", $this->id_pago, PDO::PARAM_INT);
            $stmt2->execute();
            $movimientos = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
            // Calcular el saldo total
            $saldo = 0;
            foreach ($movimientos as $mov) {
                if (strtolower($mov['tipo_movimiento']) == 'ingreso') {
                    $saldo += $mov['monto_movimiento'];
                } else if (strtolower($mov['tipo_movimiento']) == 'egreso') {
                    $saldo -= $mov['monto_movimiento'];
                }
            }
    
            // Actualizar el saldo en la tabla cajas
            $query3 = "UPDATE cajas SET saldo_caja = :saldo WHERE ID = :id_cajas";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(":saldo", $saldo);
            $stmt3->bindParam(":id_cajas", $this->id_cajas);
            if (!$stmt3->execute()) {
                $this->conn->rollBack();
                return false;
            }
    
            // Confirmar transacción
            $this->conn->commit();
            return true;
    
        } catch(PDOException $e) {
            // Rollback en caso de error
            $this->conn->rollBack();
            error_log("Error en Guardar_IngresoEgreso: " . $e->getMessage());
            return false;
        }finally {
            $this->closeConnection();
        }
    }
    
    


    private function Mostrar_Movimiento() {
        $this->closeConnection();
        try{
            $conn=$this->getConnection();
            // Consulta SQL para seleccionar todos los registros de la tabla bitacora
            $query = "SELECT m.*,p.nombre_modalidad,c.nombre_caja FROM movimientos_caja m
            LEFT JOIN cajas c ON m.id_cajas=c.ID
            LEFT JOIN modalidad_de_pago p ON m.id_pago=p.id_modalidad_pago";
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }



        private function Obtener_Movimiento($id) {
        $this->closeConnection();
        try{
            $conn=$this->getConnection();
            // Consulta SQL para seleccionar todos los registros de la tabla bitacora
            $query = "SELECT m.*,p.nombre_modalidad,c.nombre_caja FROM movimientos_caja m
            LEFT JOIN cajas c ON m.id_cajas=c.ID
            LEFT JOIN modalidad_de_pago p ON m.id_pago=p.id_modalidad_pago WHERE m.ID= :id";
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

}   
?>