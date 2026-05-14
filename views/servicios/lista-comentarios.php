<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Variable de sesión estandarizada
$id_usuario = $_SESSION['id_usuario'] ?? 4;

$ruta_conexion = $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';
if (file_exists($ruta_conexion)) {
    include_once $ruta_conexion;
} else {
    include_once 'views/bd/conexion.php';
}

// 1. Consulta para los datos del usuario (Header y Menu dinámico)
$query_user = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result_user = mysqli_query($conexion, $query_user);
$usuario = mysqli_fetch_assoc($result_user);

$nombre_completo = trim(($usuario['nombre'] ?? 'Usuario') . ' ' . ($usuario['apellido_paterno'] ?? ''));
$foto_user = (!empty($usuario['FotoUS']) && file_exists('public/img/' . $usuario['FotoUS'])) 
             ? $usuario['FotoUS'] . '?v=' . time() 
             : 'logo.png';

// 2. Consulta de comentarios
$result = mysqli_query($conexion, "SELECT * FROM comentarios WHERE id_usuario = '$id_usuario' ORDER BY fecha_registro DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Mis Comentarios</title>
    <link href="public/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="public/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/bracket.css">
    <style>
        .br-sideleft { background-color: #1d2127; }
        .br-menu-link.active { color: #17a2b8 !important; background-color: #1b1e24; }
        .comment-item { border-left: 4px solid #23BF08; }
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
        <a href="index.php?menu=servicios&opc=comentarios" class="br-menu-link active">
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
          <a class="breadcrumb-item" href="index.php?menu=servicios&opc=comentarios">Comentarios</a>
          <span class="breadcrumb-item active">Listado</span>
        </nav>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper shadow-base bd-0">
          <h6 class="tx-inverse tx-uppercase tx-bold tx-14 mg-b-25">Historial de Comentarios</h6>

          <div class="list-group">
            <?php
            $total = mysqli_num_rows($result);
            if ($total == 0): ?>
              <p class="tx-gray-500 text-center">No has enviado comentarios aún.</p>
            <?php else: while ($row = mysqli_fetch_assoc($result)): ?>
              <div class="list-group-item comment-item pd-y-20 pd-x-25 mg-b-10 shadow-sm" id="item-<?= $row['id_comentario'] ?>">
                <div class="d-flex align-items-center justify-content-between mg-b-10">
                  <span class="tx-12 tx-gray-500">
                    <i class="fa fa-calendar mg-r-5"></i>
                    <?= date('d \d\e F, Y', strtotime($row['fecha_registro'])) ?>
                  </span>
                  <span class="badge badge-success">Enviado</span>
                </div>

                <p class="mg-b-0 tx-inverse texto-comentario"><?= htmlspecialchars($row['comentario']) ?></p>

                <textarea class="form-control editor-comentario" rows="3" style="display:none;"><?= htmlspecialchars($row['comentario']) ?></textarea>

                <div class="text-right mg-t-10">
                  <button class="btn btn-outline-info btn-icon rounded-circle mg-r-5 btn-editar" onclick="activarEdicion(<?= $row['id_comentario'] ?>)">
                    <i class="icon ion-ios-compose-outline tx-18"></i>
                  </button>
                  <button class="btn btn-success btn-icon rounded-circle mg-r-5 btn-guardar" style="display:none;" onclick="guardarEdicion(<?= $row['id_comentario'] ?>)">
                    <i class="fa fa-check tx-14"></i>
                  </button>
                  <button class="btn btn-outline-danger btn-icon rounded-circle" onclick="eliminarComentario(<?= $row['id_comentario'] ?>)">
                    <i class="icon ion-ios-trash-outline tx-18"></i>
                  </button>
                </div>
              </div>
            <?php endwhile; endif; ?>
          </div>

          <div class="mg-t-30 text-center">
            <button class="btn btn-info pd-x-30" onclick="location.href='index.php?menu=servicios&opc=comentarios'">NUEVO COMENTARIO</button>
            <button class="btn btn-secondary pd-x-30 mg-l-5" onclick="location.href='index.php?menu=servicios&opc=comentarios'">SALIR</button>
          </div>
        </div>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>

    <script>
        function activarEdicion(id) {
            const item = document.getElementById('item-' + id);
            item.querySelector('.texto-comentario').style.display = 'none';
            item.querySelector('.editor-comentario').style.display = 'block';
            item.querySelector('.btn-editar').style.display = 'none';
            item.querySelector('.btn-guardar').style.display = 'inline-block';
        }

        function guardarEdicion(id) {
            const item = document.getElementById('item-' + id);
            const nuevoTexto = item.querySelector('.editor-comentario').value;

            if (nuevoTexto.trim() === '') {
                alert('El comentario no puede estar vacío.');
                return;
            }

            const formData = new FormData();
            formData.append('id_comentario', id);
            formData.append('comentario', nuevoTexto);

            fetch('views/bd/crudcomentarios/editar_comentario.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    item.querySelector('.texto-comentario').textContent = nuevoTexto;
                    item.querySelector('.texto-comentario').style.display = 'block';
                    item.querySelector('.editor-comentario').style.display = 'none';
                    item.querySelector('.btn-editar').style.display = 'inline-block';
                    item.querySelector('.btn-guardar').style.display = 'none';
                    alert(data.message);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error de conexión.');
            });
        }

        function eliminarComentario(id) {
            if (!confirm('¿Estás seguro de eliminar este comentario?')) return;

            const formData = new FormData();
            formData.append('id_comentario', id);

            fetch('views/bd/crudcomentarios/eliminar_comentario.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    const item = document.getElementById('item-' + id);
                    item.remove();
                    alert(data.message);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error de conexión.');
            });
        }
    </script>
</body>
</html>