<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_rol'])) {
    header("Location: login.php");
    exit();
}

$rol = $_SESSION['usuario_rol'];
$usuarioNombre = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : 'Usuario';

// Obtener cursos y asignaturas
$query_cursos = "SELECT * FROM cursos";
$result_cursos = mysqli_query($enlace, $query_cursos);

$query_asignaturas = "SELECT * FROM asignaturas";
$result_asignaturas = mysqli_query($enlace, $query_asignaturas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Enseñanza Media - Registro de Ausentes</title>
    <link rel="stylesheet" href="http://localhost/sanviator_v2/css/tercerciclo.css?<?php echo time(); ?>">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <!-- Ícono hamburguesa -->
    <div class="menu-toggle" onclick="toggleSidebar()">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>

    <h1 class="navbar-text">Fundación Colegio San Viator</h1>

    <!-- Logo a la derecha -->
    <img src="/sanviator_v2/imagenes/logosinfondo.png" alt="Logo" class="navbar-logo">
</nav>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-container">
        <div class="close-container">
            <span class="close-btn" onclick="toggleSidebar()">✖</span>
        </div>
        <div class="user-info"><?php echo htmlspecialchars($usuarioNombre); ?></div>
        <button onclick="window.location.href='secciones.php'">Inicio</button>
        <?php if ($rol == 'coordinador'): ?>
            <button onclick="window.location.href='ausentes.php'">Ausentes</button>
        <?php endif; ?>
        <button onclick="window.location.href='pruebas.php'">Crear Prueba</button>
        <button onclick="window.location.href='logout.php'">Cerrar Sesión</button>
    </div>
</div>

<!-- Contenido Principal -->
<div class="container">
    <h1>Enseñanza Media - Registro de Ausentes</h1>

    <!-- Formulario de búsqueda -->
    <form id="filtro-form">
        <div class="form-group">
            <label for="curso">Curso:</label>
            <select name="curso" id="curso">
                <option value="">Todos</option>
                <?php while ($curso = mysqli_fetch_assoc($result_cursos)) {
                    echo "<option value='{$curso['id']}'>{$curso['nombre']}</option>";
                } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="asignatura">Asignatura:</label>
            <select name="asignatura" id="asignatura">
                <option value="">Todas</option>
                <?php while ($asignatura = mysqli_fetch_assoc($result_asignaturas)) {
                    echo "<option value='{$asignatura['id']}'>{$asignatura['nombre']}</option>";
                } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="rut">Buscar por RUT:</label>
            <input type="text" name="rut" id="rut">
        </div>

        <div class="form-group">
            <label for="nombre">Buscar por Nombre:</label>
            <input type="text" name="nombre" id="nombre">
        </div>
    </form>

    <!-- Tabla de estudiantes -->
    <form method="POST" action="guardar_asistencia.php">
        <div id="tabla-estudiantes">
            <table>
                <thead>
                    <tr>
                        <th>RUT</th>
                        <th>Nombre</th>
                        <th>Asignatura</th>
                        <th>Curso</th>
                        <th>Asistencia</th>
                        <th>Justificación</th>
                    </tr>
                </thead>
                <tbody id="tabla-body">
                    <!-- Aquí se cargan los datos con AJAX -->
                </tbody>
            </table>
        </div>

        <div style="text-align: right; margin-top: 20px;">
            <button type="submit" name="guardar" class="btn-guardar">Guardar Asistencias</button>
        </div>
    </form>
</div>

<script>
// Función para alternar la visibilidad de la sidebar
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('visible');
}

// Función para alternar la visibilidad de la justificación
function toggleJustificacion(checkbox) {
    const justificacion = checkbox.closest('td').querySelector('.justificacion');
    justificacion.style.display = checkbox.checked ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filtro-form');
    const tablaBody = document.getElementById('tabla-body');
    const inputs = form.querySelectorAll('input, select');
    let timeout = null;

    // Función para obtener los estudiantes
    function fetchEstudiantes() {
        const formData = new FormData(form);
        fetch('buscar_estudiantes.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(html => {
            tablaBody.innerHTML = html;
        });
    }

    // Escucha cambios en todos los filtros con pequeño retardo (300ms)
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(fetchEstudiantes, 300);
        });
    });

    // Cargar estudiantes al iniciar
    fetchEstudiantes();
});
</script>

</body>
</html>
