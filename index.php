<?php
// PUNTO DE ENTRADA al proyecto MVC
// Este archivo es el "router" simple que maneja las rutas

// 1. Incluir la configuración de base de datos
require_once 'config/database.php';

// 2. Incluir el modelo (lógica de datos)
require_once 'models/Producto.php';

// 3. Incluir el controlador (lógica de negocio)
require_once 'controllers/ProductoController.php';

// 4. Obtener la acción desde la URL (por defecto es 'listar')
$action = $_GET['action'] ?? 'listar';

// 5. Crear instancia del controlador
$controller = new ProductoController();

// 6. Ejecutar la acción solicitada
// Las acciones disponibles son: 'listar', 'create', 'crear'
$controller->$action();
?>
