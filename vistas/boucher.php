<?php
session_start();

// Obtener datos desde la sesión
$rut               = $_SESSION['rut'] ?? '';
$nombre            = $_SESSION['nombre'] ?? '';
$asignatura        = $_SESSION['asignatura'] ?? '';
$fecha             = $_SESSION['fecha'] ?? '';
$motivo            = $_SESSION['motivo'] ?? '';
$sitioExamen       = $_SESSION['sitioExamen'] ?? '';
$email             = $_SESSION['email'] ?? '';
$fechaReagendacion = $_SESSION['fechaReagendacion'] ?? '';
$mensaje           = $_SESSION['mensaje'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boucher de Reagendamiento</title>
    <link rel="stylesheet" href="http://localhost/sanviator_v2/css/recibo.css?<?php echo time(); ?>">
</head>
<body id="top">
    <a href="ausentes.php" id="top-button">↑ Volver</a>

    <div class="container">
        <h2>Detalles del Reagendamiento</h2>

        <p><strong>Estudiante:</strong> <?php echo htmlspecialchars($nombre); ?> (RUT: <?php echo htmlspecialchars($rut); ?>)</p>
        <p><strong>Asignatura:</strong> <?php echo htmlspecialchars($asignatura); ?></p>
        <p><strong>Fecha de la ausencia:</strong> <?php echo htmlspecialchars($fecha); ?></p>
        <p><strong>justificado:</strong> <?php echo htmlspecialchars($motivo); ?></p>
        <p><strong>Sitio de examen:</strong> <?php echo htmlspecialchars($sitioExamen); ?></p>
        <p><strong>Fecha de reagendación:</strong> <?php echo htmlspecialchars($fechaReagendacion); ?></p>
        <p><strong>Mensaje:</strong> <?php echo nl2br(htmlspecialchars($mensaje)); ?></p>

        <br>

        <!-- Botón para imprimir -->
        <button onclick="window.print()">🖨️ Imprimir Boucher</button>

        <!-- Botón para generar PDF -->
        <form action="boucher_pdf.php" method="GET" target="_blank">
            <input type="hidden" name="rut" value="<?php echo $rut; ?>" />
            <input type="hidden" name="nombre" value="<?php echo $nombre; ?>" />
            <input type="hidden" name="asignatura" value="<?php echo $asignatura; ?>" />
            <input type="hidden" name="fecha" value="<?php echo $fecha; ?>" />
            <input type="hidden" name="justificado" value="<?php echo $motivo; ?>" />
            <input type="hidden" name="sitioExamen" value="<?php echo $sitioExamen; ?>" />
            <input type="hidden" name="email" value="<?php echo $email; ?>" />
            <input type="hidden" name="fechaReagendacion" value="<?php echo $fechaReagendacion; ?>" />
            <input type="hidden" name="mensaje" value="<?php echo $mensaje; ?>" />
            <button type="submit">📄 Descargar PDF</button>
        </form>
    </div>
</body>
</html>
