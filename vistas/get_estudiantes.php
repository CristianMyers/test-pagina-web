<?php
include 'conexion.php';

if (isset($_GET['curso_id'])) {
    $curso_id = intval($_GET['curso_id']);

    $query = "SELECT id, nombre FROM estudiantes WHERE curso_id = $curso_id";
    $result = mysqli_query($enlace, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div>
                    <input type='checkbox' name='estudiantes[]' value='{$row['id']}'> {$row['nombre']}
                </div>";
        }
    } else {
        echo "<p>No hay estudiantes en este curso.</p>";
    }
}
?>
