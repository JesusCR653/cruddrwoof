<?php
if (session_status() === PHP_SESSION_NONE) session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comentario  = mysqli_real_escape_string($conexion, $_POST['comentario'] ?? '');
    $id_usuario  = mysqli_real_escape_string($conexion, $_POST['id_usuario'] ?? ($_SESSION['usuario_id'] ?? 4));
    $fecha       = date('Y-m-d H:i:s');

    if (empty($comentario)) {
        echo json_encode(['status' => 'error', 'message' => 'El comentario no puede estar vacío.']);
        exit;
    }

    $query = "INSERT INTO comentarios (comentario, id_usuario, fecha_registro) VALUES ('$comentario', '$id_usuario', '$fecha')";

    if (mysqli_query($conexion, $query)) {
        echo json_encode(['status' => 'success', 'message' => '¡Comentario enviado correctamente!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al guardar: ' . mysqli_error($conexion)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
}
?>