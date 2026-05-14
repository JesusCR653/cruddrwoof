<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'views/bd/conexion.php';

// ID de usuario e ID de mascota desde la URL
$id_usuario = $_SESSION['id_usuario'] ?? 4;
$id_canino  = $_GET['id'] ?? 0;

// 1. Consulta para los datos del usuario (Header) basado en drwoof_db.usuarios
$query_user = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result_user = mysqli_query($conexion, $query_user);
$usuario = mysqli_fetch_assoc($result_user);

$nombre_completo = trim(($usuario['nombre'] ?? 'Usuario') . ' ' . ($usuario['apellido_paterno'] ?? ''));
$foto_user = (!empty($usuario['FotoUS']) && file_exists('public/img/' . $usuario['FotoUS'])) 
             ? $usuario['FotoUS'] . '?v=' . time() 
             : 'logo.png';

// 2. Consulta para los datos de la mascota (Título y Validación)
$query_dog = "SELECT nombre FROM caninos WHERE id_canino = '$id_canino' AND id_usuario = '$id_usuario'";
$result_dog = mysqli_query($conexion, $query_dog);
$perro = mysqli_fetch_assoc($result_dog);

if (!$perro) {
    header("Location: index.php?menu=mascotas&opc=listado");
    exit();
}

// 3. Consulta de la tabla GALERIA según image_2df4cc.png
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
        .br-sideleft { background-color: #1d2127; }
        .br-menu-link.active { color: #17a2b8 !important; background-color: #1b1e24; }
        .img-gallery { height: 200px; object-fit: cover; width: 100%; border-radius: 5px 5px 0 0; transition: transform 0.3s ease; }
        .card-gallery:hover .img-gallery { transform: scale(1.05); }
        .card-gallery { overflow: hidden; border: 1px solid #dee2e6; position: relative; }
        .btn-green-woof { background-color: #23BF08 !important; border-color: #23BF08 !important; color: #ffffff !important; }
        .gallery-actions { position: absolute; top: 10px; right: 10px; display: flex; gap: 5px; opacity: 0; transition: 0.3s; }
        .card-gallery:hover .gallery-actions { opacity: 1; }
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
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
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

      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30 d-flex align-items-center justify-content-between">
        <div>
          <h4 class="tx-gray-800 mg-b-5">Galería: <?php echo $perro['nombre']; ?></h4>
          <p class="mg-b-0">Recuerdos fotográficos de tu mascota.</p>
        </div>
        <!-- ✅ BOTÓN VERDE DE CÁMARA CONFIGURADO -->
        <button class="btn btn-green-woof btn-with-icon" onclick="$('#uploadModal').modal('show')">
          <div class="ht-40">
            <span class="icon wd-40"><i class="fa fa-camera"></i></span>
            <span class="pd-x-15">Subir Foto</span>
          </div>
        </button>
      </div>

      <div class="br-pagebody">
        <div class="row row-sm mg-t-20">
          
          <?php if (mysqli_num_rows($resultado_galeria) > 0): ?>
            <?php while($foto = mysqli_fetch_assoc($resultado_galeria)): ?>
              <div class="col-sm-6 col-md-4 col-lg-3 mg-b-20">
                <div class="card shadow-base bd-0 card-gallery">
                  <!-- Acciones sobre la card -->
                  <div class="gallery-actions">
                    <button class="btn btn-warning btn-icon btn-sm rounded-circle" 
                            onclick="abrirEditar('<?php echo $foto['id_foto']; ?>', '<?php echo addslashes($foto['titulo_foto']); ?>', '<?php echo addslashes($foto['notas_proceso']); ?>')">
                        <i class="fa fa-edit text-white"></i>
                    </button>
                    <!-- ✅ ELIMINAR: Redirige al controlador central index.php -->
                    <a href="index.php?menu=mascotas&opc=eliminar-foto&id_foto=<?php echo $foto['id_foto']; ?>&id_canino=<?php echo $id_canino; ?>" 
                       class="btn btn-danger btn-icon btn-sm rounded-circle" 
                       onclick="return confirm('¿Eliminar esta foto?')">
                        <i class="fa fa-trash text-white"></i>
                    </a>
                  </div>

                  <img class="img-gallery" src="public/img/caninos/<?php echo $foto['ruta_foto']; ?>" alt="Foto">
                  <div class="pd-15">
                    <p class="tx-11 tx-uppercase tx-mont tx-semibold mg-b-5">
                      <?php echo $foto['titulo_foto']; ?>
                    </p>
                    <p class="tx-12 tx-gray-600 mg-b-5">Fecha: <?php echo $foto['fecha_foto']; ?></p>
                    <p class="tx-13 mg-b-0 italic"><?php echo $foto['notas_proceso']; ?></p>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <div class="col-12 text-center mg-t-40">
              <i class="icon ion-ios-images-outline tx-60 tx-gray-400"></i>
              <p class="tx-gray-600">Aún no hay fotos en esta galería.</p>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </div>

    <!-- ✅ MODAL SUBIR: action apunta al controlador central index.php -->
    <div id="uploadModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
          <form action="index.php?menu=mascotas&opc=subir-galeria" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_canino" value="<?php echo $id_canino; ?>">
            <div class="modal-header pd-x-20">
              <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Nueva Foto: <?php echo $perro['nombre']; ?></h6>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body pd-20">
              <div class="form-group">
                <label class="form-control-label">Imagen:</label>
                <input type="file" name="archivo_foto" class="form-control" required accept="image/*">
              </div>
              <div class="form-group">
                <label class="form-control-label">Título:</label>
                <input type="text" name="titulo" class="form-control" placeholder="Ej: Primer baño" required>
              </div>
              <div class="form-group">
                <label class="form-control-label">Notas:</label>
                <textarea name="notas" class="form-control" placeholder="Ej: Se portó muy bien"></textarea>
              </div>
              <div class="form-group">
                <label class="form-control-label">Fecha:</label>
                <input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>">
              </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- ✅ MODAL EDITAR: action apunta al controlador central index.php -->
    <div id="editModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
          <form action="index.php?menu=mascotas&opc=editar-foto" method="POST">
            <input type="hidden" name="id_canino" value="<?php echo $id_canino; ?>">
            <input type="hidden" name="id_foto" id="edit_id_foto">
            <div class="modal-header pd-x-20">
              <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Editar Información</h6>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body pd-20">
              <div class="form-group">
                <label class="form-control-label">Título:</label>
                <input type="text" name="titulo" id="edit_titulo" class="form-control" required>
              </div>
              <div class="form-group">
                <label class="form-control-label">Notas:</label>
                <textarea name="notas" id="edit_notas" class="form-control"></textarea>
              </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Actualizar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>

    <script>
    function abrirEditar(id, titulo, notas) {
        $('#edit_id_foto').val(id);
        $('#edit_titulo').val(titulo);
        $('#edit_notas').val(notas);
        $('#editModal').modal('show');
    }
    </script>
</body>
</html>