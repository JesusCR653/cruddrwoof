<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'views/bd/conexion.php';

if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
} else {
    $id_usuario = 4;
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
$nombre_completo = $nombre_usuario . ' ' . $apellido_usuario;

$foto_perfil = 'logo.png';
if (isset($usuario['FotoUS']) && $usuario['FotoUS'] != "") {
    if (file_exists('public/img/' . $usuario['FotoUS'])) {
        $foto_perfil = $usuario['FotoUS'] . '?v=' . time();
    }
}

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
            padding: 50px 40px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: none !important;
            min-height: 85vh;
            margin-top: 0 !important;
        }

        .label-turquesa {
            background-color: #34b5e5 !important;
            color: white !important;
            padding: 10px 25px;
            font-weight: bold;
            border-radius: 25px !important;
            display: inline-block;
            text-transform: uppercase;
            font-size: 14px;
        }

        .thead-marino th {
            background-color: #1e3a8a !important;
            color: white !important;
            border: none !important;
            font-size: 13px !important;
            text-transform: uppercase;
            font-weight: bold;
            padding: 15px !important;
        }

        .form-control-custom-edit {
            color: #1e3a8a !important;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 6px;
            display: block;
            text-align: center;
        }
        .form-control-custom {
            background-color: #dcdcdc !important;
            color: #333333 !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 25px !important;
            font-size: 16px !important;
            font-weight: bold;
            height: auto !important;
            text-align: center;
        }
        .form-control-custom:focus {
            background-color: #cfcfcf !important;
            outline: none;
        }
        textarea.form-control-custom {
            border-radius: 20px !important;
            text-align: left;
        }

        .btn-custom-regresar {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 40px !important;
            font-size: 15px !important;
            font-weight: bold;
            display: inline-block;
        }
        .btn-custom-modal-edit {
            background-color: #92bc5c !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            font-weight: bold;
        }
        .btn-custom-modal-cancel {
            background-color: #34b5e5 !important;
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
        <a href="index.php?menu=mascotas&opc=listado" class="br-menu-link">
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
          <h6>LISTADO DE CITAS</h6>
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
        <div class="br-section-wrapper d-flex flex-column justify-content-center">
          
          <div class="mg-b-30">
              <span class="label-turquesa">Citas Agendadas</span>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="thead-marino">
                <tr>
                  <th class="wd-20p text-center">Mascota</th>
                  <th class="wd-15p text-center">Fecha</th>
                  <th class="wd-15p text-center">Hora</th>
                  <th class="wd-35p text-left">Motivo</th>
                  <th class="wd-15p text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if(mysqli_num_rows($result_citas) > 0): ?>
                    <?php while($cita = mysqli_fetch_assoc($result_citas)): ?>
                    <tr class="tx-inverse bg-white text-center">
                      <td class="valign-middle text-left"><strong style="color: #1e3a8a; font-size: 15px;"><?php echo htmlspecialchars($cita['nombre_mascota']); ?></strong></td>
                      <td class="valign-middle"><?php echo date('d/m/Y', strtotime($cita['fecha'])); ?></td>
                      <td class="valign-middle"><?php echo date('h:i A', strtotime($cita['hora'])); ?></td>
                      <td class="valign-middle text-left"><?php echo htmlspecialchars($cita['motivo_cita']); ?></td>
                      <td class="valign-middle text-center">
                        <button class="btn btn-warning btn-icon rounded-circle" 
                                onclick="abrirEditarCita('<?php echo $cita['id_cita']; ?>', '<?php echo $cita['fecha']; ?>', '<?php echo $cita['hora']; ?>', '<?php echo addslashes($cita['motivo_cita']); ?>')">
                            <i class="fa fa-edit text-white"></i>
                        </button>
                        <a href="index.php?menu=servicios&opc=eliminar-cita&id=<?php echo $cita['id_cita']; ?>" 
                           class="btn btn-danger btn-icon rounded-circle mg-l-5" 
                           onclick="return confirm('¿Estás seguro de cancelar esta cita?')">
                            <i class="fa fa-trash text-white"></i>
                        </a>
                      </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center pd-y-40 text-muted font-weight-bold">
                            <i class="icon ion-ios-calendar-outline tx-60 text-muted d-block mg-b-10"></i>
                            No tienes citas agendadas actualmente.
                        </td>
                    </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          
          <div class="mg-t-40 text-center">
            <button class="btn btn-custom-regresar text-center" onclick="history.back()">Regresar</button>
          </div>
        </div>
      </div>
    </div>

    <div id="modalEditarCita" class="modal fade">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tx-size-sm" style="border-radius: 15px; overflow: hidden; border: none;">
                <form action="index.php?menu=servicios&opc=editar-cita" method="POST">
                    <input type="hidden" name="id_cita" id="edit_id_cita">
                    <div class="modal-header pd-x-20 bg-gray-100">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Reagendar / Editar Cita</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pd-20">
                        <div class="form-group">
                            <label class="form-control-custom-edit">Nueva Fecha:</label>
                            <input type="date" name="fecha" id="edit_fecha" class="form-control form-control-custom" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-custom-edit">Nueva Hora:</label>
                            <input type="time" name="hora" id="edit_hora" class="form-control form-control-custom" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-custom-edit">Motivo de la Cita:</label>
                            <textarea name="motivo_cita" id="edit_motivo" class="form-control form-control-custom" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center gap-2">
                        <button type="submit" class="btn btn-custom-modal-edit pd-x-25 pd-y-10 tx-uppercase tx-bold tx-12">Actualizar</button>
                        <button type="button" class="btn btn-custom-modal-cancel pd-x-25 pd-y-10 tx-uppercase tx-bold tx-12" data-dismiss="modal">Cerrar</button>
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
        document.getElementById('edit_id_cita').value = id;
        document.getElementById('edit_fecha').value = fecha;
        document.getElementById('edit_hora').value = hora;
        document.getElementById('edit_motivo').value = motivo;
        $('#modalEditarCita').modal('show');
    }
    </script>
</body>
</html>