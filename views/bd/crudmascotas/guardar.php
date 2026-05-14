<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'views/bd/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Limpieza de datos básica
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

    // Manejo de foto
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

    // Asegúrate de que el orden de las columnas coincida EXACTAMENTE con bind_param
    $sql = "INSERT INTO caninos (nombre, raza, edad, sexo, fotoCan, Color, peso, fecha_nacimiento, alergias, Tratamiento, id_usuario)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        /* 
           Tipos: 
           s = string, i = integer, d = double (para el peso)
           He cambiado el peso a 's' por si acaso lo mandas como string (ej. "5.5 kg"), 
           si en tu BD es decimal, cambia esa 's' por una 'd'.
        */
        $tipos = 'ssisssssssi'; // 11 caracteres para 11 parámetros
        
        $stmt->bind_param($tipos, 
            $nombre,           // 1 s
            $raza,             // 2 s
            $edad,             // 3 i
            $sexo,             // 4 s
            $fotoCan,          // 5 s
            $color,            // 6 s
            $peso,             // 7 s (o d si es decimal puro)
            $fecha_nacimiento, // 8 s
            $alergias,         // 9 s
            $tratamiento,      // 10 s
            $id_usuario        // 11 i
        );

        if ($stmt->execute()) {
            header('Location: index.php?menu=mascotas&opc=registro&exito=1');
        } else {
            // Imprime el error para debug si sigue fallando (quitar en producción)
            // echo "Error al ejecutar: " . $stmt->error;
            header('Location: index.php?menu=mascotas&opc=registro&error=1');
        }
        $stmt->close();
    } else {
        header('Location: index.php?menu=mascotas&opc=registro&error=1');
    }
    $conn->close();
    exit;
} else {
    header('Location: index.php?menu=mascotas&opc=registro');
    exit;
}