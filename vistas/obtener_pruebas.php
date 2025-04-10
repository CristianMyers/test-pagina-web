<?php
include 'conexion.php';

if (isset($_POST['curso_id']) && isset($_POST['asignatura_id'])) {
    $curso_id = $_POST['curso_id'];
    $asignatura_id = $_POST['asignatura_id'];

    // Consulta para obtener las pruebas según el curso y la asignatura
    $query_pruebas = "
        SELECT 
            p.id,
            p.nombre,
            p.archivo,
            p.fecha_creacion
        FROM pruebas p
        WHERE p.curso_id = $curso_id AND p.asignatura_id = $asignatura_id
    ";

    $result_pruebas = mysqli_query($enlace, $query_pruebas);

    $pruebas = [];
    while ($row = mysqli_fetch_assoc($result_pruebas)) {
        $pruebas[] = $row;
    }

    // Devolver las pruebas como JSON
    echo json_encode($pruebas);
}
?>
