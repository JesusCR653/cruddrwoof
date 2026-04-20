<?php
$conexion = mysqli_connect("localhost", "root", "", "drwoof_db");

if (!$conexion) {
    die("Error: " . mysqli_connect_error());
}
mysqli_set_charset($conexion, "utf8");
?>