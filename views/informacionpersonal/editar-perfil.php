<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'views/bd/conexion.php';

// ID de usuario desde la sesión
$id_usuario = $_SESSION['id_usuario'] ?? 4;

// Consulta según image_2e83b2.png (drwoof_db.usuarios)
$query = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result = mysqli_query($conexion, $query);
$usuario = mysqli_fetch_assoc($result);

// Variables dinámicas basadas en las columnas de tu BD
$nombre_completo = trim(($usuario['nombre'] ?? 'Usuario') . ' ' . ($usuario['apellido_paterno'] ?? ''));

// ✅ Nombre de columna FotoUS con truco anti-caché para refresco instantáneo
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
    <title>DR. WOOF - Editar Perfil</title>

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
        <a href="index.php?menu=personal&opc=perfil" class="br-menu-link active">
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
              <span class="logged-name"><?= $nombre_completo; ?></span>
              <img src="public/img/<?= $foto_perfil; ?>" class="wd-32 rounded-circle mg-l-10" alt="Perfil">
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
          <h6 class="tx-gray-800 tx-uppercase tx-bold mg-b-20">Actualizar mis datos personales</h6>
          
          <form action="index.php?menu=personal&opc=actualizar" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-8">
                <div class="form-layout form-layout-1 shadow-base">
                  <div class="row mg-b-25">
                    
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">Nombre(s):</label>
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

                  </div>

                  <div class="form-layout-footer text-right">
                    <button type="submit" class="btn btn-info pd-x-20">Guardar Cambios</button>
                    <a href="index.php?menu=personal&opc=perfil" class="btn btn-secondary pd-x-20 mg-l-5">Cancelar</a>
                  </div>
                </div>
              </div>

              <div class="col-md-4 text-center">
                <div class="card bd-0 pd-20 shadow-base">
                  <img class="card-img-top img-fluid rounded-circle wd-150 mx-auto" src="public/img/<?= $foto_perfil; ?>" alt="Foto">
                  <div class="mg-t-20">
                    <p class="tx-inverse tx-bold tx-uppercase tx-11 mg-b-10">Actualizar Foto de Perfil</p>
                    <input type="file" name="foto" class="form-control-file" accept="image/*">
                    <p class="tx-11 mg-t-10 text-muted">Selecciona una imagen nueva para tu perfil.</p>
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