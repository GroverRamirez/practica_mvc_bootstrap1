<?php
/**
 * Configuración de Base de Datos
 * Patrón Singleton con PDO para una única conexión segura
 */

// Parámetros de conexión
define('DB_HOST', 'localhost');
define('DB_NAME', 'mvc1_productos');
define('DB_USER', 'root');
define('DB_PASS', '');

/**
 * Clase Database - Patrón Singleton
 * Garantiza una única instancia de conexión
 */
class Database{
    private static $instancia = null;
    private $conexion;

    /**
     * Constructor privado - Solo se crea internamente
     */
    private function __construct(){
        try{
            $this->conexion = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", 
                DB_USER, 
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch(PDOException $e){
            die("Error de conexión: " . $e->getMessage());
        }
    }

    /**
     * Obtener instancia única de Database
     */
    public static function getInstancia(){
        if(self::$instancia === null){
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    /**
     * Obtener conexión PDO
     */
    public function getConexion(){
        return $this->conexion;
    }
}

/**
 * Función helper para obtener la conexión
 */
function getDB(){
    return Database::getInstancia()->getConexion();
}
?>