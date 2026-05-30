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

$query_user = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'");
$usuario = mysqli_fetch_assoc($query_user);

if ($usuario['nombre'] != "") {
    $nombre_completo = $usuario['nombre'] . ' ' . $usuario['apellido_paterno'];
} else {
    $nombre_completo = 'Usuario';
}

$foto_db = $usuario['FotoUS'];
if ($foto_db != "" && file_exists('public/img/' . $foto_db)) {
    $foto_perfil = $foto_db . '?v=' . time();
} else {
    $foto_perfil = 'logo.png';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id_canino'];
    
    // RECOGER EL NUEVO CAMPO AGREGADO
    $tipo_mascota = $_POST['tipo_mascota'] ?? 'Otro';
    
    $nombre = $_POST['nombre'];
    $sexo = $_POST['sexo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $raza = $_POST['raza'];
    $color = $_POST['color'];
    $alergias = $_POST['alergias'];
    $edad = (int)$_POST['edad'];
    $peso = $_POST['peso'];
    $tratamiento = $_POST['tratamiento'];
    $fotoActual = $_POST['foto_actual'];

    $fotoCan = $fotoActual;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $info = pathinfo($_FILES['foto']['name']);
        $ext = $info['extension'];
        $nombreFoto = uniqid('can_') . '.' . $ext;
        $destino = 'public/img/caninos/' . $nombreFoto;

        if (!is_dir('public/img/caninos')) {
            mkdir('public/img/caninos', 0755, true);
        }

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
            if ($fotoActual != 'sin_foto.png' && file_exists('public/img/caninos/' . $fotoActual)) {
                unlink('public/img/caninos/' . $fotoActual);
            }
            $fotoCan = $nombreFoto;
        }
    }

    // ACTUALIZADO: Se agrega la modificación de la columna tipo_mascota
    $sql = "UPDATE caninos SET 
            nombre='$nombre', 
            raza='$raza', 
            edad=$edad, 
            sexo='$sexo', 
            fotoCan='$fotoCan', 
            Color='$color', 
            peso='$peso',
            fecha_nacimiento='$fecha_nacimiento', 
            alergias='$alergias', 
            Tratamiento='$tratamiento',
            tipo_mascota='$tipo_mascota' 
            WHERE id_canino=$id";

    $ejecutar = mysqli_query($conexion, $sql);

    if ($ejecutar) {
        header('Location: index.php?menu=mascotas&opc=listado&exito=2');
    } else {
        header('Location: index.php?menu=mascotas&opc=editar&id=' . $id . '&error=1');
    }
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
} else {
    $id = 0;
}

if ($id == 0) {
    header('Location: index.php?menu=mascotas&opc=listado');
    exit;
}

$query_mascota = mysqli_query($conexion, "SELECT * FROM caninos WHERE id_canino = $id");
$mascota = mysqli_fetch_assoc($query_mascota);

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
    <title>DR. WOOF - Editar Mascota</title>
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
            padding: 60px 40px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: none !important;
            min-height: 85vh;
            margin-top: 0 !important;
        }

        .form-group {
            margin-bottom: 25px;
        }
        
        .form-control-label-custom {
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
            transition: all 0.2s ease;
            text-align-last: center;
        }
        .form-control-custom:focus {
            background-color: #cfcfcf !important;
            outline: none;
        }
        input.form-control-custom {
            text-align: center;
        }

        .input-file-custom {
            border-radius: 15px !important;
            padding: 8px 15px !important;
            font-size: 14px !important;
        }

        .preview-foto {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 15px;
            border: 4px solid #1e3a8a;
            margin-top: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .btn-custom-cancelar {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 35px !important;
            font-size: 16px !important;
            font-weight: bold;
        }
        .btn-custom-actualizar {
            background-color: #92bc5c !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 45px !important;
            font-size: 16px !important;
            font-weight: bold;
            cursor: pointer;
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
        <div class="navicon-left hidden-md-down">
          <a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a>
        </div>
      </div>

      <div class="header-welcome-centered">
          <h6>EDITAR MASCOTA</h6>
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
      <div class="br-pagebody">
        
        <?php if (isset($_GET['exito'])): ?>
        <div class="alert alert-success mg-t-15">
            <i class="fa fa-check mg-r-5"></i> Mascota actualizada correctamente.
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger mg-t-15">
            <i class="fa fa-times mg-r-5"></i> Ocurrió un error al actualizar. Intenta de nuevo.
        </div>
        <?php endif; ?>

        <div class="br-section-wrapper d-flex flex-column justify-content-center">
          <form action="index.php?menu=mascotas&opc=editar" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_canino" value="<?php echo $mascota['id_canino']; ?>">
            <input type="hidden" name="foto_actual" value="<?php echo $mascota['fotoCan']; ?>">

            <div class="row justify-content-center">

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label-custom">Tipo de Mascota:</label>
                    <select name="tipo_mascota" class="form-control form-control-custom" required>
                      <option value="Perro"  <?php if(($mascota['tipo_mascota'] ?? '') == 'Perro') echo 'selected'; ?>>Perro</option>
                      <option value="Gato"  <?php if(($mascota['tipo_mascota'] ?? '') == 'Gato') echo 'selected'; ?>>Gato</option>
                      <option value="Ave"   <?php if(($mascota['tipo_mascota'] ?? '') == 'Ave') echo 'selected'; ?>>Ave</option>
                      <option value="Reptil"<?php if(($mascota['tipo_mascota'] ?? '') == 'Reptil') echo 'selected'; ?>>Reptil</option>
                      <option value="Otro"  <?php if(($mascota['tipo_mascota'] ?? '') == 'Otro') echo 'selected'; ?>>Otro</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label-custom">Nombre del canino:</label>
                    <input name="nombre" class="form-control form-control-custom" type="text" placeholder="Nombre"
                           value="<?php echo $mascota['nombre']; ?>" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label-custom">Sexo:</label>
                    <select name="sexo" class="form-control form-control-custom">
                      <option value="Macho"  <?php if($mascota['sexo'] == 'Macho') echo 'selected'; ?>>Macho</option>
                      <option value="Hembra" <?php if($mascota['sexo'] == 'Hembra') echo 'selected'; ?>>Hembra</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label-custom">Fecha de nacimiento:</label>
                    <input name="fecha_nacimiento" class="form-control form-control-custom" type="date"
                           value="<?php echo $mascota['fecha_nacimiento']; ?>" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label-custom">Raza:</label>
                    <input name="raza" class="form-control form-control-custom" type="text" placeholder="Raza"
                           value="<?php echo $mascota['raza']; ?>" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label-custom">Color:</label>
                    <input name="color" class="form-control form-control-custom" type="text" placeholder="Color"
                           value="<?php echo $mascota['Color']; ?>" required>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label-custom">Alergias:</label>
                    <input name="alergias" class="form-control form-control-custom" type="text" placeholder="Alergias"
                           value="<?php echo $mascota['alergias']; ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label-custom">Edad:</label>
                    <input name="edad" class="form-control form-control-custom" type="number" placeholder="Edad"
                           value="<?php echo $mascota['edad']; ?>" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label-custom">Peso:</label>
                    <input name="peso" class="form-control form-control-custom" type="text" placeholder="Peso"
                           value="<?php echo $mascota['peso']; ?>" required>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label-custom">Tratamiento:</label>
                    <input name="tratamiento" class="form-control form-control-custom" type="text" placeholder="Tratamiento"
                           value="<?php echo $mascota['Tratamiento']; ?>">
                  </div>
                </div>

                <div class="col-md-6 text-center mg-t-10 mg-b-20">
                  <div class="form-group">
                    <label class="form-control-label-custom">Foto de la mascota:</label>
                    <?php if ($mascota['fotoCan'] != "" && $mascota['fotoCan'] != 'sin_foto.png'): ?>
                      <img src="public/img/caninos/<?php echo $mascota['fotoCan']; ?>"
                           alt="Foto actual" class="preview-foto" id="fotoPreview">
                    <?php else: ?>
                      <img src="public/img/logo.png" alt="Sin foto" class="preview-foto" id="fotoPreview">
                    <?php endif; ?>
                    <input name="foto" class="form-control form-control-custom input-file-custom mg-t-15 mx-auto" type="file" accept="image/*" id="inputFoto" style="max-width: 320px;">
                  </div>
                </div>

            </div>

            <div class="d-flex align-items-center justify-content-center mg-t-20 gap-4 flex-wrap">
                <div>
                    <a href="index.php?menu=mascotas&opc=listado" class="btn btn-custom-cancelar text-center">
                        Cancelar
                    </a>
                </div>
                <div>
                    <button type="submit" class="btn-custom-actualizar">
                        Actualizar
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
      document.getElementById('inputFoto').addEventListener('change', function () {
        var file = this.files[0];
        if (file) {
          var reader = new FileReader();
          reader.onload = function (e) {
            document.getElementById('fotoPreview').src = e.target.result;
          };
          reader.readAsDataURL(file);
        }
      });
    </script>
</body>
</html>