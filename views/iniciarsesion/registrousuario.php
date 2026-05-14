<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'views/bd/conexion.php';

$id_usuario = $_SESSION['id_usuario'] ?? 4;

$query = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result = mysqli_query($conexion, $query);
$usuario = mysqli_fetch_assoc($result);

$foto_db = $usuario['FotoUS'] ?? ''; 
$foto_perfil = (!empty($foto_db) && file_exists('public/img/' . $foto_db)) 
               ? $foto_db . '?v=' . time() 
               : 'logo.png'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Crear Cuenta</title>

    <link href="public/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/bracket.css">
    
    <style>
        .pswm-req { font-size: 11px; margin-top: 5px; color: #868e96; list-style: none; padding-left: 0; }
        .pswm-req li { display: inline-block; margin-right: 15px; }
        .pswm-req i { margin-right: 4px; font-size: 13px; }
        .req-valido { color: #23bf08 !important; font-weight: bold; }
    </style>
</head>

<body class="bg-br-primary">

    <div class="d-flex align-items-center justify-content-center ht-100v">
      <div class="login-wrapper wd-700 pd-25 pd-x-40 bg-white shadow-base bd-0">
        <div class="tx-center mg-b-30">
            <span class="tx-30 tx-bold tx-inverse"><span class="tx-info">DR.</span> WOOF</span>
            <p class="tx-12 mg-t-5">Crea tu cuenta para gestionar tus mascotas</p>
        </div>

        <form onsubmit="event.preventDefault(); enviarUsuario();" enctype="multipart/form-data">
            <div class="row row-xs">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-control-label">Nombre:</label>
                        <input id="u_nombre" type="text" class="form-control" placeholder="Nombre" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-control-label">Apellido Paterno:</label>
                        <input id="u_paterno" type="text" class="form-control" placeholder="Paterno" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-control-label">Apellido Materno:</label>
                        <input id="u_materno" type="text" class="form-control" placeholder="Materno" required>
                    </div>
                </div>

                <div class="col-sm-6 mg-t-10">
                    <div class="form-group">
                        <label class="form-control-label">Número de teléfono:</label>
                        <input id="u_telefono" type="text" class="form-control" placeholder="248 000 0000" required>
                    </div>
                </div>
                <div class="col-sm-6 mg-t-10">
                    <div class="form-group">
                        <label class="form-control-label">Dirección:</label>
                        <input id="u_direccion" type="text" class="form-control" placeholder="Calle, Número, Col." required>
                    </div>
                </div>

                <div class="col-sm-12 mg-t-10">
                    <div class="form-group">
                        <label class="form-control-label">Correo Electrónico:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="icon ion-ios-email-outline tx-20"></i></span>
                            <input id="u_correo" type="email" class="form-control" placeholder="ejemplo@correo.com" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|net|org|edu|gob|mx|info|biz)" title="El correo debe terminar con una extensión válida como .com, .mx, .net, etc." required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 mg-t-10">
                    <div class="form-group">
                        <label class="form-control-label">Contraseña:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="icon ion-ios-locked-outline tx-20"></i></span>
                            <input id="u_password" type="password" class="form-control" placeholder="********" required>
                        </div>
                        <ul class="pswm-req">
                            <li id="req_longitud"><i class="icon ion-ios-circle-outline"></i> Mínimo 8 dígitos</li>
                            <li id="req_numero"><i class="icon ion-ios-circle-outline"></i> Un número</li>
                            <li id="req_especial"><i class="icon ion-ios-circle-outline"></i> Un carácter especial</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="row row-xs mg-t-30">
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-info btn-block">Crear Cuenta</button>
                </div>
                <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <button type="button" class="btn btn-outline-primary btn-block" onclick="document.getElementById('u_foto').click();">
                        <i class="fa fa-camera mg-r-5"></i> <span id="txt_foto">Foto</span>
                    </button>
                    <input type="file" id="u_foto" name="foto" accept="image/*" style="display: none;" onchange="actualizarBotonFoto(this)">
                </div>
                <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <a href="index.php?menu=sesion&opc=index" class="btn btn-secondary btn-block">Cancelar</a>
                </div>
            </div>

            <div class="mg-t-40 tx-center tx-12">DR. WOOF_JCR &copy; 2026.</div>
        </form>
      </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>

    <script>
        const pswInput = document.getElementById('u_password');
        const reqLongitud = document.getElementById('req_longitud');
        const reqNumero = document.getElementById('req_numero');
        const reqEspecial = document.getElementById('req_especial');

        pswInput.addEventListener('input', function() {
            const valor = pswInput.value;

            if (valor.length >= 8) {
                reqLongitud.classList.add('req-valido');
                reqLongitud.querySelector('i').className = 'icon ion-ios-checkmark';
            } else {
                reqLongitud.classList.remove('req-valido');
                reqLongitud.querySelector('i').className = 'icon ion-ios-circle-outline';
            }

            if (/[0-9]/.test(valor)) {
                reqNumero.classList.add('req-valido');
                reqNumero.querySelector('i').className = 'icon ion-ios-checkmark';
            } else {
                reqNumero.classList.remove('req-valido');
                reqNumero.querySelector('i').className = 'icon ion-ios-circle-outline';
            }

            if (/[!@#$%^&*(),.?":{}|<>_+\-\[\]\\/]/.test(valor)) {
                reqEspecial.classList.add('req-valido');
                reqEspecial.querySelector('i').className = 'icon ion-ios-checkmark';
            } else {
                reqEspecial.classList.remove('req-valido');
                reqEspecial.querySelector('i').className = 'icon ion-ios-circle-outline';
            }
        });

        function actualizarBotonFoto(input) {
            const txtFoto = document.getElementById('txt_foto');
            if (input.files && input.files[0]) {
                txtFoto.textContent = "¡Foto cargada!";
            } else {
                txtFoto.textContent = "Foto";
            }
        }

        function enviarUsuario() {
            const passwordVal = pswInput.value;
            const correoVal = document.getElementById('u_correo').value;

            const tieneLongitud = passwordVal.length >= 8;
            const tieneNumero = /[0-9]/.test(passwordVal);
            const tieneEspecial = /[!@#$%^&*(),.?":{}|<>_+\-\[\]\\/]/.test(passwordVal);

            if (!tieneLongitud || !tieneNumero || !tieneEspecial) {
                alert("Por favor, cumple con todos los requisitos de la contraseña.");
                return;
            }

            const regexCorreo = /\.(com|net|org|edu|gob|mx|info|biz)$/i;
            if (!regexCorreo.test(correoVal)) {
                alert("El correo electrónico debe terminar con una extensión válida (ej: .com, .mx)");
                return;
            }

            const formData = new FormData();
            formData.append('nombre', document.getElementById('u_nombre').value);
            formData.append('paterno', document.getElementById('u_paterno').value);
            formData.append('materno', document.getElementById('u_materno').value);
            formData.append('telefono', document.getElementById('u_telefono').value);
            formData.append('direccion', document.getElementById('u_direccion').value);
            formData.append('correo', correoVal);
            formData.append('password', passwordVal);

            const fotoInput = document.getElementById('u_foto');
            if (fotoInput.files && fotoInput.files.length > 0) {
                formData.append('foto', fotoInput.files[0]);
            }

            fetch('views/bd/crudusuarios/guardar_usuario.php', {
                method: 'POST',
                body: formData
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Error HTTP: ' + res.status);
                }
                return res.text();
            })
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if(data.status === 'success') {
                        alert(data.message);
                        window.location.href = 'index.php?menu=sesion&opc=index';
                    } else {
                        alert("Error del servidor: " + data.message);
                    }
                } catch (e) {
                    alert("Respuesta inesperada del servidor: " + text);
                }
            })
            .catch(err => {
                console.error("Error:", err);
                alert("Hubo un error de red al procesar el registro.");
            });
        }
    </script>
</body>
</html>