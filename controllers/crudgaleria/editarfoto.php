<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Ajustamos la ruta para conectar a tu archivo de conexión real
include_once '../../../views/bd/conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_foto   = mysqli_real_escape_string($conexion, $_POST['id_foto']);
    $id_canino = mysqli_real_escape_string($conexion, $_POST['id_canino']);
    $titulo    = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $notas     = mysqli_real_escape_string($conexion, $_POST['notas']);

    $sql = "UPDATE galeria SET titulo_foto = '$titulo', notas_proceso = '$notas' WHERE id_foto = '$id_foto'";
    
    if (mysqli_query($conexion, $sql)) {
        // Redirige de vuelta al panel de la galería del perro correspondiente
        echo "<script>window.location.href='../../../index.php?menu=mascotas&opc=galeria&id=$id_canino';</script>";
    } else {
        echo "<script>alert('Error al actualizar los datos en la base de datos.'); window.history.back();</script>";
    }
    exit();
}
?>