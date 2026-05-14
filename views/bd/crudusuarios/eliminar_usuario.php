<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── CORRECCIÓN DE RUTA ───────────────────────────────────────────────────────
// Subimos dos niveles desde crudusuarios/ para llegar a views/bd/
$ruta_conexion = dirname(__DIR__, 1) . '/conexion.php';

if (!file_exists($ruta_conexion)) {
    // Si falla, intentamos la ruta manual exacta basada en tu estructura
    $ruta_conexion = __DIR__ . '/../conexion.php';
}

if (!file_exists($ruta_conexion)) {
    die("Error: No se encontró el archivo de conexión. Verifique la ubicación en views/bd/conexion.php");
}

include_once $ruta_conexion;

// ── ID de usuario desde sesión ────────────────────────────────────────────────
$id_usuario = $_SESSION['id_usuario'] ?? null;

if (!$id_usuario) {
    header("Location: ../../../index.php?menu=sesion&opc=index");
    exit();
}

// ── Borrar foto de perfil del servidor ────────────────────────────────────────
$sql_foto = "SELECT FotoUS FROM usuarios WHERE id_usuario = '$id_usuario'";
$res_foto = mysqli_query($conexion, $sql_foto);
if ($res_foto && $row_foto = mysqli_fetch_assoc($res_foto)) {
    $foto = $row_foto['FotoUS'];
    if (!empty($foto) && $foto !== 'logo.png') {
        // La ruta de la imagen está en drwoof/public/img/
        $ruta_foto = dirname(__DIR__, 3) . '/public/img/' . $foto;
        if (file_exists($ruta_foto)) {
            unlink($ruta_foto);
        }
    }
}

// ── Eliminar en cascada ───────────────────────────────────────────────────────
mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS = 0");

// 1. Historial médico
mysqli_query($conexion,
    "DELETE FROM historial_medico 
     WHERE id_canino IN (SELECT id_canino FROM caninos WHERE id_usuario = '$id_usuario')"
);

// 2. Citas
mysqli_query($conexion,
    "DELETE FROM citas 
     WHERE id_canino IN (SELECT id_canino FROM caninos WHERE id_usuario = '$id_usuario')"
);

// 3. Caninos
mysqli_query($conexion, "DELETE FROM caninos WHERE id_usuario = '$id_usuario'");

// 4. Usuario
$resultado = mysqli_query($conexion, "DELETE FROM usuarios WHERE id_usuario = '$id_usuario'");

mysqli_query($conexion, "SET FOREIGN_KEY_CHECKS = 1");

// ── Cerrar sesión y redirigir ─────────────────────────────────────────────────
if ($resultado) {
    session_unset();
    session_destroy();
    header("Location: ../../../index.php?menu=sesion&opc=index&eliminado=1");
    exit();
} else {
    die("Error al eliminar la cuenta: " . mysqli_error($conexion));
}
?>