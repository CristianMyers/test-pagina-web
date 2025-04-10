<?php
include 'conexion.php';

if (isset($_POST['asistencia'])) {
    foreach ($_POST['asistencia'] as $estudiante_id => $asignaturas) {
        foreach ($asignaturas as $asignatura_id => $datos) {
            // Verificar si la asistencia fue marcada como "no asistió"
            $estado_asistencia = isset($datos['estado']) ? $datos['estado'] : null; // 'si' o 'no'

            // Solo procesar si la asistencia fue marcada como "no" (ausente)
            if ($estado_asistencia === 'no') {
                // Verificar si la ausencia está justificada
                $justificado = isset($datos['justificado']) && $datos['justificado'] === 'si' ? 'sí' : 'no';

                // Obtener la fecha actual
                $fecha = date('Y-m-d');

                // Insertar en la base de datos solo si la asistencia fue "no"
                $query = "INSERT INTO ausentes (estudiante_id, asignatura_id, fecha, justificado)
                            VALUES ('$estudiante_id', '$asignatura_id', '$fecha', '$justificado')";
                mysqli_query($enlace, $query);
            }
        }
    }

    echo "<script>alert('Asistencias guardadas correctamente.'); window.location.href='primerciclo.php';</script>";
} else {
    echo "<script>alert('No se registraron inasistencias.'); window.location.href='primerciclo.php';</script>";
}
?>
