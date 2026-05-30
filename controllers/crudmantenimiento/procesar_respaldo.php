<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once '../../../views/bd/conexion.php';

$tablas = array();
$result = mysqli_query($conexion, "SHOW TABLES");
while ($row = mysqli_fetch_row($result)) {
    $tablas[] = $row[0];
}

$contenido = "";
for ($i = 0; $i < count($tablas); $i++) {
    $tabla = $tablas[$i];
    
    $resStructure = mysqli_query($conexion, "SHOW CREATE TABLE " . $tabla);
    $rowStructure = mysqli_fetch_row($resStructure);
    $contenido = $contenido . "\n\n" . $rowStructure[1] . ";\n\n";

    $resData = mysqli_query($conexion, "SELECT * FROM " . $tabla);
    while ($rowData = mysqli_fetch_row($resData)) {
        $contenido = $contenido . "INSERT INTO " . $tabla . " VALUES(";
        for ($j = 0; $j < count($rowData); $j++) {
            if (isset($rowData[$j])) {
                $contenido = $contenido . "'" . mysqli_real_escape_string($conexion, $rowData[$j]) . "'";
            } else {
                $contenido = $contenido . "NULL";
            }
            if ($j < (count($rowData) - 1)) {
                $contenido = $contenido . ",";
            }
        }
        $contenido = $contenido . ");\n";
    }
}

$nombreArchivo = "respaldo_drwoof_" . date("Y-m-d_H-i-s") . ".sql";
header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: Binary');
header('Content-disposition: attachment; filename="' . $nombreArchivo . '"');
echo $contenido;
exit();
?>