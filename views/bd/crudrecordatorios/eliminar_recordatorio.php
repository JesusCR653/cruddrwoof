<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($conexion, $_POST['id_recordatorio'] ?? '');

    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado.']);
        exit;
    }

    if (mysqli_query($conexion, "DELETE FROM recordatorios WHERE id_recordatorio = '$id'")) {
        echo json_encode(['status' => 'success', 'message' => '¡Recordatorio eliminado!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conexion)]);
    }
}
?>