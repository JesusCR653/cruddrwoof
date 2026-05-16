<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once '../../../views/bd/conexion.php';

if (isset($_FILES['respaldo']) && $_FILES['respaldo']['error'] == 0) {
    $rutaTemporal = $_FILES['respaldo']['tmp_name'];
    $lineas = file($rutaTemporal);
    
    $queryCompleta = "";
    $error = false;

    for ($i = 0; $i < count($lineas); $i++) {
        $linea = trim($lineas[$i]);
        
        if ($linea == "" || substr($linea, 0, 2) == "--" || substr($linea, 0, 1) == "#") {
            continue;
        }

        $queryCompleta = $queryCompleta . $linea;

        if (substr($linea, -1, 1) == ";") {
            if (mysqli_query($conexion, $queryCompleta) == false) {
                $error = true;
                break;
            }
            $queryCompleta = "";
        }
    }

    if ($error == false) {
        echo json_encode(array("status" => "success", "message" => "Base de datos restaurada correctamente."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Ocurrió un error al ejecutar las consultas SQL."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "No se pudo cargar el archivo correctamente."));
}
exit();
?>