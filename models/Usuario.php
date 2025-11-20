<?php
//Autenticacion y gestion de usuarios
class Usuario{
    //propiedad privada para almacenar la conexion a la base de datos
    private $db;
    //Constructor 
    public function __construct(){
        $this->db=getDB();
    }
    //Metodo para autenticar usuarios
    public function autenticar($usuario, $password){
        try{
            //1 Definir la consulta SQL para buscar el usuario por username o email
            //NO buscamos por password porque está encriptado en la BD
            $sql = "SELECT * FROM usuarios WHERE username = ? OR email = ?";

            //2 preparar la consulta
            $stmt = $this->db->prepare($sql);

            //3 ejecutar la consulta (buscamos por username o email)
            $stmt->execute([$usuario, $usuario]);

            //4 obtener el usuario de la base de datos
            $usuarioData = $stmt->fetch();
            
            //5 Verificamos si el usuario existe
            if($usuarioData){
                //6 Verificar la contraseña usando password_verify
                if(password_verify($password, $usuarioData['password'])){
                    //7 Eliminar la contraseña del array antes de devolver (por seguridad)
                    unset($usuarioData['password']);
                    return $usuarioData;
                }
            }
            
            return false;
        }
        catch(PDOException $e){
            return false;
        }
    }

    //Metodo para crear usuarios
    public function crear($datos){
        try{
            //Verificar si el username ya existe
            if($this->existeUsuario($datos['username'])){
                return false;
            }

            //Verificar si el email ya existe
            if($this->existeEmail($datos['email'])){
                return false;
            }

            //Encriptar la contraseña
            $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);
            
            //definir la consulta SQL
            $sql = "INSERT INTO usuarios(username, email, password, nombre) VALUES(?, ?, ?, ?)";
            
            //Preparar la consulta
            $stmt = $this->db->prepare($sql);
            
            //Ejecutar la consulta  
            $resultado = $stmt->execute([
                $datos['username'],
                $datos['email'],
                $passwordHash,
                $datos['nombre']
            ]);
            
            return $resultado;
        }
        catch(PDOException $e){
            //Error al insertar (probablemente duplicado)
            return false;
        }
    }

    //Metodo para verificar si un usuario existe
    public function existeUsuario($username){
        try{
            $sql = "SELECT COUNT(*) FROM usuarios WHERE username = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$username]);
            $count = $stmt->fetchColumn();
            return $count > 0;
        }
        catch(PDOException $e){
            return false;
        }
    }

    //Metodo para verificar si un email existe
    public function existeEmail($email){
        try{
            $sql = "SELECT COUNT(*) FROM usuarios WHERE email = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$email]);
            $count = $stmt->fetchColumn();
            return $count > 0;
        }
        catch(PDOException $e){
            return false;
        }
    }

    //Metodo para obtener usuarios por username o email
    public function obtenerPorUsuario($usuario){
        try{
            //1 Definir la consulta SQL para buscar por username o email
            $sql = "SELECT id, username, email, nombre FROM usuarios WHERE username = ? OR email = ?";
            
            //2 preparar la consulta
            $stmt = $this->db->prepare($sql);
            
            //3 ejecutar la consulta
            $stmt->execute([$usuario, $usuario]);
            
            //4 obtener el usuario
            $usuarioData = $stmt->fetch();
            
            if($usuarioData){
                return [
                    'id' => $usuarioData['id'],
                    'username' => $usuarioData['username'],
                    'nombre' => $usuarioData['nombre'],
                    'email' => $usuarioData['email']
                ];
            }
            
            return null;
        }
        catch(PDOException $e){
            return null;
        }
    }

    //Metodo: obtener usuario por ID
    public function obtenerPorId($id){
        try{
            //1 definir la consulta SQL
            $sql = "SELECT id, username, email, nombre FROM usuarios WHERE id = ?";

            //2 preparar la consulta
            $stmt = $this->db->prepare($sql);

            //3 ejecutar la consulta
            $stmt->execute([$id]);

            //4 obtener el usuario (sin la contraseña por seguridad)
            $usuarioData = $stmt->fetch();
            
            return $usuarioData ? $usuarioData : null;
        }
        catch(PDOException $e){
            return null;
        }
    }
}

?>