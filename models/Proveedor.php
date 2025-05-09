<?php

require_once "Conexion.php";

class Proveedor extends Conexion{
    //Atributos
    private $id_proveedor;
    private $nombre_proveedor;
    private $direccion_proveedor;
    private $tlf_proveedor;
    private $id_representante_legal;
    private $nombre_representante_legal;
    private $tlf_representante_legal;
    private $tipo;
    private $tipo2;

    //constuctor
    public function __construct()
    {
        parent::__construct();
    }

    private function setProveedorData($proveedor) {
        if (is_string($proveedor)) {
            $proveedor = json_decode($proveedor, true);
            if ($proveedor === null) {
                return ['status' => false, 'msj' => 'JSON inválido'];
            }
        }
    
        // Expresiones regulares para validar campos
        $exp_nombre = "/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]{1,50}$/u"; // Letras y espacios, max 50 caracteres
        $exp_direccion = "/^[a-zA-Z0-9À-ÖØ-öø-ÿ\s\.,#\-]{1,100}$/u"; // Letras, números y algunos símbolos, max 100 caracteres
        $exp_telefono = "/^\+?\d{7,15}$/"; // Teléfono con 7 a 15 dígitos, opcional '+' al inicio
        $exp_tipo = "/^\w{0,20}$/"; // Palabra alfanumérica, max 20 caracteres (ajustar según necesidades)
        $exp_id = "/^\d+$/"; // Números enteros positivos
    
        // Validar id_proveedor (opcional, entero)
        if (isset($proveedor['id_proveedor']) && !preg_match($exp_id, strval($proveedor['id_proveedor']))) {
            return ['status' => false, 'msj' => 'ID de proveedor inválido'];
        }
        $this->id_proveedor = isset($proveedor['id_proveedor']) ? (int)$proveedor['id_proveedor'] : null;
    
        // Validar nombre_proveedor (obligatorio)
        $nombre_prov = trim($proveedor['nombre_proveedor'] ?? '');
        if ($nombre_prov === '' || !preg_match($exp_nombre, $nombre_prov)) {
            return ['status' => false, 'msj' => 'Nombre de proveedor inválido o vacío'];
        }
        $this->nombre_proveedor = $nombre_prov;
    
        // Validar direccion_proveedor (obligatorio)
        $direccion_prov = trim($proveedor['direccion_proveedor'] ?? '');
        if ($direccion_prov === '' || !preg_match($exp_direccion, $direccion_prov)) {
            return ['status' => false, 'msj' => 'Dirección de proveedor inválida o vacía'];
        }
        $this->direccion_proveedor = $direccion_prov;
    
        // Validar telefono_proveedor (obligatorio)
        $tlf_prov = trim($proveedor['telefono_proveedor'] ?? '');
        if ($tlf_prov === '' || !preg_match($exp_telefono, $tlf_prov)) {
            return ['status' => false, 'msj' => 'Teléfono de proveedor inválido o vacío'];
        }
        $this->tlf_proveedor = $tlf_prov;
    
        // Validar id_representante_legal (opcional, entero)
        if (isset($proveedor['id_representante_legal']) && !preg_match($exp_id, strval($proveedor['id_representante_legal']))) {
            return ['status' => false, 'msj' => 'ID de representante legal inválido'];
        }
        $this->id_representante_legal = isset($proveedor['id_representante_legal']) ? (int)$proveedor['id_representante_legal'] : null;
    
        // Validar nombre_representante_legal (obligatorio)
        $nombre_rep = trim($proveedor['nombre_representante_legal'] ?? '');
        if ($nombre_rep === '' || !preg_match($exp_nombre, $nombre_rep)) {
            return ['status' => false, 'msj' => 'Nombre del representante legal inválido o vacío'];
        }
        $this->nombre_representante_legal = $nombre_rep;
    
        // Validar telefono_representante_legal (opcional)
        $tlf_rep = trim($proveedor['telefono_representante_legal'] ?? '');
        if ($tlf_rep !== '' && !preg_match($exp_telefono, $tlf_rep)) {
            return ['status' => false, 'msj' => 'Teléfono del representante legal inválido'];
        }
        $this->tlf_representante_legal = $tlf_rep !== '' ? $tlf_rep : null;
    
        // Validar tipo (opcional)
        $tipo = trim($proveedor['tipo'] ?? '');
        if ($tipo !== '' && !preg_match($exp_tipo, $tipo)) {
            return ['status' => false, 'msj' => 'Tipo inválido'];
        }
        $this->tipo = $tipo !== '' ? $tipo : null;
    
        // Validar tipo2 (opcional)
        $tipo2 = trim($proveedor['tipo2'] ?? '');
        if ($tipo2 !== '' && !preg_match($exp_tipo, $tipo2)) {
            return ['status' => false, 'msj' => 'Tipo2 inválido'];
        }
        $this->tipo2 = $tipo2 !== '' ? $tipo2 : null;
    
        // Todo validado y asignado correctamente
        return ['status' => true, 'msj' => 'Datos de proveedor validados correctamente'];
    }


    private function setValideId($proveedor){

        // Validar id_cliente y tipo_id como numéricos
    if (!is_numeric($proveedor) ) {
        return ['status' => false, 'msj' => 'ID invalida'];
    }
    $this->id_proveedor = (int)$proveedor;
    return ['status' => true, 'msj' => 'ID validado correctamente'];
}
    
    

        // Getters
        public function getIdProveedor() {
            return $this->id_proveedor;
        }
    
        public function getNombreProveedor() {
            return $this->nombre_proveedor;
        }
    
        public function getDireccionProveedor() {
            return $this->direccion_proveedor;
        }
    
        public function getTlfProveedor() {
            return $this->tlf_proveedor;
        }
    
        public function getIdRepresentanteLegal() {
            return $this->id_representante_legal;
        }
    
        public function getNombreRepresentanteLegal() {
            return $this->nombre_representante_legal;
        }
    
        public function getTlfRepresentanteLegal() {
            return $this->tlf_representante_legal;
        }
    
        public function getTipo() {
            return $this->tipo;
        }
    
        public function getTipo2() {
            return $this->tipo2;
        }
    
        // Setters
        public function setIdProveedor($id_proveedor) {
            $this->id_proveedor = $id_proveedor;
        }
    
        public function setNombreProveedor($nombre_proveedor) {
            $this->nombre_proveedor = $nombre_proveedor;
        }
    
        public function setDireccionProveedor($direccion_proveedor) {
            $this->direccion_proveedor = $direccion_proveedor;
        }
    
        public function setTlfProveedor($tlf_proveedor) {
            $this->tlf_proveedor = $tlf_proveedor;
        }
    
        public function setIdRepresentanteLegal($id_representante_legal) {
            $this->id_representante_legal = $id_representante_legal;
        }
    
        public function setNombreRepresentanteLegal($nombre_representante_legal) {
            $this->nombre_representante_legal = $nombre_representante_legal;
        }
    
        public function setTlfRepresentanteLegal($tlf_representante_legal) {
            $this->tlf_representante_legal = $tlf_representante_legal;
        }
    
        public function setTipo($tipo) {
            $this->tipo = $tipo;
        }
    
        public function setTipo2($tipo2) {
            $this->tipo2 = $tipo2;
        }

    //Metodos




        //Indiferentemente sea la accion primero la funcion manejar accion llama a la 
    //funcion setcliente data que validad todos los valores
    //luego de que todo los datos sean validados correctamente
    //verifica que la variable validacion que contiene el status de la funcion sea correcta 
    //si es incorrecta retorna el status de mensajes de errores 
    //si es correcta me llama la funcion correspondiente 
    public function manejarAccion($accion, $proveedor) {
        switch ($accion) {
            case 'agregar':
                $validacion = $this->setProveedorData($proveedor);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Guardar_Proveedor();
    
            case 'actualizar':
                $validacion = $this->setProveedorData($proveedor);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Actualizar_Proveedor();
    
            case 'obtener':
                $validacion = $this->setValideId($proveedor);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Obtener_Proveedor($proveedor);
    
            case 'eliminar':
                $validacion = $this->setValideId($proveedor);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Eliminar_Proveedor($proveedor);
    
            case 'consultar':
                return $this->Mostrar_Proveedor();
    
            default:
                return ['status' => false, 'msj' => 'Acción inválida'];
        }
    }
    

    private function Guardar_Proveedor() {
        $conn = null;
        try {
            $conn = $this->getConnection();

            // Verificar si el proveedor ya existe
            $query = "SELECT * FROM proveedor WHERE id_proveedor = :id_proveedor";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id_proveedor", $this->id_proveedor);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return ['status' => false, 'msj' => 'El proveedor ya existe'];
            }

            // Insertar nuevo proveedor
            $query = "INSERT INTO proveedor (id_proveedor, nombre_proveedor, direccion, 
                      tlf, id_representante, nombre_representante, tlf_representante, tipo_id, tipo_id2) 
                      VALUES (:id_proveedor, :nombre_proveedor, :direccion_proveedor, 
                      :tlf_proveedor, :id_representante_legal, :nombre_representante_legal, 
                      :tlf_representante_legal, :tipo, :tipo2)";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(":id_proveedor", $this->id_proveedor);
            $stmt->bindParam(":tipo", $this->tipo);
            $stmt->bindParam(":tipo2", $this->tipo2);
            $stmt->bindParam(":nombre_proveedor", $this->nombre_proveedor);
            $stmt->bindParam(":direccion_proveedor", $this->direccion_proveedor);
            $stmt->bindParam(":tlf_proveedor", $this->tlf_proveedor);
            $stmt->bindParam(":id_representante_legal", $this->id_representante_legal);
            $stmt->bindParam(":nombre_representante_legal", $this->nombre_representante_legal);
            $stmt->bindParam(":tlf_representante_legal", $this->tlf_representante_legal);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Proveedor guardado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al guardar el proveedor'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }

    private function Mostrar_Proveedor() {
        $conn = null;
        try {
            $conn = $this->getConnection();

            $query = "SELECT * FROM proveedor";
            $stmt = $conn->prepare($query);

            if (!$stmt->execute()) {
                return ['status' => false, 'msj' => 'Error al obtener proveedores'];
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            //return ['status' => true, 'data' => $data];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }

    private function Obtener_Proveedor($id_proveedor) {
        $conn = null;
        try {
            $conn = $this->getConnection();

            $query = "SELECT * FROM proveedor WHERE id_proveedor = :id_proveedor";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id_proveedor", $id_proveedor, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                return ['status' => false, 'msj' => 'Error al obtener proveedor'];
            }

            return $stmt->fetch(PDO::FETCH_ASSOC);
            //return ['status' => true, 'data' => $data];

        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }

    private function Actualizar_Proveedor() {
        $conn = null;
        try {
            $conn = $this->getConnection();

            $query = "UPDATE proveedor
                      SET nombre_proveedor = :nombre,
                          direccion = :direccion,
                          tlf = :tlf,
                          id_representante = :id_representante,
                          nombre_representante = :nombre_representante,
                          tlf_representante = :tlf_representante,
                          tipo_id = :tipo,
                          tipo_id2 = :tipo2
                      WHERE id_proveedor = :id_proveedor";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(":id_proveedor", $this->id_proveedor, PDO::PARAM_INT);
            $stmt->bindParam(":tipo", $this->tipo, PDO::PARAM_STR);
            $stmt->bindParam(":tipo2", $this->tipo2, PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $this->nombre_proveedor, PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $this->direccion_proveedor, PDO::PARAM_STR);
            $stmt->bindParam(":tlf", $this->tlf_proveedor, PDO::PARAM_STR);
            $stmt->bindParam(":id_representante", $this->id_representante_legal, PDO::PARAM_INT);
            $stmt->bindParam(":nombre_representante", $this->nombre_representante_legal, PDO::PARAM_STR);
            $stmt->bindParam(":tlf_representante", $this->tlf_representante_legal, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Proveedor actualizado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar el proveedor'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }

    private function Eliminar_Proveedor($id_proveedor) {
        $conn = null;
        try {
            $conn = $this->getConnection();

            $query = "DELETE FROM proveedor WHERE id_proveedor = :id_proveedor";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id_proveedor", $id_proveedor, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Proveedor eliminado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar el proveedor'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }
}
?>