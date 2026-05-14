<?php
include_once 'views/bd/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cita = $_POST['id_cita'];
    $fecha   = $_POST['fecha'];
    $hora    = $_POST['hora'];
    $motivo  = mysqli_real_escape_string($conexion, $_POST['motivo_cita']);

    $sql = "UPDATE citas SET 
            fecha = '$fecha', 
            hora = '$hora', 
            motivo_cita = '$motivo' 
            WHERE id_cita = '$id_cita'";
            
    if(mysqli_query($conexion, $sql)) {
        echo "<script>alert('Cita actualizada correctamente'); window.location.href='index.php?menu=servicios&opc=listado_citas';</script>";
    } else {
        echo "Error al actualizar: " . mysqli_error($conexion);
    }
}
?>