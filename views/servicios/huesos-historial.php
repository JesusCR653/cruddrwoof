<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Historial Médico Huesos</title>
    
    <link href="public/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="public/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    
    <link rel="stylesheet" href="public/css/bracket.css">
    
    <style>
        .br-menu-sub { display: block !important; }
        .br-sideleft { background-color: #1d2127; }
        
        .br-menu-sub .nav-link.active {
            color: #17a2b8 !important;
            font-weight: 700;
        }
    </style>
</head>

<body>

    <div class="br-logo"><a href="index.html"><span>DR.</span> WOOF<span>+</span></a></div>
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
</div>

      <label class="sidebar-label pd-x-15 mg-t-25 mg-b-20 tx-info op-9">MIS MASCOTAS</label>
<div class="br-sideleft-menu">
  <a href="#" class="br-menu-link show-sub">
    <div class="br-menu-item">
      <i class="menu-item-icon icon ion-ios-paw tx-22"></i>
      <span class="menu-item-label">Manchas</span>
      <i class="menu-item-arrow fa fa-angle-down"></i>
    </div>
  </a>
  <ul class="br-menu-sub nav flex-column">
    <li class="nav-item"><a href="index.php?menu=mascotas&opc=info" class="nav-link">Información canina</a></li>
    <li class="nav-item"><a href="index.php?menu=servicios&opc=historial" class="nav-link">Historial medico</a></li>
    <li class="nav-item"><a href="index.php?menu=servicios&opc=agendam" class="nav-link">Citas</a></li>
    <li class="nav-item"><a href="index.php?menu=mascotas&opc=qr" class="nav-link">Qr</a></li>
<li class="nav-item">
    <a href="index.php?menu=mascotas&opc=galeria" class="nav-link">Galeria de fotos</a>
</li>
  </ul>

  <a href="#" class="br-menu-link show-sub mg-t-10">
    <div class="br-menu-item">
      <i class="icon ion-ios-paw tx-22"></i>
      <span class="menu-item-label">Huesos</span>
      <i class="menu-item-arrow fa fa-angle-down"></i>
    </div>
  </a>
  <ul class="br-menu-sub nav flex-column">
    <li class="nav-item"><a href="index.php?menu=mascotas&opc=huesos-info" class="nav-link">Información canina</a></li>
    <li class="nav-item"><a href="index.php?menu=servicios&opc=huesos-historial" class="nav-link">Historial medico</a></li>
    <li class="nav-item"><a href="index.php?menu=servicios&opc=huesos-agenda" class="nav-link">Citas</a></li>
    <li class="nav-item"><a href="index.php?menu=mascotas&opc=huesos-qr" class="nav-link">Qr</a></li>
    <li class="nav-item"><a href="index.php?menu=mascotas&opc=huesos-galeria" class="nav-link">Galeria de fotos</a></li>
  </ul>
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
          <span class="logged-name">Axel Jesús Casique</span>
          <img src="public/img/Axel.png" class="wd-32 rounded-circle mg-l-10" alt="Perfil">
        </a>
        <div class="dropdown-menu dropdown-menu-header wd-200">
          <ul class="list-unstyled user-profile-nav">
            <li>
              <a href="index.php?menu=personal&opc=perfil">
                <i class="icon ion-ios-person"></i> Perfil
              </a>
            </li>
            <li>
              <a href="index.php?menu=bienvenida">
                <i class="icon ion-power"></i> Cerrar Sesión
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</div>

    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.html">DR. WOOF</a>
          <span class="breadcrumb-item">Huesos</span>
          <span class="breadcrumb-item active">Historial Médico</span>
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
                      <label class="form-control-label">Peso actual:</label>
                      <input class="form-control tx-bold tx-inverse" type="text" value="12.2 Kg (Cachorro)" readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                  <div class="col-lg-12 mg-t-20">
                    <div class="form-group">
                      <label class="form-control-label">Diagnostico:</label>
                      <textarea rows="3" class="form-control" readonly style="background-color: #f8f9fa;">Revisión de crecimiento. Desarrollo óseo normal para su edad. Se inicia desparasitación de refuerzo.</textarea>
                    </div>
                  </div>
                  <div class="col-lg-12 mg-t-20">
                    <div class="form-group">
                      <label class="form-control-label">Fecha de consulta:</label>
                      <input class="form-control" type="text" value="02 de Abril, 2026" readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                  <div class="col-lg-12 mg-t-20">
                    <div class="form-group">
                      <label class="form-control-label">Proxima revisión:</label>
                      <input class="form-control text-info tx-bold" type="text" value="16 de Abril, 2026 (Vacuna Triple)" readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4 text-center">
                <h6 class="tx-info tx-uppercase tx-bold mg-b-15">Archivos adjuntos:</h6>
                <div class="card bd-0 shadow-base pd-25 bg-gray-100 mg-b-20">
                    <i class="icon ion-ios-download-outline tx-70 tx-info"></i>
                    <p class="mg-t-10 tx-12 tx-gray-600">Recetas, Análisis Clínicos, Placas.</p>
                    <button class="btn btn-info btn-block btn-sm">Descargar Todo</button>
                </div>

                <h6 class="tx-info tx-uppercase tx-bold mg-b-15">Certificados:</h6>
                <div class="card bd-0 shadow-base pd-25 bg-gray-100">
                    <i class="icon ion-ios-paper-outline tx-70 tx-info"></i>
                    <p class="mg-t-10 tx-12 tx-gray-600">Cartilla de Vacunación Digital.</p>
                    <button class="btn btn-info btn-block btn-sm" onclick="window.location.href='cartilla-huesos.html'">Abrir Cartilla</button>
                </div>
            </div>
          </div>
          <div class="form-layout-footer mg-t-30 text-right">
            <button class="btn btn-outline-info pd-x-30" onclick="window.location.href='index.php?menu=servicios&opc=histoh'">Ver historial completo</button>
          </div>
        </div>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>
</body>
</html>