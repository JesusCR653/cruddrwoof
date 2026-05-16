<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'views/bd/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // RECOGER EL NUEVO CAMPO DEL SELECT
    $tipo_mascota     = $_POST['tipo_mascota'] ?? 'Otro';
    
    $nombre           = trim($_POST['nombre']);
    $sexo             = $_POST['sexo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $raza             = trim($_POST['raza']);
    $color            = trim($_POST['color']);
    $alergias         = trim($_POST['alergias']);
    $edad             = (int)$_POST['edad'];
    $peso             = $_POST['peso']; 
    $tratamiento      = trim($_POST['tratamiento']);
    $id_usuario       = $_SESSION['id_usuario'];

    $fotoCan = 'sin_foto.png'; 
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ext        = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nombreFoto = uniqid('can_') . '.' . $ext;
        $destino    = 'public/img/caninos/' . $nombreFoto;

        if (!is_dir('public/img/caninos')) {
            mkdir('public/img/caninos', 0755, true);
        }

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
            $fotoCan = $nombreFoto;
        }
    }

    // AJUSTADO: Se añade la columna tipo_mascota al final de la consulta SQL
    $sql = "INSERT INTO caninos (nombre, raza, edad, sexo, fotoCan, Color, peso, fecha_nacimiento, alergias, Tratamiento, id_usuario, tipo_mascota)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        // AJUSTADO: Se agrega una 's' al final de la cadena por ser un VARCHAR (tipo_mascota)
        $tipos = 'ssisssssssis';
        
        $stmt->bind_param($tipos, 
            $nombre,          
            $raza,             
            $edad,             
            $sexo,             
            $fotoCan,          
            $color,            
            $peso,             
            $fecha_nacimiento, 
            $alergias,         
            $tratamiento,      
            $id_usuario,
            $tipo_mascota // Enviamos la variable al parámetro del query
        );

        if ($stmt->execute()) {
            header('Location: index.php?menu=mascotas&opc=registro&exito=1');
        } else {
            header('Location: index.php?menu=mascotas&opc=registro&error=1');
        }
        $stmt->close();
    } else {
        header('Location: index.php?menu=mascotas&opc=registro&error=1');
    }
    
    // CORRECCIÓN: Se cambia $conn por tu variable real $conexion
    $conexion->close();
    exit;
} else {
    header('Location: index.php?menu=mascotas&opc=registro');
    exit;
}
?>