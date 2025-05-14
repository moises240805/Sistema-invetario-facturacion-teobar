<?php

require_once "Conexion.php";

class Cliente extends Conexion{
    //Atributos

    private $id_cliente;
    private $nombre_cliente;
    private $tlf_cliente;
    private $direccion_cliente;
    private $email_cliente;
    private $tipo;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    private function setClienteData($cliente) {
        if (is_string($cliente)) {
            $cliente = json_decode($cliente, true);
        }
    
         // Expresiones regulares corregidas y con modificador 'u' para UTF-8
    $exp_nombre = "/^[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?(( |\-)[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?)*$/u";
    $exp_tlf = "/^\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/";
    $exp_direccion = "/^[a-zA-Z0-9À-ÖØ-öø-ÿ\s\.,#\-]+$/u";
    $exp_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    // Validar nombre_cliente (longitud máxima 20)
    $nombre = trim($cliente['nombre_cliente']);
    if (!preg_match($exp_nombre, $nombre) || mb_strlen($nombre) > 20) {
        return ['status' => false, 'msj' => 'Nombre invalido'];
    }
    $this->nombre_cliente = $nombre;

    // Validar teléfono (longitud máxima 11)
    $telefono = trim($cliente['telefono']);
    if (!preg_match($exp_tlf, $telefono) || mb_strlen($telefono) > 11) {
        return ['status' => false, 'msj' => 'Telefono invalido'];
    }
    $this->tlf_cliente = $telefono;

    // Validar id_cliente y tipo_id como numéricos
    if (!is_numeric($cliente['id_cliente']) || mb_strlen($cliente['id_cliente']) > 8 || mb_strlen($cliente['id_cliente']) < 6) {
        return ['status' => false, 'msj' => 'Tipo id invalida'];
    }
    $this->id_cliente = (int)$cliente['id_cliente'];
    $this->tipo = $cliente['tipo_id'];

    // Validar dirección (no vacía, longitud razonable, caracteres permitidos)
    $direccion = trim($cliente['direccion']);
    if ($direccion === '' || !preg_match($exp_direccion, $direccion) || mb_strlen($direccion) > 100) {
        return ['status' => false, 'msj' => 'Direccion invalida'];

    }
    $this->direccion_cliente = $direccion;

    // Validar email
    $email = trim($cliente['email']);
    if (!preg_match($exp_email, $email)) {
        return ['status' => false, 'msj' => 'Email invalidado'];
    }
    $this->email_cliente = $email;

    return ['status' => true, 'msj' => 'Datos validados correctamente'];
    }

    private function setValideId($cliente){

            // Validar id_cliente y tipo_id como numéricos
        if (!is_numeric($cliente) ) {
            return ['status' => false, 'msj' => 'ID invalida'];
        }
        $this->id_cliente = (int)$cliente;
        return ['status' => true, 'msj' => 'ID validado correctamente'];
    }


    // Métodos set y get
    public function setIdCliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    public function getIdCliente() {
        return $this->id_cliente;
    }

    public function setNombreCliente($nombre_cliente) {
        $this->nombre_cliente = $nombre_cliente;
    }

    public function getNombreCliente() {
        return $this->nombre_cliente;
    }

    public function setTlfCliente($tlf_cliente) {
        $this->tlf_cliente = $tlf_cliente;
    }

    public function getTlfCliente() {
        return $this->tlf_cliente;
    }

    public function setDireccionCliente($direccion_cliente) {
        $this->direccion_cliente = $direccion_cliente;
    }

    public function getDireccionCliente() {
        return $this->direccion_cliente;
    }

    public function setEmailCliente($email_cliente) {
        $this->email_cliente = $email_cliente;
    }

    public function getEmailCliente() {
        return $this->email_cliente;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getTipo() {
        return $this->tipo;
    }

    //Metodos

    //Indiferentemente sea la accion primero la funcion manejar accion llama a la 
    //funcion setcliente data que validad todos los valores
    //luego de que todo los datos sean validados correctamente
    //verifica que la variable validacion que contiene el status de la funcion sea correcta 
    //si es incorrecta retorna el status de mensajes de errores 
    //si es correcta me llama la funcion correspondiente 
    public function manejarAccion($accion, $cliente) {
        switch ($accion) {

            case 'agregar':
                $validacion=$this->setClienteData($cliente);
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    return $this->Guardar_Cliente();
                }
                break;

            case 'actualizar':
                $validacion=$this->setClienteData($cliente);
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    return $this->Actualizar_Cliente(); 
                }

            case 'obtener':
                $validacion=$this->setValideId($cliente);
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    return $this->Obtener_Cliente($cliente);
                }

            case 'eliminar':
                $validacion=$this->setValideId($cliente);
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    return $this->Eliminar_Cliente($cliente);
                }

            case 'consultar':

                    return $this->Mostrar_Cliente();
                
            default:
                return ['status' => false, 'msj' => 'Accion invalida'];
        }
    }

    private function Guardar_Cliente()
    {
        $conn=null;
        try {
            // Consulta para verificar si el cliente ya existe
            $query = "SELECT * FROM cliente WHERE id_cliente = :id_cliente";
            $conn=$this->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id_cliente", $this->id_cliente);
            $stmt->execute();
    
            if ($stmt->rowCount() == 0) {
                // Insertar nuevo cliente
                $query = "INSERT INTO cliente (id_cliente, nombre_cliente, tlf, direccion, email, tipo_id, status) 
                          VALUES (:id_cliente, :nombre_cliente, :tlf_cliente, :direccion_cliente, :email_cliente, :tipo, 1)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":id_cliente", $this->id_cliente);
                $stmt->bindParam(":tipo", $this->tipo);
                $stmt->bindParam(":nombre_cliente", $this->nombre_cliente);
                $stmt->bindParam(":tlf_cliente", $this->tlf_cliente);
                $stmt->bindParam(":direccion_cliente", $this->direccion_cliente);
                $stmt->bindParam(":email_cliente", $this->email_cliente);
    
                if ($stmt->execute()) {
                    return ['status' => true, 'msj' => 'Cliente guardado correctamente'];
                } else {
                    return ['status' => false, 'msj' => 'Error al guardar el cliente'];
                }
            } else {
                return ['status' => false, 'msj' => 'El cliente ya existe'];
            }
        } catch (PDOException $e) {
            // Retornar mensaje de error sin hacer echo
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }

    // Método para obtener todas las personas de la base de datos
    private function Mostrar_Cliente() {

            $conn = null;
            try{

            // Consulta SQL para seleccionar todos los registros de la tabla personas
            $query = "SELECT * FROM cliente  WHERE status=1";
            // Prepara la consulta
            $conn=$this->getConnection();
            $stmt = $conn->prepare($query);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Retornar mensaje de error sin hacer echo
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }

    private function Obtener_Cliente($id_cliente) {

        $conn = null;
        try{
            $query = "SELECT * FROM cliente WHERE id_cliente = :id_cliente";
            $conn=$this->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id_cliente", $this->id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            // Retornar mensaje de error sin hacer echo
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $conn = null;
        }
    }

    private function Actualizar_Cliente() {

        $conn = null;
        try {
            $query = "UPDATE cliente SET nombre_cliente = :nombre, tlf = :tlf, direccion = :direccion, email = :email_cliente, tipo_id = :tipo WHERE id_cliente = :id_cliente";
            $conn=$this->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id_cliente", $this->id_cliente, PDO::PARAM_INT);
            $stmt->bindParam(":tipo", $this->tipo, PDO::PARAM_STR); // Corregido aquí
            $stmt->bindParam(":nombre", $this->nombre_cliente, PDO::PARAM_STR);
            $stmt->bindParam(":tlf", $this->tlf_cliente, PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $this->direccion_cliente, PDO::PARAM_STR);
            $stmt->bindParam(":email_cliente", $this->email_cliente, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Cliente actualizado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar el cliente'];
            }
            }catch (PDOException $e) {
                // Retornar mensaje de error sin hacer echo
                return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
            } finally {
                $conn = null;
            }
    }
    

private function Eliminar_Cliente($id_cliente) {
    $conn = null;
    try {
        $query = "UPDATE cliente SET status = 0 WHERE id_cliente = :id_cliente";
        $conn = $this->getConnection();
        $stmt = $conn->prepare($query);

        // Usar el parámetro recibido en la función
        $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return ['status' => true, 'msj' => 'Cliente eliminado correctamente'];
        } else {
            return ['status' => false, 'msj' => 'Error al eliminar el cliente'];
        }
    } catch (PDOException $e) {
        return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
    } finally {
        $conn = null;
    }
}

}
?>