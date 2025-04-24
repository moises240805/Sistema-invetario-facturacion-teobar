<?php

require_once "Conexion.php";

class Roles extends Conexion {
    // Atributos
    private $estatus;
    private $modulo;
    private $id;
    private $rol;
    private $permiso;

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

    public function verificarPermiso($modulo, $action, $id_rol) {
        try {
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
        }
    }
    
    



    public function Mostrar_Roles() {
        try {
            $query = "SELECT 
            a.*, 
            r.nombre_rol,
            p.nombre_permiso,
            m.nombre_modulo
             FROM accesos a
            LEFT JOIN roles r ON a.id_rol=r.id_rol
            LEFT JOIN permisos p ON a.id_permiso=p.id_permiso
            LEFT JOIN modulos m ON a.id_modulo=m.id_modulo
            GROUP BY 
                    a.id_accesos";  // Opcional para optimizar
            
            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            error_log("Error de permisos: " . $e->getMessage());
            return false;
        }
    }
    
    




    public function Actualizar_Roles($id_modulo, $id_rol, $id_permiso, $estatus) {
        try {
            $query = "UPDATE accesos 
                      SET estatus = :estatus 
                      WHERE id_modulo = :id_modulo 
                        AND id_rol = :id_rol 
                        AND id_permiso = :id_permiso";
    
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);
            $stmt->bindParam(':id_modulo', $id_modulo, PDO::PARAM_INT);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $stmt->bindParam(':id_permiso', $id_permiso, PDO::PARAM_INT);
    
            $stmt->execute();
    
            // Opcional: devolver true si se actualizó alguna fila
            return $stmt->rowCount() > 0;
    
        } catch(PDOException $e) {
            error_log("Error actualizando permisos: " . $e->getMessage());
            return false;
        }
    }
    
    
    }
    ?>