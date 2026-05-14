<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'views/bd/conexion.php';

// ID de usuario desde la sesión
$id_usuario = $_SESSION['id_usuario'] ?? 4;

// Consulta para obtener los datos actualizados del usuario (Nombre y Foto)
$query_user = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result_user = mysqli_query($conexion, $query_user);
$usuario = mysqli_fetch_assoc($result_user);

$nombre_completo = trim(($usuario['nombre'] ?? 'Usuario') . ' ' . ($usuario['apellido_paterno'] ?? ''));

// Lógica de la foto de perfil con anti-caché (Columna FotoUS)
$foto_db = $usuario['FotoUS'] ?? ''; 
$foto_perfil = (!empty($foto_db) && file_exists('public/img/' . $foto_db)) 
               ? $foto_db . '?v=' . time() 
               : 'logo.png'; 
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
        .br-sideleft { background-color: #1d2127; }
        .br-menu-link.active {
            color: #17a2b8 !important;
            background-color: #1b1e24;
        }
    </style>
</head>

<body>

    <div class="br-logo"><a href="index.php"><span>DR.</span> WOOF<span>+</span></a></div>
    
    <div class="br-sideleft overflow-y-auto">
      <label class="sidebar-label pd-x-15 mg-t-20">Menú Principal</label>
      <div class="br-sideleft-menu">
        <a href="index.php?menu=panel&opc=bienvenida" class="br-menu-link">
          <div class="br-menu-item">
            <i class="icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">Inicio</span>
          </div>
        </a>
        <a href="index.php?menu=personal&opc=perfil" class="br-menu-link">
          <div class="br-menu-item">
            <i class="icon ion-ios-person-outline tx-24"></i>
            <span class="menu-item-label">Información Personal</span>
          </div>
        </a>
        <a href="index.php?menu=mascotas&opc=registro" class="br-menu-link">
          <div class="br-menu-item">
            <i class="icon ion-ios-plus-outline tx-24"></i>
            <span class="menu-item-label">Registro Canino</span>
          </div>
        </a>
        <a href="index.php?menu=mascotas&opc=listado" class="br-menu-link active">
          <div class="br-menu-item">
            <i class="icon ion-ios-paw tx-24"></i>
            <span class="menu-item-label">Mis Mascotas</span>
          </div>
        </a>
      </div>

      <label class="sidebar-label pd-x-15 mg-t-25 mg-b-20">Herramientas</label>
      <div class="br-sideleft-menu">
        <a href="index.php?menu=servicios&opc=agendag" class="br-menu-link">
          <div class="br-menu-item">
            <i class="icon ion-ios-calendar-outline tx-24"></i>
            <span class="menu-item-label">Agenda</span>
          </div>
        </a>
        <a href="index.php?menu=servicios&opc=recordatorios" class="br-menu-link">
          <div class="br-menu-item">
            <i class="icon ion-ios-alarm-outline tx-24"></i>
            <span class="menu-item-label">Recordatorios</span>
          </div>
        </a>
        <a href="index.php?menu=servicios&opc=comentarios" class="br-menu-link">
          <div class="br-menu-item">
            <i class="icon ion-ios-chatboxes-outline tx-24"></i>
            <span class="menu-item-label">Comentarios</span>
          </div>
        </a>
      </div>
    </div>

    <div class="br-header">
      <div class="br-header-left">
        <div class="navicon-left hidden-md-down">
          <a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a>
        </div>
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
                <span class="breadcrumb-item">Mascota</span>
                <span class="breadcrumb-item active">Generar QR</span>
            </nav>
        </div>

        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
            <h4 class="tx-gray-800 mg-b-5">Identificador Digital Canino</h4>
            <p class="mg-b-0">Genera el código único para la placa de tu mascota.</p>
        </div>

        <div class="br-pagebody">
            <div class="row row-sm justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow-base bd-0 pd-40 text-center">
                        <h5 class="tx-inverse tx-bold mg-b-20">Código de Identificación</h5>
                        <p class="tx-13 mg-b-30">Escanea este código para acceder al historial médico de tu mascota de forma inmediata.</p>
                        <div class="bg-gray-200 pd-40 mg-b-30 rounded d-inline-block mx-auto">
                            <i class="fa fa-qrcode tx-150 lh-0 tx-gray-800"></i>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-info pd-x-25 mg-r-10" onclick="$('#successModal').modal('show')">
                                <i class="fa fa-refresh mg-r-10"></i> Generar Nuevo
                            </button>
                            <button class="btn btn-outline-secondary pd-x-25">
                                <i class="fa fa-print mg-r-10"></i> Imprimir Placa
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="successModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-success tx-semibold mg-b-20">¡QR Generado!</h4>
                    <p class="mg-b-20 mg-x-20">El código único ha sido creado exitosamente y está listo para imprimirse.</p>
                    <button type="button" class="btn btn-success tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium mg-b-20" data-dismiss="modal">Aceptar</button>
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