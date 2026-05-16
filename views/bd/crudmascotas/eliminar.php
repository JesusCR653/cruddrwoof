<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'views/bd/conexion.php';

if (isset($_GET['id'])) {
    $id_recibido = (int)$_GET['id'];
    $id_usuario = $_SESSION['id_usuario'] ?? 4;

    // 1. Obtener primero el nombre de la foto para poder borrarla del servidor
    $sql_foto = "SELECT fotoCan FROM caninos WHERE id_canino = ? AND id_usuario = ?";
    $stmt_foto = $conexion->prepare($sql_foto);

    if ($stmt_foto) {
        $stmt_foto->bind_param("ii", $id_recibido, $id_usuario);
        $stmt_foto->execute();
        $resultado = $stmt_foto->get_result();
        
        if ($canino = $resultado->fetch_assoc()) {
            $nombre_foto = $canino['fotoCan'];
            $stmt_foto->close();

            // 2. Ejecutar el borrado físico del registro en la base de datos
            $stmt_del = $conexion->prepare("DELETE FROM caninos WHERE id_canino = ? AND id_usuario = ?");
            
            if ($stmt_del) {
                $stmt_del->bind_param("ii", $id_recibido, $id_usuario);
                
                if ($stmt_del->execute()) {
                    $stmt_del->close();

                    // 3. Si se borró de la BD, eliminar la imagen de la carpeta para no acumular basura
                    if ($nombre_foto != 'sin_foto.png' && !empty($nombre_foto)) {
                        $ruta_foto = 'public/img/caninos/' . $nombre_foto;
                        if (file_exists($ruta_foto)) { 
                            unlink($ruta_foto); 
                        }
                    }
                    
                    // Redirección limpia al listado con aviso de éxito
                    header("Location: index.php?menu=mascotas&opc=listado&eliminado=1");
                    exit;
                }
                $stmt_del->close();
            }
        } else {
            $stmt_foto->close();
            header("Location: index.php?menu=mascotas&opc=listado&error=no_encontrado");
            exit;
        }
    } else {
        header("Location: index.php?menu=mascotas&opc=listado&error=consulta");
        exit;
    }
} else {
    header("Location: index.php?menu=mascotas&opc=listado");
    exit;
}
?>