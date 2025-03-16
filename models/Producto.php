<?php

require_once "Conexion.php";

class Producto extends Conexion{
    //Atributos
    private $id_producto;
    private $nombre_producto;
    private $presentacion;
    private $fech_vencimiento;
    private $fecha_registro;
    private $cantidad_producto;
    private $cantidad_producto2;
    private $cantidad_producto3;
    private $precio_producto;
    private $precio_producto2;
    private $precio_producto3;
    private $uni_medida;
    private $uni_medida2;
    private $uni_medida3;
    private $id_actualizacion;
    private $peso;
    private $peso2;
    private $peso3;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

public function setProductoData($producto) {
    // Si $producto es un string JSON, decodifícalo
    if (is_string($producto)) {
        $producto = json_decode($producto, true);
    }

    // Ahora puedes asignar los valores
    $this->id_producto = $producto['id_producto'] ?? null;
    $this->nombre_producto = $producto['nombre_producto'] ?? null; // Corregido el key
    $this->presentacion = $producto['presentacion'] ?? null; // Corregido el key
    $this->fech_vencimiento = $producto['fecha_vencimiento'] ?? null;
    $this->fecha_registro = $producto['fecha_registro'] ?? null;
    $this->cantidad_producto = $producto['cantidad_producto'] ?? null; // Corregido el key
    $this->cantidad_producto2 = $producto['cantidad_producto2'] ?? null;
    $this->cantidad_producto3 = $producto['cantidad_producto3'] ?? null;
    $this->precio_producto = $producto['precio_producto'] ?? null; // Corregido el key
    $this->precio_producto2 = $producto['precio_producto2'] ?? null;
    $this->precio_producto3 = $producto['precio_producto3'] ?? null;
    $this->uni_medida = $producto['uni_medida'] ?? null; // Corregido el key
    $this->uni_medida2 = $producto['uni_medida2'] ?? null;
    $this->uni_medida3 = $producto['uni_medida3'] ?? null;
    $this->id_actualizacion = $producto['id_actualizacion'] ?? null; // Si este campo no existe, no lo asignes
    $this->peso = $producto['peso'] ?? null;
    $this->peso2 = $producto['peso2'] ?? null; // Si este campo no existe, no lo asignes
    $this->peso3 = $producto['peso3'] ?? null;
}



    // Getters
    public function getIdProducto() {
        return $this->id_producto;
    }

    public function getNombreProducto() {
        return $this->nombre_producto;
    }

    public function getPresentacion() {
        return $this->presentacion;
    }

    public function getFechVencimiento() {
        return $this->fech_vencimiento;
    }

    public function getFechaRegistro() {
        return $this->fecha_registro;
    }

    public function getCantidadProducto() {
        return $this->cantidad_producto;
    }

    public function getCantidadProducto2() {
        return $this->cantidad_producto2;
    }

    public function getCantidadProducto3() {
        return $this->cantidad_producto3;
    }

    public function getPrecioProducto() {
        return $this->precio_producto;
    }

    public function getPrecioProducto2() {
        return $this->precio_producto2;
    }

    public function getPrecioProducto3() {
        return $this->precio_producto3;
    }

    public function getUniMedida() {
        return  $this->uni_medida; 
    }

    public function getUniMedida2() {
        return $this->uni_medida2; 
    }

    public function getUniMedida3() {
        return $this->uni_medida3; 
    }

    public function getIdActualizacion() {
        return $this->id_actualizacion; 
    }

    public function getPeso() {
        return $this->peso; 
    }

    public function getPeso2() {
        return $this->peso2; 
    }

    public function getPeso3() {
        return $this->peso3; 
    }

    // Setters
    public function setIdProducto($id_producto) {
        $this->id_producto =  $id_producto;  
    }

    public function setNombreProducto($nombre_producto) {
        $this->nombre_producto =  $nombre_producto;  
    }

    public function setPresentacion($presentacion) {
        $this->presentacion =  $presentacion;  
    }

    public function setFechVencimiento($fech_vencimiento) {
        $this->fech_vencimiento =  $fech_vencimiento;  
    }

    public function setFechaRegistro($fecha_registro) {
        $this->fecha_registro =  $fecha_registro;  
    }

    public function setCantidadProducto($cantidad_producto) {
        $this->cantidad_producto =  $cantidad_producto;  
    }

    public function setCantidadProducto2($cantidad_producto2) {
        $this->cantidad_producto2 =  $cantidad_producto2;  
    }

    public function setCantidadProducto3($cantidad_producto3) {
        $this->cantidad_producto3 =  $cantidad_producto3;  
    }

    public function setPrecioProducto($precio_producto) {
        $this->precio_producto=  $precio_producto;  
    }

    public function setPrecioProducto2($precio_producto_2) { 
        $this->precio_producto_2= $precio_producto_2;  
    }
    
    public function setPrecioProducto3($precio_producto_3) { 
        $this->precio_producto_3= $precio_producto_3;  
    }
    
    public function setUniMedida($uni_medida) { 
        $this->uni_medida= $uni_medida;  
    }
    
    public function setUniMedida2($uni_medida_2) { 
        $this->uni_medida_2= $uni_medida_2;  
    }
    
    public function setUniMedida3($uni_medida_3) { 
        $this->uni_medida_3= $uni_medida_3;  
    }
    
    public function setIdActualizacion($id_actualizacion) { 
        $this->id_actualizacion= $id_actualizacion;  
    }
    
    public function setPeso($peso) { 
        $this->peso= $peso;  
    }
    
    public function setPeso2($peso_2) { 
        $this->peso_2= $peso_2;  
    }
    
    public function setPeso3($peso_3) { 
        $this->peso_3= $peso_3;  
    }

    //Metodos
    public function Guardar_Producto()
    {
          // Consulta SQL para insertar un nuevo registro en la tabla producto 
    $query = "INSERT INTO producto (id_producto, nombre, fecha_vencimiento, fecha_registro, id_presentacion) 
    VALUES (:id_producto, :nombre_producto, :fech_venci, :fecha_registro, :presentacion)"; 

    // Prepara la consulta 
    $stmt = $this->conn->prepare($query); 

    // Vincula los parámetros con los valores 
    $stmt->bindParam(":id_producto", $this->id_producto, PDO::PARAM_INT); 
    $stmt->bindParam(":nombre_producto", $this->nombre_producto, PDO::PARAM_STR); 
    $stmt->bindParam(":fech_venci", $this->fech_vencimiento); 
    $stmt->bindParam(":fecha_registro", $this->fecha_registro); 
    $stmt->bindParam(":presentacion", $this->presentacion, PDO::PARAM_STR);

    // Ejecuta la consulta
    if ($stmt->execute()) {
    // Ahora inserta en la tabla cantidad_producto
    $query = "INSERT INTO cantidad_producto (id_producto, cantidad, precio, id_unidad_medida,peso)  
            VALUES (:id_producto, :cantidad_producto, :precio_producto, :uni_medida,:peso),
                (:id_producto, :cantidad_producto2, :precio_producto2, :uni_medida2,:peso2),
                (:id_producto, :cantidad_producto3, :precio_producto3, :uni_medida3,:peso3)"; 

    $stmt = $this->conn->prepare($query); 

    // Vincula los parámetros para la segunda inserción
    $stmt->bindParam(":id_producto", $this->id_producto); // El mismo ID del producto
    $stmt->bindParam(":cantidad_producto", $this->cantidad_producto, PDO::PARAM_INT); 
    $stmt->bindParam(":precio_producto", $this->precio_producto); // Cambié a DECIMAL
    $stmt->bindParam(":uni_medida", $this->uni_medida, PDO::PARAM_INT); 
    $stmt->bindParam(":cantidad_producto2", $this->cantidad_producto2, PDO::PARAM_INT); 
    $stmt->bindParam(":precio_producto2", $this->precio_producto2); // Cambié a DECIMAL
    $stmt->bindParam(":uni_medida2", $this->uni_medida2, PDO::PARAM_INT);
    $stmt->bindParam(":cantidad_producto3", $this->cantidad_producto3, PDO::PARAM_INT); 
    $stmt->bindParam(":precio_producto3", $this->precio_producto3); // Cambié a DECIMAL
    $stmt->bindParam(":uni_medida3", $this->uni_medida3, PDO::PARAM_INT);
    $stmt->bindParam(":peso", $this->peso );
    $stmt->bindParam(":peso2", $this->peso2);
    $stmt->bindParam(":peso3", $this->peso3);

    // Ejecuta la segunda consulta y retorna true si ambas tienen éxito
    return $stmt->execute(); 
    }

    return false; // Si falla la primera inserción
    }

    public function Guardar_Producto2()
    {
          // Consulta SQL para insertar un nuevo registro en la tabla producto 
          $query = "INSERT INTO producto (id_producto, nombre, fecha_vencimiento, fecha_registro, id_presentacion) 
    VALUES (:id_producto, :nombre_producto, :fech_venci, :fecha_registro, :presentacion)";  

    // Prepara la consulta 
    $stmt = $this->conn->prepare($query); 

    // Vincula los parámetros con los valores 
    $stmt->bindParam(":id_producto", $this->id_producto, PDO::PARAM_INT); 
    $stmt->bindParam(":nombre_producto", $this->nombre_producto, PDO::PARAM_STR); 
    $stmt->bindParam(":fech_venci", $this->fech_vencimiento); 
    $stmt->bindParam(":fecha_registro", $this->fecha_registro); 
    $stmt->bindParam(":presentacion", $this->presentacion, PDO::PARAM_STR);

    // Ejecuta la consulta
    if ($stmt->execute()) {
    // Ahora inserta en la tabla cantidad_producto
    $query = "INSERT INTO cantidad_producto (id_producto, cantidad, precio, id_unidad_medida)  
            VALUES (:id_producto, :cantidad_producto, :precio_producto, :uni_medida)"; 

    $stmt = $this->conn->prepare($query); 

    // Vincula los parámetros para la segunda inserción
    $stmt->bindParam(":id_producto", $this->id_producto); // El mismo ID del producto
    $stmt->bindParam(":cantidad_producto", $this->cantidad_producto, PDO::PARAM_INT); 
    $stmt->bindParam(":precio_producto", $this->precio_producto); // Cambié a DECIMAL
    $stmt->bindParam(":uni_medida", $this->uni_medida, PDO::PARAM_INT); 


    // Ejecuta la segunda consulta y retorna true si ambas tienen éxito
    return $stmt->execute(); 
    }

    return false; // Si falla la primera inserción
    }

    // Método para obtener todas las personas de la base de datos
    public function Mostrar_Producto() { 
        // Consulta SQL para seleccionar todos los registros de la tabla producto
        $query = "SELECT 
                    p.id_producto,
                    p.fecha_registro, 
                    p.nombre,
                    p.id_presentacion, 
                    MAX(p.fecha_vencimiento) AS fecha_vencimiento, 
                    GROUP_CONCAT(cp.cantidad SEPARATOR '\n ') AS cantidad, 
                    GROUP_CONCAT(cp.precio SEPARATOR ' $ Bs\n ') AS precio, 
                    GROUP_CONCAT(cp.peso SEPARATOR '\n ') AS peso,
                    GROUP_CONCAT(m.nombre_medida SEPARATOR '\n ') AS nombre_medida, 
                    a.nombre_motivo,
                    s.presentacion
                  FROM 
                    producto p  
                  LEFT JOIN 
                    motivo_actualizacion a ON p.id_motivoActualizacion = a.ID   
                  LEFT JOIN 
                    cantidad_producto cp ON p.id_producto = cp.id_producto  
                  LEFT JOIN 
                    unidades_de_medida m ON cp.id_unidad_medida = m.id_unidad_medida
                  LEFT JOIN 
                    presentacion s ON s.id_presentacion = p.id_presentacion
                  GROUP BY 
                    p.id_producto"; 
    
        // Prepara la consulta 
        $stmt = $this->conn->prepare($query); 
        // Ejecuta la consulta 
        $stmt->execute(); 
        // Retorna los resultados como un arreglo asociativo 
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    public function Mostrar_Producto2() {
      // Consulta SQL para seleccionar todos los registros de la tabla personas
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

    public function Obtener_Producto($id_producto) {
        $query = "SELECT p.*, a.nombre_motivo, cp.cantidad, cp.precio,cp.peso, s.presentacion, m.nombre_medida AS nombre_medida 
          FROM producto p  
          LEFT JOIN motivo_actualizacion a ON p.id_motivoActualizacion = a.ID   
          LEFT JOIN cantidad_producto cp ON p.id_producto = cp.id_producto  
          LEFT JOIN unidades_de_medida m ON cp.id_unidad_medida = m.id_unidad_medida  
          LEFT JOIN presentacion s ON s.id_presentacion = p.id_presentacion
          WHERE cp.id_producto = :id_producto;";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function Actualizar_Producto() {
        try {
            $query = "UPDATE producto SET nombre = :nombre, id_presentacion = :presentacion, fecha_vencimiento = :fecha_vencimiento, id_motivoActualizacion = :id_actualizacion WHERE id_producto = :id_producto;";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_producto", $this->id_producto);
            $stmt->bindParam(":nombre", $this->nombre_producto);
            $stmt->bindParam(":fecha_vencimiento", $this->fech_vencimiento);
            $stmt->bindParam(":id_actualizacion", $this->id_actualizacion);
            $stmt->bindParam(":presentacion", $this->presentacion);
            
            $success1 = $stmt->execute();

            $query3 = "UPDATE cantidad_producto SET 
    cantidad = CASE 
        WHEN id_unidad_medida = :uni_medida THEN :cantidad_producto
        WHEN id_unidad_medida = :uni_medida2 THEN :cantidad_producto2
        WHEN id_unidad_medida = :uni_medida3 THEN :cantidad_producto3
        ELSE cantidad 
    END,
    precio = CASE 
        WHEN id_unidad_medida = :uni_medida THEN :precio_producto
        WHEN id_unidad_medida = :uni_medida2 THEN :precio_producto2
        WHEN id_unidad_medida = :uni_medida3 THEN :precio_producto3
        ELSE precio 
    END,
        peso = CASE 
        WHEN id_unidad_medida = :uni_medida THEN :peso
        WHEN id_unidad_medida = :uni_medida2 THEN :peso2
        WHEN id_unidad_medida = :uni_medida3 THEN :peso3
        ELSE peso 
    END,
    id_unidad_medida = CASE 
        WHEN id_unidad_medida IN (:uni_medida, :uni_medida2, :uni_medida3) THEN  id_unidad_medida
        ELSE id_unidad_medida 
    END
WHERE id_producto = :id_producto AND id_unidad_medida IN (:uni_medida, :uni_medida2, :uni_medida3);";
            $stmt3 = $this->conn->prepare($query3);
            $stmt3->bindParam(":id_producto", $this->id_producto);
            $stmt3->bindParam(":cantidad_producto", $this->cantidad_producto);
            $stmt3->bindParam(":cantidad_producto2", $this->cantidad_producto2);
            $stmt3->bindParam(":cantidad_producto3", $this->cantidad_producto3);
            $stmt3->bindParam(":precio_producto", $this->precio_producto);
            $stmt3->bindParam(":precio_producto2", $this->precio_producto2);
            $stmt3->bindParam(":precio_producto3", $this->precio_producto3);
            $stmt3->bindParam(":uni_medida", $this->uni_medida);
            $stmt3->bindParam(":uni_medida2", $this->uni_medida2);
            $stmt3->bindParam(":uni_medida3", $this->uni_medida3);
            $stmt3->bindParam(":peso", $this->peso);
            $stmt3->bindParam(":peso2", $this->peso2);
            $stmt3->bindParam(":peso3", $this->peso3);

            $success3 = $stmt3->execute();

            return $success1;


        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }

    public function Eliminar_Producto($id_producto) {
        $query = "DELETE FROM producto WHERE id_producto = :id_producto";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_producto", $id_producto, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
}
?>