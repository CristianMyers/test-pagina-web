<?php
    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $baseDeDatos = "sanviator_v2";

    // Corregir error tipográfico en mysqli_connect
    $enlace = mysqli_connect($servidor, $usuario, $clave, $baseDeDatos);

    // Verificar si la conexión fue exitosa
    if (!$enlace) {
        die("Error de conexión: " . mysqli_connect_error());
    }
?>