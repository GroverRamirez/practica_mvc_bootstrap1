# 📦 Sistema de Gestión de Productos - MVC con Bootstrap

Sistema CRUD de productos implementado con patrón MVC, PHP y Bootstrap 5.

## 🚀 Características

- ✅ Arquitectura MVC (Modelo-Vista-Controlador)
- ✅ CRUD de productos (Crear, Leer)
- ✅ Bootstrap 5.3.8 + Bootstrap Icons
- ✅ Validación frontend y backend
- ✅ PDO con consultas preparadas (seguridad)
- ✅ Patrón Singleton para conexión BD
- ✅ Diseño responsive y moderno
- ✅ Protección contra XSS e inyección SQL

## 📋 Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- XAMPP, WAMP o servidor web con PHP y MySQL

## 🔧 Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/GroverRamirez/practica_mvc_bootstrap1.git
cd practica_mvc_bootstrap1
```

2. **Crear la base de datos**
```sql
-- Importar el archivo database.sql en phpMyAdmin
-- O ejecutar desde consola MySQL:
mysql -u root -p < database.sql
```

3. **Configurar la conexión**
Editar `config/database.php` con tus credenciales:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'mvc1_productos');
define('DB_USER', 'root');
define('DB_PASS', '');
```

4. **Iniciar el servidor**
```bash
# Opción 1: XAMPP
# Colocar proyecto en C:/xampp/htdocs/
# Acceder a: http://localhost/practica_mvc_bootstrap1/

# Opción 2: Servidor PHP integrado
php -S localhost:8000
```

## 📁 Estructura del Proyecto

```
practica_mvc_bootstrap1/
├── assets/
│   ├── css/
│   │   ├── bootstrap-5.3.8-dist/
│   │   └── style.css
│   ├── js/
│   │   ├── bootstrap-5.3.8-dist/
│   │   └── script.js
│   └── bootstrap-icons-1.13.1/
├── config/
│   └── database.php          # Configuración BD (Singleton)
├── controllers/
│   └── ProductoController.php # Lógica de negocio
├── models/
│   └── Producto.php          # Modelo de datos
├── views/
│   ├── layout.php            # Template principal
│   ├── Show.php              # Vista lista productos
│   └── Create.php            # Vista formulario
├── index.php                 # Punto de entrada (Router)
├── database.sql              # Script SQL
└── README.md
```

## 🎯 Uso

### Rutas disponibles:

- `index.php` o `index.php?action=listar` - Lista de productos
- `index.php?action=create` - Formulario de registro
- `index.php?action=crear` - Procesar creación (POST)

### Ejemplo de uso:

1. Acceder a `http://localhost/practica_mvc_bootstrap1/`
2. Click en "Registrar Nuevo Producto"
3. Llenar el formulario
4. Ver el producto en la lista

## 🛠️ Tecnologías

- **Backend:** PHP 8.x
- **Base de Datos:** MySQL
- **Frontend:** Bootstrap 5.3.8, Bootstrap Icons
- **Arquitectura:** MVC (Model-View-Controller)
- **Seguridad:** PDO Prepared Statements, htmlspecialchars()

## 📝 Patrón MVC

```
Usuario → index.php (Router)
            ↓
     ProductoController (Controlador)
            ↓
       Producto (Modelo) ←→ MySQL
            ↓
      Views (Vistas) → HTML/Bootstrap
```

## 🔒 Seguridad

- ✅ PDO con consultas preparadas (previene SQL Injection)
- ✅ `htmlspecialchars()` en todas las salidas (previene XSS)
- ✅ Validación de datos frontend y backend
- ✅ Filtrado de datos con `trim()` y `floatval()`

## 🎨 Características de UI/UX

- Diseño responsive (mobile-first)
- Alertas auto-dismissibles (5 segundos)
- Validación en tiempo real
- Animaciones suaves
- Estados vacíos informativos
- Iconos Bootstrap Icons

## 📌 Próximas Mejoras

- [ ] Implementar editar productos
- [ ] Implementar eliminar productos
- [ ] Paginación de resultados
- [ ] Búsqueda y filtros
- [ ] Subida de imágenes
- [ ] Autenticación de usuarios

## 👤 Autor

**Grover Ramirez**
- GitHub: [@GroverRamirez](https://github.com/GroverRamirez)

## 📄 Licencia

Este proyecto es de código abierto y está disponible para fines educativos.

---

⭐ Si te gusta este proyecto, dale una estrella en GitHub

