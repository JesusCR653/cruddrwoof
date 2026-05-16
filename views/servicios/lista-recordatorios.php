<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$ruta_conexion = $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';
if (file_exists($ruta_conexion)) {
    include_once $ruta_conexion;
} else {
    include_once 'views/bd/conexion.php';
}

if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
} else {
    $id_usuario = 4;
}

$query_user = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'");
$usuario = mysqli_fetch_assoc($query_user);

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

        .sidebar-label, .br-menu-link, .br-menu-item { color: #ffffff !important; }
        .br-sideleft-menu .br-menu-link.active {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
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

        .title-section-custom {
            color: #1e3a8a !important;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 16px;
            letter-spacing: 0.5px;
        }

        .media-list-custom {
            background-color: transparent !important;
            box-shadow: none !important;
        }
        .media-item-custom {
            background-color: #ffffff !important;
            border: none !important;
            border-bottom: 1px solid #e9ecef !important;
            padding: 20px 10px !important;
        }
        .list-number {
            font-size: 22px;
            font-weight: bold;
            color: #34b5e5 !important;
            padding-right: 20px;
            display: flex;
            align-items: center;
        }

        .box-oval-data {
            background-color: #dcdcdc !important;
            color: #333333 !important;
            border-radius: 25px !important;
            padding: 10px 15px !important;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
        }
        .form-control-custom-edit {
            background-color: #dcdcdc !important;
            color: #333333 !important;
            border: none !important;
            border-radius: 25px !important;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
            height: auto !important;
            padding: 6px 12px !important;
        }
        .form-control-custom-edit:focus {
            background-color: #cfcfcf !important;
            outline: none;
        }

        .label-field-title {
            color: #1e3a8a !important;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 4px;
            display: block;
            text-align: center;
        }

        .btn-custom-agregar {
            background-color: #92bc5c !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 35px !important;
            font-size: 16px !important;
            font-weight: bold;
        }
        .btn-custom-regresar {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 35px !important;
            font-size: 16px !important;
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
          <div class="br-menu-item"><i class="icon ion-ios-plus-outline tx-24"></i><span class="menu-item-label">Registro de mascota</span></div>
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
        <a href="index.php?menu=servicios&opc=recordatorios" class="br-menu-link active">
          <div class="br-menu-item"><i class="icon ion-ios-alarm-outline tx-24"></i><span class="menu-item-label">Recordatorios</span></div>
        </a>
        <a href="index.php?menu=servicios&opc=comentarios" class="br-menu-link">
          <div class="br-menu-item"><i class="icon ion-ios-chatboxes-outline tx-24"></i><span class="menu-item-label">Comentarios</span></div>
        </a>
        <a href="index.php?menu=servicios&opc=mantenimiento" class="br-menu-link">
  <div class="br-menu-item">
    <i class="icon ion-ios-gear-outline tx-24"></i>
    <span class="menu-item-label">Mantenimiento</span>
  </div>
</a>
      </div>
    </div>

    <div class="br-header">
      <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
      </div>
      
      <div class="header-welcome-centered">
          <h6>RECORDATORIOS</h6>
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
          <a class="breadcrumb-item" href="index.php?menu=servicios&opc=recordatorios">Recordatorios</a>
          <span class="breadcrumb-item active">Listado</span>
        </nav>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
          <h6 class="title-section-custom mg-b-25">Recordatorios Activos</h6>

          <div class="media-list media-list-custom">
            <?php
            $total = mysqli_num_rows($result);
            if ($total == 0): ?>
              <p class="text-muted text-center pd-20 font-weight-bold">No tienes recordatorios registrados actualmente.</p>
            <?php else:
              $i = 1;
              while ($row = mysqli_fetch_assoc($result)): ?>

              <div class="media media-item-custom align-items-center" id="rec-<?php echo $row['id_recordatorio']; ?>">
                <span class="list-number"><?php echo $i; ?></span>
                <div class="media-body row align-items-center">

                  <div class="col-sm-2 text-center" id="lec-pet-<?php echo $row['id_recordatorio']; ?>">
                    <label class="label-field-title">Mascota</label>
                    <div class="box-oval-data text-truncate"><?php echo htmlspecialchars($row['nombre_canino']); ?></div>
                  </div>
                  <div class="col-sm-2 text-center" id="lec-fec-<?php echo $row['id_recordatorio']; ?>">
                    <label class="label-field-title">Fecha</label>
                    <div class="box-oval-data"><?php echo date('d/m/Y', strtotime($row['fecha'])); ?></div>
                  </div>
                  <div class="col-sm-2 text-center" id="lec-hor-<?php echo $row['id_recordatorio']; ?>">
                    <label class="label-field-title">Hora</label>
                    <div class="box-oval-data"><?php echo date('h:i A', strtotime($row['hora'])); ?></div>
                  </div>
                  <div class="col-sm-2 text-center" id="lec-rep-<?php echo $row['id_recordatorio']; ?>">
                    <label class="label-field-title">Repetir</label>
                    <div class="box-oval-data text-truncate"><?php echo htmlspecialchars($row['repetir']); ?></div>
                  </div>
                  <div class="col-sm-3 text-center" id="lec-mot-<?php echo $row['id_recordatorio']; ?>">
                    <label class="label-field-title">Motivo</label>
                    <div class="box-oval-data text-truncate" style="color: #1e3a8a;"><?php echo htmlspecialchars($row['motivo']); ?></div>
                  </div>

                  <div class="col-sm-2 text-center" id="edit-fec-<?php echo $row['id_recordatorio']; ?>" style="display:none;">
                    <label class="label-field-title">Fecha</label>
                    <input type="date" id="input-fec-<?php echo $row['id_recordatorio']; ?>" class="form-control form-control-custom-edit" value="<?php echo $row['fecha']; ?>">
                  </div>
                  <div class="col-sm-2 text-center" id="edit-hor-<?php echo $row['id_recordatorio']; ?>" style="display:none;">
                    <label class="label-field-title">Hora</label>
                    <input type="time" id="input-hor-<?php echo $row['id_recordatorio']; ?>" class="form-control form-control-custom-edit" value="<?php echo substr($row['hora'], 0, 5); ?>">
                  </div>
                  <div class="col-sm-2 text-center" id="edit-rep-<?php echo $row['id_recordatorio']; ?>" style="display:none;">
                    <label class="label-field-title">Repetir</label>
                    <select id="input-rep-<?php echo $row['id_recordatorio']; ?>" class="form-control form-control-custom-edit" style="text-align-last: center;">
                      <?php
                      $opciones = array('5 minutos','10 minutos','30 minutos','1 hora','2 horas','6 horas','12 horas','24 horas','7 días');
                      for ($k = 0; $k < count($opciones); $k++): 
                        $op = $opciones[$k];
                      ?>
                        <option value="<?php echo $op; ?>" <?php if ($row['repetir'] == $op) { echo 'selected'; } ?>><?php echo $op; ?></option>
                      <?php endfor; ?>
                    </select>
                  </div>
                  <div class="col-sm-5 text-center" id="edit-mot-<?php echo $row['id_recordatorio']; ?>" style="display:none;">
                    <label class="label-field-title">Motivo</label>
                    <input type="text" id="input-mot-<?php echo $row['id_recordatorio']; ?>" class="form-control form-control-custom-edit" value="<?php echo htmlspecialchars($row['motivo']); ?>">
                  </div>

                  <div class="col-sm-1 text-right d-flex flex-column align-items-center justify-content-center gap-1">
                    <button class="btn btn-outline-info btn-icon rounded-circle" id="btn-edit-<?php echo $row['id_recordatorio']; ?>" onclick="activarEdicion(<?php echo $row['id_recordatorio']; ?>)" style="padding: 4px 8px;">
                      <i class="icon ion-ios-compose-outline tx-18"></i>
                    </button>
                    <button class="btn btn-success btn-icon rounded-circle" id="btn-save-<?php echo $row['id_recordatorio']; ?>" style="display:none; padding: 4px 8px;" onclick="guardarEdicion(<?php echo $row['id_recordatorio']; ?>)">
                      <i class="fa fa-check tx-14"></i>
                    </button>
                    <button class="btn btn-outline-danger btn-icon rounded-circle mg-t-5" onclick="eliminarRecordatorio(<?php echo $row['id_recordatorio']; ?>)" style="padding: 4px 8px;">
                      <i class="icon ion-ios-trash-outline tx-20"></i>
                    </button>
                  </div>

                </div>
              </div>

            <?php $i = $i + 1; endwhile; endif; ?>
          </div>

          <div class="mg-t-40 text-center d-flex align-items-center justify-content-center gap-3 flex-wrap">
            <button class="btn btn-custom-agregar" onclick="location.href='index.php?menu=servicios&opc=recordatorios'">AGREGAR OTRO</button>
            <button class="btn btn-custom-regresar" onclick="location.href='index.php?menu=servicios&opc=recordatorios'">REGRESAR</button>
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
            document.getElementById('lec-fec-' + id).style.display = 'none';
            document.getElementById('lec-hor-' + id).style.display = 'none';
            document.getElementById('lec-rep-' + id).style.display = 'none';
            document.getElementById('lec-mot-' + id).style.display = 'none';

            document.getElementById('edit-fec-' + id).style.display = 'block';
            document.getElementById('edit-hor-' + id).style.display = 'block';
            document.getElementById('edit-rep-' + id).style.display = 'block';
            document.getElementById('edit-mot-' + id).style.display = 'block';

            document.getElementById('btn-edit-' + id).style.display = 'none';
            document.getElementById('btn-save-' + id).style.display = 'inline-block';
        }

        function guardarEdicion(id) {
            var fecha = document.getElementById('input-fec-' + id).value;
            var hora = document.getElementById('input-hor-' + id).value;
            var repetir = document.getElementById('input-rep-' + id).value;
            var motivo = document.getElementById('input-mot-' + id).value;

            var motivoLimpio = "";
            for (var i = 0; i < motivo.length; i++) {
                if (motivo.charAt(i) !== ' ' && motivo.charAt(i) !== '\n' && motivo.charAt(i) !== '\r') {
                    motivoLimpio = motivo;
                    break;
                }
            }

            if (fecha == "" || hora == "" || motivoLimpio == "") {
                alert('Por favor completa todos los campos.');
                return;
            }

            var ajax = new XMLHttpRequest();
            ajax.open('POST', 'views/bd/crudrecordatorios/editar_recordatorio.php', true);
            
            var datos = new FormData();
            datos.append('id_recordatorio', id);
            datos.append('fecha', fecha);
            datos.append('hora', hora);
            datos.append('repetir', repetir);
            datos.append('motivo', motivo);

            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    var respuesta = JSON.parse(ajax.responseText);
                    if (respuesta.status == 'success') {
                        alert(respuesta.message);
                        window.location.reload();
                    } else {
                        alert('Error: ' + respuesta.message);
                    }
                }
            };
            
            ajax.send(datos);
        }

        function eliminarRecordatorio(id) {
            if (confirm('¿Estás seguro de eliminar este recordatorio?') == false) {
                return;
            }

            var ajax = new XMLHttpRequest();
            ajax.open('POST', 'views/bd/crudrecordatorios/eliminar_recordatorio.php', true);
            
            var datos = new FormData();
            datos.append('id_recordatorio', id);

            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    var respuesta = JSON.parse(ajax.responseText);
                    if (respuesta.status == 'success') {
                        var elemento = document.getElementById('rec-' + id);
                        elemento.parentNode.removeChild(elemento);
                        alert(respuesta.message);
                    } else {
                        alert('Error: ' + respuesta.message);
                    }
                }
            };

            ajax.send(datos);
        }
    </script>
</body>
</html>