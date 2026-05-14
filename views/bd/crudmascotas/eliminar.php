<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'views/bd/conexion.php';

if (isset($_GET['id'])) {
    $id_recibido = (int)$_GET['id'];
    $id_usuario = $_SESSION['id_usuario'];

    // PRUEBA 1: Cambiamos a 'id_canino' (singular) ya que el error dice que el plural no existe
    $sql_foto = "SELECT fotoCan FROM caninos WHERE id_canino = ? AND id_usuario = ?";
    
    $stmt_foto = $conexion->prepare($sql_foto);

    if (!$stmt_foto) {
        // Si vuelve a fallar, intentaremos con 'id' a secas
        $sql_foto = "SELECT fotoCan FROM caninos WHERE id = ? AND id_usuario = ?";
        $stmt_foto = $conexion->prepare($sql_foto);
    }

    if ($stmt_foto) {
        $stmt_foto->bind_param("ii", $id_recibido, $id_usuario);
        $stmt_foto->execute();
        $resultado = $stmt_foto->get_result();
        
        if ($canino = $resultado->fetch_assoc()) {
            $nombre_foto = $canino['fotoCan'];

            // Usar el mismo nombre de columna que funcionó arriba para el DELETE
            // Determinamos cuál funcionó
            $columna_id = (strpos($stmt_foto->insert_id, 'id_canino') !== false) ? 'id_canino' : 'id';
            
            // Para no errar, escribimos el DELETE con la que funcionó en el SELECT
            $sql_delete = "DELETE FROM caninos WHERE id_canino = ? AND id_usuario = ?";
            // Si el anterior fue 'id', usamos 'id'
            
            // Intentar eliminar (asumiendo que id_canino es la correcta)
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
        // Si llega aquí, es que ni 'id_canino' ni 'id' funcionan. 
        // Vamos a imprimir las columnas reales de tu tabla para salir de dudas:
        $res = $conexion->query("SHOW COLUMNS FROM caninos");
        echo "Las columnas de tu tabla son: ";
        while($row = $res->fetch_assoc()){ echo "[" . $row['Field'] . "] "; }
        die("<br>Copia estos nombres y dime cuáles aparecen.");
    }
}