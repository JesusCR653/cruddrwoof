<?php
include_once 'views/bd/conexion.php';

$id_cita = $_GET['id'] ?? 0;

if ($id_cita > 0) {
    $sql = "DELETE FROM citas WHERE id_cita = '$id_cita'";
    mysqli_query($conexion, $sql);
}

echo "<script>window.location.href='index.php?menu=servicios&opc=listado_citas';</script>";
exit();
?>