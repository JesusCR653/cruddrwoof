<?php
session_start();

$host     = "127.0.0.1";
$usuario  = "root";
$password = "";
$base     = "drwoof_db";

$conn = mysqli_connect($host, $usuario, $password, $base);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

$correo   = trim($_POST['correo'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($correo) || empty($password)) {
    header("Location: index.php?menu=sesion&opc=index&error=1");
    exit();
}

$sql = "SELECT * FROM usuarios WHERE correo_electronico = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $correo);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if ($fila = mysqli_fetch_assoc($resultado)) {
    if ($password === $fila['contrasena']) {
        $_SESSION['id_usuario']  = $fila['id_usuario'];
        $_SESSION['nombre']      = $fila['nombre'];
        $_SESSION['apellido']    = $fila['apellido_paterno'];
        $_SESSION['correo']      = $fila['correo_electronico'];

        header("Location: index.php?menu=panel&opc=bienvenida");
        exit();
    } else {
        header("Location: index.php?menu=sesion&opc=index&error=1");
        exit();
    }
} else {
    header("Location: index.php?menu=sesion&opc=index&error=1");  
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>