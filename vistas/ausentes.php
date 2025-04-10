<?php
include 'conexion.php';

// Consulta para obtener los estudiantes ausentes
$query_ausentes = "
    SELECT 
        a.id AS ausencia_id, 
        c.nombre AS curso_nombre,
        e.nombre AS estudiante_nombre, 
        asig.nombre AS asignatura_nombre, 
        a.fecha, 
        a.justificado,
        e.id AS estudiante_id,
        asig.id AS asignatura_id,
        c.id AS curso_id
    FROM ausentes a
    INNER JOIN estudiantes e ON a.estudiante_id = e.id
    INNER JOIN cursos c ON e.curso_id = c.id
    INNER JOIN asignaturas asig ON a.asignatura_id = asig.id
";
$result_ausentes = mysqli_query($enlace, $query_ausentes);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Ausentes</title>
    <link rel="stylesheet" href="http://localhost/sanviator_v2/css/ausentes.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>
<nav class="navbar">
    <a href="secciones.php">
        <img src="/sanviator_v2/imagenes/logosinfondo.png" alt="Menú" class="menu-icon">
    </a>
    <span class="navbar-text">Fundación Colegio San Viator</span>
</nav>

<div class="container">
    <h2>Registro de Ausentes</h2>

    <!-- Filtros -->
    <div class="filtros" style="margin-bottom: 20px;">
        <label for="filtroCurso">Filtrar por Curso:</label>
        <select id="filtroCurso">
            <option value="">Todos</option>
        </select>

        <label for="filtroAsignatura" style="margin-left: 20px;">Filtrar por Asignatura:</label>
        <select id="filtroAsignatura">
            <option value="">Todas</option>
        </select>
    </div>

    <table id="tablaAusentes" class="display">
        <thead>
            <tr>
                <th>Curso</th>
                <th>Nombre del Estudiante</th>
                <th>Asignatura</th>
                <th>Fecha</th>
                <th>Justificación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_ausentes)) { ?>
                <tr 
                    data-curso-id="<?= $row['curso_id'] ?>" 
                    data-asignatura-id="<?= $row['asignatura_id'] ?>"
                    data-estudiante-id="<?= $row['estudiante_id'] ?>"
                >
                    <td><?= htmlspecialchars($row['curso_nombre']) ?></td>
                    <td><?= htmlspecialchars($row['estudiante_nombre']) ?></td>
                    <td><?= htmlspecialchars($row['asignatura_nombre']) ?></td>
                    <td><?= htmlspecialchars($row['fecha']) ?></td>
                    <td><?= htmlspecialchars($row['justificado']) ?></td>
                    <td>
                        <button class='reagendar' data-id='<?= $row['ausencia_id'] ?>'>Reagendar</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="ventana-emergente" id="modalReagendar">
    <div class="ventana-contenido">
        <span class="cerrar">&times;</span>
        <h3>Reagendar Prueba</h3>
        <form id="formReagendar" method="POST" action="enviar_correo.php">
            <label for="rut">Curso del estudiante:</label>
            <input type="text" id="rut" name="rut" readonly>

            <label for="nombre">Nombre del estudiante:</label>
            <input type="text" id="nombre" name="nombre" readonly>

            <label for="asignatura">Asignatura:</label>
            <input type="text" id="asignatura" name="asignatura" readonly>

            <label for="fecha">Fecha de la ausencia:</label>
            <input type="text" id="fecha" name="fecha" readonly>

            <label for="motivo">Justificado:</label>
            <input type="text" id="motivo" name="motivo" readonly>

            <label for="pruebaSelect">Seleccionar Prueba:</label>
            <select id="pruebaSelect" name="pruebaSelect">
                <option value="">Seleccione una prueba</option>
            </select>

            <label for="sitioExamen">Sitio de Examen:</label>
            <input type="text" id="sitioExamen" name="sitioExamen" required>

            <label for="email">Correo del estudiante:</label>
            <input type="email" id="email" name="email" required>

            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" rows="4" placeholder="Escribe un mensaje..."></textarea>

            <label for="fechaReagendacion">Fecha de Reagendación:</label>
            <input type="date" id="fechaReagendacion" name="fechaReagendacion" required>

            <button type="submit">Enviar Reagendamiento</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    const tabla = $('#tablaAusentes').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        initComplete: function () {
            this.api().columns([0, 2]).every(function (index) {
                const column = this;
                const select = index === 0 ? $('#filtroCurso') : $('#filtroAsignatura');

                column.data().unique().sort().each(function (d) {
                    select.append(`<option value="${d}">${d}</option>`);
                });

                select.on('change', function () {
                    const val = $.fn.dataTable.util.escapeRegex($(this).val());
                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                });
            });
        }
    });

    document.querySelectorAll('.reagendar').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            document.getElementById('rut').value = row.children[0].textContent;
            document.getElementById('nombre').value = row.children[1].textContent;
            document.getElementById('asignatura').value = row.children[2].textContent;
            document.getElementById('fecha').value = row.children[3].textContent;
            document.getElementById('motivo').value = row.children[4].textContent;
            const cursoId = row.getAttribute('data-curso-id');
            const asignaturaId = row.getAttribute('data-asignatura-id');

            // Cargar pruebas por AJAX
            $.ajax({
                url: 'obtener_pruebas.php', // Cambiar a obtener_pruebas.php
                type: 'POST',
                data: {
                    curso_id: cursoId,
                    asignatura_id: asignaturaId
                },
                success: function (response) {
                    const pruebas = JSON.parse(response);
                    const select = document.getElementById('pruebaSelect');
                    select.innerHTML = '<option value="">Seleccione una prueba</option>';
                    pruebas.forEach(function (prueba) {
                        select.innerHTML += `
                            <option value="${prueba.id}">
                                ${prueba.nombre} (${prueba.fecha_creacion}) - Archivo: ${prueba.archivo}
                            </option>
                        `;
                    });
                }
            });

            document.getElementById('modalReagendar').style.display = 'flex';
        });
    });

    document.querySelector('.cerrar').addEventListener('click', function () {
        document.getElementById('modalReagendar').style.display = 'none';
    });

    document.getElementById('modalReagendar').addEventListener('click', function (event) {
        if (event.target === this) {
            this.style.display = 'none';
        }
    });
});
</script>
</body>
</html>
