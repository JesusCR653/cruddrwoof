<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'views/bd/conexion.php';

if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
} else {
    $id_usuario = 4;
}

$query_user = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result_user = mysqli_query($conexion, $query_user);
$usuario = mysqli_fetch_assoc($result_user);

$nombre_usuario = "Usuario";
$apellido_usuario = "";
if (isset($usuario['nombre'])) {
    $nombre_usuario = $usuario['nombre'];
}
if (isset($usuario['apellido_paterno'])) {
    $apellido_usuario = $usuario['apellido_paterno'];
}
$nombre_completo = $nombre_usuario . ' ' . $apellido_usuario;

$foto_perfil = 'logo.png';
if (isset($usuario['FotoUS']) && $usuario['FotoUS'] != "") {
    if (file_exists('public/img/' . $usuario['FotoUS'])) {
        $foto_perfil = $usuario['FotoUS'] . '?v=' . time();
    }
}

if (isset($_GET['id'])) {
    $id_canino_url = $_GET['id'];
} else {
    $id_canino_url = 0;
}

$query_dog = "SELECT nombre FROM caninos WHERE id_canino = '$id_canino_url' AND id_usuario = '$id_usuario'";
$res_dog = mysqli_query($conexion, $query_dog);
$perro = mysqli_fetch_assoc($res_dog);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Agendar Cita</title>

    <link href="public/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="public/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/bracket.css">
    
    <style>
        .br-sideleft { background-color: #2c4ea3 !important; }
        .br-header { background-color: #1e3a8a !important; border: none !important; }
        
        .br-logo { background-color: #1e3a8a !important; border: none !important; }
        .br-logo a { color: #ffffff !important; font-weight: 700; }
        .br-logo a span { color: #00bfa5 !important; font-weight: 400; }

        .br-mainpanel {
            background-color: #cdebf7 !important;
            min-height: 100vh;
        }

        .br-pageheader {
            display: none !important;
        }

        .br-pagebody {
            padding: 0 30px 30px 30px !important;
        }

        .br-section-wrapper {
            background-color: #ffffff !important;
            border-radius: 0 0 40px 40px !important;
            padding: 50px 40px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: none !important;
            min-height: 85vh;
            margin-top: 0 !important;
        }

        .form-group {
            margin-bottom: 25px;
        }
        .form-control-label-custom {
            color: #1e3a8a !important;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 6px;
            display: block;
            text-align: center;
        }
        .form-control-custom {
            background-color: #dcdcdc !important;
            color: #333333 !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 25px !important;
            font-size: 16px !important;
            font-weight: bold;
            height: auto !important;
            text-align: center;
        }
        .form-control-custom:focus {
            background-color: #cfcfcf !important;
            outline: none;
        }
        textarea.form-control-custom {
            border-radius: 20px !important;
        }

        .btn-custom-agendar {
            background-color: #92bc5c !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 35px !important;
            font-size: 15px !important;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-custom-lista {
            background-color: #1e3a8a !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 30px !important;
            font-size: 15px !important;
            font-weight: bold;
        }
        .btn-custom-regresar {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 35px !important;
            font-size: 15px !important;
            font-weight: bold;
        }

        .header-welcome-centered {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            color: white;
            width: auto;
        }
        .header-welcome-centered h6 { margin: 0; font-weight: bold; font-size: 18px; text-transform: uppercase; }

        .logged-name, .navicon-left a i, .sidebar-label, .br-menu-link { color: #ffffff !important; }
        .br-menu-link.active { background-color: #4da9d4 !important; }
    </style>
</head>

<body class="show-left">

    <div class="br-logo"><a href="index.php?menu=panel&opc=bienvenida"><span>DR. </span>WOOF<span>+</span></a></div>
    
    <div class="br-sideleft overflow-y-auto">
        <label class="sidebar-label pd-x-15 mg-t-20">Menú Principal</label>
        <div class="br-sideleft-menu">
            <a href="index.php?menu=panel&opc=bienvenida" class="br-menu-link">
                <div class="br-menu-item"><i class="icon ion-ios-home-outline tx-22"></i><span class="menu-item-label">Inicio</span></div>
            </a>
            <a href="index.php?menu=personal&opc=perfil" class="br-menu-link">
                <div class="br-menu-item"><i class="icon ion-ios-person-outline tx-24"></i><span class="menu-item-label">Información Personal</span></div>
            </a>
            <a href="index.php?menu=mascotas&opc=registro" class="br-menu-link">
                <div class="br-menu-item"><i class="icon ion-ios-plus-outline tx-24"></i><span class="menu-item-label">Registro de mascota</span></div>
            </a>
            <a href="index.php?menu=mascotas&opc=listado" class="br-menu-link active">
                <div class="br-menu-item"><i class="icon ion-ios-paw tx-24"></i><span class="menu-item-label">Mis Mascotas</span></div>
            </a>
        </div>

        <label class="sidebar-label pd-x-15 mg-t-25 mg-b-20">Herramientas</label>
        <div class="br-sideleft-menu">
            <a href="index.php?menu=servicios&opc=agendag" class="br-menu-link">
                <div class="br-menu-item"><i class="icon ion-ios-calendar-outline tx-24"></i><span class="menu-item-label">Agenda</span></div>
            </a>
            <a href="index.php?menu=servicios&opc=recordatorios" class="br-menu-link">
                <div class="br-menu-item"><i class="icon ion-ios-alarm-outline tx-24"></i><span class="menu-item-label">Recordatorios</span></div>
            </a>
            <a href="index.php?menu=servicios&opc=comentarios" class="br-menu-link">
                <div class="br-menu-item"><i class="icon ion-ios-chatboxes-outline tx-24"></i><span class="menu-item-label">Comentarios</span></div>
            </a>
            <a href="index.php?menu=servicios&opc=mantenimiento" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="icon ion-ios-gear-outline tx-24"></i>
                    <span class="menu-item-label">Mantenimiento</span>
                </div>
            </a>
        </div>
    </div>

    <div class="br-header">
        <div class="br-header-left">
            <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
        </div>
        
        <div class="header-welcome-centered">
            <h6>AGENDAR CITA</h6>
        </div>

        <div class="br-header-right">
            <nav class="nav">
                <div class="dropdown">
                    <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
                        <span class="logged-name"><?php echo $nombre_completo; ?></span>
                        <img src="public/img/<?php echo $foto_perfil; ?>" class="wd-32 rounded-circle mg-l-10" alt="Perfil">
                    </a>
                    <div class="dropdown-menu dropdown-menu-header wd-200">
                        <ul class="list-unstyled user-profile-nav">
                            <li><a href="index.php?menu=personal&opc=perfil"><i class="icon ion-ios-person"></i> Perfil</a></li>
                            <li><a href="index.php?menu=bienvenida"><i class="icon ion-power"></i> Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="br-mainpanel">
        <div class="br-pagebody">
            <div class="br-section-wrapper d-flex flex-column justify-content-center align-items-center">
                
                <form action="index.php?menu=servicios&opc=guardar-cita" method="POST" style="width: 100%; max-width: 750px;">
                    <input type="hidden" name="id_canino" value="<?php echo (int)$id_canino_url; ?>">

                    <div class="form-layout form-layout-1">
                        
                        <div class="text-center mg-b-30">
                            <h4 class="tx-inverse tx-bold" style="color: #1e3a8a;">
                                Nueva Cita <?php if ($perro) { echo "para " . htmlspecialchars($perro['nombre']); } ?>
                            </h4>
                        </div>

                        <div class="row justify-content-center">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label-custom">Fecha de la cita:</label>
                                    <input class="form-control form-control-custom" type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label-custom">Hora de la consulta:</label>
                                    <input class="form-control form-control-custom" type="time" name="hora" value="12:00" required>
                                </div>
                            </div>

                            <div class="col-md-12 mg-t-10">
                                <div class="form-group">
                                    <label class="form-control-label-custom">Motivo de la cita:</label>
                                    <textarea rows="4" class="form-control form-control-custom" name="motivo_cita" placeholder="Ej: Refuerzo de vacuna triple o revisión de crecimiento" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-center mg-t-40 gap-3 flex-wrap">
                            <div>
                                <button type="submit" class="btn-custom-agendar">Agendar Cita</button>
                            </div>
                            <div>
                                <button type="button" class="btn-custom-lista" id="btnListaCitas">Lista de Citas</button>
                            </div>
                            <div>
                                <button type="button" class="btn-custom-regresar" id="btnRegresarCita">Regresar</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>

    <script>
        var botonLista = document.getElementById("btnListaCitas");
        botonLista.onclick = function() {
            window.location.href = "index.php?menu=servicios&opc=listado_citas";
        };

        var botonRegresar = document.getElementById("btnRegresarCita");
        botonRegresar.onclick = function() {
            window.history.back();
        };
    </script>
</body>
</html>