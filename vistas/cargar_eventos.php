<?php
include 'conexion.php';

// Consulta para obtener los eventos de la base de datos
$query = "SELECT id, titulo, descripcion, fecha_inicio, fecha_fin FROM eventos";
$result = mysqli_query($enlace, $query);

$eventos = [];

while ($row = mysqli_fetch_assoc($result)) {
    $eventos[] = [
        'id' => $row['id'],
        'title' => $row['titulo'],
        'description' => $row['descripcion'],
        'start' => $row['fecha_inicio'],
        'end' => $row['fecha_fin']
    ];
}

// Devolver los eventos en formato JSON
echo json_encode($eventos);
?>
