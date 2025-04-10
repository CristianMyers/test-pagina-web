<?php
include 'conexion.php';  // Incluir la conexión a la base de datos
session_start();

// Limpiar mensajes previos
$error = "";

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $email = mysqli_real_escape_string($enlace, $_POST['gmail']);
    $password = $_POST['password'];  // Contraseña en texto plano

    // Consultar en la tabla profesores
    $query_profesor = "SELECT * FROM profesores WHERE gmail = '$email' LIMIT 1";
    $result_profesor = mysqli_query($enlace, $query_profesor);

    // Consultar en la tabla coordinadores
    $query_coordinador = "SELECT * FROM coordinadores WHERE email = '$email' LIMIT 1";
    $result_coordinador = mysqli_query($enlace, $query_coordinador);

    // Función para iniciar sesión
    function iniciarSesion($usuario, $rol) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_rol'] = $rol;
        $_SESSION['usuario_cursos'] = isset($usuario['cursos_asignados']) ? $usuario['cursos_asignados'] : ''; // Verificar si el campo existe
        header("Location: secciones.php");
        exit();
    }

    // Validar usuario en "profesores"
    if (mysqli_num_rows($result_profesor) > 0) {
        $usuario = mysqli_fetch_assoc($result_profesor);
        if ($password == $usuario['contraseña']) {
            iniciarSesion($usuario, 'profesor');
        } else {
            $error = "Contraseña incorrecta.";
        }
    }
    // Validar usuario en "coordinadores"
    elseif (mysqli_num_rows($result_coordinador) > 0) {
        $usuario = mysqli_fetch_assoc($result_coordinador);
        if ($password == $usuario['contrasena']) {
            iniciarSesion($usuario, 'coordinador');
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "El correo electrónico no está registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Asistencia de Alumnos</title>
    <link rel="stylesheet" href="http://localhost/sanviator_v2/css/login.css?<?php echo time(); ?>">

</head>


<body>
    <div class="container">
        <div class="logo">
        <img src="/sanviator_v2/imagenes/logosinfondo.png" alt="Logo de Asistencia" />
        </div>
        <h1>Iniciar Sesión</h1>

        <!-- Formulario para el login -->
        <form action="login.php" method="POST">
            <label for="gmail">Gmail:</label>
            <input type="text" id="gmail" name="gmail" placeholder="Escribe tu gmail" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" placeholder="Escribe tu contraseña" required>

            <button type="submit">Ingresar</button>

            <!-- Mostrar mensaje de error -->
            <?php if (!empty($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>

</html>
