<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'views/bd/conexion.php';

$id_usuario = $_SESSION['id_usuario'] ?? 4;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $archivo         = $_FILES['foto'];
    $ruta_temporal   = $archivo['tmp_name'];
    $error           = $archivo['error'];

    if ($error === UPLOAD_ERR_OK) {
        $extension       = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        $nuevo_nombre    = 'user_' . $id_usuario . '_' . time() . '.' . $extension;
        $carpeta_destino = 'public/img/' . $nuevo_nombre;

        if (move_uploaded_file($ruta_temporal, $carpeta_destino)) {
            $query_update = "UPDATE usuarios SET FotoUS = '$nuevo_nombre' WHERE id_usuario = '$id_usuario'";
            mysqli_query($conexion, $query_update);
        }
    }
}

$query   = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result  = mysqli_query($conexion, $query);
$usuario = mysqli_fetch_assoc($result);

$nombre_usuario  = $usuario['nombre'] ?? 'Usuario';
$apellido_usuario = $usuario['apellido_paterno'] ?? '';
$nombre_completo = trim($nombre_usuario . ' ' . $apellido_usuario);
$telefono        = $usuario['telefono']  ?? 'No registrado';
$direccion       = $usuario['direccion'] ?? 'No registrada';

$foto_db     = $usuario['FotoUS'] ?? '';
$foto_perfil = (!empty($foto_db) && file_exists('public/img/' . $foto_db))
               ? $foto_db . '?v=' . time()
               : 'logo.png';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Información Personal</title>

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

        /* ── Modal overlay ── */
        .modal-eliminar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.55);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        .modal-eliminar-overlay.show { display: flex; }

        .modal-eliminar-box {
            background: #fff;
            border-radius: 8px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 40px rgba(0,0,0,.25);
            overflow: hidden;
            animation: popIn .18s ease;
        }
        @keyframes popIn {
            from { transform: scale(.92); opacity: 0; }
            to   { transform: scale(1);  opacity: 1; }
        }

        .modal-eliminar-header {
            background: #dc3545;
            color: #fff;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .modal-eliminar-header i { font-size: 22px; }
        .modal-eliminar-header h5 { margin: 0; font-size: 16px; font-weight: 700; }

        .modal-eliminar-body {
            padding: 24px 20px 10px;
            font-size: 14px;
            color: #333;
        }
        .modal-eliminar-body p  { margin-bottom: 8px; }
        .modal-eliminar-body .advertencia {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px 14px;
            border-radius: 4px;
            font-size: 13px;
            color: #856404;
            margin-top: 12px;
        }

        /* Campo de confirmación */
        .confirm-field { margin-top: 18px; }
        .confirm-field label { font-weight: 600; font-size: 13px; color: #555; }
        .confirm-field input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            margin-top: 6px;
            font-size: 14px;
            transition: border-color .2s;
        }
        .confirm-field input:focus { outline: none; border-color: #dc3545; }
        .confirm-field input.input-error { border-color: #dc3545; background: #fff5f5; }

        .modal-eliminar-footer {
            padding: 16px 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #f0f0f0;
            margin-top: 16px;
        }

        /* Botón eliminar en perfil */
        .btn-eliminar-cuenta {
            border: 1px solid #dc3545;
            color: #dc3545;
            background: transparent;
            padding: 8px 20px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .2s;
            margin-left: 10px;
        }
        .btn-eliminar-cuenta:hover {
            background: #dc3545;
            color: #fff;
        }
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
                <li><a href="index.php?menu=sesion&opc=cerrar"><i class="icon ion-power"></i> Cerrar Sesión</a></li>
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
          <span class="breadcrumb-item active">Información Personal</span>
        </nav>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper shadow-base bd-0">
          <div class="row">

            <div class="col-md-8">
              <div class="form-layout form-layout-1">
                <div class="row mg-b-25">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-control-label">Nombre completo:</label>
                      <input class="form-control tx-bold tx-inverse" type="text"
                             value="<?php echo htmlspecialchars($nombre_completo); ?>"
                             readonly style="background-color:#f8f9fa;">
                    </div>
                  </div>
                  <div class="col-lg-12 mg-t-20">
                    <div class="form-group">
                      <label class="form-control-label">Teléfono:</label>
                      <input class="form-control tx-bold tx-inverse" type="text"
                             value="<?php echo htmlspecialchars($telefono); ?>"
                             readonly style="background-color:#f8f9fa;">
                    </div>
                  </div>
                  <div class="col-lg-12 mg-t-20">
                    <div class="form-group">
                      <label class="form-control-label">Dirección:</label>
                      <textarea rows="3" class="form-control tx-bold tx-inverse"
                                readonly style="background-color:#f8f9fa;"><?php echo htmlspecialchars($direccion); ?></textarea>
                    </div>
                  </div>
                </div>

                <div class="form-layout-footer text-right">
                  <button type="button" class="btn-eliminar-cuenta" onclick="abrirModalEliminar()">
                    <i class="fa fa-user-times mg-r-5"></i> Eliminar Cuenta
                  </button>
                  <a href="index.php?menu=personal&opc=editar-perfil"
                     class="btn btn-info pd-x-25 tx-uppercase tx-bold tx-11 mg-l-10">
                    <i class="fa fa-edit mg-r-10"></i> Editar Perfil
                  </a>
                </div>
              </div>
            </div>

            <div class="col-md-4 text-center">
              <div class="card bd-0 shadow-base">
                <img class="card-img-top img-fluid"
                     src="public/img/<?php echo $foto_perfil; ?>"
                     alt="Foto de perfil">
                <div class="card-body bg-gray-100">
                  <p class="card-text tx-bold tx-inverse tx-uppercase tx-11 mg-b-0">Foto del propietario</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="modal-eliminar-overlay" id="modalEliminarOverlay">
      <div class="modal-eliminar-box">

        <div class="modal-eliminar-header">
          <i class="fa fa-exclamation-triangle"></i>
          <h5>Eliminar cuenta permanentemente</h5>
        </div>

        <div class="modal-eliminar-body">
          <p>Estás a punto de eliminar tu cuenta <strong><?php echo htmlspecialchars($nombre_completo); ?></strong>.</p>
          <p>Esta acción eliminará también:</p>
          <ul style="font-size:13px; color:#555; padding-left:18px; margin-bottom:0;">
            <li>Todas tus mascotas registradas</li>
            <li>Historial médico y citas</li>
            <li>Tu foto de perfil del servidor</li>
          </ul>

          <div class="advertencia">
            <i class="fa fa-warning mg-r-5"></i>
            <strong>Esta acción es irreversible.</strong> No podrás recuperar tu información.
          </div>

          <div class="confirm-field">
            <label>Para confirmar, escribe tu nombre: <span style="color:#dc3545;"><?php echo htmlspecialchars($nombre_usuario); ?></span></label>
            <input type="text" id="inputConfirm"
                   placeholder="Escribe tu nombre aquí..."
                   oninput="validarConfirmacion()">
            <p id="msgError" style="color:#dc3545; font-size:12px; margin-top:5px; display:none;">
              El nombre no coincide.
            </p>
          </div>
        </div>

        <div class="modal-eliminar-footer">
          <button type="button" class="btn btn-secondary btn-sm pd-x-20" onclick="cerrarModalEliminar()">
            <i class="fa fa-times mg-r-5"></i> Cancelar
          </button>
          <a id="btnConfirmarEliminar"
             href="#"
             class="btn btn-danger btn-sm pd-x-20 disabled"
             style="pointer-events:none; opacity:.5;">
            <i class="fa fa-trash mg-r-5"></i> Sí, eliminar mi cuenta
          </a>
        </div>

      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/popper.js/popper.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>

    <script>
      const NOMBRE_ESPERADO = <?php echo json_encode($nombre_usuario); ?>;

      function abrirModalEliminar() {
        document.getElementById('inputConfirm').value = '';
        document.getElementById('msgError').style.display = 'none';
        deshabilitarBoton();
        document.getElementById('modalEliminarOverlay').classList.add('show');
      }

      function cerrarModalEliminar() {
        document.getElementById('modalEliminarOverlay').classList.remove('show');
      }

      // Cerrar si se hace clic fuera del box
      document.getElementById('modalEliminarOverlay').addEventListener('click', function(e) {
        if (e.target === this) cerrarModalEliminar();
      });

      function validarConfirmacion() {
        const valor  = document.getElementById('inputConfirm').value.trim();
        const btn    = document.getElementById('btnConfirmarEliminar');
        const msgErr = document.getElementById('msgError');
        const input  = document.getElementById('inputConfirm');

        if (valor === NOMBRE_ESPERADO) {
          // Habilitar botón y asignar la ruta correcta de destino
          btn.classList.remove('disabled');
          btn.setAttribute('href', 'views/bd/crudusuarios/eliminar_usuario.php');
          btn.style.pointerEvents = 'auto';
          btn.style.opacity = '1';
          msgErr.style.display = 'none';
          input.classList.remove('input-error');
        } else {
          deshabilitarBoton();
          if (valor.length > 0) {
            msgErr.style.display = 'block';
            input.classList.add('input-error');
          } else {
            msgErr.style.display = 'none';
            input.classList.remove('input-error');
          }
        }
      }

      function deshabilitarBoton() {
        const btn = document.getElementById('btnConfirmarEliminar');
        btn.classList.add('disabled');
        btn.setAttribute('href', '#');
        btn.style.pointerEvents = 'none';
        btn.style.opacity = '.5';
      }
    </script>
</body>
</html>