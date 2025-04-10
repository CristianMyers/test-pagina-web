<?php 
include 'conexion.php';
session_start();  // Asegúrate de iniciar la sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir al login si no está logueado
    header('Location: login.php');
    exit();
}

// Obtener el nombre del usuario desde la sesión
$nombreUsuario = $_SESSION['usuario_nombre']; // Suponiendo que guardas el nombre en esta variable

// Obtener asignaturas y cursos desde la base de datos
$asignaturas = mysqli_query($enlace, "SELECT * FROM asignaturas");
$cursos = mysqli_query($enlace, "SELECT * FROM cursos");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Prueba</title>
    <link rel="stylesheet" href="http://localhost/sanviator_v2/css/pruebas.css?<?php echo time(); ?>">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="menu-toggle" onclick="toggleSidebar()">
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="navbar-text">Fundación Colegio San Viator</div>
    <div class="logo">
        <!-- Aquí puedes colocar el logo si es necesario -->
        <img src="/sanviator_v2/imagenes/logosinfondo.png" alt="Logo" class="logo">
    </div>
</nav>

<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div class="close-container">
        <button class="close-btn" onclick="toggleSidebar()">X</button>
    </div>
    <div class="user-info">
        <!-- Solo el nombre del usuario -->
        <p><?php echo htmlspecialchars($nombreUsuario); ?></p>
    </div>
    <button onclick="window.location.href='secciones.php'">Inicio</button>
    <button onclick="window.location.href='ausentes.php'">Ausentes</button>
    <button onclick="window.location.href='ver_pruebas.php'">Pruebas Creadas</button>
    <button onclick="window.location.href='cerrar_sesion.php'">Cerrar sesión</button>
</div>

<!-- Contenido principal -->
<div class="container">
    <div class="form-container">
        <h1>Crear Prueba</h1>
        <form id="formPrueba" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nombre de la Prueba:</label>
                <input type="text" name="nombre" required>
            </div>

            <div class="form-group">
                <label>Asignatura:</label>
                <select name="asignatura" required>
                    <option value="">Seleccione</option>
                    <?php while ($row = mysqli_fetch_assoc($asignaturas)) {
                        echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                    } ?>
                </select>
            </div>

            <div class="form-group">
                <label>Curso:</label>
                <select name="curso" id="cursoSelect" required>
                    <option value="">Seleccione</option>
                    <?php while ($row = mysqli_fetch_assoc($cursos)) {
                        echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                    } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Fecha de la Prueba:</label>
                <input type="date" name="fecha" required>
            </div>
            <!-- Sección para cargar un archivo -->
            <div class="form-group">
                <label for="archivo">Cargar Archivo:</label>
                <input type="file" name="archivo" id="archivo" accept=".pdf,.docx,.xlsx" required>
            </div>

            <button type="submit" class="btn-crear">Crear Prueba</button>
        </form>
    </div>
</div>

<script>
document.getElementById("formPrueba").addEventListener("submit", function(event) {
    event.preventDefault();
    let formData = new FormData(this);

    fetch('guardar_prueba.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        location.reload(); // Recarga la página para ver la prueba creada
    })
    .catch(error => console.error("Error al guardar la prueba:", error));
});

// Función para mostrar/ocultar el sidebar
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('visible');
}
</script>

</body>
</html>
