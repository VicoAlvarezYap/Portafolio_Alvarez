<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Portafolio | Ana Victoria Alvarez Yapura</title>
   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/Proyectos/Portafolio/Estilos/inicio.css">
</head>
<body>


    <nav class="navbar">
        <button id="hamburger-toggle" class="hamburger-btn" aria-label="Abrir menú">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        <div class="navbar-brand">
            <a href="index.php?action=inicio" class="brand-name">Ana Victoria Alvarez Yapura</a>
        </div>

        <div id="nav-menu" class="nav-menu">
            <ul class="nav-links">
                <li><a href="index.php?action=inicio">Inicio</a></li>
                <li><a href="index.php?action=estudios">Educación</a></li>
                <li><a href="index.php?action=inicio#skills">Skills</a></li>
                <li><a href="index.php?action=inicio#contacto">Contactos</a></li>
                
                <?php if (isset($_SESSION['username']) || (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true)): ?>
                    <li><a href="index.php?action=estudios" class="admin-link">⚙️ Admin</a></li>
                    <li><a href="index.php?action=logout" style="color: #ff4d4d;">🚪 Salir</a></li>
                <?php else: ?>
                    <li><a href="index.php?action=login" class="login-link">👤 Iniciar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </div>

    </nav>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
    const hamburgerBtn = document.getElementById('hamburger-toggle');
    const navMenu = document.getElementById('nav-menu');

    if (hamburgerBtn && navMenu) {
        
        hamburgerBtn.addEventListener('click', () => {
            hamburgerBtn.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                hamburgerBtn.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
    }
});
    </script>
</body>
</html>