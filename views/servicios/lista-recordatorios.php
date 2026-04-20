<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Mis Recordatorios</title>
    <link href="public/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/bracket.css">
    <style>
        .br-menu-sub { display: block !important; }
        .br-sideleft { background-color: #1d2127; }
        .list-number { font-size: 24px; font-weight: bold; color: #17a2b8; padding-right: 15px; }
    </style>
</head>

<body>
    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.html">DR. WOOF</a>
          <a class="breadcrumb-item" href="recordatorios.html">Recordatorios</a>
          <span class="breadcrumb-item active">Listado</span>
        </nav>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper shadow-base bd-0">
          <h6 class="tx-inverse tx-uppercase tx-bold tx-14 mg-b-25">Recordatorios Activos</h6>
          
          <div class="media-list bg-white rounded shadow-base">
            <div class="media pd-20 bd-b">
              <span class="list-number">1</span>
              <div class="media-body row">
                <div class="col-sm-3"><label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Fecha</label><p class="mg-b-0 tx-inverse">08/04/2026</p></div>
                <div class="col-sm-2"><label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Hora</label><p class="mg-b-0 tx-inverse">10:00 AM</p></div>
                <div class="col-sm-5"><label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Motivo</label><p class="mg-b-0 tx-inverse tx-bold">Cita con veterinario - Huesos</p></div>
                <div class="col-sm-2 text-right"><button class="btn btn-outline-danger btn-icon rounded-circle"><i class="icon ion-ios-trash-outline tx-20"></i></button></div>
              </div>
            </div>

            <div class="media pd-20 bd-b">
              <span class="list-number">2</span>
              <div class="media-body row">
                <div class="col-sm-3"><label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Fecha</label><p class="mg-b-0 tx-inverse">09/04/2026</p></div>
                <div class="col-sm-2"><label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Hora</label><p class="mg-b-0 tx-inverse">08:00 PM</p></div>
                <div class="col-sm-5"><label class="tx-11 tx-uppercase tx-gray-600 mg-b-5">Motivo</label><p class="mg-b-0 tx-inverse tx-bold">Medicina Manchas (Cada 12h)</p></div>
                <div class="col-sm-2 text-right"><button class="btn btn-outline-danger btn-icon rounded-circle"><i class="icon ion-ios-trash-outline tx-20"></i></button></div>
              </div>
            </div>
          </div>

          <div class="mg-t-30 text-center">
            <button class="btn btn-info pd-x-30" onclick="location.href='recordatorios.html'">AGREGAR OTRO</button>
            <button class="btn btn-secondary pd-x-30 mg-l-5" onclick="location.href='index.html'">REGRESAR AL INICIO</button>
          </div>
        </div>
      </div>
    </div>
    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
</body>
</html>