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
$nombre_completo = $nombre_usuario . " " . $apellido_usuario;

$foto_perfil = "logo.png";
if (isset($usuario['FotoUS']) && $usuario['FotoUS'] != "") {
    if (file_exists('public/img/' . $usuario['FotoUS'])) {
        $foto_perfil = $usuario['FotoUS'] . '?v=' . time();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Generar QR</title>

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
            padding: 60px 30px !important;
        }

        .qr-display-area {
            background-color: #cdebf7 !important;
            border-radius: 20px;
            padding: 20px;
            display: inline-block;
        }

        .qr-icon-big {
            font-size: 280px !important;
            color: #000000 !important;
            line-height: 1;
        }

        .btn-custom-generar {
            background-color: #92bc5c !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 50px !important;
            font-size: 16px !important;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
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
            <h6>GENERAR QR</h6>
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
                            <li><a href="index.php?menu=sesion&opc=cerrar"><i class="icon ion-power"></i> Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="br-mainpanel">
        <div class="br-pagebody text-center d-flex flex-column align-items-center justify-content-center" style="min-height: 80vh;">
            
            <div class="mg-b-40">
                <div class="qr-display-area">
                    <i class="fa fa-qrcode qr-icon-big"></i>
                </div>
            </div>

            <div>
                <button type="button" class="btn-custom-generar" id="btnGenerarQR">
                    Generar Nuevo
                </button>
            </div>

        </div>
    </div>

    <div id="successModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content tx-size-sm" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-success tx-semibold mg-b-20">¡QR Generado!</h4>
                    <p class="mg-b-20 mg-x-20">El código único ha sido creado exitosamente.</p>
                    <button type="button" class="btn btn-success tx-uppercase pd-y-12 pd-x-25 tx-bold" data-dismiss="modal" style="border-radius: 20px; background-color: #92bc5c; border: none;">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>

    <script>
        var botonGenerar = document.getElementById("btnGenerarQR");
        botonGenerar.onclick = function() {
            $('#successModal').modal('show');
        };
    </script>
</body>
</html>