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
        
<form action="index.php?menu=panel&opc=bienvenida" method="POST">
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

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger" role="alert" style="padding: 5px 10px; font-size: 12px; margin-bottom: 15px;">
                            Correo o contraseña incorrectos.
                        </div>
                    <?php endif; ?>

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

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/popper.js/popper.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>

</body>
</html>