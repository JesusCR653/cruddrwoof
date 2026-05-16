public function respaldar() {
    include 'views/mantenimiento/respaldo.php';
}

public function descargar_respaldo() {
    $tablas = array();
    $result = $this->conexion->query("SHOW TABLES");
    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        $tablas[] = $row[0];
    }

    $contenido = "";
    for ($i = 0; $i < count($tablas); $i++) {
        $tabla = $tablas[$i];
        
        $resStructure = $this->conexion->query("SHOW CREATE TABLE " . $tabla);
        $rowStructure = $resStructure->fetch(PDO::FETCH_NUM);
        $contenido = $contenido . "\n\n" . $rowStructure[1] . ";\n\n";

        $resData = $this->conexion->query("SELECT * FROM " . $tabla);
        while ($rowData = $resData->fetch(PDO::FETCH_NUM)) {
            $contenido = $contenido . "INSERT INTO " . $tabla . " VALUES(";
            for ($j = 0; $j < count($rowData); $j++) {
                if (isset($rowData[$j])) {
                    $contenido = $contenido . "'" . addslashes($rowData[$j]) . "'";
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
}

public function procesar_restauracion() {
    if (isset($_FILES['respaldo']) && $_FILES['respaldo']['error'] == 0) {
        $rutaTemporal = $_FILES['respaldo']['tmp_name'];
        $contenido = file_get_contents($rutaTemporal);
        
        try {
            $this->conexion->exec($contenido);
            echo json_encode(array("status" => "success", "message" => "Base de datos restaurada correctamente."));
        } catch (PDOException $e) {
            echo json_encode(array("status" => "error", "message" => "Error al ejecutar el script SQL."));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "No se pudo subir el archivo de respaldo."));
    }
    exit();
}