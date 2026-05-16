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

$query = "SELECT * FROM caninos WHERE id_usuario = '$id_usuario'";
$resultado = mysqli_query($conexion, $query);

$query_user = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result_user = mysqli_query($conexion, $query_user);
$usuario = mysqli_fetch_assoc($result_user);

$nombre_usuario = "Usuario";
if (isset($usuario['nombre'])) {
    $nombre_usuario = $usuario['nombre'];
} else if (isset($_SESSION['nombre'])) {
    $nombre_usuario = $_SESSION['nombre'];
}

$apellido_usuario = "";
if (isset($usuario['apellido_paterno'])) {
    $apellido_usuario = $usuario['apellido_paterno'];
} else if (isset($_SESSION['apellido'])) {
    $apellido_usuario = $_SESSION['apellido'];
}

$apellido_materno = "";
if (isset($usuario['apellido_materno'])) {
    $apellido_materno = $usuario['apellido_materno'];
} else if (isset($_SESSION['apellidom'])) {
    $apellido_materno = $_SESSION['apellidom'];
}

$nombre_completo = $nombre_usuario . ' ' . $apellido_usuario . ' ' . $apellido_materno;

$foto_perfil = 'logo.png';
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
    <title>DR. WOOF - Mis Mascotas</title>

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
            margin-top: 0 !important;
        }

        .label-turquesa {
            background-color: #34b5e5 !important;
            color: white !important;
            padding: 10px 25px;
            font-weight: bold;
            border-radius: 25px !important;
            display: inline-block;
            text-transform: uppercase;
            font-size: 14px;
        }

        .btn-custom-agregar {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 10px 30px !important;
            font-size: 15px !important;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .thead-marino th {
            background-color: #1e3a8a !important;
            color: white !important;
            border: none !important;
            font-size: 13px !important;
            text-transform: uppercase;
            font-weight: bold;
            padding: 15px !important;
        }

        .btn-outline-custom-service {
            border: 2px solid #34b5e5 !important;
            color: #34b5e5 !important;
            background-color: transparent;
            font-weight: bold;
            padding: 6px 15px;
            transition: all 0.2s;
        }
        .btn-outline-custom-service:hover {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
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
          <div class="br-menu-item"><i class="icon ion-ios-plus-outline tx-24"></i><span class="menu-item-label">Registro Canino</span></div>
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
      </div>
    </div>

    <div class="br-header">
      <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
      </div>

      <div class="header-welcome-centered">
          <h6>MIS MASCOTAS</h6>
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
        <div class="br-section-wrapper">
          
          <div class="d-flex align-items-center justify-content-between mg-b-30 flex-wrap gap-3">
              <span class="label-turquesa">Mis Mascotas registradas</span>
              <a href="index.php?menu=mascotas&opc=registro" class="btn-custom-agregar">
                  <i class="fa fa-plus"></i> Agregar Nueva
              </a>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
                <thead class="thead-marino">
                    <tr>
                        <th class="wd-5p text-center">ID</th>
                        <th class="wd-15p">Mascota</th>
                        <th class="wd-15p">Raza</th>
                        <th class="wd-50p text-center">Opciones de Servicio</th>
                        <th class="wd-15p text-center">Gestión</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($resultado) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($resultado)): ?>
                        <tr class="tx-inverse bg-white text-center">
                            <td class="valign-middle font-weight-bold"><?php echo $row['id_canino']; ?></td>
                            <td class="valign-middle text-left"><strong style="color: #1e3a8a; font-size: 15px;"><?php echo htmlspecialchars($row['nombre']); ?></strong></td>
                            <td class="valign-middle text-left"><?php echo htmlspecialchars($row['raza']); ?></td>
                            <td class="valign-middle text-center">
                                <div class="btn-group" role="group">
                                    <a href="index.php?menu=mascotas&opc=info&id=<?php echo $row['id_canino']; ?>" class="btn btn-outline-custom-service btn-sm">Info</a>
                                    <a href="index.php?menu=mascotas&opc=qr&id=<?php echo $row['id_canino']; ?>" class="btn btn-outline-custom-service btn-sm">QR</a>
                                    <a href="index.php?menu=servicios&opc=historial&id=<?php echo $row['id_canino']; ?>" class="btn btn-outline-custom-service btn-sm">Historial</a>
                                    <a href="index.php?menu=servicios&opc=agendam&id=<?php echo $row['id_canino']; ?>" class="btn btn-outline-custom-service btn-sm">Citas</a>
                                    <a href="index.php?menu=mascotas&opc=galeria&id=<?php echo $row['id_canino']; ?>" class="btn btn-outline-custom-service btn-sm">Fotos</a>
                                </div>
                            </td>
                            <td class="valign-middle text-center">
                                <a href="index.php?menu=mascotas&opc=editar&id=<?php echo $row['id_canino']; ?>" class="btn btn-warning btn-icon btn-sm" style="border-radius: 6px;"><i class="fa fa-edit"></i></a>
                                <a href="index.php?menu=mascotas&opc=eliminar&id=<?php echo $row['id_canino']; ?>" class="btn btn-danger btn-icon btn-sm mg-l-5" style="border-radius: 6px;" onclick="return confirm('¿Estás seguro de eliminar a esta mascota?')"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center pd-y-40 text-muted font-weight-bold">No tienes mascotas registradas aún.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>
</body>
</html>