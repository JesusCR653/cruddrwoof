<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'views/bd/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id              = (int)$_POST['id_canino'];
    $nombre          = trim($_POST['nombre']);
    $sexo            = $_POST['sexo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $raza            = trim($_POST['raza']);
    $color           = trim($_POST['color']);
    $alergias        = trim($_POST['alergias']);
    $edad            = (int)$_POST['edad'];
    $peso            = $_POST['peso'];
    $tratamiento     = trim($_POST['tratamiento']);
    $fotoActual      = $_POST['foto_actual'];

    $fotoCan = $fotoActual;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ext        = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nombreFoto = uniqid('can_') . '.' . $ext;
        $destino    = 'public/img/caninos/' . $nombreFoto;

        if (!is_dir('public/img/caninos')) {
            mkdir('public/img/caninos', 0755, true);
        }

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
            if ($fotoActual !== 'sin_foto.png' && file_exists('public/img/caninos/' . $fotoActual)) {
                unlink('public/img/caninos/' . $fotoActual);
            }
            $fotoCan = $nombreFoto;
        }
    }

    $sql = "UPDATE caninos
            SET nombre=?, raza=?, edad=?, sexo=?, fotoCan=?, Color=?, peso=?,
                fecha_nacimiento=?, alergias=?, Tratamiento=?
            WHERE id_canino=?";

    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('ssisssssssi',
            $nombre, $raza, $edad, $sexo, $fotoCan,
            $color, $peso, $fecha_nacimiento, $alergias, $tratamiento, $id
        );
        if ($stmt->execute()) {
            header('Location: index.php?menu=mascotas&opc=listado&exito=2');
        } else {
            header('Location: index.php?menu=mascotas&opc=editar&id=' . $id . '&error=1');
        }
        $stmt->close();
    } else {
        header('Location: index.php?menu=mascotas&opc=editar&id=' . $id . '&error=1');
    }
    $conn->close();
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id === 0) {
    header('Location: index.php?menu=mascotas&opc=listado');
    exit;
}

$stmt = $conexion->prepare("SELECT * FROM caninos WHERE id_canino = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$mascota = $result->fetch_assoc();
$stmt->close();

if (!$mascota) {
    header('Location: index.php?menu=mascotas&opc=listado&error=404');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Editar Canino</title>
    <link href="public/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="public/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/bracket.css">
    <style>
        .br-sideleft { background-color: #1d2127; }
        .preview-foto {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            margin-top: 8px;
        }
    </style>
</head>
<body>

    <div class="br-logo"><a href="index.php"><span>DR.</span> WOOF<span>+</span></a></div>

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
        <div class="navicon-left hidden-md-down">
          <a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a>
        </div>
      </div>
      <div class="br-header-right">
        <nav class="nav">
          <div class="dropdown">
            <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name"><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?></span>
              <img src="public/img/logo.png" class="wd-32 rounded-circle mg-l-10" alt="Perfil">
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
          <a class="breadcrumb-item" href="index.php?menu=mascotas&opc=listado">Mis Mascotas</a>
          <span class="breadcrumb-item active">Editar Canino</span>
        </nav>
      </div>

      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Editar Mascota</h4>
        <p class="mg-b-0">Modifique los datos del canino registrado.</p>
      </div>

      <?php if (isset($_GET['exito'])): ?>
      <div class="alert alert-success mg-x-20 mg-t-20">
        <i class="fa fa-check mg-r-5"></i> Mascota actualizada correctamente.
      </div>
      <?php endif; ?>

      <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger mg-x-20 mg-t-20">
        <i class="fa fa-times mg-r-5"></i> Ocurrió un error al actualizar. Intenta de nuevo.
      </div>
      <?php endif; ?>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
          <form action="index.php?menu=mascotas&opc=editar" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_canino" value="<?php echo $mascota['id_canino']; ?>">
            <input type="hidden" name="foto_actual" value="<?php echo htmlspecialchars($mascota['fotoCan']); ?>">

            <div class="form-layout form-layout-1">
              <div class="row mg-b-25">

                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Nombre:</label>
                    <input name="nombre" class="form-control" type="text" placeholder="Ejemplo: Firulais"
                           value="<?php echo htmlspecialchars($mascota['nombre']); ?>" required>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Sexo:</label>
                    <select name="sexo" class="form-control">
                      <option value="Macho"  <?php echo $mascota['sexo'] === 'Macho'  ? 'selected' : ''; ?>>Macho</option>
                      <option value="Hembra" <?php echo $mascota['sexo'] === 'Hembra' ? 'selected' : ''; ?>>Hembra</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Fecha de nacimiento:</label>
                    <input name="fecha_nacimiento" class="form-control" type="date"
                           value="<?php echo htmlspecialchars($mascota['fecha_nacimiento']); ?>" required>
                  </div>
                </div>

                <div class="col-lg-4 mg-t-20">
                  <div class="form-group">
                    <label class="form-control-label">Raza:</label>
                    <input name="raza" class="form-control" type="text" placeholder="Ejemplo: Husky Siberiano"
                           value="<?php echo htmlspecialchars($mascota['raza']); ?>" required>
                  </div>
                </div>
                <div class="col-lg-4 mg-t-20">
                  <div class="form-group">
                    <label class="form-control-label">Color:</label>
                    <input name="color" class="form-control" type="text" placeholder="Ejemplo: Blanco con Gris"
                           value="<?php echo htmlspecialchars($mascota['Color']); ?>" required>
                  </div>
                </div>
                <div class="col-lg-4 mg-t-20">
                  <div class="form-group">
                    <label class="form-control-label">Alergias:</label>
                    <input name="alergias" class="form-control" type="text" placeholder="Ejemplo: Polen o Ninguna"
                           value="<?php echo htmlspecialchars($mascota['alergias']); ?>">
                  </div>
                </div>

                <div class="col-lg-4 mg-t-20">
                  <div class="form-group">
                    <label class="form-control-label">Edad (número):</label>
                    <input name="edad" class="form-control" type="number" placeholder="Ejemplo: 3"
                           value="<?php echo htmlspecialchars($mascota['edad']); ?>" required>
                  </div>
                </div>
                <div class="col-lg-4 mg-t-20">
                  <div class="form-group">
                    <label class="form-control-label">Peso en kg:</label>
                    <input name="peso" class="form-control" type="text" placeholder="Ejemplo: 2.2"
                           value="<?php echo htmlspecialchars($mascota['peso']); ?>" required>
                  </div>
                </div>
                <div class="col-lg-4 mg-t-20">
                  <div class="form-group">
                    <label class="form-control-label">Tratamiento:</label>
                    <input name="tratamiento" class="form-control" type="text" placeholder="Ejemplo: Desparasitación mensual"
                           value="<?php echo htmlspecialchars($mascota['Tratamiento']); ?>">
                  </div>
                </div>

                <div class="col-lg-12 mg-t-20">
                  <div class="form-group">
                    <label class="form-control-label">Foto del canino:</label>
                    <?php if (!empty($mascota['fotoCan']) && $mascota['fotoCan'] !== 'sin_foto.png'): ?>
                      <br>
                      <img src="public/img/caninos/<?php echo htmlspecialchars($mascota['fotoCan']); ?>"
                           alt="Foto actual" class="preview-foto" id="fotoPreview">
                      <p class="tx-12 tx-gray-500 mg-t-5">Foto actual. Selecciona una nueva para reemplazarla.</p>
                    <?php else: ?>
                      <img src="public/img/logo.png" alt="Sin foto" class="preview-foto" id="fotoPreview">
                    <?php endif; ?>
                    <input name="foto" class="form-control mg-t-10" type="file" accept="image/*" id="inputFoto">
                  </div>
                </div>

              </div>
              <div class="form-layout-footer text-right">
                <a href="index.php?menu=mascotas&opc=listado" class="btn btn-secondary pd-x-20 mg-r-10">
                  <i class="fa fa-arrow-left mg-r-5"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-warning pd-x-20">
                  <i class="fa fa-pencil mg-r-5"></i> Actualizar
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>
    <script>
      // Preview de nueva foto antes de subir
      document.getElementById('inputFoto').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function (e) {
            document.getElementById('fotoPreview').src = e.target.result;
          };
          reader.readAsDataURL(file);
        }
      });
    </script>
</body>
</html>