<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'views/bd/conexion.php';

if (isset($_GET['id'])) {
    $id_recibido = (int)$_GET['id'];
    $id_usuario = $_SESSION['id_usuario'];

    $sql_foto = "SELECT fotoCan FROM caninos WHERE id_canino = ? AND id_usuario = ?";
    
    $stmt_foto = $conexion->prepare($sql_foto);

    if (!$stmt_foto) {
        $sql_foto = "SELECT fotoCan FROM caninos WHERE id = ? AND id_usuario = ?";
        $stmt_foto = $conexion->prepare($sql_foto);
    }

    if ($stmt_foto) {
        $stmt_foto->bind_param("ii", $id_recibido, $id_usuario);
        $stmt_foto->execute();
        $resultado = $stmt_foto->get_result();
        
        if ($canino = $resultado->fetch_assoc()) {
            $nombre_foto = $canino['fotoCan'];

            $columna_id = (strpos($stmt_foto->insert_id, 'id_canino') !== false) ? 'id_canino' : 'id';
            
            $sql_delete = "DELETE FROM caninos WHERE id_canino = ? AND id_usuario = ?";
            
            $stmt_del = $conexion->prepare("DELETE FROM caninos WHERE id_canino = ? AND id_usuario = ?");
            if(!$stmt_del) {
                $stmt_del = $conexion->prepare("DELETE FROM caninos WHERE id = ? AND id_usuario = ?");
            }

            $stmt_del->bind_param("ii", $id_recibido, $id_usuario);
            
            if ($stmt_del->execute()) {
                if ($nombre_foto != 'sin_foto.png') {
                    $ruta_foto = 'public/img/caninos/' . $nombre_foto;
                    if (file_exists($ruta_foto)) { unlink($ruta_foto); }
                }
                header("Location: index.php?menu=mascotas&opc=listado&eliminado=1");
                exit;
            }
        } else {
            echo "No se encontró la mascota. Verifica que el ID $id_recibido pertenezca al usuario $id_usuario";
        }
    } else {
        $res = $conexion->query("SHOW COLUMNS FROM caninos");
        echo "Las columnas de tu tabla son: ";
        while($row = $res->fetch_assoc()){ echo "[" . $row['Field'] . "] "; }
        die("<br>Copia estos nombres y dime cuáles aparecen.");
    }
}