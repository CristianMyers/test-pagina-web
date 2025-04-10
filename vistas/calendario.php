<?php
include 'conexion.php';

// Verificar si se han enviado datos para agregar un nuevo evento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = mysqli_real_escape_string($enlace, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($enlace, $_POST['descripcion']);
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Agregar el evento a la base de datos
    $query = "INSERT INTO eventos (titulo, descripcion, fecha_inicio, fecha_fin)
                VALUES ('$titulo', '$descripcion', '$fecha_inicio', '$fecha_fin')";
    if (mysqli_query($enlace, $query)) {
        echo "Evento agregado correctamente";
    } else {
        echo "Error al agregar evento: " . mysqli_error($enlace);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Eventos</title>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.css" rel="stylesheet">
    <style>
        /* Ajusta el tamaño del calendario */
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<!-- Formulario para agregar evento -->
<h3>Agregar Evento</h3>
<form id="form-agregar-evento" method="POST">
    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo" required><br>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion" required></textarea><br>

    <label for="fecha_inicio">Fecha de Inicio:</label>
    <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" required><br>

    <label for="fecha_fin">Fecha de Fin:</label>
    <input type="datetime-local" id="fecha_fin" name="fecha_fin" required><br>

    <button type="submit">Agregar Evento</button>
</form>

<!-- Calendario FullCalendar -->
<div id="calendar"></div>

<!-- FullCalendar JS y dependencias -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.js"></script>

<script>
// Inicialización de FullCalendar
$(document).ready(function() {
    // Cargar eventos desde el servidor
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: 'cargar_eventos.php', // Archivo PHP que carga los eventos

        // Función para manejar el clic en un día del calendario
        dayClick: function(date, jsEvent, view) {
            // Mostrar formulario de evento
            $('#titulo').val('');
            $('#descripcion').val('');
            $('#fecha_inicio').val(date.format());
            $('#fecha_fin').val(date.format());

            // Mostrar el formulario de agregar evento
            $('#form-agregar-evento').show();
        },

        // Configuración de eventos: crear, editar, eliminar
        editable: true,
        droppable: true, // Permite arrastrar los eventos
    });
});
</script>

</body>
</html>
