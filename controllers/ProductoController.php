<?php
/**
 * CONTROLADOR - ProductoController.php
 * Maneja la lógica de negocio y coordina Modelo-Vista
 */

class ProductoController{
    // Propiedad privada para almacenar la instancia del modelo
    private $modelo;
    
    //Constructor - Inicializa el modelo
    public function __construct(){
        // Creamos una instancia del modelo Producto
        $this->modelo = new Producto();
    }

    // Lista todos los productos
    public function listar(){
        // 1. Pedirle al modelo que obtenga todos los productos
        $productos = $this->modelo->obtenerTodos();
        
        // 2. Cargar la vista y pasarle los datos
        $this->cargarVista('show', ['productos' => $productos]);
    }

    // Muestra formulario de creación
    public function create(){
        // Solo cargamos la vista del formulario (sin datos)
        $this->cargarVista('Create', []);
    }

    // Procesa el formulario y crea un producto
    public function crear(){
        // Variables para manejar mensajes de éxito/error
        $mensaje = '';
        $tipoMensaje = '';
        
        // Verificar que la petición sea POST (datos del formulario)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. OBTENER Y LIMPIAR DATOS DEL FORMULARIO
            $nombre = trim($_POST['nombre'] ?? '');        // trim() elimina espacios
            $precio = floatval($_POST['precio'] ?? 0);     // floatval() convierte a número
            $descripcion = trim($_POST['descripcion'] ?? '');
            
            // 2. VALIDAR DATOS (reglas de negocio)
            if (empty($nombre)) {
                $mensaje = 'El nombre del producto es obligatorio.';
                $tipoMensaje = 'error';
            } elseif ($precio <= 0) {
                $mensaje = 'El precio debe ser mayor a 0.';
                $tipoMensaje = 'error';
            } elseif (empty($descripcion)) {
                $mensaje = 'La descripción es obligatoria.';
                $tipoMensaje = 'error';
            } else {
                // 3. DATOS VÁLIDOS - PREPARAR PARA GUARDAR
                $datos = [
                    'nombre' => $nombre,
                    'precio' => $precio,
                    'descripcion' => $descripcion
                ];
                
                // 4. GUARDAR EN BD USANDO EL MODELO
                if ($this->modelo->crear($datos)) {
                    $mensaje = 'Producto creado exitosamente.';
                    $tipoMensaje = 'success';
                } else {
                    $mensaje = 'Error al crear el producto.';
                    $tipoMensaje = 'error';
                }
            }
        }
        
        // 5. DESPUÉS DE PROCESAR, MOSTRAR LA LISTA DE PRODUCTOS
        // Obtenemos todos los productos actualizados
        $productos = $this->modelo->obtenerTodos();
        
        // Cargamos la vista con los productos y el mensaje
        $this->cargarVista('show', [
            'productos' => $productos,
            'mensaje' => $mensaje,
            'tipoMensaje' => $tipoMensaje
        ]);
    }

    // Carga una vista con datos y layout
    private function cargarVista($vista, $datos = []){
        // extract() convierte: ['productos' => $array] → $productos = $array
        extract($datos);

        // Capturar el contenido de la vista en una variable
        ob_start();
        include "views/{$vista}.php";
        $contenido = ob_get_clean();

        // Incluir el layout que contiene Bootstrap y la estructura HTML
        include "views/layout.php";
    }
}

?>