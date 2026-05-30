<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_recordatorio = mysqli_real_escape_string($conexion, $_POST['id_recordatorio'] ?? '');
    $fecha           = mysqli_real_escape_string($conexion, $_POST['fecha'] ?? '');
    $hora            = mysqli_real_escape_string($conexion, $_POST['hora'] ?? '');
    $repetir         = mysqli_real_escape_string($conexion, $_POST['repetir'] ?? '');
    $motivo          = mysqli_real_escape_string($conexion, $_POST['motivo'] ?? '');

    if (!$id_recordatorio || !$fecha || !$hora || !$motivo) {
        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
        exit;
    }

    $query = "UPDATE recordatorios SET fecha='$fecha', hora='$hora', repetir='$repetir', motivo='$motivo' WHERE id_recordatorio='$id_recordatorio'";

    if (mysqli_query($conexion, $query)) {
        echo json_encode(['status' => 'success', 'message' => '¡Recordatorio actualizado correctamente!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conexion)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
}
?>