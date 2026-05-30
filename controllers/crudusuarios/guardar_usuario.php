<?php
error_reporting(0);

$ruta_conexion = $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';

if (file_exists($ruta_conexion)) {
    include_once $ruta_conexion;
} else {
    $ruta_alternativa = $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';
    if (file_exists($ruta_alternativa)) {
        include_once $ruta_alternativa;
    } else {
        header('Location: ../../index.php?menu=sesion&opc=registro&error=conexion');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../index.php?menu=sesion&opc=registro&error=metodo');
    exit();
}

$nombre    = trim($_POST['nombre']    ?? '');
$paterno   = trim($_POST['paterno']   ?? '');
$materno   = trim($_POST['materno']   ?? '');
$telefono  = trim($_POST['telefono']  ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$correo    = trim($_POST['correo']    ?? '');
$password  = $_POST['password'] ?? '';

if (empty($nombre) || empty($correo) || empty($password)) {
    header('Location: ../../index.php?menu=sesion&opc=registro&error=campos');
    exit();
}

$FotoUS = 'logo.png';

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $tipoReal        = mime_content_type($_FILES['foto']['tmp_name']);

    if (!in_array($tipoReal, $tiposPermitidos)) {
        header('Location: ../../index.php?menu=sesion&opc=registro&error=tipo_imagen');
        exit();
    }

    if ($_FILES['foto']['size'] > 3 * 1024 * 1024) {
        header('Location: ../../index.php?menu=sesion&opc=registro&error=tamano_imagen');
        exit();
    }

    $ext        = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $nombreFoto = 'usr_' . uniqid() . '.' . $ext;

    $carpetaDestino = $_SERVER['DOCUMENT_ROOT'] . '/drwoof/public/img/';

    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0755, true);
    }

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $carpetaDestino . $nombreFoto)) {
        $FotoUS = $nombreFoto;
    } else {
        header('Location: ../../index.php?menu=sesion&opc=registro&error=imagen');
        exit();
    }
}

$stmt = $conexion->prepare(
    "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, telefono, direccion, correo_electronico, contrasena, FotoUS)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);

if ($stmt) {
    $stmt->bind_param("ssssssss",
        $nombre, $paterno, $materno, $telefono,
        $direccion, $correo, $password, $FotoUS
    );

    if ($stmt->execute()) {
        $stmt->close();
        header('Location: ../../index.php?menu=sesion&opc=index&registro=exitoso');
        exit();
    } else {
        $stmt->close();
        header('Location: ../../index.php?menu=sesion&opc=registro&error=db');
        exit();
    }
} else {
    header('Location: ../../index.php?menu=sesion&opc=registro&error=consulta');
    exit();
}
?>