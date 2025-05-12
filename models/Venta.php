<?php

require_once "Conexion.php";

class Venta extends Conexion{
    //Atributos
    private $id_venta;
    private $id_producto;
    private $tipo_compra;
    private $tlf;
    private $id_cliente;
    private $cantidad;
    private $fech_emision;
    private $fech_vencimiento;
    private $id_modalidad_pago;
    private $monto;
    private $tipo_entrega;
    private $rif_banco;
    private $id_medida;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    private function setVentaData($venta) {
        if (is_string($venta)) {
            $venta = json_decode($venta, true);
        }
    
        // Expresiones regulares para validar campos específicos
        $exp_id = "/^\d+$/"; // solo números para ids
        $exp_tipo_compra = "/^(5|6)$/i"; // ejemplo: tipos permitidos
        $exp_tlf = "/^\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/";
        $exp_tipo_entrega = "/^(Directa|Delivery)$/i"; // ejemplo: tipos permitidos
        $exp_rif_banco = "/^[A-Z0-9\-]+$/i"; // ejemplo: caracteres permitidos para rif banco
    
        // Validar id_venta (único)
        if (!isset($venta['id_venta']) || !preg_match($exp_id, $venta['id_venta'])) {
            return ['status' => false, 'msj' => 'ID de venta inválido'];
        }
        $this->id_venta = (int)$venta['id_venta'];

        // Validar productos (arrays)
        if (
            !isset($venta['productos']['id_producto']) || 
            !is_array($venta['productos']['id_producto']) || 
            empty($venta['productos']['id_producto'])
        ) {
            return ['status' => false, 'msj' => 'Productos no especificados'];
        }
        if (
            !isset($venta['productos']['id_medida']) || 
            !is_array($venta['productos']['id_medida']) || 
            empty($venta['productos']['id_medida'])
        ) {
            return ['status' => false, 'msj' => 'Medidas no especificadas'];
        }
        if (
            !isset($venta['cantidad']) || 
            !is_array($venta['cantidad']) || 
            empty($venta['cantidad'])
        ) {
            return ['status' => false, 'msj' => 'Cantidades no especificadas'];
        }

        // Validar cada id_producto
        foreach ($venta['productos']['id_producto'] as $id_producto) {
            if (!preg_match($exp_id, $id_producto)) {
                return ['status' => false, 'msj' => 'ID de producto inválido'];
            }
        }
        $this->id_producto = $venta['productos']['id_producto'];

        // Validar cada id_medida
        foreach ($venta['productos']['id_medida'] as $id_medida) {
            if (!preg_match($exp_id, $id_medida)) {
                return ['status' => false, 'msj' => 'ID de medida inválido'];
            }
        }
        $this->id_medida = $venta['productos']['id_medida'];

        // Validar cada cantidad
        foreach ($venta['cantidad'] as $cantidad) {
            if (!is_numeric($cantidad) || $cantidad <= 0) {
                return ['status' => false, 'msj' => 'Cantidad inválida'];
            }
        }
        $this->cantidad = $venta['cantidad'];
    
        // Validar tipo_compra
        $tipo_compra = trim($venta['tipo_compra'] ?? '');
        if (!preg_match($exp_tipo_compra, $tipo_compra)) {
            return ['status' => false, 'msj' => 'Tipo de compra inválido'];
        }
        $this->tipo_compra = strtolower($tipo_compra);
    
        // Validar teléfono
        $tlf = trim($venta['tlf'] ?? '');
        if($tlf!=""){
            if (!preg_match($exp_tlf, $tlf)) {
                return ['status' => false, 'msj' => 'Teléfono inválido'];
            }
        }
        $this->tlf = $tlf;
    
        // Validar id_cliente
        if (!isset($venta['id_cliente']) || !preg_match($exp_id, $venta['id_cliente'])) {
            return ['status' => false, 'msj' => 'ID de cliente inválido'];
        }
        $this->id_cliente = (int)$venta['id_cliente'];
    
        // Validar fecha de emisión (formato YYYY-MM-DD)
        $fech_emision = trim($venta['fech_emision'] ?? '');
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fech_emision) || !strtotime($fech_emision)) {
            return ['status' => false, 'msj' => 'Fecha de emisión inválida'];
        }
        $this->fech_emision = $fech_emision;

        // Validar fecha de emisión (formato YYYY-MM-DD)
        $fech_vencimiento = trim($venta['fech_vencimiento'] ?? '');
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fech_vencimiento) || !strtotime($fech_vencimiento)) {
            return ['status' => false, 'msj' => 'Fecha de vencimiento inválida'];
        }
        $this->fech_vencimiento = $fech_vencimiento;
    
        // Validar id_modalidad_pago
        if($venta['id_modalidad_pago']!=""){
            if (!isset($venta['id_modalidad_pago']) || !preg_match($exp_id, $venta['id_modalidad_pago'])) {
                return ['status' => false, 'msj' => 'ID de modalidad de pago inválido'];
            }
        }
        $this->id_modalidad_pago = (int)$venta['id_modalidad_pago'];
    
        // Validar monto (numérico y mayor que 0)
        if (!isset($venta['monto']) || !is_numeric($venta['monto']) || $venta['monto'] <= 0) {
            return ['status' => false, 'msj' => 'Monto inválido'];
        }
        $this->monto = (float)$venta['monto'];
    
        // Validar tipo_entrega
        $tipo_entrega = trim($venta['tipo_entrega'] ?? '');
        if($tipo_entrega!=""){
            if (!preg_match($exp_tipo_entrega, $tipo_entrega)) {
                return ['status' => false, 'msj' => 'Tipo de entrega inválido'];
            }
        }
        $this->tipo_entrega = ucwords(mb_strtolower($tipo_entrega));
    
        // Validar rif_banco (puede ser opcional, validar si existe)
        $rif_banco = trim($venta['rif_banco'] ?? '');
        if ($rif_banco !== '' && !preg_match($exp_rif_banco, $rif_banco)) {
            return ['status' => false, 'msj' => 'RIF banco inválido'];
        }
        $this->rif_banco = $rif_banco !== '' ? strtoupper($rif_banco) : null;
    
        return ['status' => true, 'msj' => 'Datos de venta validados correctamente'];
    }

    private function setValideId($venta) {
        if (is_string($venta)) {
            $venta = json_decode($venta, true);
        }
    
        // Expresiones regulares para validar campos específicos
        $exp_id = "/^\d+$/"; // solo números para ids
    
        // Validar id_venta
        if (!isset($venta['id_venta']) || !preg_match($exp_id, $venta['id_venta'])) {
            return ['status' => false, 'msj' => 'ID de venta inválido'];
        }
        $this->id_venta = (int)$venta['id_venta'];
        return ['status' => true, 'msj' => 'Datos de venta validados correctamente'];
    }
    
    

    // Getters
    public function getIdVenta() {
        return $this->id_venta;
    }

    public function getIdProducto() {
        return $this->id_producto;
    }

    public function getTipoCompra() {
        return $this->tipo_compra;
    }

    public function getTlf() {
        return $this->tlf;
    }

    public function getIdCliente() {
        return $this->id_cliente;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getFechEmision() {
        return $this->fech_emision;
    }

    public function getFechVencimiento() {
        return $this->fech_vencimiento;
    }

    public function getIdModalidadPago() {
        return $this->id_modalidad_pago;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function getTipoEntrega() {
        return $this->tipo_entrega;
    }

    public function getRifBanco() {
        return $this->rif_banco;
    }

    public function getIdMedida() {
        return $this->id_medida;
    }

    // Setters
    public function setIdVenta($id_venta) {
        $this->id_venta = $id_venta;
    }

    public function setIdProducto($id_producto) {
        $this->id_producto = $id_producto;
    }

    public function setTipoCompra($tipo_compra) {
        $this->tipo_compra = $tipo_compra;
    }

    public function setTlf($tlf) {
        $this->tlf = $tlf;
    }

    public function setIdCliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setFechEmision($fech_emision) {
        $this->fech_emision = $fech_emision;
    }

    public function setFechVencimiento($fech_vencimiento) {
        $this->fech_vencimiento = $fech_vencimiento;
        
    }

    public function setIdModalidadPago($id_modalidad_pago) {
        $this->id_modalidad_pago = $id_modalidad_pago;
    }

    public function setMonto($monto) {
        $this->monto = $monto;
    }

    public function setTipoEntrega($tipo_entrega) {
        $this->tipo_entrega =  $tipo_entrega; 
    }

    public function setRifBanco($rif_banco) { 
        $this->$rif_banco= $rif_banco;  
    }

    public function setIdMedida($id_medida) { 
        $this->$id_medida= $id_medida;  
    }

    //Metodos



    //Indiferentemente sea la accion primero la funcion manejar accion llama a la 
    //funcion setcliente data que validad todos los valores
    //luego de que todo los datos sean validados correctamente
    //verifica que la variable validacion que contiene el status de la funcion sea correcta 
    //si es incorrecta retorna el status de mensajes de errores 
    //si es correcta me llama la funcion correspondiente 
    public function manejarAccion($accion, $venta) {
        switch ($accion) {

            case 'agregar':
                $validacion=$this->setVentaData($venta);
                // print_r($validacion);
                // die();
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    // echo "Guardar";
                    return $this->Guardar_Venta();
                }
                break;

            case 'actualizar':


            case 'obtenerBancos':
                return $this->obtenerBancos();
                break;
                
            case 'obtenerPagos':
                return $this->obtenerPagos();
                break;
            
            case 'obtenerNumeroVenta':
                return $this->obtenerNumeroVenta();
                break;

            case 'eliminar':
                $validacion=$this->setValideId($venta);
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    return $this->Eliminar_Venta($venta);
                }

            case 'consultar':

                    return $this->Mostrar_Venta();
                
            default:
                return ['status' => false, 'msj' => 'Accion invalida'];
        }
    }



    private function Guardar_Venta() 
    { 
        try { 
            $this->conn->beginTransaction(); 
            
            // Recorrer los arrays de productos y medidas
            for ($i = 0; $i < count($this->id_producto); $i++) {
                $producto_id = $this->id_producto[$i];
                $medida_id = $this->id_medida[$i];
                $cantidad = $this->cantidad[$i]; // Suponiendo que cantidad también es un array
    
                // Verificar la cantidad disponible del producto 
                $stmt = $this->conn->prepare("SELECT cantidad FROM cantidad_producto WHERE id_producto = :id_producto AND id_unidad_medida = :id_medida"); 
                $stmt->bindParam(':id_producto', $producto_id); 
                $stmt->bindParam(':id_medida', $medida_id); 
                $stmt->execute(); 
                
                $producto = $stmt->fetch(PDO::FETCH_ASSOC); 
                
                // Verificar si se encontró el producto
                if (!$producto) {
                    // No se encontró el producto, hacer rollback y retornar error
                    $this->conn->rollBack();
                    return ['status' => false, 'msj' => "Producto no encontrado: ID $producto_id"];
                }
        
                // Comprobar si hay suficiente cantidad
                if ($producto['cantidad'] < $cantidad) { 
                    $this->conn->rollBack();
                    return ['status' => false, 'msj' => "Cantidad insuficiente para el producto ID $producto_id"];
                } 
                
                // Registrar la venta 
                $stmt2 = $this->conn->prepare("INSERT INTO venta (id_venta, id_producto, id_cliente, cantidad, fech_emision, fech_vencimiento, id_modalidad_pago, monto, tipo_entrega, rif_banco, venta, tlf) VALUES (:id_venta, :id_producto, :id_cliente, :cantidad, :fech_emision, :fech_vencimiento, :id_modalidad_pago, :monto, :tipo_entrega, :rif_banco, :tipo_compra, :tlf)"); 
                $stmt2->bindParam(':id_venta', $this->id_venta); 
                $stmt2->bindParam(':tipo_compra', $this->tipo_compra); 
                $stmt2->bindParam(':tlf', $this->tlf); 
                $stmt2->bindParam(':id_producto', $producto_id); 
                $stmt2->bindParam(':id_cliente', $this->id_cliente); 
                $stmt2->bindParam(':cantidad', $cantidad); 
                $stmt2->bindParam(':fech_emision', $this->fech_emision);
                $stmt2->bindParam(':fech_vencimiento', $this->fech_vencimiento);
                $stmt2->bindParam(':id_modalidad_pago', $this->id_modalidad_pago); 
                $stmt2->bindParam(':monto', $this->monto); // Asegúrate de que el monto sea correcto para cada producto
                $stmt2->bindParam(':tipo_entrega', $this->tipo_entrega); 
                $stmt2->bindParam(':rif_banco', $this->rif_banco); 
                $stmt2->execute();

                
                $stmt3 = $this->conn->prepare("INSERT INTO detalle_producto (id_detalle_producto, id_venta, id_producto, cantidad_producto, id_medida_especifica, precio) VALUES (:id_detalleproducto, :id_venta, :id_producto, :cantidad, :id_medida, :monto)"); 
                $stmt3->bindParam(':id_venta', $this->id_venta); 
                $stmt3->bindParam(':id_producto', $producto_id); 
                $stmt3->bindParam(':id_medida', $medida_id); 
                $stmt3->bindParam(':cantidad', $cantidad); 
                $stmt3->bindParam(':id_detalleproducto', $this->id_venta); 
                $stmt3->bindParam(':monto', $this->monto); // Asegúrate que monto sea correcto para cada producto 
                $stmt3->execute(); 
        
                // Descontar la cantidad del producto 
                $nueva_cantidad = $producto['cantidad'] - $cantidad; 
                $stmt4 = $this->conn->prepare("UPDATE cantidad_producto SET cantidad = :nueva_cantidad WHERE id_producto = :id_producto AND id_unidad_medida = :id_medida"); 
                $stmt4->bindParam(':nueva_cantidad', $nueva_cantidad); 
                $stmt4->bindParam(':id_producto', $producto_id); 
                $stmt4->bindParam(':id_medida', $medida_id); 
                $stmt4->execute(); 
            }
    
            // Si tipo_compra es igual a 5 (según tu lógica)
            $n = 5;
            $m = $this->tipo_compra;
            if ($m == $n) {
                $stmt5 = $this->conn->prepare("INSERT INTO cuenta_por_cobrar (id_cuentaCobrar, id_venta, fecha_cuentaCobrar, monto_cuentaCobrar) VALUES (:id_cuentaCobrar, :id_venta, :fecha_cuentaCobrar, :monto_cuentaCobrar)"); 
                $stmt5->bindParam(':id_venta', $this->id_venta); 
                $stmt5->bindParam(':id_cuentaCobrar', $this->id_venta);
                $stmt5->bindParam(':fecha_cuentaCobrar', $this->fech_emision); 
                $stmt5->bindParam(':monto_cuentaCobrar', $this->monto); // Asegúrate que monto sea correcto
                $stmt5->execute();  
            }
    
            $id_actualizacion = 1;
            $stmt6 = $this->conn->prepare("UPDATE producto SET id_motivoActualizacion = :id_actualizacion WHERE id_producto = :id_producto");
            $stmt6->bindParam(':id_actualizacion', $id_actualizacion); 
            $stmt6->bindParam(':id_producto', $producto_id); 
            $stmt6->execute(); 
    
            // Confirmar la transacción solo si todas las operaciones fueron exitosas
            if ($this->conn->inTransaction()) {
                $this->conn->commit(); 
            }
            
            return ['status' => true, 'msj' => 'Venta registrada correctamente']; 
    
        } catch (Exception $e) { 
            // Revertir la transacción en caso de error 
            if ($this->conn->inTransaction()) { 
                $this->conn->rollBack(); 
            } 
            return ['status' => false, 'msj' => 'Error al registrar la venta: ' . $e->getMessage()]; 
        } 
    }
    
    

    // Método para obtener todas las venta de la base de datos
    private function Mostrar_Venta() {
        // Consulta SQL para seleccionar todos los registros de la tabla venta
        $query = "SELECT 
                    v.id_venta, 
                    v.fech_emision, 
                    c.nombre_cliente AS nombre_cliente,
                    c.id_cliente,
                    v.tipo_entrega,
                    b.nombre_banco,
                    p.nombre AS nombre,
                    m.nombre_modalidad,
                    v.monto,
                    v.tlf,
                    GROUP_CONCAT(p.nombre SEPARATOR '\n ') AS nombre,
                    GROUP_CONCAT(v.cantidad SEPARATOR '\n ') AS cantidad
                  FROM 
                    venta v 
                  LEFT JOIN 
                    producto p ON p.id_producto = v.id_producto
                  LEFT JOIN 
                    cliente c ON c.id_cliente = v.id_cliente
                  LEFT JOIN 
                    bancos b ON b.rif_banco = v.rif_banco
                  LEFT JOIN 
                    modalidad_de_pago m ON m.id_modalidad_pago = v.id_modalidad_pago
                  GROUP BY 
                    v.id_venta"; 
    
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function Obtener_Venta($id_venta) {
        $query = "SELECT * FROM venta WHERE id_venta = :id_venta";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_venta", $id_venta, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function Actualizar_Venta() {
        try {
            // Iniciar la transacción
            $this->conn->beginTransaction();
            // Paso 1: Obtener el monto actual
            $querySelect = "SELECT monto_cuentaCobrar FROM cuenta_por_cobrar WHERE id_cuentaCobrar = :id_venta";
            $stmtSelect = $this->conn->prepare($querySelect);
            $stmtSelect->bindParam(":id_venta", $this->id_venta);
            $stmtSelect->execute();
    
            if ($stmtSelect->rowCount() > 0) {
                $currentMonto = (float)$stmtSelect->fetchColumn();
                $montoArestar = (float)$this->monto;
    
                // Validar que el nuevo monto no sea negativo
                if ($currentMonto - $montoArestar < 0) {
                    echo "El monto a restar es mayor que el monto actual.";
                    return false;
                }
    
                $nuevoMonto = $currentMonto - $montoArestar;
    
                // Paso 4: Actualizar la tabla con el nuevo monto
                $queryUpdate = "UPDATE cuenta_por_cobrar SET monto_cuentaCobrar = :monto, fecha_cuentaCobrar = :fech_emision WHERE id_cuentaCobrar = :id_venta";
                $stmtUpdate = $this->conn->prepare($queryUpdate);
    
                // Vincula los parámetros
                $stmtUpdate->bindParam(":id_venta", $this->id_venta);
                $stmtUpdate->bindParam(":fech_emision", $this->fech_emision);
                $stmtUpdate->bindParam(":monto", $nuevoMonto);
    
                if ($stmtUpdate->execute()) {
                    // Confirmar la transacción
                    $this->conn->commit();
                    return true;
                } else {
                    // Deshacer la transacción en caso de error
                    $this->conn->rollBack();
                    echo "Error al actualizar el registro.";
                    return false;
                }
            } else {
                echo "No se encontró la venta con ID: " . $this->id_venta;
                return false;
            }
        } catch (PDOException $e) {
            // Deshacer la transacción en caso de excepción
            $this->conn->rollBack();
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }
    
     function Eliminar_Venta($id_venta) {
        $query = "DELETE FROM venta WHERE id_venta = :id_venta";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_venta", $this->id_venta, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }

    public function obtenerCuentas() {
        $query = "SELECT 
                    c.id_cuentaCobrar, 
                    c.fecha_cuentaCobrar, 
                    c.monto_cuentaCobrar, 
                    s.nombre_cliente,
                    v.id_cliente,
                    GROUP_CONCAT(v.id_venta SEPARATOR '\n ') AS id_venta,
                    GROUP_CONCAT(v.fech_emision SEPARATOR '\n ') AS fechas_ventas,
                    GROUP_CONCAT(v.monto SEPARATOR ' $ Bs\n ') AS montos_ventas
                  FROM 
                    cuenta_por_cobrar c
                  LEFT JOIN 
                    venta v ON c.id_cuentaCobrar = v.id_venta
                    LEFT JOIN cliente s ON s.id_cliente = v.id_cliente
                  GROUP BY 
                    c.id_cuentaCobrar"; 
    
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function obtenerBancos() {
        $query = "SELECT * FROM bancos";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function obtenerPagos() {
        $query = "SELECT * FROM modalidad_de_pago";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function obtenerNumeroVenta() {
        $query = "SELECT MAX(id_venta) as id_venta FROM venta LIMIT 1";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*function Eliminar_Venta($id_venta) {
        $query = "UPDATE venta SET is_active = 0 WHERE id_venta = :id_venta";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_venta", $id_venta, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }*/
}
?>