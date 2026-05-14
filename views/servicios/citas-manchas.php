<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'views/bd/conexion.php';

$id_usuario = $_SESSION['id_usuario'] ?? 4;

$query_user = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result_user = mysqli_query($conexion, $query_user);
$usuario = mysqli_fetch_assoc($result_user);

$nombre_completo = trim(($usuario['nombre'] ?? 'Usuario') . ' ' . ($usuario['apellido_paterno'] ?? ''));
$foto_perfil = (!empty($usuario['FotoUS']) && file_exists('public/img/' . $usuario['FotoUS'])) 
                ? $usuario['FotoUS'] . '?v=' . time() 
                : 'logo.png'; 

$id_canino_url = $_GET['id'] ?? 0;
$query_dog = "SELECT nombre FROM caninos WHERE id_canino = '$id_canino_url' AND id_usuario = '$id_usuario'";
$res_dog = mysqli_query($conexion, $query_dog);
$perro = mysqli_fetch_assoc($res_dog);

$mascotas_user = mysqli_query($conexion, "SELECT id_canino, nombre FROM caninos WHERE id_usuario = '$id_usuario'");
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
        .br-sideleft { background-color: #1d2127; }
        .br-menu-link.active { color: #17a2b8 !important; background-color: #1b1e24; }
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
        <a href="index.php?menu=mascotas&opc=listado" class="br-menu-link">
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
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
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
          <span class="breadcrumb-item active">Agendar Cita</span>
        </nav>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper shadow-base bd-0 text-center">
          <h6 class="tx-inverse tx-uppercase tx-bold tx-14 mg-b-20">
            Nueva Cita <?php echo $perro ? "para " . $perro['nombre'] : ""; ?>
          </h6>
          
          <form action="index.php?menu=servicios&opc=guardar-cita" method="POST">
            <div class="form-layout form-layout-1">
                <div class="row mg-b-25 justify-content-center">
                    
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="form-control-label">Mascota: <span class="tx-danger">*</span></label>
                            <select name="id_canino" class="form-control" required>
                                <?php if($perro): ?>
                                    <option value="<?= $id_canino_url ?>"><?= $perro['nombre'] ?></option>
                                <?php else: ?>
                                    <option value="">-- Selecciona una mascota --</option>
                                    <?php while($m = mysqli_fetch_assoc($mascotas_user)): ?>
                                        <option value="<?= $m['id_canino'] ?>"><?= $m['nombre'] ?></option>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="form-control-label">Fecha de la cita: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="date" name="fecha" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="col-lg-5 mg-t-20">
                        <div class="form-group">
                            <label class="form-control-label">Hora: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="time" name="hora" value="12:00" required>
                        </div>
                    </div>

                    <div class="col-lg-10 mg-t-20">
                        <div class="form-group mg-b-0">
                            <label class="form-control-label">Motivo de la cita: <span class="tx-danger">*</span></label>
                            <textarea rows="3" class="form-control" name="motivo_cita" placeholder="Ej: Refuerzo de vacuna triple o revisión de crecimiento" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-layout-footer mg-t-30">
                    <button type="submit" class="btn btn-success pd-x-40 tx-uppercase tx-bold tx-11">Agendar</button>
                    
                    <button type="button" class="btn btn-info pd-x-40 tx-uppercase tx-bold tx-11 mg-l-5" onclick="location.href='index.php?menu=servicios&opc=listado_citas'">Lista de citas</button>
                    
                    <button type="button" class="btn btn-secondary pd-x-40 tx-uppercase tx-bold tx-11 mg-l-5" onclick="history.back()">Regresar</button>
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