<?php
/**
 * MODELO - Producto.php
 * 
 * ¿Qué es un Modelo en MVC?
 * El modelo es la "capa de datos" que:
 * - Maneja todas las operaciones con la base de datos
 * - Contiene la lógica específica de los datos
 * - No sabe nada sobre la interfaz (vistas)
 * - Proporciona métodos para CRUD (Create, Read, Update, Delete)
 * 
 * En resumen: El modelo es el "almacén de datos" que se conecta a la BD
 */

class Producto{
    // Propiedad privada para almacenar la conexión a la base de datos
    private $db;
    
    /**
     * CONSTRUCTOR
     * Se ejecuta cuando se crea una instancia del modelo
     * Aquí establecemos la conexión a la base de datos
     */
    public function __construct(){
        // getDB() es una función definida en config/database.php
        // que nos devuelve la conexión a la base de datos
        $this->db = getDB();  
    }

    /**
     * MÉTODO: obtenerTodos()
     * 
     * ¿Qué hace?
     * - Ejecuta una consulta SELECT para obtener todos los productos
     * - Ordena por ID descendente (los más recientes primero)
     * - Devuelve un array con todos los productos
     * 
     * ¿Cuándo se usa?
     * - Cuando el controlador necesita mostrar la lista de productos
     * 
     * @return array Array con todos los productos de la BD
     */
    public function obtenerTodos(){
        // 1. Definir la consulta SQL
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        
        // 2. Preparar la consulta (previene inyección SQL)
        $stmt = $this->db->prepare($sql);
        
        // 3. Ejecutar la consulta
        $stmt->execute();
        
        // 4. Devolver todos los resultados como array
        return $stmt->fetchAll();
    }

    /**
     * MÉTODO: crear($datos)
     * 
     * ¿Qué hace?
     * - Inserta un nuevo producto en la base de datos
     * - Usa consultas preparadas para seguridad
     * - Devuelve true si se insertó correctamente, false si hubo error
     * 
     * ¿Cuándo se usa?
     * - Cuando el controlador necesita guardar un nuevo producto
     * 
     * @param array $datos Array con los datos del producto ['nombre', 'precio', 'descripcion']
     * @return bool true si se creó exitosamente, false si hubo error
     */
    public function crear($datos){
        // 1. Definir la consulta SQL con placeholders (?) para seguridad
        $sql = "INSERT INTO productos (nombre, precio, descripcion) VALUES (?, ?, ?)";
        
        // 2. Preparar la consulta
        $stmt = $this->db->prepare($sql);
        
        // 3. Ejecutar la consulta pasando los valores en el mismo orden
        // execute() devuelve true si fue exitoso, false si hubo error
        return $stmt->execute([
            $datos['nombre'],      // Primer ? (nombre)
            $datos['precio'],      // Segundo ? (precio)  
            $datos['descripcion']  // Tercer ? (descripcion)
        ]);
    }
}

?>