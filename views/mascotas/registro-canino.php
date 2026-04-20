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

    <div class="br-mainpanel">
      <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="index.html">DR. WOOF</a>
          <span class="breadcrumb-item active">Registro Canino</span>
        </nav>
      </div>

      <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Registro de Nueva Mascota</h4>
        <p class="mg-b-0">Ingrese los datos para actualizar el inventario canino.</p>
      </div>

      <div class="br-pagebody">
        <div class="br-section-wrapper">
          <div class="form-layout form-layout-1">
            <div class="row mg-b-25">
              
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Nombre:</label>
                  <input id="c_nombre" class="form-control" type="text" placeholder="Ejemplo: Firulais">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Sexo:</label>
                  <select id="c_sexo" class="form-control">
                    <option value="macho">Macho</option>
                    <option value="hembra">Hembra</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Fecha de nacimiento:</label>
                  <input id="c_fecha" class="form-control" type="date">
                </div>
              </div>

              <div class="col-lg-4 mg-t-20">
                <div class="form-group">
                  <label class="form-control-label">Raza:</label>
                  <input id="c_raza" class="form-control" type="text" placeholder="Ejemplo: Husky Siberiano">
                </div>
              </div>
              <div class="col-lg-4 mg-t-20">
                <div class="form-group">
                  <label class="form-control-label">Color:</label>
                  <input id="c_color" class="form-control" type="text" placeholder="Ejemplo: Blanco con Gris">
                </div>
              </div>
              <div class="col-lg-4 mg-t-20">
                <div class="form-group">
                  <label class="form-control-label">Alergias:</label>
                  <input id="c_alergias" class="form-control" type="text" placeholder="Ejemplo: Polen, Pollo o Ninguna">
                </div>
              </div>

              <div class="col-lg-4 mg-t-20">
                <div class="form-group">
                  <label class="form-control-label">Edad(numero):</label>
                  <input id="c_edad" class="form-control" type="text" placeholder="Ejemplo: 3">
                </div>
              </div>
              <div class="col-lg-4 mg-t-20">
                <div class="form-group">
                  <label class="form-control-label">Peso en kg:</label>
                  <input id="c_peso" class="form-control" type="text" placeholder="Ejemplo: 2.2">
                </div>
              </div>
              <div class="col-lg-4 mg-t-20">
                <div class="form-group">
                  <label class="form-control-label">Tratamiento:</label>
                  <input id="c_trata" class="form-control" type="text" placeholder="Ejemplo: Desparasitación mensual">
                </div>
              </div>

            </div><div class="form-layout-footer text-right">
              <button class="btn btn-secondary pd-x-20"><i class="fa fa-camera mg-r-5"></i> Agregar foto</button>
              <button class="btn btn-info pd-x-20" onclick="enviarRegistro()">Registrar</button>
              <button class="btn btn-success pd-x-20 mg-l-5" data-toggle="modal" data-target="#modalQR">Generar QR</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="modalQR" class="modal fade">
      <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-body pd-25 text-center">
            <h4 class="lh-3 mg-b-20 tx-inverse">Código QR Generado</h4>
            <div class="bg-gray-200 pd-40 mg-b-20 rounded d-inline-block">
                <i class="fa fa-qrcode tx-100"></i>
            </div>
            <p class="mg-b-0">Placa lista para el nuevo canino.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>
    <script src="public/js/bracket.js"></script>

    <script>
        function enviarRegistro() {
            const formData = new FormData();
            formData.append('nombre', document.getElementById('c_nombre').value);
            formData.append('sexo', document.getElementById('c_sexo').value);
            formData.append('fecha_nacimiento', document.getElementById('c_fecha').value);
            formData.append('raza', document.getElementById('c_raza').value);
            formData.append('color', document.getElementById('c_color').value);
            formData.append('alergias', document.getElementById('c_alergias').value);
            formData.append('edad', document.getElementById('c_edad').value);
            formData.append('peso', document.getElementById('c_peso').value);
            formData.append('tratamiento', document.getElementById('c_trata').value);

            fetch('guardar_perro.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    alert(data.message);
                    window.location.href = 'index.html';
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert("Error de red o de base de datos.");
            });
        }
    </script>
</body>
</html>