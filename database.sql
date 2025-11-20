-- Base de datos para el proyecto MVC de Productos
-- Ejecutar este script en phpMyAdmin o MySQL

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS mvc1_productos;
USE mvc1_productos;

-- Crear la tabla de productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertar algunos datos de ejemplo
INSERT INTO productos (nombre, precio, descripcion) VALUES
('Laptop Dell Inspiron', 899.99, 'Laptop de 15 pulgadas con procesador Intel i5'),
('Mouse Inalámbrico', 25.50, 'Mouse óptico inalámbrico con receptor USB'),
('Teclado Mecánico', 89.99, 'Teclado mecánico RGB con switches azules'),
('Monitor 24 pulgadas', 199.99, 'Monitor LED Full HD de 24 pulgadas'),
('Auriculares Gaming', 75.00, 'Auriculares con micrófono para gaming');

-- Crear la tabla de usuarios para el sistema de login
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertar un usuario de ejemplo (password: admin123)
INSERT INTO usuarios (username, email, password, nombre) VALUES
('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador');

-- Verificar que los datos se insertaron correctamente
SELECT * FROM productos;
SELECT * FROM usuarios;