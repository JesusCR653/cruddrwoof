<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$raiz = dirname(__DIR__, 3);
include_once $raiz . '/views/bd/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_canino = mysqli_real_escape_string($conexion, $_POST['id_canino']);
    $titulo    = mysqli_real_escape_string($conexion, $_POST['titulo'] ?? 'Sin título');
    $notas     = mysqli_real_escape_string($conexion, $_POST['notas'] ?? '');
    $fecha     = mysqli_real_escape_string($conexion, $_POST['fecha'] ?? date('Y-m-d'));
    $es_ajax   = isset($_POST['ajax']) && $_POST['ajax'] == '1';

    if (isset($_FILES['archivo_foto']) && $_FILES['archivo_foto']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['archivo_foto']['name'], PATHINFO_EXTENSION));
        $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($ext, $extensiones_permitidas)) {
            if ($es_ajax) { echo json_encode(['ok' => false, 'msg' => 'Formato no permitido']); exit(); }
            echo "<script>alert('Formato no permitido.'); window.history.back();</script>"; exit();
        }

        $nombre_archivo  = "gal_" . $id_canino . "_" . time() . "." . $ext;
        $carpeta_destino = $raiz . '/public/img/';
        $ruta_destino    = $carpeta_destino . $nombre_archivo;

        if (!is_dir($carpeta_destino)) mkdir($carpeta_destino, 0755, true);

        if (move_uploaded_file($_FILES['archivo_foto']['tmp_name'], $ruta_destino)) {
            $sql = "INSERT INTO galeria (titulo_foto, ruta_foto, fecha_foto, notas_proceso, id_canino)
                    VALUES ('$titulo', '$nombre_archivo', '$fecha', '$notas', '$id_canino')";
            mysqli_query($conexion, $sql);
            $id_foto = mysqli_insert_id($conexion);

            if ($es_ajax) {
                echo json_encode([
                    'ok'            => true,
                    'id_foto'       => $id_foto,
                    'ruta_foto'     => $nombre_archivo,
                    'titulo_foto'   => $titulo,
                    'fecha_foto'    => $fecha,
                    'notas_proceso' => $notas,
                    'id_canino'     => $id_canino
                ]);
                exit();
            }

            echo "<script>window.location.href='index.php?menu=mascotas&opc=galeria&id=$id_canino';</script>";
            exit();
        } else {
            if ($es_ajax) { echo json_encode(['ok' => false, 'msg' => 'Error al mover archivo. Verifica permisos de public/img/']); exit(); }
            echo "<script>alert('Error al guardar la imagen. Verifica permisos de public/img/'); window.history.back();</script>"; exit();
        }
    } else {
        $code = $_FILES['archivo_foto']['error'] ?? 'sin archivo';
        if ($es_ajax) { echo json_encode(['ok' => false, 'msg' => "Error archivo: $code"]); exit(); }
        echo "<script>alert('No se recibió imagen. Error: $code'); window.history.back();</script>"; exit();
    }
}
?>