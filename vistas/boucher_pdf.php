<?php
require_once('../tcpdf/tcpdf.php');

// Asegurarse de que los datos son recibidos correctamente
$rut = $_GET['rut'] ?? '';
$nombre = $_GET['nombre'] ?? '';
$asignatura = $_GET['asignatura'] ?? '';
$fecha = $_GET['fecha'] ?? '';
$motivo = $_GET['motivo'] ?? '';
$sitioExamen = $_GET['sitioExamen'] ?? '';
$email = $_GET['email'] ?? '';
$fechaReagendacion = $_GET['fechaReagendacion'] ?? '';
$mensaje = $_GET['mensaje'] ?? '';


// Crear el objeto TCPDF
$pdf = new TCPDF();
$pdf->AddPage();

// Configuración del PDF (puedes ajustar los detalles)
$pdf->SetFont('Helvetica', '', 12);

// Escribir el contenido
$pdf->Cell(0, 10, "Detalles del Reagendamiento", 0, 1, 'C');
$pdf->Ln(10);
$pdf->Cell(0, 10, "Estudiante: $nombre (RUT: $rut)", 0, 1);
$pdf->Cell(0, 10, "Asignatura: $asignatura", 0, 1);
$pdf->Cell(0, 10, "Fecha de la ausencia: $fecha", 0, 1);
$pdf->Cell(0, 10, "justidicado: $motivo", 0, 1);
$pdf->Cell(0, 10, "Sitio de examen: $sitioExamen", 0, 1);
$pdf->Cell(0, 10, "Fecha de reagendación: $fechaReagendacion", 0, 1);
$pdf->Cell(0, 10, "Mensaje: $mensaje", 0, 1);

// Output del PDF al navegador
$pdf->Output('reagendamiento.pdf', 'I');
?>
