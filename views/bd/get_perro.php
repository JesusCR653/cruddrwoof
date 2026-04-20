<?php
include('conexion.php');

if(isset($_GET['nombre'])) {
    $nombre = mysqli_real_escape_string($conexion, $_GET['nombre']);
    
    $sql = "SELECT * FROM caninos WHERE nombre = '$nombre' LIMIT 1";
    $resultado = mysqli_query($conexion, $sql);
    
    if($resultado && mysqli_num_rows($resultado) > 0) {
        $datos = mysqli_fetch_assoc($resultado);
        echo json_encode($datos);
    } else {
        echo json_encode(["error" => "No se encontró a la mascota"]);
    }
}
?>