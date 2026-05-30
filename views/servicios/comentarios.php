<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$ruta_conexion = $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';
if (file_exists($ruta_conexion)) {
    include_once $ruta_conexion;
} else {
    include_once 'views/bd/conexion.php';
}

if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
} else {
    $id_usuario = 4;
}

$query_user = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'");
$usuario = mysqli_fetch_assoc($query_user);

$nombre_usuario = "Usuario";
$apellido_usuario = "";
if (isset($usuario['nombre'])) {
    $nombre_usuario = $usuario['nombre'];
}
if (isset($usuario['apellido_paterno'])) {
    $apellido_usuario = $usuario['apellido_paterno'];
}
if ($usuario['apellido_materno'] != "") {
    $apellido_materno = $usuario['apellido_materno'];
} else {
    $apellido_materno = '';
}

$nombre_completo = $nombre_usuario . ' ' . $apellido_usuario . ' ' . $apellido_materno;

$foto_user = 'logo.png';
if (isset($usuario['FotoUS']) && $usuario['FotoUS'] != "") {
    if (file_exists('public/img/' . $usuario['FotoUS'])) {
        $foto_user = $usuario['FotoUS'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Comentarios</title>

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

        .br-pagebody {
            padding: 0 30px 30px 30px !important;
        }

        .br-section-wrapper {
            background-color: #ffffff !important;
            border-radius: 0 0 40px 40px !important;
            padding: 60px 40px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: none !important;
            min-height: 85vh;
            margin-top: 0 !important;
        }

        .label-ovalada {
            background-color: #dcdcdc !important;
            color: #333333 !important;
            padding: 12px 25px;
            font-weight: bold;
            font-size: 16px;
            border-radius: 25px;
            display: inline-block;
            text-align: center;
            width: 100%;
            max-width: 260px;
        }

        .decoracion-icono {
            font-size: 110px;
            color: #000000;
            margin-top: 20px;
        }

        .textarea-marino-container {
            position: relative;
            background-color: #dcdcdc !important;
            border-radius: 35px !important;
            padding: 20px !important;
        }
       
        .textarea-custom {
            background-color: transparent !important;
            color: #333333 !important;
            border: none !important;
            font-size: 16px !important;
            font-weight: bold;
            width: 100%;
            resize: none;
            padding-left: 10px;
        }
        .textarea-custom:focus {
            outline: none;
        }

        .textarea-marino-container i.fa-font {
            background-color: #000000;
            color: #ffffff;
            padding: 5px 8px;
            font-size: 12px;
            border-radius: 3px;
            margin-bottom: 10px;
            display: inline-block;
        }

        .btn-custom-agregar {
            background-color: #92bc5c !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 50px !important;
            font-size: 16px !important;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-custom-ver {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 35px !important;
            font-size: 16px !important;
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
            <a href="index.php?menu=mascotas&opc=listado" class="br-menu-link">
                <div class="br-menu-item"><i class="icon ion-ios-paw-outline tx-24"></i><span class="menu-item-label">Mis Mascotas</span></div>
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
            <a href="index.php?menu=servicios&opc=comentarios" class="br-menu-link active">
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
            <h6>COMENTARIOS</h6>
        </div>

        <div class="br-header-right">
            <nav class="nav">
                <div class="dropdown">
                    <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
                        <span class="logged-name"><?php echo $nombre_completo; ?></span>
                        <img src="public/img/<?php echo $foto_user; ?>" class="wd-32 rounded-circle mg-l-10" alt="Perfil">
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

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger text-center mx-auto mg-b-20" style="max-width: 700px; border-radius: 20px; font-weight: bold;">
                        <i class="fa fa-times mg-r-5"></i>
                        <?php
                            $error = $_GET['error'];
                            if ($error == 'vacio') {
                                echo "El comentario no puede estar vacío.";
                            } else if ($error == 'db') {
                                echo "Error al guardar el comentario. Intenta de nuevo.";
                            } else {
                                echo "Ocurrió un error. Intenta de nuevo.";
                            }
                        ?>
                    </div>
                <?php endif; ?>
         
                <form action="controllers/crudcomentarios/guardar_comentario.php" method="POST">
                    <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">

                    <div class="row align-items-center justify-content-center">
               
                        <div class="col-md-4 text-center mg-b-30">
                            <div class="label-ovalada">
                                Comentarios o sugerencias
                            </div>
                            <div class="d-flex justify-content-center">
                                <i class="fa fa-file-text-o decoracion-icono"></i>
                            </div>
                        </div>

                        <div class="col-md-7 mg-b-30">
                            <div class="textarea-marino-container">
                                <div><i class="fa fa-font"></i></div>
                                <textarea name="comentario" rows="8" class="textarea-custom" placeholder="Escribe aquí tu opinión o sugerencia..." required></textarea>
                            </div>

                            <div class="d-flex align-items-center justify-content-center mg-t-30 gap-4 flex-wrap">
                                <div>
                                    <button type="submit" class="btn-custom-agregar">Agregar</button>
                                </div>
                                <div>
                                    <a href="index.php?menu=servicios&opc=mis-comentarios" class="btn btn-custom-ver text-center">Ver comentarios</a>
                                </div>
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
</body>
</html>