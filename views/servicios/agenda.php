<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$ruta_conexion = $_SERVER['DOCUMENT_ROOT'] . '/drwoof/views/bd/conexion.php';
if (file_exists($ruta_conexion)) {
    include_once $ruta_conexion;
} else {
    include_once 'views/bd/conexion.php';
}

$id_usuario = $_SESSION['id_usuario'] ?? 4;
$query_user = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'");
$usuario = mysqli_fetch_assoc($query_user);

$nombre_completo = trim(($usuario['nombre'] ?? 'Usuario') . ' ' . ($usuario['apellido_paterno'] ?? ''));
$foto_db = $usuario['FotoUS'] ?? ''; 
$foto_perfil = (!empty($foto_db) && file_exists('public/img/' . $foto_db)) 
               ? $foto_db . '?v=' . time() 
               : 'logo.png'; 

// Manejo simple de fechas para el calendario
$mes = isset($_GET['mes']) ? (int)$_GET['mes'] : (int)date('m');
$anio = isset($_GET['anio']) ? (int)$_GET['anio'] : (int)date('Y');

$mes_anterior = $mes - 1; $anio_anterior = $anio;
if ($mes_anterior < 1) { $mes_anterior = 12; $anio_anterior--; }

$mes_siguiente = $mes + 1; $anio_siguiente = $anio;
if ($mes_siguiente > 12) { $mes_siguiente = 1; $anio_siguiente++; }

$nombres_meses = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
$primer_dia_mes = "$anio-$mes-01";
$ultimo_dia_mes = date('Y-m-t', strtotime($primer_dia_mes));

// Consulta simple de recordatorios
$result = mysqli_query($conexion, "
    SELECT r.id_recordatorio, r.fecha, r.hora, r.motivo, r.repetir, c.nombre AS nombre_canino
    FROM recordatorios r
    INNER JOIN caninos c ON r.id_canino = c.id_canino
    WHERE c.id_usuario = '$id_usuario'
    AND r.fecha BETWEEN '$primer_dia_mes' AND '$ultimo_dia_mes'
    ORDER BY r.fecha ASC, r.hora ASC
");

$recordatorios_por_dia = [];
$todos_recordatorios = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dia_k = (int)date('j', strtotime($row['fecha']));
    $recordatorios_por_dia[$dia_k][] = $row;
    $todos_recordatorios[] = $row;
}

$primer_dia_semana = (int)date('w', strtotime($primer_dia_mes));
$dias_en_mes = (int)date('t', strtotime($primer_dia_mes));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Agenda</title>

    <link href="public/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="public/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/bracket.css">
    
    <style>
        /* --- AJUSTES DE COLORES DR. WOOF --- */
        .br-sideleft { background-color: #2c4ea3 !important; }
        .br-header { background-color: #1e3a8a !important; border: none !important; }
        
        /* Logotipo Superior Izquierdo */
        .br-logo { background-color: #1e3a8a !important; border: none !important; }
        .br-logo a { color: #ffffff !important; font-weight: 700; }
        .br-logo a span { color: #00bfa5 !important; font-weight: 400; }

        /* Fondo celeste general */
        .br-mainpanel {
            background-color: #cdebf7 !important;
            min-height: 100vh;
        }

        /* Ocultar barra superior rígida de migas de pan */
        .br-pageheader {
            display: none !important;
        }

        /* Espaciado para pegar el contenedor blanco directamente arriba */
        .br-pagebody {
            padding: 0 30px 30px 30px !important;
        }

        /* Contenedores blancos estilizados con esquinas redondeadas abajo */
        .br-section-wrapper {
            background-color: #ffffff !important;
            border-radius: 0 0 40px 40px !important;
            padding: 40px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: none !important;
            min-height: 85vh;
            margin-top: 0 !important;
        }
        
        .card-agenda-panel {
            background-color: #ffffff !important;
            border-radius: 20px !important;
            padding: 25px !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: none !important;
        }

        /* --- ELEMENTOS DEL CALENDARIO --- */
        .calendar-table td { 
            width: 45px; 
            height: 45px; 
            text-align: center; 
            vertical-align: middle; 
            font-weight: 500;
        }

        /* Color blanco para Dom, Lun, Mar, Mié, Jue, Vie, Sáb */
        .calendar-table thead tr th {
            color: #ffffff !important;
        }
        
        /* Días con Evento marcados en Azul Claro */
        .event-marked {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
            font-weight: bold;
            border-radius: 50%;
            cursor: pointer;
        }
        .event-marked:hover { background-color: #299ec9 !important; }
        
        /* Día Actual marcado en Azul Marino Fuerte */
        .day-today {
            background-color: #1e3a8a !important;
            color: #ffffff !important;
            font-weight: bold;
            border-radius: 50%;
        }

        /* Barra de detalle lateral izquierda */
        .event-detail { border-left: 4px solid #34b5e5; }

        /* Bienvenida y textos en Header */
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
        .br-sideleft-menu .br-menu-link.active { background-color: #4da9d4 !important; }
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
          <div class="br-menu-item"><i class="icon ion-ios-paw-outline tx-24"></i><span class="menu-item-label">Mis Mascotas</span></div>
        </a>
      </div>

      <label class="sidebar-label pd-x-15 mg-t-25 mg-b-20">Herramientas</label>
      <div class="br-sideleft-menu">
        <a href="index.php?menu=servicios&opc=agendag" class="br-menu-link active">
          <div class="br-menu-item"><i class="icon ion-ios-calendar-outline tx-24"></i><span class="menu-item-label">Agenda</span></div>
        </a>
        <a href="index.php?menu=servicios&opc=recordatorios" class="br-menu-link">
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
          <h6>AGENDA GENERAL</h6>
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
          <span class="breadcrumb-item active">Agenda</span>
        </nav>
      </div>

      <div class="br-pagebody pd-t-20">
        <div class="br-section-wrapper">
          <div class="row align-items-start">
            
            <div class="col-md-8 mg-b-20">
              <div class="d-flex align-items-center justify-content-between mg-b-20">
                <a href="index.php?menu=servicios&opc=agendag&mes=<?= $mes_anterior ?>&anio=<?= $anio_anterior ?>" class="btn btn-outline-primary btn-sm" style="color: #1e3a8a; border-color: #1e3a8a;">
                  <i class="fa fa-chevron-left"></i>
                </a>
                <h5 class="tx-inverse tx-bold mg-b-0" style="color: #1e3a8a; font-size: 18px;"><?= $nombres_meses[$mes] ?> — <?= $anio ?></h5>
                <a href="index.php?menu=servicios&opc=agendag&mes=<?= $mes_siguiente ?>&anio=<?= $anio_siguiente ?>" class="btn btn-outline-primary btn-sm" style="color: #1e3a8a; border-color: #1e3a8a;">
                  <i class="fa fa-chevron-right"></i>
                </a>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered bg-white text-center calendar-table">
                  <thead>
                    <tr style="background-color: #1e3a8a; color: white;">
                      <th>Dom</th><th>Lun</th><th>Mar</th><th>Mié</th><th>Jue</th><th>Vie</th><th>Sáb</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $dia = 1;
                  $hoy_j = (int)date('j'); $mes_h = (int)date('m'); $anio_h = (int)date('Y');
                  $total_celdas = $primer_dia_semana + $dias_en_mes;
                  $filas = ceil($total_celdas / 7);

                  for ($f = 0; $f < $filas; $f++): ?>
                    <tr>
                    <?php for ($c = 0; $c < 7; $c++):
                      $celda = $f * 7 + $c;
                      if ($celda < $primer_dia_semana || $dia > $dias_en_mes): ?>
                        <td></td>
                      <?php else:
                        $es_hoy = ($dia == $hoy_j && $mes == $mes_h && $anio == $anio_h);
                        $tiene_evento = isset($recordatorios_por_dia[$dia]);
                        $clase = $es_hoy ? 'day-today' : ($tiene_evento ? 'event-marked' : '');
                        $onclick = $tiene_evento ? "onclick=\"mostrarDia($dia)\"" : '';
                      ?>
                        <td class="<?= $clase ?>" <?= $onclick ?>><?= $dia ?></td>
                      <?php $dia++; endif; ?>
                    <?php endfor; ?>
                    </tr>
                  <?php endfor; ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-md-4">
              
              <div class="card card-agenda-panel mg-b-20" id="panel-dia" style="display:none; border-top: 4px solid #1e3a8a !important;">
                <h6 class="tx-inverse tx-uppercase tx-bold tx-13 mg-b-15" id="titulo-dia" style="color: #1e3a8a;"></h6>
                <div id="lista-dia"></div>
              </div>

              <div class="card card-agenda-panel">
                <h6 class="tx-inverse tx-uppercase tx-bold tx-13 mg-b-15" style="color: #1e3a8a;">Recordatorios de <?= $nombres_meses[$mes] ?></h6>
                
                <div style="max-height: 320px; overflow-y: auto;">
                <?php if (empty($todos_recordatorios)): ?>
                  <p class="tx-gray-500 tx-13 text-center pd-y-10">No hay recordatorios registrados para este mes.</p>
                <?php else: foreach ($todos_recordatorios as $r): ?>
                  <div class="media mg-b-15 pd-b-15 bd-b event-detail pd-l-10">
                    <div class="media-body">
                      <p class="mg-b-0 tx-inverse tx-bold tx-13"><?= htmlspecialchars($r['nombre_canino']) ?></p>
                      <p class="mg-b-0 tx-13 tx-gray-600"><?= htmlspecialchars($r['motivo']) ?></p>
                      <p class="mg-b-0 tx-12 tx-info" style="color: #34b5e5 !important;"><?= date('d/m/Y', strtotime($r['fecha'])) ?> — <?= date('h:i A', strtotime($r['hora'])) ?></p>
                    </div>
                  </div>
                <?php endforeach; endif; ?>
                </div>

                <div class="mg-t-20 text-center">
                  <a href="index.php?menu=servicios&opc=recordatorios" class="btn btn-info btn-sm pd-x-20" style="background-color: #34b5e5; border: none; border-radius: 20px; font-weight: bold;">
                    <i class="fa fa-plus mg-r-5"></i> Agregar Recordatorio
                  </a>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>
    <script>
        const recordatoriosPorDia = <?= json_encode($recordatorios_por_dia) ?>;
        const nombresMeses = <?= json_encode($nombres_meses) ?>;
        const mesActual = <?= $mes ?>;
        const anioActual = <?= $anio ?>;

        function mostrarDia(dia) {
            const panel = $('#panel-dia');
            const lista = $('#lista-dia');
            $('#titulo-dia').text(dia + ' de ' + nombresMeses[mesActual] + ' ' + anioActual);
            lista.empty();
            const eventos = recordatoriosPorDia[dia];
            if (eventos) {
                eventos.forEach(r => {
                    lista.append(`<div class="media mg-b-10 pd-b-10 bd-b">
                        <div class="media-body">
                            <p class="mg-b-0 tx-inverse tx-bold tx-13" style="color:#1e3a8a;">${r.nombre_canino}</p>
                            <p class="mg-b-0 tx-13 text-secondary">${r.motivo}</p>
                        </div>
                    </div>`);
                });
            }
            panel.fadeIn();
        }
    </script>
</body>
</html>