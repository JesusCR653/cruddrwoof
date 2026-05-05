<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id_usuario = $_SESSION['usuario_id'] ?? 4;

$ruta_conexion = 'views/bd/conexion.php';
if (file_exists($ruta_conexion)) {
    include_once $ruta_conexion;
} else {
    include_once 'views/bd/conexion.php'; 
}

mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS = 0;");

$sql_historial = "DELETE FROM historial_medico WHERE id_canino IN (SELECT id_canino FROM caninos WHERE id_usuario = '$id_usuario')";
mysqli_query($conexion, $sql_historial);

$sql_citas = "DELETE FROM citas WHERE id_canino IN (SELECT id_canino FROM caninos WHERE id_usuario = '$id_usuario')";
@mysqli_query($conexion, $sql_citas);

$sql_mascotas = "DELETE FROM caninos WHERE id_usuario = '$id_usuario'";
mysqli_query($conexion, $sql_mascotas);

$sql_usuario = "DELETE FROM usuarios WHERE id_usuario = '$id_usuario'";
$resultado = mysqli_query($conexion, $sql_usuario);

mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS = 1;");

if ($resultado) {
    session_unset();
    session_destroy();
    header("Location: index.php?menu=bienvenida");
    exit();
} else {
    echo "Error al eliminar la cuenta: " . mysqli_error($conexion);
}
?>