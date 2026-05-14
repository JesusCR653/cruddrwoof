<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'views/bd/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $nombre    = trim($_POST['nombre']);
    $paterno   = trim($_POST['paterno']);
    $materno   = trim($_POST['materno']);
    $telefono  = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);

    $query_foto = "";
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nombre_archivo = "user_" . $id_usuario . "_" . time() . "." . $ext;
        $ruta_destino = "public/img/" . $nombre_archivo;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_destino)) {
            $query_foto = ", FotoUS = '$nombre_archivo'";
            $_SESSION['foto'] = $nombre_archivo; 
        }
    }

    $sql = "UPDATE usuarios SET 
            nombre = '$nombre', 
            apellido_paterno = '$paterno', 
            apellido_materno = '$materno', 
            telefono = '$telefono', 
            direccion = '$direccion'
            $query_foto 
            WHERE id_usuario = '$id_usuario'";

    if (mysqli_query($conexion, $sql)) {
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $paterno;
        header("Location: index.php?menu=personal&opc=perfil&update=success");
    } else {
        header("Location: index.php?menu=personal&opc=perfil&update=error");
    }
    exit();
}