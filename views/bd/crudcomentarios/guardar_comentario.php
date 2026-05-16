<?php
if (session_status() === PHP_SESSION_NONE) session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /drwoof/index.php?menu=servicios&opc=comentarios&error=metodo');
    exit;
}

$comentario = mysqli_real_escape_string($conexion, $_POST['comentario'] ?? '');
$id_usuario = mysqli_real_escape_string($conexion, $_POST['id_usuario'] ?? ($_SESSION['id_usuario'] ?? 4));
$fecha      = date('Y-m-d H:i:s');

if (empty($comentario)) {
    header('Location: /drwoof/index.php?menu=servicios&opc=comentarios&error=vacio');
    exit;
}

$query = "INSERT INTO comentarios (comentario, id_usuario, fecha_registro) VALUES ('$comentario', '$id_usuario', '$fecha')";

if (mysqli_query($conexion, $query)) {
    header('Location: /drwoof/index.php?menu=servicios&opc=mis-comentarios&guardado=exitoso');
    exit;
} else {
    header('Location: /drwoof/index.php?menu=servicios&opc=comentarios&error=db');
    exit;
}
?>