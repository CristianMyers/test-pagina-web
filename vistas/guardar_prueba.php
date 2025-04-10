<?php
include 'conexion.php';

if (
    isset($_POST['nombre'], $_POST['asignatura'], $_POST['curso'], $_POST['fecha']) &&
    isset($_FILES['archivo'])
) {
    $nombre = mysqli_real_escape_string($enlace, $_POST['nombre']);
    $asignatura_id = $_POST['asignatura'];
    $curso_id = $_POST['curso'];
    $fecha = $_POST['fecha'];
    $archivo = $_FILES['archivo'];

    $archivo_nombre = basename($archivo['name']);
    $archivo_tmp = $archivo['tmp_name'];

    // Ruta absoluta para subir el archivo
    $archivo_destino = __DIR__ . '/../uploads/' . $archivo_nombre;
    // Ruta relativa para guardar en la base de datos
    $archivo_relativo = 'uploads/' . $archivo_nombre;

    if (move_uploaded_file($archivo_tmp, $archivo_destino)) {
        // Usamos NOW() para obtener fecha y hora exacta del servidor
        $query = "INSERT INTO pruebas (nombre, asignatura_id, curso_id, fecha_creacion, archivo) 
                    VALUES ('$nombre', '$asignatura_id', '$curso_id', NOW(), '$archivo_relativo')";

        if (mysqli_query($enlace, $query)) {
            echo json_encode(['message' => 'Prueba creada con éxito.']);
        } else {
            echo json_encode(['message' => 'Error al crear la prueba.']);
        }
    } else {
        echo json_encode(['message' => 'Error al subir el archivo.']);
    }
} else {
    echo json_encode(['message' => 'Datos incompletos.']);
}