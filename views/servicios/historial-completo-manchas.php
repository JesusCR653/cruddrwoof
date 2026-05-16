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
$nombre_completo = $nombre_usuario . ' ' . $apellido_usuario;

$foto_perfil = 'logo.png';
if (isset($usuario['FotoUS']) && $usuario['FotoUS'] != "") {
    if (file_exists('public/img/' . $usuario['FotoUS'])) {
        $foto_perfil = $usuario['FotoUS'] . '?v=' . time();
    }
} 

if (isset($_GET['id'])) {
    $id_canino = $_GET['id'];
} else {
    $id_canino = 0;
}

$query_dog = mysqli_query($conexion, "SELECT nombre FROM caninos WHERE id_canino = '$id_canino' AND id_usuario = '$id_usuario'");
$perro = mysqli_fetch_assoc($query_dog);

$nombre_mascota = "la mascota";
if ($perro != false) {
    $nombre_mascota = $perro['nombre'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Historial Médico de <?php echo htmlspecialchars($nombre_mascota); ?></title>

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

        .thead-marino th {
            background-color: #1e3a8a !important;
            color: white !important;
            border: none !important;
            font-size: 13px !important;
            text-transform: uppercase;
            font-weight: bold;
            padding: 15px !important;
        }

        .btn-outline-custom-table {
            border: 2px solid #34b5e5 !important;
            color: #34b5e5 !important;
            background-color: transparent;
            font-weight: bold;
            transition: all 0.2s;
        }
        .btn-outline-custom-table:hover {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
        }

        .btn-custom-regresar {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 40px !important;
            font-size: 15px !important;
            font-weight: bold;
            display: inline-block;
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
          <h6>HISTORIAL MÉDICO COMPLETO</h6>
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
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.php">DR. WOOF</a>
          <span class="breadcrumb-item active">Historial Completo</span>
        </nav>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper d-flex flex-column justify-content-center">
          
          <div class="mg-b-30">
              <span class="label-turquesa mg-b-10">Historial Médico de <?php echo htmlspecialchars($nombre_mascota); ?></span>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="thead-marino">
                <tr>
                  <th class="wd-15p text-center">Fecha</th>
                  <th class="wd-15p text-center">Peso</th>
                  <th class="wd-50p text-left">Diagnóstico / Motivo</th>
                  <th class="wd-20p text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr class="tx-inverse bg-white text-center">
                  <td class="valign-middle">08/04/2026</td>
                  <td class="valign-middle font-weight-bold">24.5 Kg</td>
                  <td class="valign-middle text-left"><strong>Dermatitis Alérgica:</strong> Inicio de tratamiento con champú medicado y dieta hipoalergénica.</td>
                  <td class="valign-middle text-center">
                    <button class="btn btn-outline-custom-table btn-icon btn-sm" title="Ver Receta"><i class="fa fa-file-pdf-o"></i></button>
                    <button class="btn btn-outline-custom-table btn-icon btn-sm mg-l-5" title="Ver Fotos"><i class="fa fa-image"></i></button>
                  </td>
                </tr>
                <tr class="tx-inverse bg-white text-center">
                  <td class="valign-middle">15/01/2026</td>
                  <td class="valign-middle font-weight-bold">23.8 Kg</td>
                  <td class="valign-middle text-left"><strong>Check-up Anual:</strong> Vacunación Sextuple y Rabia. Parámetros normales.</td>
                  <td class="valign-middle text-center">
                    <button class="btn btn-outline-custom-table btn-icon btn-sm"><i class="fa fa-file-pdf-o"></i></button>
                  </td>
                </tr>
                <tr class="tx-inverse bg-white text-center">
                  <td class="valign-middle">10/11/2025</td>
                  <td class="valign-middle font-weight-bold">24.0 Kg</td>
                  <td class="valign-middle text-left"><strong>Desparasitación:</strong> Aplicación de refuerzo interno y externo.</td>
                  <td class="valign-middle text-center">
                    <button class="btn btn-outline-custom-table btn-icon btn-sm"><i class="fa fa-file-pdf-o"></i></button>
                  </td>
                </tr>
                <tr class="tx-inverse bg-white text-center">
                  <td class="valign-middle">02/09/2025</td>
                  <td class="valign-middle font-weight-bold">22.5 Kg</td>
                  <td class="valign-middle text-left"><strong>Infección Estomacal:</strong> Tratamiento con antibióticos por 7 días debido a ingesta de basura.</td>
                  <td class="valign-middle text-center">
                    <button class="btn btn-outline-custom-table btn-icon btn-sm"><i class="fa fa-file-pdf-o"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="mg-t-40 text-center">
            <a href="idex.php?menu=mascotas&opc=listado" id="btnRegresarHistorial" class="btn btn-custom-regresar">Regresar</a>
          </div>

        </div>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>
    <script>
    var botonRegresar = document.getElementById("btnRegresarHistorial");
    botonRegresar.onclick = function(e) {
        e.preventDefault();
        window.history.back();
    };
    </script>
</body>
</html>