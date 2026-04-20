<?php
include('conexion.php');

// Obligatorio para que AJAX entienda la respuesta
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibimos los datos
    $nombre = $_POST['nombre'] ?? '';
    $sexo   = $_POST['sexo'] ?? '';
    $fecha  = $_POST['fecha_nacimiento'] ?? '';
    $raza   = $_POST['raza'] ?? '';
    $color  = $_POST['color'] ?? '';
    $alerg  = $_POST['alergias'] ?? '';
    $edad   = $_POST['edad'] ?? '';
    $peso   = $_POST['peso'] ?? '';
    $trata  = $_POST['tratamiento'] ?? '';
    
    $id_usuario = 1; 

    // Query preparada para evitar errores de comillas
    $sql = "INSERT INTO caninos (nombre, raza, edad, sexo, peso, fecha_nacimiento, alergias, Tratamiento, id_usuario, Color) 
            VALUES ('$nombre', '$raza', '$edad', '$sexo', '$peso', '$fecha', '$alerg', '$trata', '$id_usuario', '$color')";

    if (mysqli_query($conexion, $sql)) {
        echo json_encode(["status" => "success", "message" => "¡$nombre ha sido registrado con éxito!"]);
    } else {
        // Si hay error en la tabla (ej: falta una columna), nos dirá exactamente cuál es
        echo json_encode(["status" => "error", "message" => mysqli_error($conexion)]);
    }
}
?>