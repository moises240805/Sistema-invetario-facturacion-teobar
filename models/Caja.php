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
            break;
            case 'movimiento':
                return $this->Mostrar_Movimiento_Caja();
            break;
            case 'open':
                return $this->Open_Caja($caja);
            break;
            case 'close':
                return $this->Close_Caja();
            break;
            case 'status':
                return $this->Status_Caja();
            break;
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
        $this->closeConnection();
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

    private function Mostrar_Movimiento_Caja() {
        $this->closeConnection();
        try{
            $conn=$this->getConnection();
            // Consulta SQL para seleccionar todos los registros de la tabla bitacora
            $query = "SELECT a.*,c.nombre_caja FROM aperturacierrecaja a 
                    LEFT JOIN cajas c ON a.id_cajas=c.ID ";
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            error_log("Error : " . $e->getMessage()); // Mejor que echo
            return false;
        }    
        $this->closeConnection();
    }

    private function Open_Caja($caja) {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            $conn->beginTransaction();
    
            if($caja==1){


               // 1. Actualizar cajas cerradas a abiertas
            $updateQuery = "UPDATE cajas SET status=1 WHERE status=0";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->execute();
    
            // Verificar si se actualizaron filas
            $rowCount = $updateStmt->rowCount();
            if ($rowCount === 0) {
                $conn->rollBack();
                return ['status' => false, 'msj' => 'No hay cajas cerradas para abrir'];
            }
    
            // 2. Obtener TODAS las cajas 
            $selectQuery = "SELECT * FROM cajas";
            $selectStmt = $conn->prepare($selectQuery);
            $selectStmt->execute();
            $cajas = $selectStmt->fetchAll(PDO::FETCH_ASSOC); 
    
            if (count($cajas) < 2) { // Verificar que haya al menos 2 cajas
                $conn->rollBack();
                return ['status' => false, 'msj' => 'Se necesitan al menos 2 cajas abiertas'];
            }
    
            // 3. Acceder correctamente a los datos del array
            $saldo1 = 0.00; // Primer elemento del array
            $saldo2 = 0.00; // Segundo elemento del array
            $id_cajas1 = $cajas[0]['ID']; 
            $id_cajas2 = $cajas[1]['ID'];
            $movimiento = "Apertura";
            $fecha = date('Y-m-d H:i:s');
    
            $insertQuery = "INSERT INTO AperturaCierreCaja 
                            (id_cajas, tipo_movimiento, monto, Fecha_hora) 
                            VALUES  
                            (:id_cajas1, :movimiento, :saldo1, :fecha),
                            (:id_cajas2, :movimiento, :saldo2, :fecha)";
    
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bindParam(":id_cajas1", $id_cajas1);
            $insertStmt->bindParam(":id_cajas2", $id_cajas2);
            $insertStmt->bindParam(":movimiento", $movimiento);
            $insertStmt->bindParam(":saldo1", $saldo1);
            $insertStmt->bindParam(":saldo2", $saldo2);
            $insertStmt->bindParam(":fecha", $fecha);
            $insertStmt->execute();

            $conn->commit();
            return ['status' => true, 'msj' => 'Cajas abiertas en $0.00 y registros creados correctamente'];

            }
            // 1. Actualizar cajas cerradas a abiertas
            $updateQuery = "UPDATE cajas SET status=1 WHERE status=0";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->execute();
    
            // Verificar si se actualizaron filas
            $rowCount = $updateStmt->rowCount();
            if ($rowCount === 0) {
                $conn->rollBack();
                return ['status' => false, 'msj' => 'No hay cajas cerradas para abrir'];
            }
    
            // 2. Obtener TODAS las cajas 
            $selectQuery = "SELECT * FROM cajas";
            $selectStmt = $conn->prepare($selectQuery);
            $selectStmt->execute();
            $cajas = $selectStmt->fetchAll(PDO::FETCH_ASSOC); 
    
            if (count($cajas) < 2) { // Verificar que haya al menos 2 cajas
                $conn->rollBack();
                return ['status' => false, 'msj' => 'Se necesitan al menos 2 cajas abiertas'];
            }
    
            // 3. Acceder correctamente a los datos del array
            $saldo1 = $cajas[0]['saldo_caja']; // Primer elemento del array
            $saldo2 = $cajas[1]['saldo_caja']; // Segundo elemento del array
            $id_cajas1 = $cajas[0]['ID']; 
            $id_cajas2 = $cajas[1]['ID'];
            $movimiento = "Apertura";
            $fecha = date('Y-m-d H:i:s');
    
            $insertQuery = "INSERT INTO AperturaCierreCaja 
                            (id_cajas, tipo_movimiento, monto, Fecha_hora) 
                            VALUES  
                            (:id_cajas1, :movimiento, :saldo1, :fecha),
                            (:id_cajas2, :movimiento, :saldo2, :fecha)";
    
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bindParam(":id_cajas1", $id_cajas1);
            $insertStmt->bindParam(":id_cajas2", $id_cajas2);
            $insertStmt->bindParam(":movimiento", $movimiento);
            $insertStmt->bindParam(":saldo1", $saldo1);
            $insertStmt->bindParam(":saldo2", $saldo2);
            $insertStmt->bindParam(":fecha", $fecha);
            $insertStmt->execute();
    
            $conn->commit();
            return ['status' => true, 'msj' => 'Cajas abiertas y registros creados correctamente'];
    
        } catch (PDOException $e) {
            if ($conn && $conn->inTransaction()) {
                $conn->rollBack();
            }
            error_log("Error en Open_Caja: " . $e->getMessage());
            return ['status' => false, 'msj' => 'Error al abrir la caja: ' . $e->getMessage()];
        } finally {
            if ($conn) {
                $this->closeConnection();
            }
        }
    }
    


    private function Close_Caja() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            $conn->beginTransaction();
            // 1. Update cajas to "open" where closed
            $updateQuery = "UPDATE cajas SET status=0 WHERE status=1 ";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->execute();
    
            // Check if any rows were updated
            $rowCount = $updateStmt->rowCount();
            if ($rowCount === 0) {
                $conn->rollBack();
                return ['status' => false, 'msj' => 'No hay cajas abiertas para cerrar'];
            }
    
            // 2. Get saldo_caja from the first updated caja
            $selectQuery = "SELECT * FROM cajas ";
            $selectStmt = $conn->prepare($selectQuery);
            $selectStmt->execute();
            $cajaData = $selectStmt->fetchAll(PDO::FETCH_ASSOC);
    
            if (!$cajaData) {
                return ['status' => false, 'msj' => 'Error al obtener saldo de caja'];
            }
    
            $saldo1 = $cajaData[0]['saldo_caja'];
            $saldo2 = $cajaData[1]['saldo_caja'];
            $movimiento = "Cierre";
            $fecha = date('Y-m-d H:i:s');
            $id_cajas1 = $cajaData[0]['ID']; 
            $id_cajas2 = $cajaData[1]['ID'];
    
            // 3. Insert into AperturaCierreCaja (adjust IDs as needed)
            $insertQuery = "INSERT INTO AperturaCierreCaja 
                            (id_cajas, tipo_movimiento, monto, Fecha_hora) 
                            VALUES  
                            (:id_cajas1, :movimiento, :saldo1, :fecha),
                            (:id_cajas2, :movimiento, :saldo2, :fecha)";
    
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bindParam(":id_cajas1", $id_cajas1); // Define these properly
            $insertStmt->bindParam(":id_cajas2", $id_cajas2);
            $insertStmt->bindParam(":movimiento", $movimiento);
            $insertStmt->bindParam(":saldo1", $saldo1);
            $insertStmt->bindParam(":saldo2", $saldo2);
            $insertStmt->bindParam(":fecha", $fecha);
            $insertStmt->execute();
            
            $conn->commit();
            return ['status' => true, 'msj' => 'Caja cerrada y registro creado'];
    
        } catch (PDOException $e) {
            if ($conn && $conn->inTransaction()) {
                $conn->rollBack(); // Revertir cambios si hay error
            }
            error_log("Error en Open_Caja: " . $e->getMessage());
            return ['status' => false, 'msj' => 'Error al cerrar la caja'];
        } finally {
            if ($conn) {
                $this->closeConnection();
            }
        }
    }
    

    private function Status_Caja() {
        try {
            $conn = $this->getConnection(); 
    
            $query = "SELECT status FROM cajas WHERE status = 1";
            $stmt = $conn->prepare($query);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result && $result['status'] > 0) {
                return ['status' => true, 'msj' => 'Caja abierta'];
            } else {
                return ['status' => false, 'msj' => 'Caja cerrada'];
            }
        } catch (PDOException $e) {
            error_log("Error en Status_Caja: " . $e->getMessage());
            return ['status' => false, 'msj' => 'Error al consultar el estado de la caja'];
        } finally {
            $this->closeConnection();
        }
    }
    
}   
?>