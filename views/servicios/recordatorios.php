<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Configuración de conexión
$ruta_conexion = $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';
if (file_exists($ruta_conexion)) {
    include_once $ruta_conexion;
} else {
    include_once 'views/bd/conexion.php';
}

// ID de usuario e información para el Header (Nombre y FotoUS)
$id_usuario = $_SESSION['id_usuario'] ?? 4;
$query_user = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'");
$usuario = mysqli_fetch_assoc($query_user);

$nombre_completo = trim(($usuario['nombre'] ?? 'Usuario') . ' ' . ($usuario['apellido_paterno'] ?? ''));
$foto_user = (!empty($usuario['FotoUS']) && file_exists('public/img/' . $usuario['FotoUS'])) 
             ? $usuario['FotoUS'] . '?v=' . time() 
             : 'logo.png';

// Traer mascotas del usuario para el select (Asegúrate que la columna sea id_caninos o id_canino según tu BD)
$mascotas = mysqli_query($conexion, "SELECT id_canino as id_canino, nombre FROM caninos WHERE id_usuario = '$id_usuario'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Crear Recordatorio</title>

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
        <a href="index.php?menu=servicios&opc=recordatorios" class="br-menu-link active">
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
          <span class="breadcrumb-item active">Nuevo Recordatorio</span>
        </nav>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper shadow-base bd-0">
          <h6 class="tx-inverse tx-uppercase tx-bold tx-14 mg-b-20">Configurar Alarma / Recordatorio</h6>
          
          <div class="form-layout form-layout-1">
            <div class="row mg-b-25">

              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Mascota:</label>
                  <select id="r_canino" class="form-control">
                    <option value="">-- Selecciona una mascota --</option>
                    <?php while ($m = mysqli_fetch_assoc($mascotas)): ?>
                      <option value="<?= $m['id_canino'] ?>"><?= htmlspecialchars($m['nombre']) ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Fecha: <i class="fa fa-calendar mg-l-5 text-info"></i></label>
                  <input id="r_fecha" class="form-control" type="date">
                </div>
              </div>

              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Hora: <i class="fa fa-clock-o mg-l-5 text-info"></i></label>
                  <input id="r_hora" class="form-control" type="time" value="08:00">
                </div>
              </div>

              <div class="col-lg-4 mg-t-20">
                <div class="form-group">
                  <label class="form-control-label">Repetir cada:</label>
                  <select id="r_repetir" class="form-control">
                    <option value="5 minutos">5 minutos</option>
                    <option value="10 minutos">10 minutos</option>
                    <option value="30 minutos">30 minutos</option>
                    <option value="1 hora">1 hora</option>
                    <option value="2 horas">2 horas</option>
                    <option value="6 horas">6 horas</option>
                    <option value="12 horas">12 horas</option>
                    <option value="24 horas">24 horas</option>
                    <option value="7 días">7 días</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-8 mg-t-20">
                <div class="form-group mg-b-0">
                  <label class="form-control-label">Motivo del recordatorio:</label>
                  <input id="r_motivo" class="form-control" type="text" placeholder="Ej: Dar medicamento a Manchas">
                </div>
              </div>

            </div>

            <div class="form-layout-footer text-center">
              <button class="btn btn-success pd-x-30" onclick="guardarRecordatorio()">AGREGAR</button>
              <button class="btn btn-info pd-x-30 mg-l-5" onclick="location.href='index.php?menu=servicios&opc=listarecordatorios'">MIS RECORDATORIOS</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>

    <script>
        function guardarRecordatorio() {
            const canino  = document.getElementById('r_canino').value;
            const fecha   = document.getElementById('r_fecha').value;
            const hora    = document.getElementById('r_hora').value;
            const repetir = document.getElementById('r_repetir').value;
            const motivo  = document.getElementById('r_motivo').value;

            if (!canino || !fecha || !hora || !motivo.trim()) {
                alert('Por favor completa todos los campos.');
                return;
            }

            const formData = new FormData();
            formData.append('id_canino', canino);
            formData.append('fecha', fecha);
            formData.append('hora', hora);
            formData.append('repetir', repetir);
            formData.append('motivo', motivo);

            fetch('views/bd/crudrecordatorios/guardar_recordatorio.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    window.location.href = 'index.php?menu=servicios&opc=listarecordatorios';
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