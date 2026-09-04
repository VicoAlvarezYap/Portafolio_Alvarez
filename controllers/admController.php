<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/user.php";

class admController {
    private $userModel;

    public function __construct() {
    global $pdo;
    $this->userModel = new user($pdo);
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

public function authenticate() {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $usuario = $this->userModel->getByUsername($username);

    if ($usuario && $password === $usuario['password']) {
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

 
    public function login() {
        // si el usuario ya ingreso lo redicciona a la parte de edicion
        if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true) {
            header("Location: index.php?action=index");
            exit;
        }

        require __DIR__ . "/../views/auth/login.php";
    }


    // Cierra la sesión
    public function logout() {
        // Destruir la sesión y redirigir al formulario de ingreso
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}