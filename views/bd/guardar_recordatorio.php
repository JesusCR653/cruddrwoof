<?php
include('conexion.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha     = $_POST['fecha'];
    $hora      = $_POST['hora'];
    $repetir   = $_POST['repetir'];
    $motivo    = $_POST['motivo'];
    $id_canino = $_POST['id_canino'];

    $sql = "INSERT INTO recordatorios (fecha, hora, repetir, motivo, id_canino) 
            VALUES ('$fecha', '$hora', '$repetir', '$motivo', '$id_canino')";

    if (mysqli_query($conexion, $sql)) {
        echo json_encode(["status" => "success", "message" => "¡Recordatorio agregado correctamente!"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conexion)]);
    }
}
?>