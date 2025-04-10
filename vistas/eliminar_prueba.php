<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "DELETE FROM pruebas WHERE id = ?";
    $stmt = $enlace->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Prueba eliminada con éxito"]);
    } else {
        echo json_encode(["message" => "Error al eliminar la prueba"]);
    }
    $stmt->close();
}
?>
