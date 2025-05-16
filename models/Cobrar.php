<?php

require_once "Conexion.php";

class Cobrar extends Conexion{

    private $id_cuenta;
    private $tlf;
    private $id_cliente;
    private $fech_emision;
    private $monto;
    private $id_modalidad_pago;
    private $rif_banco;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    private function setCuentaData($cuenta) {
    if (is_string($cuenta)) {
        $cuenta = json_decode($cuenta, true);
    }

    // Expresiones regulares y validaciones
    $exp_id = "/^\d+$/";
    $exp_tlf = "/^\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/";
    $exp_fecha = "/^\d{4}-\d{2}-\d{2}$/"; // Formato YYYY-MM-DD
    $exp_monto = "/^\d+(\.\d{1,2})?$/";
    $exp_rif = "/^[A-Z0-9\-]{5,20}$/i"; // Ejemplo para RIF, ajusta según formato exacto

    // Validar id_cuenta
    if (!isset($cuenta['id_cuenta']) || !preg_match($exp_id, $cuenta['id_cuenta'])) {
        return ['status' => false, 'msj' => 'ID de cuenta inválido'];
    }
    $this->id_cuenta = (int)$cuenta['id_cuenta'];


    // Validar fecha de emisión
    $fecha = trim($cuenta['fech_emision'] ?? '');
    if (!preg_match($exp_fecha, $fecha)) {
        return ['status' => false, 'msj' => 'Fecha de emisión inválida'];
    }
    $this->fech_emision = $fecha;

    // Validar id_modalidad_pago (id_pago)
    if (!isset($cuenta['id_pago']) || !preg_match($exp_id, $cuenta['id_pago'])) {
        return ['status' => false, 'msj' => 'ID de modalidad de pago inválido'];
    }
    $this->id_modalidad_pago = (int)$cuenta['id_pago'];

    // Validar monto
    $monto = trim($cuenta['monto'] ?? '');
    if (!preg_match($exp_monto, $monto) || $monto <= 0) {
        return ['status' => false, 'msj' => 'Monto inválido'];
    }
    $this->monto = (float)$monto;

    return ['status' => true, 'msj' => 'Datos de cuenta validados correctamente'];
}

    private function setValideId($cuenta) {
    if (is_string($cuenta)) {
        $cuenta = json_decode($cuenta, true);
    }

    // Expresiones regulares y validaciones
    $exp_id = "/^\d+$/";
        // Validar id_cuenta
    if (!isset($cuenta['id_cuenta']) || !preg_match($exp_id, $cuenta['id_cuenta'])) {
        return ['status' => false, 'msj' => 'ID de cuenta inválido'];
    }
    $this->id_cuenta = (int)$cuenta['id_cuenta'];
    return ['status' => true, 'msj' => 'Datos de cuenta validados correctamente'];
    
}

    

       //Metodos

    //Indiferentemente sea la accion primero la funcion manejar accion llama a la 
    //funcion setcliente data que validad todos los valores
    //luego de que todo los datos sean validados correctamente
    //verifica que la variable validacion que contiene el status de la funcion sea correcta 
    //si es incorrecta retorna el status de mensajes de errores 
    //si es correcta me llama la funcion correspondiente 
    public function manejarAccion($accion, $cuenta) {
        switch ($accion) {

            case 'agregar':
                $validacion=$this->setCuentaData($cuenta);
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    return $this->Actualizar_Cuenta();
                }
                break;

            case 'obtener':

                    return $this->obtenerCuentasID($cuenta);
                
                break;

            case 'consultar':

                    return $this->obtenerCuentas();
                
            default:
                return ['status' => false, 'msj' => 'Accion invalida'];
        }
    }




    private function obtenerCuentas() {
        $this->closeConnection();
        try{
            $conn=$this->getConnection();
            $query = "SELECT 
                        c.id_cuentaCobrar, 
                        c.fecha_cuentaCobrar, 
                        c.monto_cuentaCobrar,
                        c.id_pago, 
                        s.nombre_cliente,
                        s.tlf,
                        s.tipo_id,
                        v.id_cliente,
                        m.nombre_modalidad,
                        GROUP_CONCAT(v.id_venta SEPARATOR '\n ') AS id_cuenta,
                        GROUP_CONCAT(v.fech_emision SEPARATOR '\n ') AS fechas_ventas,
                        GROUP_CONCAT(v.monto SEPARATOR ' $ Bs\n ') AS montos_ventas
                    FROM 
                        cuenta_por_cobrar c
                    LEFT JOIN 
                        venta v ON c.id_cuentaCobrar = v.id_venta
                        LEFT JOIN cliente s ON s.id_cliente = v.id_cliente
                        LEFT JOIN modalidad_de_pago m ON c.id_pago = m.id_modalidad_pago 
                    WHERE c.status = 1 
                    GROUP BY 
                        c.id_cuentaCobrar"; 
        
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) {
                // Retornar mensaje de error sin hacer echo
                return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
            } finally {
                $this->closeConnection();
            }
    }

    private function obtenerCuentasID($cuenta) {
        $this->closeConnection();
        try{
            $conn=$this->getConnection();
            $query = "SELECT 
                        c.id_cuentaCobrar, 
                        c.fecha_cuentaCobrar, 
                        c.monto_cuentaCobrar,
                        c.id_pago, 
                        s.nombre_cliente,
                        s.tlf,
                        s.tipo_id,
                        v.id_cliente
                    FROM 
                        cuenta_por_cobrar c
                    LEFT JOIN 
                        venta v ON c.id_cuentaCobrar = v.id_venta
                        LEFT JOIN cliente s ON s.id_cliente = v.id_cliente
                    WHERE id_cuentaCobrar=:id_cuenta
                    GROUP BY 
                        c.id_cuentaCobrar"; 
        
            // Prepara la consulta
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cuenta', $cuenta, PDO::PARAM_INT);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) {
                // Retornar mensaje de error sin hacer echo
                return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
            } finally {
                $this->closeConnection();
            }
    }

private function Actualizar_Cuenta()
{
    $this->closeConnection();
    try {
        $conn=$this->getConnection();
        // Iniciar la transacción
        $conn->beginTransaction();

        // Paso 1: Obtener el monto actual
        $querySelect = "SELECT monto_cuentaCobrar FROM cuenta_por_cobrar WHERE id_cuentaCobrar = :id_cuenta";
        $stmtSelect = $conn->prepare($querySelect);
        $stmtSelect->bindParam(":id_cuenta", $this->id_cuenta);
        $stmtSelect->execute();

        if ($stmtSelect->rowCount() > 0) {
            $currentMonto = (float)$stmtSelect->fetchColumn();
            $montoArestar = (float)$this->monto;

            // Validar que el nuevo monto no sea negativo
            if ($currentMonto - $montoArestar < 0) {
                return ['status' => false, 'msj' => 'El monto a restar es mayor que el monto actual.'];
            }

            $nuevoMonto = $currentMonto - $montoArestar;

            // Actualizar la tabla con el nuevo monto
            $queryUpdate = "UPDATE cuenta_por_cobrar 
                            SET monto_cuentaCobrar = :monto, 
                                fecha_cuentaCobrar = :fech_emision, 
                                id_pago = :id_modalidad_pago 
                            WHERE id_cuentaCobrar = :id_cuenta";
            $stmtUpdate = $conn->prepare($queryUpdate);

            $stmtUpdate->bindParam(":id_cuenta", $this->id_cuenta);
            $stmtUpdate->bindParam(":fech_emision", $this->fech_emision);
            $stmtUpdate->bindParam(":id_modalidad_pago", $this->id_modalidad_pago);
            $stmtUpdate->bindParam(":monto", $nuevoMonto);

            if ($stmtUpdate->execute()) {
                // Confirmar la transacción
                $conn->commit();
                return ['status' => true, 'msj' => 'Cuenta actualizada correctamente'];
            } else {
                // Deshacer la transacción en caso de error
                $conn->rollBack();
                return ['status' => false, 'msj' => 'Error al actualizar el registro.'];
            }
        } else {
            return ['status' => false, 'msj' => 'No se encontró la cuenta con ID: ' . $this->id_cuenta];
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
    }
    finally {
        $this->closeConnection();
    }
}

}
?>