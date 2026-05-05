<?php
include_once 'views/bd/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id        = $_POST['id'];
    $nombre    = $_POST['nombre'];
    $paterno   = $_POST['paterno'];
    $materno   = $_POST['materno'];
    $telefono  = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo    = $_POST['correo'];

    $foto_nombre = null;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath   = $_FILES['foto']['tmp_name'];
        $fileName      = $_FILES['foto']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = 'user_' . $id . '.' . $fileExtension;
            $uploadFileDir = '../../public/img/';

            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $foto_nombre = $newFileName;
            }
        }
    }

    // Actualizamos la base de datos utilizando la columna correcta: id_usuario
    if ($foto_nombre) {
        $sql = "UPDATE usuarios SET 
                nombre = '$nombre', 
                apellido_paterno = '$paterno', 
                apellido_materno = '$materno', 
                telefono = '$telefono', 
                direccion = '$direccion', 
                correo_electronico = '$correo',
                foto = '$foto_nombre'
                WHERE id_usuario = $id";
    } else {
        $sql = "UPDATE usuarios SET 
                nombre = '$nombre', 
                apellido_paterno = '$paterno', 
                apellido_materno = '$materno', 
                telefono = '$telefono', 
                direccion = '$direccion', 
                correo_electronico = '$correo'
                WHERE id_usuario = $id";
    }

    if (mysqli_query($conexion, $sql)) {
        header("Location: index.php?menu=personal&opc=perfil");
        exit();
    } else {
        echo "Error al actualizar información: " . mysqli_error($conexion);
    }
}
?>