<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /drwoof/index.php?menu=servicios&opc=recordatorios&error=metodo');
    exit;
}

$id_canino = mysqli_real_escape_string($conexion, $_POST['id_canino'] ?? '');
$fecha     = mysqli_real_escape_string($conexion, $_POST['fecha']     ?? '');
$hora      = mysqli_real_escape_string($conexion, $_POST['hora']      ?? '');
$repetir   = mysqli_real_escape_string($conexion, $_POST['repetir']   ?? '');
$motivo    = mysqli_real_escape_string($conexion, $_POST['motivo']    ?? '');

if (!$id_canino || !$fecha || !$hora || !$motivo) {
    header('Location: /drwoof/index.php?menu=servicios&opc=recordatorios&error=campos');
    exit;
}

$query = "INSERT INTO recordatorios (fecha, hora, repetir, motivo, id_canino)
          VALUES ('$fecha', '$hora', '$repetir', '$motivo', '$id_canino')";

if (mysqli_query($conexion, $query)) {
    header('Location: /drwoof/index.php?menu=servicios&opc=listarecordatorios&guardado=exitoso');
    exit;
} else {
    header('Location: /drwoof/index.php?menu=servicios&opc=recordatorios&error=db');
    exit;
}
?>