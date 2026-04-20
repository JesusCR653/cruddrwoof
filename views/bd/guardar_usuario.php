<?php
include('conexion.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre    = $_POST['nombre'];
    $paterno   = $_POST['paterno'];
    $materno   = $_POST['materno'];
    $telefono  = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo    = $_POST['correo'];
    $password  = $_POST['password'];


    $sql = "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, telefono, direccion, correo_electronico, contrasena) 
            VALUES ('$nombre', '$paterno', '$materno', '$telefono', '$direccion', '$correo', '$password')";

    if (mysqli_query($conexion, $sql)) {
        echo json_encode(["status" => "success", "message" => "¡Cuenta creada con éxito! Bienvenido a DR. WOOF"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conexion)]);
    }
}
?>