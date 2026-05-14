<?php
// views/bd/crudgaleria/eliminarfoto.php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once 'views/bd/conexion.php';

$id_foto   = $_GET['id_foto'] ?? 0;
$id_canino = $_GET['id_canino'] ?? 0;

if ($id_foto > 0) {
    $res = mysqli_query($conexion, "SELECT ruta_foto FROM galeria WHERE id_foto = '$id_foto'");
    $foto = mysqli_fetch_assoc($res);

    if ($foto) {
        $archivo = "public/img/caninos/" . $foto['ruta_foto'];
        if (file_exists($archivo)) {
            unlink($archivo);
        }
        mysqli_query($conexion, "DELETE FROM galeria WHERE id_foto = '$id_foto'");
    }
}

echo "<script>window.location.href='index.php?menu=mascotas&opc=galeria&id=$id_canino';</script>";
exit();