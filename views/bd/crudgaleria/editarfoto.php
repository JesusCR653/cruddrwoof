<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once 'views/bd/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_foto   = $_POST['id_foto'];
    $id_canino = $_POST['id_canino'];
    $titulo    = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $notas     = mysqli_real_escape_string($conexion, $_POST['notas']);

    $sql = "UPDATE galeria SET titulo_foto = '$titulo', notas_proceso = '$notas' WHERE id_foto = '$id_foto'";
    mysqli_query($conexion, $sql);

    echo "<script>window.location.href='index.php?menu=mascotas&opc=galeria&id=$id_canino';</script>";
    exit();
}