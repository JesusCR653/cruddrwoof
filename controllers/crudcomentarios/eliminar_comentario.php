<?php
if (session_status() === PHP_SESSION_NONE) session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_comentario = mysqli_real_escape_string($conexion, $_POST['id_comentario'] ?? '');

    if (empty($id_comentario)) {
        echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado.']);
        exit;
    }

    $query = "DELETE FROM comentarios WHERE id_comentario = '$id_comentario'";

    if (mysqli_query($conexion, $query)) {
        echo json_encode(['status' => 'success', 'message' => '¡Comentario eliminado correctamente!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al eliminar: ' . mysqli_error($conexion)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
}
?>