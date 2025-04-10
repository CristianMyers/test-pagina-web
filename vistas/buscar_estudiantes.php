<?php
include 'conexion.php';

$curso_id = isset($_POST['curso']) ? $_POST['curso'] : '';
$asignatura_id = isset($_POST['asignatura']) ? $_POST['asignatura'] : '';
$rut = isset($_POST['rut']) ? trim($_POST['rut']) : '';
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';

$query = "SELECT e.id, e.rut, e.nombre, c.nombre AS curso, a.nombre AS asignatura, ea.asignatura_id
    FROM estudiantes e
    JOIN cursos c ON e.curso_id = c.id
    JOIN estudiantes_asignaturas ea ON e.id = ea.estudiante_id
    JOIN asignaturas a ON ea.asignatura_id = a.id
    WHERE ('$curso_id' = '' OR e.curso_id = '$curso_id')
    AND ('$asignatura_id' = '' OR ea.asignatura_id = '$asignatura_id')
    AND ('$rut' = '' OR e.rut LIKE '%$rut%')
    AND ('$nombre' = '' OR e.nombre LIKE '%$nombre%')";

$result = mysqli_query($enlace, $query);

if (mysqli_num_rows($result) > 0) {
    while ($est = mysqli_fetch_assoc($result)) {
        $id = $est['id'];
        $asig_id = $est['asignatura_id'];
        echo "<tr>
            <td>{$est['rut']}</td>
            <td>{$est['nombre']}</td>
            <td>{$est['asignatura']}</td>
            <td>{$est['curso']}</td>
            <td>
                <label>
                    <input type='checkbox' name='asistencia[{$id}][{$asig_id}][estado]' value='no' onchange='toggleJustificacion(this)'>
                    No asistió
                </label>
                <div class='justificacion' style='display: none; margin-top: 5px;'>
                    <label>¿Justificó?</label>
                    <select name='asistencia[{$id}][{$asig_id}][justificado]'>
                        <option value='no'>No</option>
                        <option value='si'>Sí</option>
                    </select>
                </div>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No hay estudiantes para el filtro seleccionado.</td></tr>";
}
?>
