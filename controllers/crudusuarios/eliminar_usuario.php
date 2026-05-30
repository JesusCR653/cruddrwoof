<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$ruta_conexion = dirname(__DIR__, 1) . '/conexion.php';

if (!file_exists($ruta_conexion)) {
    $ruta_conexion = __DIR__ . '/../conexion.php';
}

if (!file_exists($ruta_conexion)) {
    die("Error: No se encontró el archivo de conexión. Verifique la ubicación en views/bd/conexion.php");
}

include_once $ruta_conexion;

$id_usuario = $_SESSION['id_usuario'] ?? null;

if (!$id_usuario) {
    header("Location: ../../../index.php?menu=sesion&opc=index");
    exit();
}

$sql_foto = "SELECT FotoUS FROM usuarios WHERE id_usuario = '$id_usuario'";
$res_foto = mysqli_query($conexion, $sql_foto);
if ($res_foto && $row_foto = mysqli_fetch_assoc($res_foto)) {
    $foto = $row_foto['FotoUS'];
    if (!empty($foto) && $foto !== 'logo.png') {
        $ruta_foto = dirname(__DIR__, 3) . '/public/img/' . $foto;
        if (file_exists($ruta_foto)) {
            unlink($ruta_foto);
        }
    }
}

mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS = 0");

mysqli_query($conexion,
    "DELETE FROM historial_medico 
     WHERE id_canino IN (SELECT id_canino FROM caninos WHERE id_usuario = '$id_usuario')"
);

mysqli_query($conexion,
    "DELETE FROM citas 
     WHERE id_canino IN (SELECT id_canino FROM caninos WHERE id_usuario = '$id_usuario')"
);

mysqli_query($conexion, "DELETE FROM caninos WHERE id_usuario = '$id_usuario'");

$resultado = mysqli_query($conexion, "DELETE FROM usuarios WHERE id_usuario = '$id_usuario'");

mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS = 1");

if ($resultado) {
    session_unset();
    session_destroy();
    header("Location: ../../../index.php?menu=sesion&opc=index&eliminado=1");
    exit();
} else {
    die("Error al eliminar la cuenta: " . mysqli_error($conexion));
}
?>