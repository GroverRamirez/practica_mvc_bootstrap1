<?php
/**
 * MODELO - Producto.php
 * 
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
     */
    public function crear($datos){
        // 1. Definir la consulta SQL con placeholders (?) para seguridad
        $sql = "INSERT INTO productos (nombre, precio, descripcion, imagen) VALUES (?, ?, ?, ?)";
        
        // 2. Preparar la consulta
        $stmt = $this->db->prepare($sql);
        
        // 3. Ejecutar la consulta pasando los valores en el mismo orden
        // execute() devuelve true si fue exitoso, false si hubo error
        return $stmt->execute([
            $datos['nombre'],      // Primer ? (nombre)
            $datos['precio'],      // Segundo ? (precio)  
            $datos['descripcion'], // Tercer ? (descripcion)
            $datos['imagen']       // Cuarto ? (imagen)
        ]);
    }

        public function obtenerPorId($id){
        // 1. Definir la consulta SQL
        $sql = "SELECT * FROM productos WHERE id = ?";
        
        // 2. Preparar la consulta
        $stmt = $this->db->prepare($sql);
        
        // 3. Ejecutar la consulta
        $stmt->execute([$id]);
        
        // 4. Devolver el resultado (un solo registro)
        return $stmt->fetch();
    }
    public function actualizar($id, $datos){
            // 1. Definir la consulta SQL
            $sql = "UPDATE productos SET nombre = ?, precio = ?, descripcion = ?, imagen = ? WHERE id = ?";
            
            // 2. Preparar la consulta
            $stmt = $this->db->prepare($sql);
            
            // 3. Ejecutar la consulta
            return $stmt->execute([
                $datos['nombre'],      // Primer ? (nombre)
                $datos['precio'],      // Segundo ? (precio)
                $datos['descripcion'],
                $datos['imagen'],     // Tercer ? (descripcion)
                $id                    // Cuarto ? (id)
            ]);
        }

        public function eliminar($id){
            //definir consulta SQL
            $sql="DELETE FROM productos WHERE id=?";

            $stmt=$this->db->prepare($sql);

            return $stmt->execute([$id]);
        }
}

?>