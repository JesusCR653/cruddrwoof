<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Crear Cuenta</title>

    <link href="public/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/bracket.css">
</head>

<body class="bg-br-primary">

    <div class="d-flex align-items-center justify-content-center ht-100v">
      <div class="login-wrapper wd-700 pd-25 pd-x-40 bg-white shadow-base bd-0">
        <div class="tx-center mg-b-30">
            <span class="tx-30 tx-bold tx-inverse"><span class="tx-info">DR.</span> WOOF</span>
            <p class="tx-12 mg-t-5">Crea tu cuenta para gestionar tus mascotas</p>
        </div>

        <div class="row row-xs">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-control-label">Nombre:</label>
                    <input id="u_nombre" type="text" class="form-control" placeholder="Nombre">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-control-label">Apellido Paterno:</label>
                    <input id="u_paterno" type="text" class="form-control" placeholder="Paterno">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-control-label">Apellido Materno:</label>
                    <input id="u_materno" type="text" class="form-control" placeholder="Materno">
                </div>
            </div>

            <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                <div class="form-group">
                    <label class="form-control-label">Número de teléfono:</label>
                    <input id="u_telefono" type="text" class="form-control" placeholder="248 000 0000">
                </div>
            </div>
            <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                <div class="form-group">
                    <label class="form-control-label">Dirección:</label>
                    <input id="u_direccion" type="text" class="form-control" placeholder="Calle, Número, Col.">
                </div>
            </div>

            <div class="col-sm-12 mg-t-10">
                <div class="form-group">
                    <label class="form-control-label">Correo Electrónico:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon ion-ios-email-outline tx-20"></i></span>
                        <input id="u_correo" type="email" class="form-control" placeholder="ejemplo@correo.com">
                    </div>
                </div>
            </div>

            <div class="col-sm-12 mg-t-10">
                <div class="form-group">
                    <label class="form-control-label">Contraseña:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon ion-ios-locked-outline tx-20"></i></span>
                        <input id="u_password" type="password" class="form-control" placeholder="********">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row row-xs mg-t-30">
            <div class="col-sm-4">
                <button onclick="enviarUsuario()" class="btn btn-info btn-block">Crear Cuenta</button>
            </div>
            <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                <button class="btn btn-outline-primary btn-block"><i class="fa fa-camera mg-r-5"></i> Foto</button>
            </div>
            <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                <a href="?menu=sesion&opc=index" class="btn btn-secondary btn-block">Cancelar</a>
            </div>
        </div>

        <div class="mg-t-40 tx-center tx-12">DR. WOOF_JCR &copy; 2026.</div>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>

    <script>
        function enviarUsuario() {
            const formData = new FormData();
            formData.append('nombre', document.getElementById('u_nombre').value);
            formData.append('paterno', document.getElementById('u_paterno').value);
            formData.append('materno', document.getElementById('u_materno').value);
            formData.append('telefono', document.getElementById('u_telefono').value);
            formData.append('direccion', document.getElementById('u_direccion').value);
            formData.append('correo', document.getElementById('u_correo').value);
            formData.append('password', document.getElementById('u_password').value);

            fetch('guardar_usuario.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    alert(data.message);
                    window.location.href = 'signin-simple.html';
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert("Error de conexión al crear la cuenta.");
            });
        }
    </script>
</body>
</html>