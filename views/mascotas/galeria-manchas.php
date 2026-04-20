<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Galería de Manchas</title>

    <link href="public/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="public/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/bracket.css">
    
    <style>
        .br-menu-sub { display: block !important; }
        .br-sideleft { background-color: #1d2127; }
        .br-menu-sub .nav-link.active { color: #17a2b8 !important; font-weight: 700; }
        
        .img-gallery {
            height: 200px;
            object-fit: cover;
            width: 100%;
            border-radius: 5px 5px 0 0;
            transition: transform 0.3s ease;
        }
        .card-gallery:hover .img-gallery {
            transform: scale(1.05);
        }
        .card-gallery {
            overflow: hidden;
            border: 0;
        }

        .btn-green-woof {
            background-color: #23BF08 !important;
            border-color: #23BF08 !important;
            color: #ffffff !important;
            padding: 0;
        }
        .btn-green-woof:hover, .btn-green-woof:focus {
            background-color: #1e9d06 !important;
            border-color: #1e9d06 !important;
        }
        .btn-green-woof i {
            color: #ffffff !important;
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
          <span class="breadcrumb-item">Manchas</span>
          <span class="breadcrumb-item active">Galería</span>
        </nav>
      </div>

      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30 d-flex align-items-center justify-content-between">
        <div>
          <h4 class="tx-gray-800 mg-b-5">Galería de Fotos: Manchas</h4>
          <p class="mg-b-0">Colección de recuerdos y fotos médicas de tu mascota.</p>
        </div>
        <button class="btn btn-green-woof btn-with-icon" onclick="$('#uploadModal').modal('show')">
          <div class="ht-40">
            <span class="icon wd-40"><i class="fa fa-camera"></i></span>
            <span class="pd-x-15">Nueva Foto</span>
          </div>
        </button>
      </div>

      <div class="br-pagebody">
        <div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-md-4 col-lg-3 mg-b-20">
            <div class="card shadow-base bd-0 card-gallery">
              <img class="img-gallery" src="public/img/husky1.png" alt="Foto">
              <div class="pd-15">
                <p class="tx-11 tx-uppercase tx-mont tx-semibold mg-b-5">Fecha: 08/04/2026</p>
                <p class="tx-13 mg-b-0">Revisión mensual.</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 col-lg-3 mg-b-20">
            <div class="card shadow-base bd-0 card-gallery">
              <img class="img-gallery" src="public/img/husky2.png" alt="Foto">
              <div class="pd-15">
                <p class="tx-11 tx-uppercase tx-mont tx-semibold mg-b-5">Fecha: 15/01/2026</p>
                <p class="tx-13 mg-b-0">Conociendo la nieve</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 col-lg-3 mg-b-20">
            <div class="card shadow-base bd-0 card-gallery">
              <img class="img-gallery" src="public/img/husky3.png" alt="Foto">
              <div class="pd-15">
                <p class="tx-11 tx-uppercase tx-mont tx-semibold mg-b-5">Fecha: 10/11/2025</p>
                <p class="tx-13 mg-b-0">Visita al bosque</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="uploadModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Subir Nueva Foto</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body pd-20">
            <div class="form-group">
              <label class="form-control-label">Seleccionar imagen:</label>
              <input type="file" class="form-control">
            </div>
            <div class="form-group">
              <label class="form-control-label">Descripción / Nota:</label>
              <input type="text" class="form-control" placeholder="Ej: Foto de la herida sanando">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success tx-size-xs" data-dismiss="modal">Guardar Foto</button>
            <button type="button" class="btn btn-secondary tx-size-xs" data-dismiss="modal">Cancelar</button>
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