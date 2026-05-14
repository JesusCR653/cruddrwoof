<?php
session_start();

// Conexión a la base de datos
$host     = "127.0.0.1";
$usuario  = "root";
$password = "";
$base     = "drwoof_db";

$conn = mysqli_connect($host, $usuario, $password, $base);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Recoger datos del formulario
$correo   = trim($_POST['correo'] ?? '');
$password = trim($_POST['password'] ?? '');

// Validar que no vengan vacíos
if (empty($correo) || empty($password)) {
    header("Location: index.php?menu=sesion&opc=index&error=1");
    exit();
}

// Consulta a la tabla usuarios
$sql = "SELECT * FROM usuarios WHERE correo_electronico = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $correo);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if ($fila = mysqli_fetch_assoc($resultado)) {
    // Comparar contraseña
    if ($password === $fila['contrasena']) {
        // Credenciales correctas → guardar sesión
        $_SESSION['id_usuario']  = $fila['id_usuario'];
        $_SESSION['nombre']      = $fila['nombre'];
        $_SESSION['apellido']    = $fila['apellido_paterno'];
        $_SESSION['correo']      = $fila['correo_electronico'];

        // Redirigir al panel principal
        header("Location: index.php?menu=panel&opc=bienvenida");
        exit();
    } else {
        // Contraseña incorrecta
        header("Location: index.php?menu=sesion&opc=index&error=1");  // ✅ corregido
        exit();
    }
} else {
    // Correo no encontrado
    header("Location: index.php?menu=sesion&opc=index&error=1");  // ✅ corregido
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>