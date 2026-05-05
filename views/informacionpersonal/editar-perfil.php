<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$id_usuario = $_SESSION['usuario_id'] ?? 4;

include_once 'views/bd/conexion.php';

$query = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result = mysqli_query($conexion, $query);
$usuario = mysqli_fetch_assoc($result);

$nombre_completo = trim(($usuario['nombre'] ?? 'Axel Jesús') . ' ' . ($usuario['apellido_paterno'] ?? 'Casique') . ' ' . ($usuario['apellido_materno'] ?? ''));
$telefono        = $usuario['telefono'] ?? '248 123 4567';
$direccion       = $usuario['direccion'] ?? 'San Martín Texmelucan, Puebla.';
$correo          = $usuario['correo_electronico'] ?? '';
$foto            = $usuario['foto'] ?? 'Axel.png';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Editar Información Personal</title>

    <link href="public/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="public/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/bracket.css">
    
    <style>
        .br-menu-sub { display: block !important; }
        .br-sideleft { background-color: #1d2127; }
        .br-menu-link.active { color: #17a2b8 !important; background-color: #1b1e24; }
        .active-text { color: #17a2b8 !important; font-weight: 700; }
    </style>
</head>

<body>

    <div class="br-logo"><a href="index.html"><span>DR.</span> WOOF<span>+</span></a></div>
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
      </div>

      <label class="sidebar-label pd-x-15 mg-t-25 mg-b-20 tx-info op-9">MIS MASCOTAS</label>
      <div class="br-sideleft-menu">
        <a href="#" class="br-menu-link show-sub">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-paw tx-22"></i>
            <span class="menu-item-label">Manchas</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="index.php?menu=mascotas&opc=info" class="nav-link">Información canina</a></li>
          <li class="nav-item"><a href="index.php?menu=servicios&opc=historial" class="nav-link">Historial medico</a></li>
          <li class="nav-item"><a href="index.php?menu=servicios&opc=agendam" class="nav-link">Citas</a></li>
          <li class="nav-item"><a href="index.php?menu=mascotas&opc=qr" class="nav-link">Qr</a></li>
          <li class="nav-item">
            <a href="index.php?menu=mascotas&opc=galeria" class="nav-link">Galeria de fotos</a>
          </li>
        </ul>

        <a href="#" class="br-menu-link show-sub mg-t-10">
          <div class="br-menu-item">
            <i class="icon ion-ios-paw tx-22"></i>
            <span class="menu-item-label">Huesos</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="index.php?menu=mascotas&opc=huesos-info" class="nav-link">Información canina</a></li>
          <li class="nav-item"><a href="index.php?menu=servicios&opc=huesos-historial" class="nav-link">Historial medico</a></li>
          <li class="nav-item"><a href="index.php?menu=servicios&opc=huesos-agenda" class="nav-link">Citas</a></li>
          <li class="nav-item"><a href="index.php?menu=mascotas&opc=huesos-qr" class="nav-link">Qr</a></li>
          <li class="nav-item"><a href="index.php?menu=mascotas&opc=huesos-galeria" class="nav-link">Galeria de fotos</a></li>
        </ul>
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
      <div class="br-header-right">
        <nav class="nav">
          <div class="dropdown">
            <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name"><?= $nombre_completo; ?></span>
              <img src="public/img/<?= $foto; ?>" class="wd-32 rounded-circle mg-l-10" alt="Perfil">
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-200">
              <ul class="list-unstyled user-profile-nav">
                <li><a href="index.php?menu=personal&opc=perfil"><i class="icon ion-ios-person"></i> Ver Perfil</a></li>
                <li><a href="index.php?menu=bienvenida"><i class="icon ion-power"></i> Cerrar Sesión</a></li>
                <li>
                  <a href="index.php?menu=personal&opc=eliminar" onclick="return confirm('¿Estás seguro de eliminar tu cuenta? Esta acción no se puede deshacer.');">
                    <i class="icon ion-power"></i> Eliminar cuenta
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>

    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.html">DR. WOOF</a>
          <a class="breadcrumb-item" href="index.php?menu=personal&opc=perfil">Perfil</a>
          <span class="breadcrumb-item active">Editar Información</span>
        </nav>
      </div>

      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Editar Datos del Propietario</h4>
        <p class="mg-b-0">Modifique sus datos de contacto en el sistema.</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
          <form action="index.php?menu=personal&opc=actualizar" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $usuario['id_usuario'] ?? $id_usuario; ?>">
            
            <div class="row row-sm">
              <div class="col-md-8">
                <div class="form-layout form-layout-1">
                  <div class="row mg-b-25">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">Nombre:</label>
                        <input class="form-control" type="text" name="nombre" value="<?= $usuario['nombre'] ?? ''; ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-6 mg-t-20">
                      <div class="form-group">
                        <label class="form-control-label">Apellido Paterno:</label>
                        <input class="form-control" type="text" name="paterno" value="<?= $usuario['apellido_paterno'] ?? ''; ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-6 mg-t-20">
                      <div class="form-group">
                        <label class="form-control-label">Apellido Materno:</label>
                        <input class="form-control" type="text" name="materno" value="<?= $usuario['apellido_materno'] ?? ''; ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-12 mg-t-20">
                      <div class="form-group">
                        <label class="form-control-label">Número de teléfono:</label>
                        <input class="form-control" type="text" name="telefono" value="<?= $usuario['telefono'] ?? ''; ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-12 mg-t-20">
                      <div class="form-group">
                        <label class="form-control-label">Dirección:</label>
                        <textarea rows="3" class="form-control" name="direccion" required><?= $usuario['direccion'] ?? ''; ?></textarea>
                      </div>
                    </div>
                    <div class="col-lg-12 mg-t-20">
                      <div class="form-group">
                        <label class="form-control-label">Correo Electrónico:</label>
                        <input class="form-control" type="email" name="correo" value="<?= $usuario['correo_electronico'] ?? ''; ?>" required>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-layout-footer text-right">
                    <button type="submit" class="btn btn-success pd-x-20">Guardar Cambios</button>
                    <a href="index.php?menu=personal&opc=perfil" class="btn btn-secondary pd-x-20 mg-l-5">Cancelar</a>
                  </div>
                </div>
              </div>

              <div class="col-md-4 mg-t-30 mg-md-t-0 text-center">
                <div class="card bd-0 pd-20">
                  <img class="card-img-top img-fluid rounded-circle wd-150 mx-auto" src="public/img/<?= $usuario['foto'] ?? 'Axel.png'; ?>" alt="Foto">
                  <div class="card-body bd bd-t-0 text-center mg-t-15">
                    <p class="card-text tx-bold tx-inverse tx-uppercase tx-11 mg-b-10">Actualizar Foto</p>
                    <input type="file" name="foto" class="form-control-file" accept="image/*">
                  </div>
                </div>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>
</body>
</html>