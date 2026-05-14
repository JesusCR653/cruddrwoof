<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'views/bd/conexion.php';

$id_canino  = $_GET['id'] ?? 0;
$id_usuario = $_SESSION['id_usuario'];

$query     = "SELECT * FROM caninos WHERE id_canino = '$id_canino' AND id_usuario = '$id_usuario'";
$resultado = mysqli_query($conexion, $query);

$perro = mysqli_fetch_assoc($resultado);

if (!$perro) {
    header("Location: index.php?menu=mascotas&opc=listado");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Información de <?php echo $perro['nombre']; ?></title>

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
              <span class="logged-name"><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?></span>
              <img src="public/img/logo.png" class="wd-32 rounded-circle mg-l-10" alt="Perfil">
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
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.php">DR. WOOF</a>
          <span class="breadcrumb-item">Mascota</span>
          <span class="breadcrumb-item active"><?php echo $perro['nombre']; ?></span>
        </nav>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper shadow-base bd-0">
          <div class="row">

            <div class="col-md-8">
              <div class="form-layout form-layout-1">
                <div class="row mg-b-25">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label">Nombre del canino:</label>
                      <input class="form-control tx-bold tx-inverse" type="text" value="<?php echo $perro['nombre']; ?>" readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label">Raza:</label>
                      <input class="form-control" type="text" value="<?php echo $perro['raza']; ?>" readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                  <div class="col-lg-6 mg-t-20">
                    <div class="form-group">
                      <label class="form-control-label">Edad:</label>
                      <input class="form-control" type="text" value="<?php echo $perro['edad']; ?> años" readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                  <div class="col-lg-6 mg-t-20">
                    <div class="form-group">
                      <label class="form-control-label">Sexo:</label>
                      <input class="form-control" type="text" value="<?php echo $perro['sexo']; ?>" readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                  <div class="col-lg-6 mg-t-20">
                    <div class="form-group">
                      <label class="form-control-label">Color:</label>
                      <input class="form-control" type="text" value="<?php echo $perro['Color']; ?>" readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                  <div class="col-lg-6 mg-t-20">
                    <div class="form-group">
                      <label class="form-control-label">Peso:</label>
                      <input class="form-control" type="text" value="<?php echo $perro['peso']; ?> kg" readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                </div>
                <div class="form-layout-footer text-right">
                  <a href="index.php?menu=mascotas&opc=listado" class="btn btn-secondary pd-x-20 mg-r-10">
                    <i class="fa fa-arrow-left mg-r-5"></i> Regresar
                  </a>
                </div>
              </div>
            </div>

            <div class="col-md-4 text-center">
              <div class="card bd-0 shadow-base">
                <img class="card-img-top img-fluid" 
                     src="public/img/caninos/<?php echo $perro['fotoCan']; ?>" 
                     alt="<?php echo $perro['nombre']; ?>"
                     onerror="this.src='public/img/husky.png'">
                <div class="card-body bg-gray-100">
                  <p class="card-text tx-bold tx-inverse tx-uppercase tx-11">
                    <?php echo strtoupper($perro['nombre']); ?>
                  </p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/popper.js/popper.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>
</body>
</html>