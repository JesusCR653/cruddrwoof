<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_canino = mysqli_real_escape_string($conexion, $_POST['id_canino'] ?? '');
    $fecha     = mysqli_real_escape_string($conexion, $_POST['fecha'] ?? '');
    $hora      = mysqli_real_escape_string($conexion, $_POST['hora'] ?? '');
    $repetir   = mysqli_real_escape_string($conexion, $_POST['repetir'] ?? '');
    $motivo    = mysqli_real_escape_string($conexion, $_POST['motivo'] ?? '');

    if (!$id_canino || !$fecha || !$hora || !$motivo) {
        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
        exit;
    }

    $query = "INSERT INTO recordatorios (fecha, hora, repetir, motivo, id_canino) VALUES ('$fecha', '$hora', '$repetir', '$motivo', '$id_canino')";

    if (mysqli_query($conexion, $query)) {
        echo json_encode(['status' => 'success', 'message' => '¡Recordatorio guardado correctamente!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conexion)]);
    }
}
?>