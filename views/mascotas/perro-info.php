<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Información de Manchas</title>

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
          <span class="breadcrumb-item">Mascota</span>
          <span class="breadcrumb-item active">Información Canina</span>
        </nav>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper shadow-base bd-0">
          <div class="row">
            <div class="col-md-8">
              <div class="form-layout form-layout-1">
                <div class="row mg-b-25">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label">Nombre del canino:</label>
                      <input id="viewNombre" class="form-control tx-bold tx-inverse" type="text" value="Cargandopublic." readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label">Raza:</label>
                      <input id="viewRaza" class="form-control" type="text" value="public." readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                  <div class="col-lg-6 mg-t-20">
                    <div class="form-group">
                      <label class="form-control-label">Edad:</label>
                      <input id="viewEdad" class="form-control" type="text" value="public." readonly style="background-color: #f8f9fa;">
                    </div>
                  </div>
                  <div class="col-lg-6 mg-t-20">
                    <div class="form-group">
                      <label class="form-control-label">Tratamiento:</label>
                      <textarea id="viewTratamiento" rows="3" class="form-control" readonly style="background-color: #f8f9fa;">public.</textarea>
                    </div>
                  </div>
                </div>
                <div class="form-layout-footer text-right">
                  <button class="btn btn-info pd-x-30" onclick="window.location.href='editar-canino.html'">
                    <i class="fa fa-edit mg-r-5"></i> Editar datos
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-4 text-center">
                <div class="card bd-0 shadow-base">
                    <img class="card-img-top img-fluid" src="public/img/husky.png" alt="Mascota">
                    <div class="card-body bg-gray-100">
                        <p class="card-text tx-bold tx-inverse tx-uppercase tx-11">FOTO DEL CANINO</p>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/popper.js/popper.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Buscamos a "Manchas" en la tabla 'caninos' de Laragon
            fetch('get_perro.php?nombre=Manchas')
                .then(response => response.json())
                .then(data => {
                    if(!data.error) {
                        // Llenamos los inputs con los datos de la base de datos
                        document.getElementById('viewNombre').value = data.nombre;
                        document.getElementById('viewRaza').value = data.raza;
                        document.getElementById('viewEdad').value = data.edad + " años";
                        document.getElementById('viewTratamiento').value = data.Tratamiento;
                    } else {
                        console.error("Error: " + data.error);
                        document.getElementById('viewNombre').value = "No encontrado";
                    }
                })
                .catch(error => {
                    console.error('Error en la petición:', error);
                });
        });
    </script>
</body>
</html>