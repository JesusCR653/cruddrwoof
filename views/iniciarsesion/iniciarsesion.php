<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Iniciar Sesión</title>

    <link href="public/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="public/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/bracket.css">
</head>

<body class="bg-br-primary">

    <div class="d-flex align-items-center justify-content-center ht-100v">
      <div class="login-wrapper wd-700 pd-25 pd-x-40 bg-white shadow-base bd-0">
        
        <form action="index.php?menu=sesion&opc=validar" method="POST">
            <div class="row row-xs align-items-center">
                
                <div class="col-md-5 text-center mg-b-20 mg-md-b-0">
                    <div class="tx-center mg-b-20">
                        <span class="tx-30 tx-bold tx-inverse"><span class="tx-info">DR.</span> WOOF</span>
                    </div>
                    <img src="public/img/logo.png" class="wd-120 img-fluid" alt="Logo">
                </div>

                <div class="col-md-7 pd-md-l-40 bd-md-l bd-gray-300">
                    <h5 class="tx-inverse mg-b-20">Bienvenido/a</h5>
                    
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="icon ion-ios-email-outline tx-20 lh-0"></i></span>
                        <input type="email" name="correo" class="form-control" placeholder="Correo Electrónico" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="icon ion-ios-locked-outline tx-20 lh-0"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                      </div>
                    </div>

                    <div class="row row-xs mg-t-30">
                      <div class="col-sm-6">
                        <button type="submit" class="btn btn-info btn-block">Iniciar Sesión</button>
                      </div>
                      <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                        <button type="button" onclick="window.location.href='index.php?menu=sesion&opc=registro'" class="btn btn-outline-info btn-block">Crear Cuenta</button>
                      </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="mg-t-40 tx-center tx-12">DR. WOOF_JCR &copy; 2026. Todos los derechos reservados.</div>
      </div>
    </div>


    <!-- ===================== MODAL DE ERROR ===================== -->
    <div id="modalError" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
      <div style="background:#fff; border-radius:12px; width:400px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
        
        <!-- Cabecera -->
        <div style="background:#e74c3c; padding:20px 25px;">
          <h5 style="color:#fff; margin:0; font-size:16px; font-weight:700;">
            &#9888; Acceso Denegado
          </h5>
        </div>

        <!-- Cuerpo -->
        <div style="padding:30px 25px; text-align:center;">
          <div style="font-size:48px; color:#e74c3c; margin-bottom:15px;">&#128274;</div>
          <p style="font-size:15px; color:#555; margin:0;">
            El correo electrónico o la contraseña son <strong>incorrectos</strong>.<br>
            Por favor verifica tus datos e intenta de nuevo.
          </p>
        </div>

        <!-- Pie -->
        <div style="padding:15px 25px; text-align:center; border-top:1px solid #dee2e6;">
          <button onclick="cerrarModal()" style="background:#e74c3c; color:#fff; border:none; padding:8px 35px; border-radius:6px; font-size:14px; cursor:pointer;">
            Intentar de nuevo
          </button>
        </div>

      </div>
    </div>
    <!-- =========================================================== -->


    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>

    <script>
        function cerrarModal() {
            document.getElementById('modalError').style.display = 'none';
        }

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('error') === '1') {
            var modal = document.getElementById('modalError');
            modal.style.display = 'flex';
        }
    </script>

</body>
</html>