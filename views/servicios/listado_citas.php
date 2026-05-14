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

$query_citas = "SELECT c.id_cita, c.fecha, c.hora, c.motivo_cita, can.nombre as nombre_mascota 
                FROM citas c 
                INNER JOIN caninos can ON c.id_canino = can.id_canino 
                WHERE can.id_usuario = '$id_usuario' 
                ORDER BY c.fecha ASC, c.hora ASC";
$result_citas = mysqli_query($conexion, $query_citas);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Listado de Citas</title>

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
          <span class="breadcrumb-item active">Listado de Citas</span>
        </nav>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper shadow-base bd-0">
          <h6 class="tx-inverse tx-uppercase tx-bold tx-14 mg-b-20">Citas Agendadas</h6>
          
          <div class="table-wrapper">
            <table class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-20p">Mascota</th>
                  <th class="wd-15p">Fecha</th>
                  <th class="wd-15p">Hora</th>
                  <th class="wd-30p">Motivo</th>
                  <th class="wd-20p text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if(mysqli_num_rows($result_citas) > 0): ?>
                    <?php while($cita = mysqli_fetch_assoc($result_citas)): ?>
                    <tr>
                      <td><strong><?php echo htmlspecialchars($cita['nombre_mascota']); ?></strong></td>
                      <td><?php echo date('d/m/Y', strtotime($cita['fecha'])); ?></td>
                      <td><?php echo date('h:i A', strtotime($cita['hora'])); ?></td>
                      <td><?php echo htmlspecialchars($cita['motivo_cita']); ?></td>
                      <td class="text-center">
                        <!-- Botón Editar -->
                        <button class="btn btn-warning btn-icon rounded-circle mg-r-5" 
                                onclick="abrirEditarCita('<?= $cita['id_cita'] ?>', '<?= $cita['fecha'] ?>', '<?= $cita['hora'] ?>', '<?= addslashes($cita['motivo_cita']) ?>')">
                            <i class="fa fa-edit text-white"></i>
                        </button>
                        <!-- Botón Eliminar -->
                        <a href="index.php?menu=servicios&opc=eliminar-cita&id=<?= $cita['id_cita'] ?>" 
                           class="btn btn-danger btn-icon rounded-circle" 
                           onclick="return confirm('¿Estás seguro de cancelar esta cita?')">
                            <i class="fa fa-trash text-white"></i>
                        </a>
                      </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center pd-y-30">
                            <i class="icon ion-ios-calendar-outline tx-60 tx-gray-400"></i>
                            <p class="mg-t-10 tx-gray-600">No tienes citas agendadas.</p>
                        </td>
                    </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          
          <div class="mg-t-30 text-center">
            <button class="btn btn-secondary pd-x-40 tx-uppercase tx-bold tx-11" onclick="history.back()">Regresar</button>
          </div>
        </div>
      </div>
    </div>

    <div id="modalEditarCita" class="modal fade">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-size-sm">
                <form action="index.php?menu=servicios&opc=editar-cita" method="POST">
                    <input type="hidden" name="id_cita" id="edit_id_cita">
                    <div class="modal-header pd-x-20">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Reagendar / Editar Cita</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pd-20">
                        <div class="form-group">
                            <label class="form-control-label">Nueva Fecha:</label>
                            <input type="date" name="fecha" id="edit_fecha" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Nueva Hora:</label>
                            <input type="time" name="hora" id="edit_hora" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Motivo:</label>
                            <textarea name="motivo_cita" id="edit_motivo" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info tx-uppercase tx-bold tx-11">Actualizar</button>
                        <button type="button" class="btn btn-secondary tx-uppercase tx-bold tx-11" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>

    <script>
    function abrirEditarCita(id, fecha, hora, motivo) {
        $('#edit_id_cita').val(id);
        $('#edit_fecha').val(fecha);
        $('#edit_hora').val(hora);
        $('#edit_motivo').val(motivo);
        $('#modalEditarCita').modal('show');
    }
    </script>
</body>
</html>