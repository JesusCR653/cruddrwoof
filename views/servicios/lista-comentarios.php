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
        $foto_user = $usuario['FotoUS'];
    }
}

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

        .title-section-custom {
            color: #1e3a8a !important;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 16px;
            letter-spacing: 0.5px;
        }

        .comment-item { 
            border: none !important;
            background-color: #dcdcdc !important;
            color: #333333 !important;
            border-radius: 25px !important;
            padding: 20px 25px !important;
            border-left: 6px solid #34b5e5 !important;
        }
        
        .texto-comentario {
            font-weight: bold;
            font-size: 15px;
            text-align: center;
        }

        .form-control-custom-edit {
            background-color: #ffffff !important;
            color: #333333 !important;
            border: 2px solid #34b5e5 !important;
            border-radius: 20px !important;
            font-weight: bold;
            padding: 12px 20px !important;
            font-size: 14px;
            text-align: center;
        }
        .form-control-custom-edit:focus {
            outline: none;
        }

        .badge-custom-enviado {
            background-color: #1e3a8a !important;
            color: #ffffff !important;
            padding: 5px 12px;
            font-weight: bold;
            border-radius: 12px;
        }

        .btn-custom-nuevo {
            background-color: #92bc5c !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 35px !important;
            font-size: 15px !important;
            font-weight: bold;
        }
        .btn-custom-salir {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 35px !important;
            font-size: 15px !important;
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
            <a href="index.php?menu=servicios&opc=recordatorios" class="br-menu-link">
                <div class="br-menu-item"><i class="icon ion-ios-alarm-outline tx-24"></i><span class="menu-item-label">Recordatorios</span></div>
            </a>
            <a href="index.php?menu=servicios&opc=comentarios" class="br-menu-link active">
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
            <h6>HISTORIAL DE COMENTARIOS</h6>
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
            <div class="br-section-wrapper">
                <h6 class="title-section-custom mg-b-25">Historial de Comentarios</h6>

                <div class="list-group" style="gap: 15px;">
                    <?php
                    $total = mysqli_num_rows($result);
                    if ($total == 0): ?>
                        <p class="text-muted text-center font-weight-bold pd-y-20">No has enviado comentarios aún.</p>
                    <?php else: while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="list-group-item comment-item pd-y-20 pd-x-25 mg-b-10 shadow-sm" id="item-<?php echo $row['id_comentario']; ?>">
                            <div class="d-flex align-items-center justify-content-between mg-b-15">
                                <span class="tx-13 font-weight-bold" style="color: #1e3a8a;">
                                    <i class="fa fa-calendar mg-r-5"></i>
                                    <?php echo date('d \d\e F, Y', strtotime($row['fecha_registro'])); ?>
                                </span>
                                <span class="badge badge-custom-enviado">Enviado</span>
                            </div>

                            <p class="mg-b-0 tx-inverse texto-comentario" id="texto-<?php echo $row['id_comentario']; ?>"><?php echo htmlspecialchars($row['comentario']); ?></p>

                            <textarea class="form-control form-control-custom-edit" id="editor-<?php echo $row['id_comentario']; ?>" rows="3" style="display:none;"><?php echo htmlspecialchars($row['comentario']); ?></textarea>

                            <div class="text-right mg-t-15">
                                <button class="btn btn-outline-info btn-icon rounded-circle mg-r-5" id="btn-editar-<?php echo $row['id_comentario']; ?>" onclick="activarEdicion(<?php echo $row['id_comentario']; ?>)" style="padding: 4px 8px;">
                                    <i class="icon ion-ios-compose-outline tx-18"></i>
                                </button>
                                <button class="btn btn-success btn-icon rounded-circle mg-r-5" id="btn-guardar-<?php echo $row['id_comentario']; ?>" style="display:none; padding: 4px 8px;" onclick="guardarEdicion(<?php echo $row['id_comentario']; ?>)">
                                    <i class="fa fa-check tx-14"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-icon rounded-circle" onclick="eliminarComentario(<?php echo $row['id_comentario']; ?>)" style="padding: 4px 8px;">
                                    <i class="icon ion-ios-trash-outline tx-18"></i>
                                </button>
                            </div>
                        </div>
                    <?php endwhile; endif; ?>
                </div>

                <div class="mg-t-40 text-center d-flex align-items-center justify-content-center gap-3 flex-wrap">
                    <button class="btn btn-custom-nuevo" onclick="location.href='index.php?menu=servicios&opc=comentarios'">NUEVO COMENTARIO</button>
                    <button class="btn btn-custom-salir" onclick="location.href='index.php?menu=servicios&opc=comentarios'">SALIR</button>
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
            document.getElementById('texto-' + id).style.display = 'none';
            document.getElementById('editor-' + id).style.display = 'block';
            document.getElementById('btn-editar-' + id).style.display = 'none';
            document.getElementById('btn-guardar-' + id).style.display = 'inline-block';
        }

        function guardarEdicion(id) {
            var elEditor = document.getElementById('editor-' + id);
            var nuevoTexto = elEditor.value;

            var esVacio = true;
            for (var i = 0; i < nuevoTexto.length; i++) {
                if (nuevoTexto.charAt(i) !== ' ' && nuevoTexto.charAt(i) !== '\n' && nuevoTexto.charAt(i) !== '\r') {
                    esVacio = false;
                    break;
                }
            }

            if (esVacio == true) {
                alert('El comentario no puede estar vacío.');
                return;
            }

            var ajax = new XMLHttpRequest();
            ajax.open('POST', 'controllers/crudcomentarios/editar_comentario.php', true);
            
            var datos = new FormData();
            datos.append('id_comentario', id);
            datos.append('comentario', nuevoTexto);

            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    var respuesta = JSON.parse(ajax.responseText);
                    if (respuesta.status == 'success') {
                        document.getElementById('texto-' + id).innerHTML = nuevoTexto;
                        document.getElementById('texto-' + id).style.display = 'block';
                        document.getElementById('editor-' + id).style.display = 'none';
                        document.getElementById('btn-editar-' + id).style.display = 'inline-block';
                        document.getElementById('btn-guardar-' + id).style.display = 'none';
                        alert(respuesta.message);
                    } else {
                        alert('Error: ' + respuesta.message);
                    }
                }
            };
            
            ajax.send(datos);
        }

        function eliminarComentario(id) {
            if (confirm('¿Estás seguro de eliminar este comentario?') == false) {
                return;
            }

            var ajax = new XMLHttpRequest();
            ajax.open('POST', 'controllers/crudcomentarios/eliminar_comentario.php', true);
            
            var datos = new FormData();
            datos.append('id_comentario', id);

            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    var respuesta = JSON.parse(ajax.responseText);
                    if (respuesta.status == 'success') {
                        var item = document.getElementById('item-' + id);
                        item.parentNode.removeChild(item);
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