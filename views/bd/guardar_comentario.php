<?php
include('conexion.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comentario = $_POST['comentario'];
    $id_usuario = $_POST['id_usuario'];
    $fecha = date('Y-m-d H:i:s');

    $sql = "INSERT INTO comentarios (comentario, id_usuario) VALUES ('$comentario', '$id_usuario')";

    if (mysqli_query($conexion, $sql)) {
        echo json_encode(["status" => "success", "message" => "¡Gracias! Tu comentario ha sido recibido."]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conexion)]);
    }
}
?>