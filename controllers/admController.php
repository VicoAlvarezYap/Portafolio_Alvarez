<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/user.php";

class admController {
    private $userModel;

    public function __construct() {
        global $conexion;
        $this->userModel = new user($conexion);
        
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

 
    public function login() {
        // si el usuario ya ingreso lo redicciona a la parte de edicion
        if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true) {
            header("Location: index.php?action=index");
            exit;
        }

        require __DIR__ . "/../views/auth/login.php";
    }

    // procesa el envio de credencial (verificar)
    public function authenticate() {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "Por favor completa todos los campos.";
            header("Location: index.php?action=login");
            exit;
        }

       
        $usuario = $this->userModel->getByUsername($username);

        // valida 
        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['admin_logged'] = true;
            $_SESSION['admin_id'] = $usuario['id'];
            $_SESSION['admin_username'] = $usuario['username'];

            header("Location: index.php?action=index");
            exit;
        } else {
            $_SESSION['error'] = "Usuario o contraseña incorrectos.";
            header("Location: index.php?action=login");
            exit;
        }
    }

    // Cierra la sesión
    public function logout() {
        // Destruir la sesión y redirigir al formulario de ingreso
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}