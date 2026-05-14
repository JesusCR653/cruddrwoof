<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');

$ruta_conexion = $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';

if (file_exists($ruta_conexion)) {
    include_once $ruta_conexion;
} else {
    $ruta_alternativa = $_SERVER['DOCUMENT_ROOT'] . '/conexion.php';
    if (file_exists($ruta_alternativa)) {
        include_once $ruta_alternativa;
    } else {
        echo json_encode(["status" => "error", "message" => "No se encontró el archivo de conexión."]);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Método no permitido."]);
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
    echo json_encode(["status" => "error", "message" => "Por favor, completa los campos obligatorios."]);
    exit();
}

$FotoUS = 'logo.png';

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $tipoReal        = mime_content_type($_FILES['foto']['tmp_name']);

    if (!in_array($tipoReal, $tiposPermitidos)) {
        echo json_encode(["status" => "error", "message" => "Solo se permiten imágenes (JPG, PNG, GIF, WEBP)."]);
        exit();
    }

    if ($_FILES['foto']['size'] > 3 * 1024 * 1024) {
        echo json_encode(["status" => "error", "message" => "La imagen no debe superar los 3 MB."]);
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
        echo json_encode(["status" => "error", "message" => "No se pudo guardar la imagen en el servidor."]);
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
        echo json_encode([
            "status"  => "success",
            "message" => "¡Cuenta creada con éxito! Bienvenido a DR. WOOF",
            "foto"    => $FotoUS
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al registrar: " . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Error en la consulta: " . $conexion->error]);
}
?>