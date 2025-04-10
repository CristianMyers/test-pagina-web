<?php
include 'conexion.php';

$query_pruebas = "
    SELECT 
        p.id AS prueba_id, 
        p.nombre AS prueba_nombre, 
        a.nombre AS asignatura_nombre, 
        c.nombre AS curso_nombre, 
        p.archivo 
    FROM pruebas p
    INNER JOIN asignaturas a ON p.asignatura_id = a.id
    INNER JOIN cursos c ON p.curso_id = c.id
";
$result_pruebas = mysqli_query($enlace, $query_pruebas);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pruebas Creadas</title>
    <link rel="stylesheet" href="http://localhost/sanviator_v2/css/ver_pruebas.css?<?php echo time(); ?>">
</head>
<body>

<nav class="navbar">
    <h1>Fundación Colegio San Viator</h1>
    <button class="btn-volver" onclick="window.location.href='primerciclo.php';">Volver</button>
    <a href="pruebas.php" class="btn-ver-pruebas">Crear Prueba</a>
</nav>

<div class="container">
    <h2>Pruebas Creadas</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre de la Prueba</th>
                <th>Asignatura</th>
                <th>Curso</th>
                <th>Archivo</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result_pruebas)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['prueba_nombre']) ?></td>
                    <td><?= htmlspecialchars($row['asignatura_nombre']) ?></td>
                    <td><?= htmlspecialchars($row['curso_nombre']) ?></td>
                    <td>
                        <?php if ($row['archivo']) { ?>
                            <a href="<?= htmlspecialchars($row['archivo']) ?>" download>Descargar</a>
                        <?php } else { ?>
                            No disponible
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
