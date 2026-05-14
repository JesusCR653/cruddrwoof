<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'views/bd/conexion.php';

// ID de usuario desde la sesión
$id_usuario = $_SESSION['id_usuario'] ?? 4;

// Consulta para obtener los datos actualizados del usuario (Nombre y Foto)
$query_user = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result_user = mysqli_query($conexion, $query_user);
$usuario = mysqli_fetch_assoc($result_user);

$nombre_completo = trim(($usuario['nombre'] ?? 'Usuario') . ' ' . ($usuario['apellido_paterno'] ?? ''));

// Lógica de la foto de perfil con anti-caché
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
    <title>DR. WOOF - Historial Médico Manchas</title>

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
          <span class="breadcrumb-item active">Historial Médico</span>
        </nav>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper shadow-base bd-0">
          <div class="row">
            
            <div class="col-md-8">
              <div class="form-layout form-layout-1">
                <div class="row mg-b-25">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-control-label">Peso actual:</label>
                      <input class="form-control tx-bold tx-inverse" type="text" value="24.5 Kg" readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                  <div class="col-lg-12 mg-t-20">
                    <div class="form-group">
                      <label class="form-control-label">Diagnostico:</label>
                      <textarea rows="3" class="form-control" readonly style="background-color: #f8f9fa;">Paciente presenta dermatitis alérgica leve. Se recomienda cambio de dieta y baño medicado.</textarea>
                    </div>
                  </div>
                  <div class="col-lg-12 mg-t-20">
                    <div class="form-group">
                      <label class="form-control-label">Fecha de consulta:</label>
                      <input class="form-control" type="text" value="08 de Abril, 2026" readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                  <div class="col-lg-12 mg-t-20">
                    <div class="form-group">
                      <label class="form-control-label">Proxima revisión:</label>
                      <input class="form-control text-danger tx-bold" type="text" value="22 de Abril, 2026" readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4 text-center">
                <h6 class="tx-info tx-uppercase tx-bold mg-b-15">Archivos adjuntos:</h6>
                <div class="card bd-0 shadow-base pd-25 bg-gray-100 mg-b-20">
                    <i class="icon ion-ios-download-outline tx-70 tx-info"></i>
                    <p class="mg-t-10 tx-12 tx-gray-600">Recetas, Análisis Clínicos, Placas.</p>
                    <button class="btn btn-info btn-block btn-sm">Descargar Todo</button>
                </div>

                <h6 class="tx-info tx-uppercase tx-bold mg-b-15">Certificados:</h6>
                <div class="card bd-0 shadow-base pd-25 bg-gray-100">
                    <i class="icon ion-ios-paper-outline tx-70 tx-info"></i>
                    <p class="mg-t-10 tx-12 tx-gray-600">Cartilla de Vacunación Digital.</p>
                    <button class="btn btn-info btn-block btn-sm" onclick="location.href='index.php?menu=mascotas&opc=cartillamanchas'">Abrir Cartilla</button>
                </div>
            </div>

          </div>

          <div class="form-layout-footer mg-t-30 text-right">
            <button class="btn btn-outline-info pd-x-30" onclick="window.location.href='index.php?menu=servicios&opc=histom'">
              Ver historial completo
            </button>
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