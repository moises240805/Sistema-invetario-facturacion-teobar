<?php
require_once "Conexion.php";

class ReporteModel extends Conexion {
    public function __construct() {
        parent::__construct(); // Llama al constructor de la clase padre (Conexion)
    }

    public function obtenerDatos() {
        $query = "SELECT *
        FROM producto p 
        LEFT JOIN motivo_actualizacion a ON p.id_motivoActualizacion = a.ID  
        LEFT JOIN cantidad_producto cp ON p.id_producto = cp.id_producto 
        LEFT JOIN unidades_de_medida m ON cp.id_unidad_medida = m.id_unidad_medida
        LEFT JOIN presentacion s ON s.id_presentacion = p.id_presentacion";
      // Prepara la consulta
      $stmt = $this->conn->prepare($query);
      // Ejecuta la consulta
      $stmt->execute();
      // Retorna los resultados como un arreglo asociativo
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos2() {
        $query = "SELECT * FROM cliente";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos3() {
        $query = "SELECT * FROM proveedor";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos5() {
        $query = "SELECT * FROM venta v 
        LEFT JOIN producto p ON p.id_producto = v.id_producto
        LEFT JOIN cliente c ON c.id_cliente = v.id_cliente
        LEFT JOIN bancos b ON b.rif_banco = v.rif_banco
        LEFT JOIN modalidad_de_pago m ON m.ID = v.id_modalidad_pago ";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos6() {
        $query = "SELECT * FROM compra v 
        LEFT JOIN producto p ON p.id_producto = v.id_producto
        LEFT JOIN proveedor c ON c.id_proveedor = v.rif_proveedor
        LEFT JOIN modalidad_de_pago m ON m.ID = v.pago ";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos4() {
        $query = "SELECT * FROM cuenta_por_cobrar c
        LEFT JOIN venta v ON c.id_cuentaCobrar = v.id_venta";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos7() {
        $query = "SELECT                   
                c.id_cuentaPagar, 
                  c.fecha_cuentaPagar, 
                  c.monto_cuentaPagar, 
                  v.rif_proveedor 
                  FROM cuenta_por_pagar c
        LEFT JOIN compra v ON c.id_cuentaPagar = v.id_compra";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos8() {
        $query = "SELECT * FROM presentacion";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos9() {
        $query = "SELECT *
        FROM producto p 
        LEFT JOIN motivo_actualizacion a ON p.id_motivoActualizacion = a.ID  
        LEFT JOIN cantidad_producto cp ON p.id_producto = cp.id_producto 
        LEFT JOIN unidades_de_medida m ON cp.id_unidad_medida = m.id_unidad_medida
        LEFT JOIN presentacion s ON s.id_presentacion = p.id_presentacion
        WHERE p.id_motivoActualizacion = 2"; // Agregamos la cláusula WHERE
        
// Prepara la consulta
$stmt = $this->conn->prepare($query);
// Ejecuta la consulta
$stmt->execute();
// Retorna los resultados como un arreglo asociativo
return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos10() {
        $query = "SELECT *
        FROM producto p 
        LEFT JOIN motivo_actualizacion a ON p.id_motivoActualizacion = a.ID  
        LEFT JOIN cantidad_producto cp ON p.id_producto = cp.id_producto 
        LEFT JOIN unidades_de_medida m ON cp.id_unidad_medida = m.id_unidad_medida
        LEFT JOIN presentacion s ON s.id_presentacion = p.id_presentacion
        WHERE cp.cantidad < 10";; // Agregamos la cláusula WHERE
        
// Prepara la consulta
$stmt = $this->conn->prepare($query);
// Ejecuta la consulta
$stmt->execute();
// Retorna los resultados como un arreglo asociativo
return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos11() {
        $query = "SELECT  c.tipo_id, c.id_cliente, c.nombre_cliente, c.tlf, c.direccion, v.id_venta, v.monto
        FROM cliente c 
        LEFT JOIN venta v ON v.id_cliente = c.id_cliente  ";
        
// Prepara la consulta
$stmt = $this->conn->prepare($query);
// Ejecuta la consulta
$stmt->execute();
// Retorna los resultados como un arreglo asociativo
return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos12() {
        $query = "SELECT  c.tipo_id, c.id_proveedor, c.nombre_proveedor, c.tlf, c.direccion, v.id_compra, v.monto
        FROM proveedor c 
        LEFT JOIN compra v ON v.rif_proveedor = c.id_proveedor  ";
        
// Prepara la consulta
$stmt = $this->conn->prepare($query);
// Ejecuta la consulta
$stmt->execute();
// Retorna los resultados como un arreglo asociativo
return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos13() {
        $query = "SELECT * FROM venta v 
        LEFT JOIN producto p ON p.id_producto = v.id_producto
        LEFT JOIN cliente c ON c.id_cliente = v.id_cliente
        LEFT JOIN bancos b ON b.rif_banco = v.rif_banco
        LEFT JOIN modalidad_de_pago m ON m.ID = v.id_modalidad_pago
        WHERE v.id_modalidad_pago = 4"; // Agregada la cláusula WHERE

// Prepara la consulta
$stmt = $this->conn->prepare($query);

// Ejecuta la consulta
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos14() {
        $query = "SELECT * FROM venta v 
        LEFT JOIN producto p ON p.id_producto = v.id_producto
        LEFT JOIN cliente c ON c.id_cliente = v.id_cliente
        LEFT JOIN bancos b ON b.rif_banco = v.rif_banco
        LEFT JOIN modalidad_de_pago m ON m.ID = v.id_modalidad_pago
        WHERE v.id_modalidad_pago = 3"; // Agregada la cláusula WHERE

// Prepara la consulta
$stmt = $this->conn->prepare($query);

// Ejecuta la consulta
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos15() {
        $query = "SELECT * FROM venta v 
        LEFT JOIN producto p ON p.id_producto = v.id_producto
        LEFT JOIN cliente c ON c.id_cliente = v.id_cliente
        LEFT JOIN bancos b ON b.rif_banco = v.rif_banco
        LEFT JOIN modalidad_de_pago m ON m.ID = v.id_modalidad_pago
        WHERE v.id_modalidad_pago IN (1, 2)"; // Modificada la cláusula WHERE

// Prepara la consulta
$stmt = $this->conn->prepare($query);

// Ejecuta la consulta
$stmt->execute();

// Retorna los resultados como un arreglo asociativo
return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos16() {
        $query = "SELECT * FROM compra v 
        LEFT JOIN producto p ON p.id_producto = v.id_producto
        LEFT JOIN proveedor c ON c.id_proveedor = v.rif_proveedor
        LEFT JOIN modalidad_de_pago m ON m.ID = v.pago
         WHERE v.pago = 4 ";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos17() {
        $query = "SELECT * FROM compra v 
        LEFT JOIN producto p ON p.id_producto = v.id_producto
        LEFT JOIN proveedor c ON c.id_proveedor = v.rif_proveedor
        LEFT JOIN modalidad_de_pago m ON m.ID = v.pago
         WHERE v.pago = 3 ";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDatos18() {
        $query = "SELECT * FROM compra v 
        LEFT JOIN producto p ON p.id_producto = v.id_producto
        LEFT JOIN proveedor c ON c.id_proveedor = v.rif_proveedor
        LEFT JOIN modalidad_de_pago m ON m.ID = v.pago
         WHERE v.pago IN (1,2) ";
        // Prepara la consulta
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
