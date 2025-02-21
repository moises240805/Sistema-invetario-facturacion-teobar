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
    private $id_modalidad_pago;
    private $monto;
    private $tipo_entrega;
    private $rif_banco;
    private $id_medida;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    public function setVentaData($id_venta, $id_producto, $tipo_compra, $tlf, 
    $id_cliente, $cantidad, $fech_emision, 
    $id_modalidad_pago, $monto, $tipo_entrega, 
    $rif_banco, $id_medida) {
$this->id_venta = $id_venta;
$this->id_producto = $id_producto;
$this->tipo_compra = $tipo_compra;
$this->tlf = $tlf;
$this->id_cliente = $id_cliente;
$this->cantidad = $cantidad;
$this->fech_emision = $fech_emision;
$this->id_modalidad_pago = $id_modalidad_pago;
$this->monto = $monto;
$this->tipo_entrega = $tipo_entrega;
$this->rif_banco = $rif_banco;
$this->id_medida = $id_medida;
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
    public function Guardar_Venta() 
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
                    echo "Producto no encontrado: ID " . $producto_id;
                    continue; // Saltar a la siguiente iteración si no se encuentra el producto
                }
        
                // Comprobar si hay suficiente cantidad
                if ($producto['cantidad'] < $cantidad) { 
                   return false; // Saltar a la siguiente iteración si no hay suficiente cantidad
                } 
        
                // Registrar la venta 
                $stmt = $this->conn->prepare("INSERT INTO venta (id_venta, id_producto, id_cliente, cantidad, fech_emision, id_modalidad_pago, monto, tipo_entrega, rif_banco, venta, tlf) VALUES (:id_venta, :id_producto, :id_cliente, :cantidad, :fech_emision, :id_modalidad_pago, :monto, :tipo_entrega, :rif_banco, :tipo_compra, :tlf)"); 
                $stmt->bindParam(':id_venta', $this->id_venta); 
                $stmt->bindParam(':tipo_compra', $this->tipo_compra); 
                $stmt->bindParam(':tlf', $this->tlf); 
                $stmt->bindParam(':id_producto', $producto_id); 
                $stmt->bindParam(':id_cliente', $this->id_cliente); 
                $stmt->bindParam(':cantidad', $cantidad); 
                $stmt->bindParam(':fech_emision', $this->fech_emision); 
                $stmt->bindParam(':id_modalidad_pago', $this->id_modalidad_pago); 
                $stmt->bindParam(':monto', $this->monto); // Asegúrate de que el monto sea correcto para cada producto
                $stmt->bindParam(':tipo_entrega', $this->tipo_entrega); 
                $stmt->bindParam(':rif_banco', $this->rif_banco); 
                $stmt->execute();

                $stmt = $this->conn->prepare("INSERT INTO detalle_producto (id_detalle_producto, id_venta, id_producto, cantidad_producto, id_medida_especifica, precio) VALUES (:id_detalleproducto, :id_venta, :id_producto, :cantidad, :id_medida, :monto)"); 
                $stmt->bindParam(':id_venta', $this->id_venta); 
                $stmt->bindParam(':id_producto', $producto_id); 
                $stmt->bindParam(':id_medida', $medida_id); 
                $stmt->bindParam(':cantidad', $cantidad); 
                $stmt->bindParam(':id_detalleproducto', $this->id_venta); 
                $stmt->bindParam(':monto', $this->monto); // Asegúrate de que el monto sea correcto para cada producto 
                $stmt->execute(); 
        
                // Descontar la cantidad del producto 
                $nueva_cantidad = $producto['cantidad'] - $cantidad; 
                $stmt = $this->conn->prepare("UPDATE cantidad_producto SET cantidad = :nueva_cantidad WHERE id_producto = :id_producto AND id_unidad_medida = :id_medida"); 
                $stmt->bindParam(':nueva_cantidad', $nueva_cantidad); 
                $stmt->bindParam(':id_producto', $producto_id); 
                $stmt->bindParam(':id_medida', $medida_id); 
                $stmt->execute(); 
            }

            $n=5;
            $m=$this->tipo_compra;
            if($m==$n)
            {
                $stmt = $this->conn->prepare("INSERT INTO cuenta_por_cobrar (id_cuentaCobrar, id_venta, fecha_cuentaCobrar, monto_cuentaCobrar) VALUES (:id_cuentaCobrar, :id_venta, :fecha_cuentaCobrar, :monto_cuentaCobrar)"); 
                $stmt->bindParam(':id_venta', $this->id_venta); 
                $stmt->bindParam(':id_cuentaCobrar', $this->id_venta);
                $stmt->bindParam(':fecha_cuentaCobrar', $this->fech_emision); 
                $stmt->bindParam(':monto_cuentaCobrar', $this->monto); // Asegúrate de que el monto sea correcto para cada producto 
                $stmt->execute();  
            }

            $id_actualizacion=1;
            $stmt = $this->conn->prepare("UPDATE producto SET id_motivoActualizacion = :id_actualizacion WHERE id_producto = :id_producto");
            $stmt->bindParam(':id_actualizacion', $id_actualizacion); 
            $stmt->bindParam(':id_producto', $producto_id); 
            $stmt->execute(); 

            // Confirmar la transacción solo si todas las operaciones fueron exitosas
            if ($this->conn->inTransaction()) {
                $this->conn->commit(); 
            }
            
            return true; 
    
        } catch (Exception $e) { 
            // Revertir la transacción en caso de error 
            if ($this->conn->inTransaction()) { 
                $this->conn->rollBack(); 
            } 
            echo "Error al registrar la venta: " . $e->getMessage(); 
        } 
    }
    

    // Método para obtener todas las venta de la base de datos
    public function Mostrar_Venta() {
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
                    modalidad_de_pago m ON m.ID = v.id_modalidad_pago
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

    public function obtenerBancos() {
        $query = "SELECT * FROM bancos";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPagos() {
        $query = "SELECT * FROM modalidad_de_pago";
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