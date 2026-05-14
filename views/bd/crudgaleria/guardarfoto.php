<?php
// views/bd/crudgaleria/guardarfoto.php
include_once 'views/bd/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_canino = $_POST['id_canino'];
    $titulo    = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $notas     = mysqli_real_escape_string($conexion, $_POST['notas']);
    $fecha     = $_POST['fecha'];

    if (isset($_FILES['archivo_foto']) && $_FILES['archivo_foto']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['archivo_foto']['name'], PATHINFO_EXTENSION);
        $nombre_archivo = "gal_" . $id_canino . "_" . time() . "." . $ext;
        $ruta_destino = "public/img/caninos/" . $nombre_archivo;

        if (move_uploaded_file($_FILES['archivo_foto']['tmp_name'], $ruta_destino)) {
            $sql = "INSERT INTO galeria (titulo_foto, ruta_foto, fecha_foto, notas_proceso, id_canino) 
                    VALUES ('$titulo', '$nombre_archivo', '$fecha', '$notas', '$id_canino')";
            mysqli_query($conexion, $sql);
        }
    }
    
    // ✅ REDIRECCIÓN: Regresa a la galería de la mascota específica
    echo "<script>window.location.href='index.php?menu=mascotas&opc=galeria&id=$id_canino';</script>";
    exit();
}
?>