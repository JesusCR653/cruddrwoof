<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once 'views/bd/conexion.php';

$id_foto   = isset($_GET['id_foto'])   ? mysqli_real_escape_string($conexion, $_GET['id_foto'])   : 0;
$id_canino = isset($_GET['id_canino']) ? mysqli_real_escape_string($conexion, $_GET['id_canino']) : 0;

if ($id_foto > 0) {
    $res  = mysqli_query($conexion, "SELECT ruta_foto FROM galeria WHERE id_foto = '$id_foto'");
    $foto = mysqli_fetch_assoc($res);

    if ($foto) {
        // Eliminación apuntada correctamente a public/img/
        $archivo = "public/img/" . $foto['ruta_foto'];
        if (file_exists($archivo)) {
            unlink($archivo);
        }
        mysqli_query($conexion, "DELETE FROM galeria WHERE id_foto = '$id_foto'");
    }
}

echo "<script>window.location.href='index.php?menu=mascotas&opc=galeria&id=$id_canino';</script>";
exit();
?>