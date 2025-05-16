<?php

require_once "Conexion.php";

class Admin extends Conexion {
    // Atributos
    private $username;
    private $pw;
    private $id;
    private $rol;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    private function setUserData($user) {
        if (is_string($user)) {
            $user = json_decode($user, true);
            if ($user === null) {
                return ['status' => false, 'msj' => 'JSON inválido'];
            }
        }
    
        // Expresiones regulares actualizadas
        $exp_username = "/^@[a-zA-Z0-9_]{1,19}$/";
        $exp_pw = "/^(?=.*[A-Z])(?=.*\.)[A-Za-z0-9\.]{6,9}$/";
        $exp_rol = "/^\d+$/";
    
        // Validar username
        $username = trim($user['username'] ?? '');
        if (!preg_match($exp_username, $username)) {
            return ['status' => false, 'msj' => 'Nombre de usuario inválido. Debe tener hasta 20 caracteres y puede incluir letras, números y signos permitidos.'];
        }
        $this->username = $username;
    
        // Validar contraseña
        $pw = trim($user['pw'] ?? '');
        if (!preg_match($exp_pw, $pw)) {
            return ['status' => false, 'msj' => 'Contraseña inválida. Debe tener entre 6 y 9 caracteres, incluir al menos una letra mayúscula y un punto.'];
        }
        $this->pw = $pw;
    
        // Validar rol numérico
        $rol = trim($user['rol'] ?? '');
        if (!preg_match($exp_rol, $rol)) {
            return ['status' => false, 'msj' => 'Rol inválido. Debe ser un número.'];
        }
        $this->rol = (int)$rol;
    
        // Validar id (opcional)
        if (isset($user['id'])) {
            if (!is_numeric($user['id'])) {
                return ['status' => false, 'msj' => 'ID inválido'];
            }
            $this->id = (int)$user['id'];
        } else {
            $this->id = null;
        }
    
        return ['status' => true, 'msj' => 'Datos de usuario validados correctamente'];
    }

    private function setValideId($user){

        // Validar id (opcional)
        if (isset($user['id'])) {
            if (!is_numeric($user['id'])) {
                return ['status' => false, 'msj' => 'ID inválido'];
            }
            $this->id = (int)$user['id'];
        } else {
            $this->id = null;
        }
    
        return ['status' => true, 'msj' => 'Datos de usuario validados correctamente'];
    }

    private function setValide($username){

        // Expresiones regulares actualizadas
        $exp_username = "/^@[a-zA-Z0-9_]{1,19}$/";

    
        // Validar username
        $username = trim($user['username'] ?? '');
        if (!preg_match($exp_username, $username)) {
            return ['status' => false, 'msj' => 'Nombre de usuario inválido. Debe tener hasta 20 caracteres y puede incluir letras, números y signos permitidos.'];
        }
        $this->username = $username;
        return ['status' => true, 'msj' => 'Datos de usuario validados correctamente'];
    }
    

    // Métodos Getter y Setter
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->pw;
    }

    public function setPassword($pw) {
        $this->pw = $pw; // Considera agregar hashing aquí si es necesario
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    // Métodos
        //Metodos

    //Indiferentemente sea la accion primero la funcion manejar accion llama a la 
    //funcion setUser data que validad todos los valores
    //luego de que todo los datos sean validados correctamente
    //verifica que la variable validacion que contiene el status de la funcion sea correcta 
    //si es incorrecta retorna el status de mensajes de errores 
    //si es correcta me llama la funcion correspondiente 
    public function manejarAccion($accion, $usuario) {
        switch ($accion) {

            case 'agregar':
                $validacion=$this->setUserData($usuario);
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    return $this->Guardar_Usuario();
                }
                break;

            case 'actualizar':
                $validacion=$this->setUserData($usuario);
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    return $this->Actualizar_Usuario(); 
                }

            case 'obtener':
                $validacion=$this->setValideId($usuario);
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    return $this->Obtener_Usuario($usuario);
                }

            case 'eliminar':
                $validacion=$this->setValideId($usuario);
                if(!$validacion['status']){
                    return $validacion;
                }else{
                    return $this->Eliminar_Usuario($usuario);
                }

            case 'consultar':
                return $this->Mostrar_Usuario();

            case 'ingresar':
                //$validacion=$this->setValide($username);
                //if(!$validacion['status']){
                //    return $validacion;
                //}else{
                    return $this->Iniciar_Sesion($usuario);
                //}

            case 'registrar':
                //$validacion=$this->setValide($username);
                //if(!$validacion['status']){
                //    return $validacion;
                //}else{
                    return $this->Register_Online($usuario);
                //}

            default:
                return ['status' => false, 'msj' => 'Accion invalida'];
        }
    }



    private function Guardar_Usuario() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            // Consulta para verificar si el nombre de usuario ya existe
            $query = "SELECT * FROM usuarios WHERE usuario = :username";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":username", $this->username);
            $stmt->execute();
            
            if ($stmt->rowCount() == 0) {
                // Hash de la contraseña antes de almacenarla
                $hashedPassword = password_hash($this->pw, PASSWORD_DEFAULT);
                
                // Consulta SQL para insertar un nuevo registro en la tabla usuarios
                $query = "INSERT INTO usuarios (usuario, pw, id_rol, status) VALUES (:username, :pw, :rol, 1)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":username", $this->username);
                $stmt->bindParam(":pw", $hashedPassword);
                $stmt->bindParam(":rol", $this->rol);
                
                if ($stmt->execute()) {
                    return ['status' => true, 'msj' => 'Usuario guardado correctamente'];
                } else {
                    return ['status' => false, 'msj' => 'Error al guardar el usuario'];
                }
            } else {
                return ['status' => false, 'msj' => 'El usuario ya existe'];
            }
        } catch (PDOException $e) {
            // Retornar mensaje de error sin hacer echo
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
        $this->closeConnection();
        }
    }

    
    

    // Método para obtener todas las personas de la base de datos
    private function Mostrar_Usuario() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            // Consulta SQL para seleccionar todos los registros de la tabla admin
            $query = "SELECT * FROM usuarios u LEFT JOIN roles r ON u.id_rol=r.id_rol WHERE u.status = 1";
            // Prepara la consulta
            $stmt = $conn->prepare($query);
            // Ejecuta la consulta
            $stmt->execute();
            // Retorna los resultados como un arreglo asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
        $this->closeConnection();
        }
    }

    private function Obtener_Usuario($id) {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            $query = "SELECT * FROM usuarios WHERE ID = :ID";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":ID", $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            return ['status' => false, 'msj' => 'Usuario no encontrado ' . $e->getMessage()]; // No se encontró usuario
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
        $this->closeConnection();
        }
    }

    private function Actualizar_Usuario() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            // Consulta SQL para actualizar los datos del usuario
            $query = "UPDATE usuarios SET usuario = :username, pw = :pw, id_rol = :rol WHERE ID = :id";
            
            // Prepara la consulta
            $stmt = $conn->prepare($query);
            
            // Hash de la nueva contraseña
            $hashedPassword = password_hash($this->pw, PASSWORD_DEFAULT);
            
            // Vincula los parámetros con los valores
            $stmt->bindParam(":username", $this->username, PDO::PARAM_STR);
            $stmt->bindParam(":pw", $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(":rol", $this->rol, PDO::PARAM_INT);
            $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Usuario actualizado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar el usuario'];
            }
        } catch (PDOException $e) {
            // Retornar mensaje de error sin hacer echo
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
        $this->closeConnection();
        }
    }
    

    private function Eliminar_Usuario($id) { 
        $this->closeConnection();
        try { 
            $conn = $this->getConnection();
            $query = "UPDATE usuarios SET status = 0 WHERE ID = :ID"; 
            $stmt = $conn->prepare($query); 
            $stmt->bindParam(":ID", $id, PDO::PARAM_INT); 
    
            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Usuario eliminado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar el usuario'];
            }
        } catch (PDOException $e) { 
            // Retornar mensaje de error sin hacer echo
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
        $this->closeConnection();
        }
    }
    

public function Iniciar_Sesion($username) {
    $this->closeConnection();
    try {
        $conn = $this->getConnection();  // Usar la conexión local
        $query = "SELECT u.*, r.nombre_rol 
                FROM usuarios u 
                LEFT JOIN roles r ON u.id_rol = r.id_rol 
                WHERE usuario = :username 
                AND u.status = 1";  // Incluir validación de estado
        
        $stmt = $conn->prepare($query);  // Usar conexión local
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            return [
                'status' => true,
                'msj' => 'Usuario autenticado',
                'data' => $usuario  // Datos consistentes en estructura
            ];
        } else {
            return [
                'status' => false,
                'msj' => 'Usuario no encontrado o inactivo'
            ];
        }
    } catch (PDOException $e) {
        return [
            'status' => false,
            'msj' => 'Error en la consulta: ' . $e->getMessage()
        ];
    } finally {
    $this->closeConnection();
    }
    }
}

?>