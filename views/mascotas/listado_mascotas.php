<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'views/bd/conexion.php';

$id_usuario = $_SESSION['id_usuario'] ?? 4;

$query = "SELECT * FROM caninos WHERE id_usuario = '$id_usuario'";
$resultado = mysqli_query($conexion, $query);

$query_user = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result_user = mysqli_query($conexion, $query_user);
$usuario = mysqli_fetch_assoc($result_user);

$nombre_usuario = $usuario['nombre'] ?? $_SESSION['nombre'] ?? 'Usuario';
$apellido_usuario = $usuario['apellido_paterno'] ?? $_SESSION['apellido'] ?? '';
$nombre_completo = trim($nombre_usuario . ' ' . $apellido_usuario);

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
    <title>DR. WOOF - Mis Mascotas</title>

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
        .br-pagebody { margin-top: 20px; }
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
      <div class="br-pagebody">
        <div class="br-section-wrapper">
          <div class="d-flex align-items-center justify-content-between mg-b-20">
              <h6 class="tx-gray-800 tx-uppercase tx-bold mg-b-0">Mis mascotas</h6>
              <a href="index.php?menu=mascotas&opc=registro" class="btn btn-info btn-sm pd-x-15">
                  <i class="fa fa-plus mg-r-5"></i> Agregar Mascota
              </a>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered mg-b-0">
                <thead class="thead-dark bg-dark">
                    <tr class="tx-white">
                        <th class="wd-5p text-uppercase tx-12">ID</th>
                        <th class="wd-15p text-uppercase tx-12">NOMBRE</th>
                        <th class="wd-15p text-uppercase tx-12">RAZA</th>
                        <th class="wd-45p text-uppercase tx-12 text-center">SERVICIOS</th>
                        <th class="wd-20p text-uppercase tx-12 text-center">GESTIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($resultado) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($resultado)): ?>
                        <tr class="tx-inverse bg-light">
                            <td class="valign-middle"><?php echo $row['id_canino']; ?></td>
                            <td class="valign-middle"><strong class="tx-info"><?php echo $row['nombre']; ?></strong></td>
                            <td class="valign-middle"><?php echo $row['raza']; ?></td>
                            <td class="text-center">
                                <div class="btn-group shadow-base" role="group">
                                    <a href="index.php?menu=mascotas&opc=info&id=<?php echo $row['id_canino']; ?>" class="btn btn-outline-info btn-sm">Info</a>
                                    <a href="index.php?menu=servicios&opc=historial&id=<?php echo $row['id_canino']; ?>" class="btn btn-outline-info btn-sm">Historial</a>
                                    <a href="index.php?menu=servicios&opc=agendam&id=<?php echo $row['id_canino']; ?>" class="btn btn-outline-info btn-sm">Citas</a>
                                    <a href="index.php?menu=mascotas&opc=qr&id=<?php echo $row['id_canino']; ?>" class="btn btn-outline-info btn-sm">QR</a>
                                    <a href="index.php?menu=mascotas&opc=galeria&id=<?php echo $row['id_canino']; ?>" class="btn btn-outline-info btn-sm">Fotos</a>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="index.php?menu=mascotas&opc=editar&id=<?php echo $row['id_canino']; ?>" class="btn btn-warning btn-icon btn-sm" title="Editar">
                                    <div><i class="fa fa-edit"></i></div>
                                </a>
                                <a href="index.php?menu=mascotas&opc=eliminar&id=<?php echo $row['id_canino']; ?>" class="btn btn-danger btn-icon btn-sm mg-l-5" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar esta mascota?')">
                                    <div><i class="fa fa-trash"></i></div>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="tx-center tx-gray-500 pd-y-20">
                                <i class="icon ion-ios-paw tx-40 d-block mg-b-10"></i>
                                No tienes mascotas registradas aún.
                            </td>
                        </tr>
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