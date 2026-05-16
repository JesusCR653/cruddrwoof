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

$query = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result = mysqli_query($conexion, $query);
$usuario = mysqli_fetch_assoc($result);

$nombre_usuario = "Usuario";
if (isset($usuario['nombre'])) {
    $nombre_usuario = $usuario['nombre'];
} else if (isset($_SESSION['nombre'])) {
    $nombre_usuario = $_SESSION['nombre'];
}

$apellido_usuario = "";
if (isset($usuario['apellido_paterno'])) {
    $apellido_usuario = $usuario['apellido_paterno'];
} else if (isset($_SESSION['apellido'])) {
    $apellido_usuario = $_SESSION['apellido'];
}

$nombre_completo = $nombre_usuario . ' ' . $apellido_usuario;

$foto_perfil = 'logo.png';
if (isset($usuario['FotoUS']) && $usuario['FotoUS'] != "") {
    if (file_exists('public/img/' . $usuario['FotoUS'])) {
        $foto_perfil = $usuario['FotoUS'] . '?v=' . time();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Registro Canino</title>
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
        .form-control-custom::placeholder {
            color: #444444;
            text-align: center;
        }
        .form-control-custom:focus {
            background-color: #cfcfcf !important;
            outline: none;
        }
        input.form-control-custom {
            text-align: center;
        }

        .input-file-hidden {
            display: none;
        }

        .btn-custom-foto {
            background-color: #1e3a8a !important;
            color: white !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 30px !important;
            font-size: 16px !important;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            min-width: 190px;
            cursor: pointer;
        }
        .btn-custom-registrar {
            background-color: #92bc5c !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 50px !important;
            font-size: 16px !important;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-custom-qr {
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
        <a href="index.php?menu=mascotas&opc=registro" class="br-menu-link active">
          <div class="br-menu-item"><i class="icon ion-ios-plus-outline tx-24"></i><span class="menu-item-label">Registro Canino</span></div>
        </a>
        <a href="index.php?menu=mascotas&opc=listado" class="br-menu-link">
          <div class="br-menu-item"><i class="icon ion-ios-paw-outline tx-24"></i><span class="menu-item-label">Mis Mascotas</span></div>
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
          <h6>REGISTRO DE CANINO</h6>
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
            <i class="fa fa-check mg-r-5"></i> Mascota registrada correctamente.
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger mg-t-15">
            <i class="fa fa-times mg-r-5"></i> Ocurrió un error al registrar. Intenta de nuevo.
        </div>
        <?php endif; ?>

        <div class="br-section-wrapper d-flex flex-column justify-content-center">
          <form action="index.php?menu=mascotas&opc=guardar" method="POST" enctype="multipart/form-data">
            
            <div class="row justify-content-center">
                
                <div class="col-md-4">
                  <div class="form-group">
                    <input name="nombre" class="form-control form-control-custom" type="text" placeholder="Nombre" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <select name="sexo" class="form-control form-control-custom" required>
                      <option value="" disabled selected hidden>Sexo</option>
                      <option value="Macho">Macho</option>
                      <option value="Hembra">Hembra</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <input name="fecha_nacimiento" id="fecha_nac" class="form-control form-control-custom" type="text" placeholder="Fecha de nacimiento" required>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <input name="raza" class="form-control form-control-custom" type="text" placeholder="Raza" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <input name="color" class="form-control form-control-custom" type="text" placeholder="Color" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <input name="alergias" class="form-control form-control-custom" type="text" placeholder="Alergias">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <input name="edad" class="form-control form-control-custom" type="number" placeholder="Edad" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <input name="peso" class="form-control form-control-custom" type="text" placeholder="Peso" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <input name="tratamiento" class="form-control form-control-custom" type="text" placeholder="Tratamiento">
                  </div>
                </div>

            </div>

            <div class="d-flex align-items-center justify-content-center mg-t-40 gap-4 flex-wrap">
                
                <div>
                    <label for="foto-canino" class="btn-custom-foto m-0">
                        <span id="txt-foto">Agregar foto</span> <span class="tx-20 font-weight-normal">+</span>
                    </label>
                    <input name="foto" id="foto-canino" type="file" accept="image/*" class="input-file-hidden" onchange="cambiarTextoFoto()">
                </div>

                <div>
                    <button type="submit" class="btn-custom-registrar">
                        Registrar
                    </button>
                </div>

                <div>
                    <a href="index.php?menu=mascotas&opc=listado" class="btn btn-custom-qr text-center">
                        Generar QR
                    </a>
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
    var inputFecha = document.getElementById("fecha_nac");
    
    inputFecha.onfocus = function() {
        inputFecha.type = "date";
    };

    inputFecha.onblur = function() {
        if (inputFecha.value == "") {
            inputFecha.type = "text";
        }
    };

    function cambiarTextoFoto() {
        var archivo = document.getElementById("foto-canino");
        var texto = document.getElementById("txt-foto");
        if (archivo.value != "") {
            texto.innerHTML = "¡Foto cargada!";
        } else {
            texto.innerHTML = "Agregar foto";
        }
    }
    </script>
</body>
</html>