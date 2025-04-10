<?php
session_start();
require '../src/PHPMailer.php';
require '../src/SMTP.php';
require '../src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $rut               = $_POST['rut'] ?? '';
    $nombre            = $_POST['nombre'] ?? '';
    $asignatura        = $_POST['asignatura'] ?? '';
    $fecha             = $_POST['fecha'] ?? '';
    $motivo            = $_POST['motivo'] ?? '';
    $sitioExamen       = $_POST['sitioExamen'] ?? '';
    $email             = $_POST['email'] ?? '';
    $fechaReagendacion = $_POST['fechaReagendacion'] ?? '';
    $mensaje           = $_POST['mensaje'] ?? '';

    // Guardar los datos en sesión para el boucher
    $_SESSION['rut'] = $rut;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['asignatura'] = $asignatura;
    $_SESSION['fecha'] = $fecha;
    $_SESSION['motivo'] = $motivo;
    $_SESSION['sitioExamen'] = $sitioExamen;
    $_SESSION['email'] = $email;
    $_SESSION['fechaReagendacion'] = $fechaReagendacion;
    $_SESSION['mensaje'] = $mensaje;

    // Enviar correo
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'testsanviatormundaca@gmail.com';
        $mail->Password = 'ymzb ccpd svph cgub'; // Contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('testsanviatormundaca@gmail.com', 'Fundación Colegio San Viator');
        $mail->addAddress($email, $nombre);
        $mail->addReplyTo('testsanviatormundaca@gmail.com', 'Fundación Colegio San Viator');

        $mail->isHTML(true);
        $mail->Subject = 'Reagendamiento de Examen';
        $mail->Body    = "
            Estimado/a $nombre,<br><br>
            Le informamos que se ha reagendado su examen de <strong>$asignatura</strong> originalmente el <strong>$fecha</strong>.<br>
            Nueva fecha: <strong>$fechaReagendacion</strong><br>
            Lugar: <strong>$sitioExamen</strong><br>
            Motivo de ausencia original: $motivo<br><br>
            $mensaje<br><br>
            Atentamente,<br>
            Fundación Colegio San Viator
        ";

        $mail->send();

        // Redirigir a la vista del boucher
        header('Location: boucher.php');
        exit;

    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>
