<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');

// Ruta absoluta a la conexión (Asegúrate de que 'drwoof' sea el nombre de tu carpeta en C:/laragon/www/)
$ruta_conexion = $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';

if (file_exists($ruta_conexion)) {
    include_once $ruta_conexion;
} else {
    // Ruta alternativa por si el proyecto está en la raíz directa
    $ruta_alternativa = $_SERVER['DOCUMENT_ROOT'] . '/conexion.php';
    if (file_exists($ruta_alternativa)) {
        include_once $ruta_alternativa;
    } else {
        echo json_encode([
            "status" => "error", 
            "message" => "No se pudo encontrar el archivo de conexión en la raíz del servidor."
        ]);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre    = $_POST['nombre'] ?? '';
    $paterno   = $_POST['paterno'] ?? '';
    $materno   = $_POST['materno'] ?? '';
    $telefono  = $_POST['telefono'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $correo    = $_POST['correo'] ?? '';
    $password  = $_POST['password'] ?? '';

    // Validamos que los campos obligatorios vengan completos
    if (empty($nombre) || empty($correo) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Por favor, completa los campos obligatorios."]);
        exit();
    }

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, telefono, direccion, correo_electronico, contrasena) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("sssssss", $nombre, $paterno, $materno, $telefono, $direccion, $correo, $password);
        
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "¡Cuenta creada con éxito! Bienvenido a DR. WOOF"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al registrar: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $conexion->error]);
    }
}
?>