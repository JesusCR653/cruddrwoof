<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$id_usuario = $_SESSION['usuario_id'] ?? 4;

$ruta_conexion = $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';
if (file_exists($ruta_conexion)) {
    include_once $ruta_conexion;
} else {
    include_once 'views/bd/conexion.php';
}

$result = mysqli_query($conexion, "
    SELECT r.id_recordatorio, r.fecha, r.hora, r.repetir, r.motivo, c.nombre AS nombre_canino
    FROM recordatorios r
    INNER JOIN caninos c ON r.id_canino = c.id_canino
    WHERE c.id_usuario = '$id_usuario'
    ORDER BY r.fecha ASC, r.hora ASC
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Mis Recordatorios</title>
    <link href="public/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="public/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/bracket.css">
    <style>
        .br-menu-sub { display: block !important; }
        .br-sideleft { background-color: #1d2127; }
        .br-sideleft-menu .br-menu-link.active {
            background-color: #11b79e !important;
            color: #ffffff !important;
            border-radius: 4px;
            margin: 0 10px;
        }
        .br-sideleft-menu .br-menu-link.active i,
        .br-sideleft-menu .br-menu-link.active span {
            color: #ffffff !important;
        }
        .list-number { font-size: 24px; font-weight: bold; color: #17a2b8; padding-right: 15px; }
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
          <li class="nav-item"><a href="index.php?menu=mascotas&opc=galeria" class="nav-link">Galeria de fotos</a></li>
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
        <a href="index.php?menu=servicios&opc=recordatorios" class="br-menu-link active">
          <div class="br-menu-item"><i class="icon ion-ios-alarm-outline tx-24"></i><span class="menu-item-label">Recordatorios</span></div>
        </a>
        <a href="index.php?menu=servicios&opc=comentarios" class="br-menu-link">
          <div class="br-menu-item"><i class="icon ion-ios-chatboxes-outline tx-24"></i><span class="menu-item-label">Comentarios</span></div>
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
              <span class="logged-name">Axel Jesús Casique</span>
              <img src="public/img/Axel.png" class="wd-32 rounded-circle mg-l-10" alt="Perfil">
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
          <a class="breadcrumb-item" href="index.php?menu=servicios&opc=recordatorios">Recordatorios</a>
          <span class="breadcrumb-item active">Listado</span>
        </nav>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper shadow-base bd-0">
          <h6 class="tx-inverse tx-uppercase tx-bold tx-14 mg-b-25">Recordatorios Activos</h6>

          <div class="media-list bg-white rounded shadow-base">
            <?php
            $total = mysqli_num_rows($result);
            if ($total == 0): ?>
              <p class="tx-gray-500 text-center pd-20">No tienes recordatorios registrados.</p>
            <?php else:
              $i = 1;
              while ($row = mysqli_fetch_assoc($result)): ?>

              <div class="media pd-20 bd-b" id="rec-<?= $row['id_recordatorio'] ?>">
                <span class="list-number"><?= $i++ ?></span>
                <div class="media-body row">

                  <!-- Modo lectura -->
                  <div class="col-sm-2 modo-lectura">
                    <label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Mascota</label>
                    <p class="mg-b-0 tx-inverse tx-bold"><?= htmlspecialchars($row['nombre_canino']) ?></p>
                  </div>
                  <div class="col-sm-2 modo-lectura">
                    <label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Fecha</label>
                    <p class="mg-b-0 tx-inverse"><?= date('d/m/Y', strtotime($row['fecha'])) ?></p>
                  </div>
                  <div class="col-sm-2 modo-lectura">
                    <label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Hora</label>
                    <p class="mg-b-0 tx-inverse"><?= date('h:i A', strtotime($row['hora'])) ?></p>
                  </div>
                  <div class="col-sm-2 modo-lectura">
                    <label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Repetir</label>
                    <p class="mg-b-0 tx-inverse"><?= htmlspecialchars($row['repetir']) ?></p>
                  </div>
                  <div class="col-sm-3 modo-lectura">
                    <label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Motivo</label>
                    <p class="mg-b-0 tx-inverse tx-bold"><?= htmlspecialchars($row['motivo']) ?></p>
                  </div>

                  <!-- Modo edición (oculto por defecto) -->
                  <div class="col-sm-2 modo-edicion" style="display:none;">
                    <label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Fecha</label>
                    <input type="date" class="form-control edit-fecha" value="<?= $row['fecha'] ?>">
                  </div>
                  <div class="col-sm-2 modo-edicion" style="display:none;">
                    <label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Hora</label>
                    <input type="time" class="form-control edit-hora" value="<?= substr($row['hora'], 0, 5) ?>">
                  </div>
                  <div class="col-sm-2 modo-edicion" style="display:none;">
                    <label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Repetir</label>
                    <select class="form-control edit-repetir">
                      <?php
                      $opciones = ['5 minutos','10 minutos','30 minutos','1 hora','2 horas','6 horas','12 horas','24 horas','7 días'];
                      foreach ($opciones as $op): ?>
                        <option value="<?= $op ?>" <?= $row['repetir'] == $op ? 'selected' : '' ?>><?= $op ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-sm-4 modo-edicion" style="display:none;">
                    <label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Motivo</label>
                    <input type="text" class="form-control edit-motivo" value="<?= htmlspecialchars($row['motivo']) ?>">
                  </div>

                  <!-- Botones -->
                  <div class="col-sm-1 text-right">
                    <button class="btn btn-outline-info btn-icon rounded-circle mg-b-5 btn-editar" onclick="activarEdicion(<?= $row['id_recordatorio'] ?>)">
                      <i class="icon ion-ios-compose-outline tx-18"></i>
                    </button>
                    <button class="btn btn-success btn-icon rounded-circle mg-b-5 btn-guardar" style="display:none;" onclick="guardarEdicion(<?= $row['id_recordatorio'] ?>)">
                      <i class="fa fa-check tx-14"></i>
                    </button>
                    <button class="btn btn-outline-danger btn-icon rounded-circle" onclick="eliminarRecordatorio(<?= $row['id_recordatorio'] ?>)">
                      <i class="icon ion-ios-trash-outline tx-20"></i>
                    </button>
                  </div>

                </div>
              </div>

            <?php endwhile; endif; ?>
          </div>

          <div class="mg-t-30 text-center">
            <button class="btn btn-info pd-x-30" onclick="location.href='index.php?menu=servicios&opc=recordatorios'">AGREGAR OTRO</button>
            <button class="btn btn-secondary pd-x-30 mg-l-5" onclick="location.href='index.php?menu=servicios&opc=recordatorios'">REGRESAR</button>
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
            const rec = document.getElementById('rec-' + id);
            rec.querySelectorAll('.modo-lectura').forEach(el => el.style.display = 'none');
            rec.querySelectorAll('.modo-edicion').forEach(el => el.style.display = 'block');
            rec.querySelector('.btn-editar').style.display = 'none';
            rec.querySelector('.btn-guardar').style.display = 'inline-block';
        }

        function guardarEdicion(id) {
            const rec     = document.getElementById('rec-' + id);
            const fecha   = rec.querySelector('.edit-fecha').value;
            const hora    = rec.querySelector('.edit-hora').value;
            const repetir = rec.querySelector('.edit-repetir').value;
            const motivo  = rec.querySelector('.edit-motivo').value;

            if (!fecha || !hora || !motivo.trim()) {
                alert('Por favor completa todos los campos.');
                return;
            }

            const formData = new FormData();
            formData.append('id_recordatorio', id);
            formData.append('fecha', fecha);
            formData.append('hora', hora);
            formData.append('repetir', repetir);
            formData.append('motivo', motivo);

            fetch('views/bd/crudrecordatorios/editar_recordatorio.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error de conexión.');
            });
        }

        function eliminarRecordatorio(id) {
            if (!confirm('¿Estás seguro de eliminar este recordatorio?')) return;

            const formData = new FormData();
            formData.append('id_recordatorio', id);

            fetch('views/bd/crudrecordatorios/eliminar_recordatorio.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('rec-' + id).remove();
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