<?php

require_once "Conexion.php";

class Roles extends Conexion {
    // Atributos
    private $estatus;
    private $modulo;
    private $id;
    private $rol;
    private $permiso;


    private function setRolesData($data) {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        $this->modulo = intval($data['id_modulo']);
        $this->rol = intval($data['id_rol']);
        $this->permiso = intval($data['id_permiso']);
        $this->estatus = intval($data['estatus']);     
    }

    private function setValideId($id){

        // Validar id_cliente y tipo_id como numéricos
    if (!is_numeric($id) ) {
        return ['status' => false, 'msj' => 'ID invalida'];
    }
    $this->id = (int)$id;
    return ['status' => true, 'msj' => 'ID validado correctamente'];
    }

    private function setValideRol($rol){

        // Validar id_cliente y tipo_id como numéricos
        if (mb_strlen($rol) > 50) {
            return ['status' => false, 'msj' => 'El nombre rol no puede tener más de 50 caracteres'];
        }
    $this->rol = $rol;
    return ['status' => true, 'msj' => 'ID validado correctamente'];
    }




    // Métodos Getter y Setter
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($permiso) {
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

    public function getModulo() {
        return $this->modulo;
    }

    public function setModulo($modulo) {
        $this->modulo = $modulo;
    }

    public function getPermiso() {
        return $this->permiso;
    }

    public function setPermiso($permiso) {
        $this->permiso = $permiso;
    }

    public function getEstatus() {
        return $this->estatus;
    }

    public function setEstatus($estatus) {
        $this->estatus = $estatus;
    }



     //Indiferentemente sea la accion primero la funcion manejar accion llama a la 
    //funcion setcliente data que validad todos los valores
    //luego de que todo los datos sean validados correctamente
    //verifica que la variable validacion que contiene el status de la funcion sea correcta 
    //si es incorrecta retorna el status de mensajes de errores 
    //si es correcta me llama la funcion correspondiente 
    public function manejarAccion($accion, $data) {
        switch ($accion) {
            case 'actualizar':
                $this->setRolesData($data);
               return $this->Actualizar_Roles(); 
            break;
            case 'agregar':
                $validacion = $this->setValideRol($data);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Guardar_Roles($data);
            break;
            case 'eliminar':
                $validacion = $this->setValideId($data);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Eliminar_Roles();
            break;    
            case 'consultar':
                return $this->Mostrar_Roles();
            break;
            default:
                return ['status' => false, 'msj' => 'Accion invalida'];
        }
    }

    public function verificarPermiso($modulo, $action, $id_rol) {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            $query = "SELECT a.estatus, p.nombre_permiso 
                      FROM accesos a
                      JOIN modulos m ON a.id_modulo = m.id_modulo
                      JOIN permisos p ON a.id_permiso = p.id_permiso
                      WHERE a.id_rol = :id_rol
                      AND m.nombre_modulo = :modulo
                      AND p.nombre_permiso = :permiso
                      LIMIT 1";  // Opcional para optimizar
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_rol", $id_rol, PDO::PARAM_INT);
            $stmt->bindParam(":modulo", $modulo, PDO::PARAM_STR);
            $stmt->bindParam(":permiso", $action, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result && isset($result['estatus'])) {
                return $result['estatus'] == 1;
            } else {
                // No existe el permiso o no está activo
                return false;
            }
            
        } catch(PDOException $e) {
            error_log("Error de permisos: " . $e->getMessage());
            return false;
        } finally {
            $this->closeConnection();
        }
    }
    



    private function Guardar_Roles($data) {
        $conn = null;
        try {
            $this->closeConnection(); // Cierra conexión previa si la hay
            $conn = $this->getConnection();
            $conn->beginTransaction();
    
            // 1. Insertar nuevo rol
            $query = "INSERT INTO roles (nombre_rol, status) VALUES (:rol, 1)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":rol", $this->rol, PDO::PARAM_STR);
            $stmt->execute();
    
            // 2. Obtener el ID del rol insertado
            $id_rol = $conn->lastInsertId();
    
            if (!$id_rol) {
                $conn->rollBack();
                return ['status' => false, 'msj' => 'No se pudo obtener el ID del rol'];
            }
    
            // 3. Insertar accesos para el nuevo rol
            // Definimos los módulos y permisos (puedes ajustar según tu sistema)
            $accesos = [];
            for ($modulo = 1; $modulo <= 16; $modulo++) {
                for ($permiso = 1; $permiso <= 4; $permiso++) {
                    $accesos[] = "($id_rol, $modulo, $permiso, 0)";
                }
            }
    
            $insertAccesosQuery = "INSERT INTO accesos (id_rol, id_modulo, id_permiso, estatus) VALUES " . implode(", ", $accesos);
            $conn->exec($insertAccesosQuery);
    
            // 4. Confirmar transacción
            $conn->commit();
    
            return ['status' => true, 'msj' => 'Rol guardado y accesos asignados correctamente'];
    
        } catch (PDOException $e) {
            if ($conn && $conn->inTransaction()) {
                $conn->rollBack();
            }
            error_log("Error en Guardar_Roles: " . $e->getMessage());
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
    
    



    private function Mostrar_Roles() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            $query = "SELECT 
            a.*, 
            r.nombre_rol,
            p.nombre_permiso,
            m.nombre_modulo
             FROM accesos a
            LEFT JOIN roles r ON a.id_rol=r.id_rol AND r.status=1
            LEFT JOIN permisos p ON a.id_permiso=p.id_permiso
            LEFT JOIN modulos m ON a.id_modulo=m.id_modulo
            WHERE status=1
            GROUP BY 
                    a.id_accesos";  // Opcional para optimizar
            
            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            error_log("Error de permisos: " . $e->getMessage());
            return false;
        } finally {
            $this->closeConnection();
        }
    }
    
    




    private function Actualizar_Roles() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            $query = "UPDATE accesos 
                      SET estatus = :estatus 
                      WHERE id_modulo = :id_modulo 
                        AND id_rol = :id_rol 
                        AND id_permiso = :id_permiso";
    
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(':estatus', $this->estatus, PDO::PARAM_INT);
            $stmt->bindParam(':id_modulo', $this->modulo, PDO::PARAM_INT);
            $stmt->bindParam(':id_rol', $this->rol, PDO::PARAM_INT);
            $stmt->bindParam(':id_permiso', $this->permiso, PDO::PARAM_INT);
    
            $stmt->execute();
    
            // Opcional: devolver true si se actualizó alguna fila
            return $stmt->rowCount() > 0;
    
        } catch(PDOException $e) {
            error_log("Error actualizando permisos: " . $e->getMessage());
            return false;
        } finally {
            $this->closeConnection();
        }
    }
    

    private function Eliminar_Roles() {
        $this->closeConnection();
        try {
            $conn = $this->getConnection();
            $query = "UPDATE roles 
                      SET status = 0 
                      WHERE id_rol = :id_rol 
                        ";
    
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id_rol', $this->id, PDO::PARAM_INT);
    
            $stmt->execute();
    
            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Rol eliminado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar el Rol'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
    
    }
    ?>