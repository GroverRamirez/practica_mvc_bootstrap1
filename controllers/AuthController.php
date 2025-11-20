<?php
//Maneja la autenticacion de usuarios(Login)
class AuthController{
// Propiedad privada para almacenar la instancia del modelo
    private $modelo;
    
    /**
     * Constructor - Inicializa el modelo
     */
    public function __construct(){
        // Creamos una instancia del modelo Usuario
        $this->modelo = new Usuario();
    }

    //MÉTODO: login()
    public function login(){
        // Si el usuario ya está autenticado, redirigir a la lista de productos
        if($this->estaAutenticado()){
            header('Location: ?action=listar');
            exit;
        }

        //si la peticion es POST procesar el Login
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->procesarLogin();
            return;

        }
        // Cargar la vista de login
        $this->cargarVista('Login', []);
    }

    //Metodo RegistrarUsuario
    //Muestra el formulario de Registro
    public function registrar(){
        //cargar la vista de registro
        $this->cargarVista('RegistroUsuario',[]);
    }
    //Metodo para procesar registro
    public function procesarRegistro(){
        //verificar que la peticion sea POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Obtener y limpiar datos del formulario
            $nombre = trim($_POST['nombre'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirmarPassword = trim($_POST['confirmar_password'] ?? '');

            //Validar que los datos no esten vacios
            if(empty($nombre) || empty($username) || empty($email) || empty($password) || empty($confirmarPassword)){
                $this->cargarVista('RegistroUsuario', [
                    'mensaje' => 'Por favor, completa todos los campos',
                    'tipoMensaje' => 'warning'
                ]);
                return;
            }

            //Validar que las contraseñas coincidan
            if($password !== $confirmarPassword){
                $this->cargarVista('RegistroUsuario', [
                    'mensaje' => 'Las contraseñas no coinciden',
                    'tipoMensaje' => 'danger'
                ]);
                return;
            }

            //Validar longitud mínima de contraseña
            if(strlen($password) < 6){
                $this->cargarVista('RegistroUsuario', [
                    'mensaje' => 'La contraseña debe tener al menos 6 caracteres',
                    'tipoMensaje' => 'warning'
                ]);
                return;
            }

            //Validar formato de email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $this->cargarVista('RegistroUsuario', [
                    'mensaje' => 'El formato del email no es válido',
                    'tipoMensaje' => 'warning'
                ]);
                return;
            }

            //Preparar datos del usuario
            $datosUsuario = [
                'nombre' => $nombre,
                'username' => $username,
                'email' => $email,
                'password' => $password
            ];

            //Crear el usuario
            $resultado = $this->modelo->crear($datosUsuario);
            
            if($resultado){
                //Registro exitoso
                $this->cargarVista('RegistroUsuario', [
                    'mensaje' => 'Usuario registrado exitosamente. Ahora puedes iniciar sesión.',
                    'tipoMensaje' => 'success'
                ]);
            } else {
                //Error al crear usuario (probablemente usuario o email duplicado)
                $this->cargarVista('RegistroUsuario', [
                    'mensaje' => 'Error al registrar usuario. El nombre de usuario o email ya existe.',
                    'tipoMensaje' => 'danger'
                ]);
            }
        } else {
            //Si no es POST, redirigir al formulario de registro
            header('Location: ?action=registrar');
            exit;
        }
    }


    //MÉTODO: procesarLogin()
    private function procesarLogin(){
        //Obtener datos del formulario Login
        $usuario=trim($_POST['username'] ?? '');
        $password=trim($_POST['password'] ?? '');

        //Validar que los datos no esten vacios
        if(empty($usuario) || empty($password)){
            $this->cargarVista('Login',[
                'mensaje'=>'Por favor, completa todos los campos',
                'tipoMensaje'=>'warning'
            ]);
            return;
        }

        //Intentar Autenticar
        //El método autenticar() ya devuelve los datos del usuario si las credenciales son correctas
        $datosUsuario = $this->modelo->autenticar($usuario, $password);
        
        if($datosUsuario){
            //iniciar sesion
            if(session_status()===PHP_SESSION_NONE){
                session_start();
            }
            //Guardar datos del usuario en la sesion
            $_SESSION['usuario'] = $datosUsuario;

            //redirigir a la lista de productos
            header('Location: ?action=listar');
            exit;
        } else {
            //Credenciales incorrectas
            $this->cargarVista('Login',[
                'mensaje'=>'Usuario o contraseña incorrectas',
                'tipoMensaje'=>'danger'
            ]);
        }
    }

    public function estaAutenticado(){
        // Verificar si el usuario está autenticado 
        if(session_status()===PHP_SESSION_NONE){
            session_start();
        }
        return isset($_SESSION['usuario']);
    
    }

    //Metodo Logout()
    public function logout(){
        //iniciar sesion si no esta iniciada
        if(session_status()===PHP_SESSION_NONE){
            session_start();
        }

        //Destruir la sesion
        session_destroy();

        //Redirigir al Login
        header('Location:?action=login');
        exit;
    }

private function cargarVista($vista, $datos = []){

        extract($datos);

        // Capturar el contenido de la vista en una variable
        ob_start();
        include "views/{$vista}.php";
        $contenido = ob_get_clean();

        include "views/layout.php";
    }

}

?>