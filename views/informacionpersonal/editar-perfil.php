<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once 'views/bd/conexion.php';

if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
} else {
    $id_usuario = 4;
}

$query = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result = mysqli_query($conexion, $query);
$usuario = mysqli_fetch_assoc($result);

if ($usuario['nombre'] != "") {
    $nombre_completo = $usuario['nombre'] . ' ' . $usuario['apellido_paterno'];
} else {
    $nombre_completo = 'Usuario';
}

$foto_db = $usuario['FotoUS'];
if ($foto_db != "" && file_exists('public/img/' . $foto_db)) {
    $foto_perfil = $foto_db . '?v=' . time();
} else {
    $foto_perfil = 'logo.png';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Editar Perfil</title>

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
            text-align: left;
        }

        .card-profile-right {
            border: 5px solid #1e3a8a !important;
            border-radius: 20px !important;
            background-color: #ffffff;
            padding: 30px 20px !important;
            max-width: 300px;
            margin: 0 auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        }

        .btn-custom-cancelar {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 35px !important;
            font-size: 16px !important;
            font-weight: bold;
        }
        .btn-custom-guardar {
            background-color: #92bc5c !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 40px !important;
            font-size: 16px !important;
            font-weight: bold;
            cursor: pointer;
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
            <a href="index.php?menu=personal&opc=perfil" class="br-menu-link active">
                <div class="br-menu-item"><i class="icon ion-ios-person-outline tx-24"></i><span class="menu-item-label">Información Personal</span></div>
            </a>
            <a href="index.php?menu=mascotas&opc=registro" class="br-menu-link">
                <div class="br-menu-item"><i class="icon ion-ios-plus-outline tx-24"></i><span class="menu-item-label">Registro de mascota</span></div>
            </a>
            <a href="index.php?menu=mascotas&opc=listado" class="br-menu-link">
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
            <h6>INFORMACIÓN PERSONAL</h6>
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
            <div class="br-section-wrapper d-flex flex-column justify-content-center">
                
                <form action="index.php?menu=personal&opc=actualizar" method="POST" enctype="multipart/form-data">
                    <div class="row align-items-center justify-content-center">
                        
                        <div class="col-md-8">
                            <div class="form-layout form-layout-1">
                                <div class="row">
                                    
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Nombre(s):</label>
                                            <input class="form-control form-control-custom" type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Apellido Paterno:</label>
                                            <input class="form-control form-control-custom" type="text" name="paterno" value="<?php echo $usuario['apellido_paterno']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Apellido Materno:</label>
                                            <input class="form-control form-control-custom" type="text" name="materno" value="<?php echo $usuario['apellido_materno']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Número de teléfono:</label>
                                            <input class="form-control form-control-custom" type="text" name="telefono" value="<?php echo $usuario['telefono']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Dirección:</label>
                                            <textarea rows="3" class="form-control form-control-custom" name="direccion" required><?php echo $usuario['direccion']; ?></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 text-center mg-t-30 mg-md-t-0">
                            <div class="card card-profile-right">
                                <img class="img-fluid rounded-circle wd-130 mx-auto" src="public/img/<?php echo $foto_perfil; ?>" alt="Foto Perfil Principal" style="height: 130px; object-fit: cover; border: 3px solid #34b5e5;">
                                <div class="mg-t-20">
                                    <p class="tx-inverse tx-bold tx-uppercase tx-12 mg-b-10" style="color: #1e3a8a;">Actualizar Foto</p>
                                    <input type="file" name="foto" class="form-control-file mx-auto" accept="image/*" style="max-width: 200px; font-size: 13px;">
                                    <p class="tx-11 mg-t-10 text-muted">Selecciona una imagen nueva para cambiar tu foto de perfil.</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex align-items-center justify-content-center mg-t-30 gap-4 flex-wrap">
                        <div>
                            <button type="submit" class="btn-custom-guardar">Guardar Cambios</button>
                        </div>
                        <div>
                            <a href="index.php?menu=personal&opc=perfil" class="btn btn-custom-cancelar text-center">Cancelar</a>
                        </div>
                    </div>

                </form>
                
            </div>
        </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>
</body>
</html>