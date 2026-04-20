<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Historial Médico Completo</title>

    <link href="public/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="public/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/bracket.css">
    
    <style>
        .br-menu-sub { display: block !important; }
        .br-sideleft { background-color: #1d2127; }
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
    </div>

    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.html">DR. WOOF</a>
          <a class="breadcrumb-item" href="historial-manchas.html">Historial Manchas</a>
          <span class="breadcrumb-item active">Historial Completo</span>
        </nav>
      </div>

      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Archivo Médico Histórico</h4>
        <p class="mg-b-0">Listado cronológico de todas las intervenciones de Manchas.</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper shadow-base bd-0">
          
          <div class="table-responsive">
            <table class="table table-bordered table-colored table-info">
              <thead>
                <tr>
                  <th class="wd-15p text-center">Fecha</th>
                  <th class="wd-15p text-center">Peso</th>
                  <th class="wd-45p">Diagnóstico / Motivo</th>
                  <th class="wd-25p text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center">08/04/2026</td>
                  <td class="text-center">24.5 Kg</td>
                  <td><strong>Dermatitis Alérgica:</strong> Inicio de tratamiento con champú medicado y dieta hipoalergénica.</td>
                  <td class="text-center">
                    <button class="btn btn-outline-primary btn-icon btn-sm" title="Ver Receta"><i class="fa fa-file-pdf-o"></i></button>
                    <button class="btn btn-outline-info btn-icon btn-sm mg-l-5" title="Ver Fotos"><i class="fa fa-image"></i></button>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">15/01/2026</td>
                  <td class="text-center">23.8 Kg</td>
                  <td><strong>Check-up Anual:</strong> Vacunación Sextuple y Rabia. Parámetros normales.</td>
                  <td class="text-center">
                    <button class="btn btn-outline-primary btn-icon btn-sm"><i class="fa fa-file-pdf-o"></i></button>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">10/11/2025</td>
                  <td class="text-center">24.0 Kg</td>
                  <td><strong>Desparasitación:</strong> Aplicación de refuerzo interno y externo.</td>
                  <td class="text-center">
                    <button class="btn btn-outline-primary btn-icon btn-sm"><i class="fa fa-file-pdf-o"></i></button>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">02/09/2025</td>
                  <td class="text-center">22.5 Kg</td>
                  <td><strong>Infección Estomacal:</strong> Tratamiento con antibióticos por 7 días debido a ingesta de basura.</td>
                  <td class="text-center">
                    <button class="btn btn-outline-primary btn-icon btn-sm"><i class="fa fa-file-pdf-o"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="mg-t-30 text-right">
            <a href="historial-manchas.html" class="btn btn-secondary pd-x-30">Regresar</a>
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