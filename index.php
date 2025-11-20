<?php
// PUNTO DE ENTRADA al proyecto MVC
// Este archivo es el "router" simple que maneja las rutas

// 1. Incluir la configuración de base de datos
require_once 'config/database.php';

// 2. Incluir el modelo (lógica de datos)
require_once 'models/Producto.php';
require_once 'models/Usuario.php';

// 3. Incluir el controlador (lógica de negocio)
require_once 'controllers/ProductoController.php';
require_once 'controllers/AuthController.php';

// 4. Obtener la acción desde la URL (por defecto es 'login')
$action = $_GET['action'] ?? 'login';

// 5. Determinar qué controlador usar según la acción
if(in_array($action, ['login','logout','registrar','procesarRegistro'])){
    // Acciones de autenticación
    $controller = new AuthController();
} else {
    // Acciones de productos (listar, create, crear, editar, actualizar, eliminar)
    $controller = new ProductoController();
}

// 6. Ejecutar la acción solicitada
$controller->$action();
?>
