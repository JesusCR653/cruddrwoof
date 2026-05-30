<?php
include_once 'views/bd/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_canino   = $_POST['id_canino']; 
    $fecha       = $_POST['fecha'];
    $hora        = $_POST['hora'];
    $motivo_cita = mysqli_real_escape_string($conexion, $_POST['motivo_cita']);

    if (!empty($id_canino) && !empty($fecha) && !empty($hora)) {
        $sql = "INSERT INTO citas (fecha, hora, motivo_cita, id_canino) 
                VALUES ('$fecha', '$hora', '$motivo_cita', '$id_canino')";
        
        if (mysqli_query($conexion, $sql)) {
            echo "<script>
                    alert('¡Cita agendada con éxito!');
                    window.location.href='index.php?menu=servicios&opc=listado_citas';
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
        }
    } else {
        echo "<script>alert('Por favor, llena todos los campos obligatorios'); history.back();</script>";
    }
}
?>