<?php

session_start();

$action = $_GET['action'] ?? 'inicio';

function requerirAdmin() {
    if (!isset($_SESSION['username'])) {
        header('Location: index.php?action=login');
        exit;
    }
}

switch ($action) {

    case 'estudios':
        require_once __DIR__ . '/../../controllers/estudiosController.php';
        $controller = new estudiosController();
        $controller->index();
        break;

    case 'contacto_post':
        // Procesa el envío del formulario usando el controlador
        require_once __DIR__ . '/../../controllers/contactoController.php';
        $controller = new contactoController();
        $controller->enviarEmail();
        break;

    case 'login':
        require_once __DIR__ . '/../login.php'; 
        break;

    case 'login_post':
        require_once __DIR__ . '/../adm/login_post.php';
        break;

    case 'logout':
        session_unset();
        session_destroy();
        header('Location: index.php?action=inicio');
        break;

    case 'inicio':
    default:
        
        require_once __DIR__ . '/../inicio.php';
        break;
}