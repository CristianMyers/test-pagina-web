<?php 
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_rol'])) {
    header("Location: login.php");
    exit();
}

$rol = $_SESSION['usuario_rol'];
$usuarioNombre = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : 'Usuario';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla Dividida</title>
    <link rel="stylesheet" href="http://localhost/sanviator_v2/css/secciones.css?<?php echo time(); ?>">
</head>
<body>

    <!-- Navbar -->
<nav class="navbar">
    <!-- Icono Hamburguesa -->
    <div class="menu-toggle" onclick="toggleSidebar()">
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <h1 class="navbar-text">Fundación Colegio San Viator</h1>

    <!-- Logo del colegio a la derecha -->
    <img src="/sanviator_v2/imagenes/logosinfondo.png" alt="Logo" class="logo">
</nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="close-container">
            <span class="close-btn" onclick="toggleSidebar()">✖</span>
        </div>
        <div class="user-info"><?php echo htmlspecialchars($usuarioNombre); ?></div>
        <?php if ($rol == 'coordinador'): ?>
            <button onclick="window.location.href='ausentes.php'">Ausentes</button>
        <?php endif; ?>
        <button onclick="window.location.href='logout.php'">Cerrar Sesión</button>
    </div>

    <!-- Contenido principal -->
    <div class="container">
        <button class="button" onclick="location.href='primerciclo.php?ciclo=primer_ciclo'">
            <img src="/sanviator_v2/imagenes/primerciclo.avif" alt="Imagen 1">
            <div class="text">Primer ciclo</div>
        </button>
        <button class="button" onclick="location.href='segundociclo.php?ciclo=segundo_ciclo'">
            <img src="/sanviator_v2/imagenes/segundociclo.jpg" alt="Imagen 2">
            <div class="text">Segundo ciclo</div>
        </button>
        <button class="button" onclick="location.href='tercerciclo.php?ciclo=tercer_ciclo'">
            <img src="/sanviator_v2/imagenes/tercerciclo.jpg" alt="Imagen 3">
            <div class="text">Enseñanza Media</div>
        </button>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('visible');
        }
    </script>

</body>
</html>
