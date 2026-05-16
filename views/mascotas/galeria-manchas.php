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

if (isset($_GET['id'])) {
    $id_canino = $_GET['id'];
} else {
    $id_canino = 0;
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

$foto_user = "logo.png";
if (isset($usuario['FotoUS']) && $usuario['FotoUS'] != "") {
    if (file_exists('public/img/' . $usuario['FotoUS'])) {
        $foto_user = $usuario['FotoUS'] . '?v=' . time();
    }
}

$query_dog = "SELECT nombre FROM caninos WHERE id_canino = '$id_canino' AND id_usuario = '$id_usuario'";
$result_dog = mysqli_query($conexion, $query_dog);
$perro = mysqli_fetch_assoc($result_dog);

if ($perro == false) {
    header("Location: index.php?menu=mascotas&opc=listado");
    exit();
}

$query_galeria = "SELECT * FROM galeria WHERE id_canino = '$id_canino' ORDER BY fecha_foto DESC";
$resultado_galeria = mysqli_query($conexion, $query_galeria);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Galería de <?php echo $perro['nombre']; ?></title>

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
            padding: 40px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: none !important;
            min-height: 85vh;
            margin-top: 0 !important;
        }

        .card-gallery {
            overflow: hidden;
            border: 4px solid #1e3a8a !important;
            border-radius: 15px !important;
            position: relative;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.04);
        }
        .img-gallery {
            height: 180px;
            object-fit: cover;
            width: 100%;
            transition: transform 0.3s ease;
        }
        .card-gallery:hover .img-gallery {
            transform: scale(1.04);
        }
        
        .gallery-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 6px;
            opacity: 0;
            transition: 0.3s;
            z-index: 10;
        }
        .card-gallery:hover .gallery-actions {
            opacity: 1;
        }

        .btn-green-woof {
            background-color: #92bc5c !important;
            border: none !important;
            color: #ffffff !important;
            border-radius: 25px !important;
            font-weight: bold;
            padding: 10px 25px !important;
        }
        .btn-custom-modal-save {
            background-color: #92bc5c !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            font-weight: bold;
        }
        .btn-custom-modal-edit {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            font-weight: bold;
        }
        .btn-custom-modal-cancel {
            background-color: #6c757d !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            font-weight: bold;
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
          <h6>GALERÍA DE FOTOS</h6>
      </div>

      <div class="br-header-right">
        <nav class="nav">
          <div class="dropdown">
            <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name"><?php echo $nombre_completo; ?></span>
              <img src="public/img/<?php echo $foto_user; ?>" class="wd-32 rounded-circle mg-l-10" alt="Perfil">
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
          <a class="breadcrumb-item" href="index.php?menu=mascotas&opc=listado">Mascotas</a>
          <span class="breadcrumb-item active">Galería</span>
        </nav>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
          
          <div class="d-flex align-items-center justify-content-between mg-b-30 flex-wrap gap-3">
            <div>
              <h4 class="tx-inverse tx-bold mg-b-5">Galería: <?php echo htmlspecialchars($perro['nombre']); ?></h4>
              <p class="mg-b-0 text-muted">Recuerdos fotográficos de tu mascota organizados cronológicamente.</p>
            </div>
            <button class="btn btn-green-woof" id="btnAbrirSubir">
              <i class="fa fa-camera mg-r-10"></i> Subir Foto
            </button>
          </div>

          <div class="row row-sm">
            
            <?php if (mysqli_num_rows($resultado_galeria) > 0): ?>
              <?php while($foto = mysqli_fetch_assoc($resultado_galeria)): ?>
                <div class="col-sm-6 col-md-4 col-lg-3 mg-b-25">
                  <div class="card card-gallery">
                    
                    <div class="gallery-actions">
                      <button class="btn btn-warning btn-icon btn-sm rounded-circle" 
                              onclick="abrirEditar('<?php echo $foto['id_foto']; ?>', '<?php echo addslashes($foto['titulo_foto']); ?>', '<?php echo addslashes($foto['notas_proceso']); ?>')">
                          <i class="fa fa-edit text-white"></i>
                      </button>
                      <a href="index.php?menu=mascotas&opc=eliminar-foto&id_foto=<?php echo $foto['id_foto']; ?>&id_canino=<?php echo $id_canino; ?>" 
                         class="btn btn-danger btn-icon btn-sm rounded-circle" 
                         onclick="return confirm('¿Eliminar esta foto?')">
                          <i class="fa fa-trash text-white"></i>
                      </a>
                    </div>

                    <img class="img-gallery" src="public/img/caninos/<?php echo $foto['ruta_foto']; ?>" alt="Foto Canina">
                    
                    <div class="pd-15">
                      <p class="tx-14 tx-inverse tx-bold mg-b-5 text-uppercase">
                        <?php echo htmlspecialchars($foto['titulo_foto']); ?>
                      </p>
                      <p class="tx-12 text-muted mg-b-8">Fecha: <?php echo htmlspecialchars($foto['fecha_foto']); ?></p>
                      <p class="tx-13 text-secondary mg-b-0 font-italic"><?php echo htmlspecialchars($foto['notas_proceso']); ?></p>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <div class="col-12 text-center pd-y-60">
                <i class="icon ion-ios-images-outline tx-70 text-muted"></i>
                <p class="tx-15 text-muted mg-t-15">Aún no hay fotos en esta galería. ¡Sube la primera!</p>
              </div>
            <?php endif; ?>

          </div>

        </div>
      </div>
    </div>

    <div id="uploadModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm" style="border-radius: 15px; overflow: hidden;">
          <form action="index.php?menu=mascotas&opc=subir-galeria" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_canino" value="<?php echo $id_canino; ?>">
            <div class="modal-header pd-x-20 bg-gray-100">
              <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Nueva Foto: <?php echo htmlspecialchars($perro['nombre']); ?></h6>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body pd-20">
              <div class="form-group">
                <label class="form-control-label font-weight-bold">Imagen:</label>
                <input type="file" name="archivo_foto" class="form-control" required accept="image/*">
              </div>
              <div class="form-group">
                <label class="form-control-label font-weight-bold">Título:</label>
                <input type="text" name="titulo" class="form-control" placeholder="Ej: Primer baño" required>
              </div>
              <div class="form-group">
                <label class="form-control-label font-weight-bold">Notas:</label>
                <textarea name="notas" class="form-control" placeholder="Ej: Se portó muy bien" rows="3"></textarea>
              </div>
              <div class="form-group">
                <label class="form-control-label font-weight-bold">Fecha:</label>
                <input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>">
              </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-custom-modal-save pd-x-25">Guardar</button>
                <button type="button" class="btn btn-secondary btn-custom-modal-cancel pd-x-25" data-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="editModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm" style="border-radius: 15px; overflow: hidden;">
          <form action="index.php?menu=mascotas&opc=editar-foto" method="POST">
            <input type="hidden" name="id_canino" value="<?php echo $id_canino; ?>">
            <input type="hidden" name="id_foto" id="edit_id_foto">
            <div class="modal-header pd-x-20 bg-gray-100">
              <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Editar Información</h6>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body pd-20">
              <div class="form-group">
                <label class="form-control-label font-weight-bold">Título:</label>
                <input type="text" name="titulo" id="edit_titulo" class="form-control" required>
              </div>
              <div class="form-group">
                <label class="form-control-label font-weight-bold">Notas:</label>
                <textarea name="notas" id="edit_notas" class="form-control" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info btn-custom-modal-edit pd-x-25">Actualizar</button>
                <button type="button" class="btn btn-secondary btn-custom-modal-cancel pd-x-25" data-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>

    <script>
    var botonAbrirSubir = document.getElementById("btnAbrirSubir");
    botonAbrirSubir.onclick = function() {
        $('#uploadModal').modal('show');
    };

    function abrirEditar(id, titulo, notas) {
        document.getElementById('edit_id_foto').value = id;
        document.getElementById('edit_titulo').value = titulo;
        document.getElementById('edit_notas').value = notas;
        $('#editModal').modal('show');
    }
    </script>
</body>
</html>