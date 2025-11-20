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
        // Verificar autenticación
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        // Si no está autenticado, redirigir al login
        if(!isset($_SESSION['usuario'])){
            header('Location: ?action=login');
            exit;
        }
        
        // 1. Obtener productos del modelo
        $productos = $this->modelo->obtenerTodos();
        
        // 2. Obtener datos del usuario de la sesión
        $usuario = $_SESSION['usuario'] ?? null;
        
        // 3. Preparar variables
        $totalProductos = count($productos);
        
        // 4. Cargar vista
        $this->cargarVista('show', [
            'productos' => $productos,
            'totalProductos' => $totalProductos,
            'usuario' => $usuario
        ]);
    }

    // Muestra formulario de creación
    public function create(){
        // Verificar autenticación
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        // Si no está autenticado, redirigir al login
        if(!isset($_SESSION['usuario'])){
            header('Location: ?action=login');
            exit;
        }
        
        // Solo cargamos la vista del formulario (sin datos)
        $this->cargarVista('Create', []);
    }

    // Procesa el formulario y crea un producto
    public function crear(){
        // Verificar autenticación
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        // Si no está autenticado, redirigir al login
        if(!isset($_SESSION['usuario'])){
            header('Location: ?action=login');
            exit;
        }
        
        //Verificar la peticion sea POST (datos del formulario)
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //OBTRENER Y LIMPIAR DATOS DEL FORMULARIO
            $nombre=trim($_POST['nombre'] ?? '');
            $precio=floatval($_POST['precio'] ?? 0);
            $descripcion=trim($_POST['descripcion'] ?? '');

            if(!empty($nombre) && $precio > 0 && !empty($descripcion)){
                // Procesar la imagen si se subió
                $rutaImagen = '';
                if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK){
                    $resultadoImagen = $this->guardarImagen($_FILES['imagen']);
                    if($resultadoImagen['error']){
                        //si hay errores, mostrar mensaje
                        $mensaje = $resultadoImagen['error'];
                        $tipoMensaje = 'warning';
                    } else {
                        $rutaImagen = $resultadoImagen['ruta'];
                    }
                } else {
                    // Si no se subió imagen, usar una imagen por defecto o vacío
                    $rutaImagen = '';
                }

                // Solo crear el producto si no hubo error con la imagen
                if(!isset($mensaje) || $tipoMensaje !== 'warning'){
                    //DATOS PREPARAR PARA GUARDAR
                    $datos = [
                        'nombre' => $nombre,
                        'precio' => $precio,
                        'descripcion' => $descripcion,
                        'imagen' => $rutaImagen
                    ];

                    //GUARDAR DATOS EN LA BD USANDO EL MODELO
                    if($this->modelo->crear($datos)){
                        $mensaje = '¡Producto creado exitosamente!';
                        $tipoMensaje = 'success';
                    } else {
                        $mensaje = 'Error al crear el producto. Inténtalo de nuevo.';
                        $tipoMensaje = 'danger';
                        //si falla, eliminar la imagen subida
                        if(!empty($rutaImagen)){
                            $this->eliminarImagen($rutaImagen);    
                        }
                    }
                }
            } else {
                $mensaje = 'Por favor, completa todos los campos correctamente.';
                $tipoMensaje = 'warning';
            }

        }

        //PROCESAR , MOSTRAR LA LISTA DE PRODUCTOS
        $productos=$this->modelo->obtenerTodos();
        
        // Obtener datos del usuario de la sesión
        $usuario = $_SESSION['usuario'] ?? null;
        
        // Preparar variables para la vista
        $totalProductos = count($productos);

        // Inicializar variables de mensaje si no existen
        $mensaje = $mensaje ?? null;
        $tipoMensaje = $tipoMensaje ?? null;

        //cargar la vista con los productos
        $this->cargarVista('show', [    
            'productos' => $productos,
            'totalProductos' => $totalProductos,
            'usuario' => $usuario,
            'mensaje' => $mensaje,
            'tipoMensaje' => $tipoMensaje
        ]);
    }

    public function editar(){
        // Verificar autenticación
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        // Si no está autenticado, redirigir al login
        if(!isset($_SESSION['usuario'])){
            header('Location: ?action=login');
            exit;
        }
        
        //obtener id del producto desde la URL
        $id=$_GET['id']?? null;

        //validar que el ID existe
        if(!$id){
            $this->listar();
            return;
        }

        // Obtener los datos del producto
        $producto = $this->modelo->obtenerPorId($id);

        // Verificar que el producto existe
        if(!$producto){
            // Si no existe, redirigir a la lista
            $this->listar();
            return;
        }

        //cargar la vista de edicion con los datos del producto
        $this->cargarVista('Edit',['producto'=>$producto]);
    }

      // Procesa el formulario de edición y actualiza el producto
    public function actualizar(){
        // Verificar autenticación
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        // Si no está autenticado, redirigir al login
        if(!isset($_SESSION['usuario'])){
            header('Location: ?action=login');
            exit;
        }
        
        $mensaje = null;
        $tipoMensaje = null;
        
        // Verificar que la petición sea POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            // Obtener el ID del producto
            $id = $_POST['id'] ?? null;
            
            // Validar que el ID existe
            if(!$id){
                $this->listar();
                return;
            }
            
            // Obtener y limpiar datos del formulario
            $nombre = trim($_POST['nombre'] ?? '');
            $precio = floatval($_POST['precio'] ?? 0);
            $descripcion = trim($_POST['descripcion'] ?? '');
            
            // Validar que los datos no estén vacíos
            if(!empty($nombre) && $precio > 0 && !empty($descripcion)){
                // Obtener el producto actual para conservar la imagen si no se sube una nueva
                $productoActual = $this->modelo->obtenerPorId($id);
                $rutaImagen = $productoActual['imagen'] ?? '';
                
                // Si se subió una nueva imagen, procesarla
                if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK){
                    $resultadoImagen = $this->guardarImagen($_FILES['imagen']);
                    if($resultadoImagen['error']){
                        $mensaje = $resultadoImagen['error'];
                        $tipoMensaje = 'warning';
                    } else {
                        // Eliminar la imagen anterior si existe
                        if(!empty($rutaImagen) && file_exists($rutaImagen)){
                            $this->eliminarImagen($rutaImagen);
                        }
                        $rutaImagen = $resultadoImagen['ruta'];
                    }
                }
                
                // Si no hubo error con la imagen, actualizar el producto
                if(!isset($mensaje) || $tipoMensaje !== 'warning'){
                    // Preparar datos para actualizar
                    $datos = [
                        'nombre' => $nombre,
                        'precio' => $precio,
                        'descripcion' => $descripcion,
                        'imagen' => $rutaImagen
                    ];
                    
                    // Actualizar el producto en la base de datos
                    if($this->modelo->actualizar($id, $datos)){
                        $mensaje = "¡Producto actualizado exitosamente!";
                        $tipoMensaje = "success";
                    } else {
                        $mensaje = "Error al actualizar el producto. Inténtalo de nuevo.";
                        $tipoMensaje = "danger";
                        // Si falla, eliminar la imagen nueva subida
                        if(isset($resultadoImagen) && !empty($resultadoImagen['ruta']) && $resultadoImagen['ruta'] !== $productoActual['imagen']){
                            $this->eliminarImagen($resultadoImagen['ruta']);
                        }
                    }
                }
            } else {
                $mensaje = "Por favor, completa todos los campos correctamente.";
                $tipoMensaje = "warning";
            }
        }
        
        // Verificar autenticación
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        // Obtener datos del usuario de la sesión
        $usuario = $_SESSION['usuario'] ?? null;
        
        // Después de actualizar, mostrar la lista de productos
        $productos = $this->modelo->obtenerTodos();
        $totalProductos = count($productos);
        
        $this->cargarVista('show', [
            'productos' => $productos,
            'totalProductos' => $totalProductos,
            'mensaje' => $mensaje,
            'tipoMensaje' => $tipoMensaje,
            'usuario' => $usuario
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

    public function eliminar(){
        // Verificar autenticación
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        // Si no está autenticado, redirigir al login
        if(!isset($_SESSION['usuario'])){
            header('Location: ?action=login');
            exit;
        }
        
        $mensaje = null;
        $tipoMensaje = null;
        
        //obtener id del producto desde la URL
        $id=$_GET['id']?? null;

        //validar que el ID existe
        if(!$id){
            $this->listar();
            return;
        }

        // Obtener el producto antes de eliminarlo para borrar su imagen
        $producto = $this->modelo->obtenerPorId($id);
        
        //Eliminar el producto de la base de datos
        if($this->modelo->eliminar($id)){
            // Eliminar la imagen del producto si existe
            if($producto && !empty($producto['imagen']) && file_exists($producto['imagen'])){
                $this->eliminarImagen($producto['imagen']);
            }
            $mensaje = "¡Producto eliminado exitosamente!";
            $tipoMensaje = "success";
        } else{
            $mensaje = "¡Error al eliminar producto!";
            $tipoMensaje = "danger";
        }

        // Verificar autenticación
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        // Obtener datos del usuario de la sesión
        $usuario = $_SESSION['usuario'] ?? null;
        
        //despues de eliminar, mostrar la lista de productos
        $productos=$this->modelo->obtenerTodos();
        $totalProductos = count($productos);

        $this->cargarVista('show',[
            'productos' => $productos,
            'totalProductos' => $totalProductos,
            'mensaje' => $mensaje,
            'tipoMensaje' => $tipoMensaje,
            'usuario' => $usuario
        ]);
    }

    /**
     * MÉTODO: guardarImagen()
     * Procesa y guarda la imagen subida del producto
     * @param array $archivo Array $_FILES['imagen']
     * @return array ['error' => string|null, 'ruta' => string]
     */
    private function guardarImagen($archivo){
        // Directorio donde se guardarán las imágenes
        $directorio = 'uploads/productos/';
        
        // Crear el directorio si no existe
        if(!file_exists($directorio)){
            if(!mkdir($directorio, 0755, true)){
                return ['error' => 'No se pudo crear el directorio para las imágenes.', 'ruta' => ''];
            }
        }

        // Verificar si se subió un archivo
        if(!isset($archivo) || !is_array($archivo) || !isset($archivo['error'])){
            // Si no hay archivo, no es un error (imagen opcional)
            return ['error' => null, 'ruta' => ''];
        }
        
        if($archivo['error'] !== UPLOAD_ERR_OK){
            // Si no se subió imagen, no es un error (imagen opcional)
            if($archivo['error'] === UPLOAD_ERR_NO_FILE){
                return ['error' => null, 'ruta' => ''];
            }
            return ['error' => 'Error al subir la imagen. Código: ' . $archivo['error'], 'ruta' => ''];
        }

        // Validar tipo de archivo
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        $tipoArchivo = $archivo['type'];
        
        if(!in_array($tipoArchivo, $tiposPermitidos)){
            return ['error' => 'Tipo de archivo no permitido. Solo se permiten: JPG, PNG o WEBP.', 'ruta' => ''];
        }

        // Validar tamaño (máximo 5MB)
        $tamañoMaximo = 5 * 1024 * 1024; // 5MB en bytes
        if($archivo['size'] > $tamañoMaximo){
            return ['error' => 'La imagen es demasiado grande. Máximo permitido: 5MB.', 'ruta' => ''];
        }

        // Generar nombre único para el archivo
        $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('producto_', true) . '.' . $extension;
        $rutaCompleta = $directorio . $nombreArchivo;

        // Mover el archivo subido al directorio de destino
        if(move_uploaded_file($archivo['tmp_name'], $rutaCompleta)){
            return ['error' => null, 'ruta' => $rutaCompleta];
        } else {
            return ['error' => 'Error al guardar la imagen en el servidor.', 'ruta' => ''];
        }
    }

    /**
     * MÉTODO: eliminarImagen()
     * Elimina una imagen del servidor
     * @param string $ruta Ruta de la imagen a eliminar
     * @return bool True si se eliminó correctamente, false en caso contrario
     */
    private function eliminarImagen($ruta){
        if(!empty($ruta) && file_exists($ruta)){
            return unlink($ruta);
        }
        return false;
    }
}

?>