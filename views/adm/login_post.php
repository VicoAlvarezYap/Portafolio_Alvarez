<?php
// Ubicación: views/adm/login_post.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar la conexión PDO
require_once dirname(__DIR__, 2) . '/config/database.php';

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if (!empty($username) && !empty($password)) {


    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    //contraseña sin encrptar (verificar)
    if ($user && $password === $user['password']) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['rol']      = $user['rol'];

        header('Location: index.php?action=admin_carreras');
        exit;
    } else {
        header('Location: index.php?action=login&error=1');
        exit;
    }

} else {
    header('Location: index.php?action=login&error=vacios');
    exit;
}