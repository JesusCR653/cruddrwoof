<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once 'views/bd/conexion.php';

if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
} else {
    $id_usuario = 4;
}

$query = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$result = mysqli_query($conexion, $query);
$usuario = mysqli_fetch_assoc($result);

$foto_db = $usuario['FotoUS']; 
if ($foto_db != "" && file_exists('public/img/' . $foto_db)) {
    $foto_perfil = $foto_db . '?v=' . time();
} else {
    $foto_perfil = 'logo.png';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DR. WOOF - Crear Cuenta</title>

    <link href="public/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link class="rtl-prevent" rel="stylesheet" href="public/css/bracket.css">
    
    <style>
        .br-header { background-color: #1e3a8a !important; border: none !important; }
        
        body {
            background-color: #cdebf7 !important;
            min-height: 100vh;
        }

        .br-section-wrapper {
            background-color: #ffffff !important;
            border-radius: 40px !important;
            padding: 50px 40px !important;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
            width: 100%;
            max-width: 950px;
            margin: 40px auto;
        }

        .title-display-center {
            font-family: 'Arial Black', Gadget, sans-serif;
            font-size: 38px;
            font-weight: 900;
            color: #1e3a8a !important;
            text-align: center;
            letter-spacing: 1px;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }
        .form-control-custom {
            background-color: #dcdcdc !important;
            color: #333333 !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 25px !important;
            font-size: 16px !important;
            font-weight: bold;
            height: auto !important;
            text-align: center;
        }
        .form-control-custom::placeholder {
            color: #444444;
            opacity: 1;
        }
        .form-control-custom:focus {
            background-color: #cfcfcf !important;
            outline: none;
        }

        .input-file-hidden {
            display: none;
        }

        .pswm-req {
            font-size: 12px;
            margin-top: 10px;
            color: #666666;
            list-style: none;
            padding-left: 0;
            text-align: center;
        }
        .pswm-req li {
            display: inline-block;
            margin: 0 10px;
        }
        .pswm-req i {
            margin-right: 4px;
        }
        .req-valido {
            color: #92bc5c !important;
            font-weight: bold;
        }

        .btn-custom-registrar {
            background-color: #92bc5c !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 40px !important;
            font-size: 16px !important;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-custom-foto {
            background-color: #1e3a8a !important;
            color: white !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 30px !important;
            font-size: 16px !important;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-width: 180px;
            cursor: pointer;
        }
        .btn-custom-cancelar {
            background-color: #34b5e5 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 40px !important;
            font-size: 16px !important;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="d-flex align-items-center justify-content-center p-3" style="min-height: 100vh;">
        <div class="br-section-wrapper">
        
            <div class="title-display-center">DR. WOOF</div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger text-center mx-auto mg-b-30" style="max-width: 750px; border-radius: 20px; font-weight: bold;">
                    <i class="fa fa-times mg-r-5"></i> 
                    <?php 
                        $error = $_GET['error'];
                        if ($error == 'campos') echo "Por favor, completa todos los campos obligatorios.";
                        elseif ($error == 'tipo_imagen') echo "Formato de imagen inválido. Solo se admiten JPG, PNG, GIF y WEBP.";
                        elseif ($error == 'tamano_imagen') echo "La imagen es demasiado grande. No debe superar los 3 MB.";
                        elseif ($error == 'imagen') echo "No se pudo guardar la imagen en el servidor.";
                        elseif ($error == 'db') echo "Error al registrar el usuario. Intenta de nuevo.";
                        elseif ($error == 'consulta') echo "Error en la consulta a la base de datos.";
                        elseif ($error == 'conexion') echo "No se pudo conectar con la base de datos.";
                        else echo "Ocurrió un error al procesar el registro. Inténtalo de nuevo.";
                    ?>
                </div>
            <?php endif; ?>

            <form action="controllers/crudusuarios/guardar_usuario.php" method="POST" enctype="multipart/form-data" onsubmit="return validarAntesDeEnviar();">
                
                <div class="row justify-content-center">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <input name="nombre" id="u_nombre" type="text" class="form-control form-control-custom" placeholder="Nombre" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input name="paterno" id="u_paterno" type="text" class="form-control form-control-custom" placeholder="Apellido Paterno" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input name="materno" id="u_materno" type="text" class="form-control form-control-custom" placeholder="Apellido Materno" required>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <input name="telefono" id="u_telefono" type="text" class="form-control form-control-custom" placeholder="Número de teléfono" >
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <input name="direccion" id="u_direccion" type="text" class="form-control form-control-custom" placeholder="Dirección" >
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="form-group">
                            <input name="correo" id="u_correo" type="email" class="form-control form-control-custom" placeholder="Correo Electrónico" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|net|org|edu|gob|mx|info|biz)" title="La extensión debe ser válida (ej: .com, .mx)" required>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="form-group">
                            <input name="password" id="u_password" type="password" class="form-control form-control-custom" placeholder="Contraseña" required>
                            <ul class="pswm-req">
                                <li id="req_longitud"><i id="ico_longitud" class="icon ion-ios-circle-outline"></i> Mínimo 8 dígitos</li>
                                <li id="req_numero"><i id="ico_numero" class="icon ion-ios-circle-outline"></i> Un número</li>
                                <li id="req_especial"><i id="ico_especial" class="icon ion-ios-circle-outline"></i> Un carácter especial</li>
                            </ul>
                        </div>
                    </div>

                </div>
                
                <div class="d-flex align-items-center justify-content-center mg-t-30 gap-4 flex-wrap">
                    
                    <div>
                        <button type="submit" class="btn-custom-registrar">Crear Cuenta</button>
                    </div>

                    <div>
                        <label for="u_foto" class="btn-custom-foto m-0">
                            <span id="txt_foto">Agregar foto</span> <span class="tx-20 font-weight-normal">+</span>
                        </label>
                        <input type="file" id="u_foto" name="foto" accept="image/*" class="input-file-hidden" onchange="actualizarBotonFoto()">
                    </div>

                    <div>
                        <a href="index.php?menu=sesion&opc=index" class="btn btn-custom-cancelar text-center">Cancelar</a>
                    </div>

                </div>

                <div class="mg-t-50 tx-center tx-12 text-muted">DR. WOOF &copy; 2026.</div>
            </form>
        </div>
    </div>

    <script src="public/lib/jquery/jquery.js"></script>
    <script src="public/lib/bootstrap/bootstrap.js"></script>

    <script>
        var pswInput = document.getElementById('u_password');
        
        pswInput.oninput = function() {
            var valor = pswInput.value;

            if (valor.length >= 8) {
                document.getElementById('req_longitud').className = 'req-valido';
                document.getElementById('ico_longitud').className = 'icon ion-ios-checkmark';
            } else {
                document.getElementById('req_longitud').className = '';
                document.getElementById('ico_longitud').className = 'icon ion-ios-circle-outline';
            }

            var tieneNumero = false;
            var numeros = "0123456789";
            for (var i = 0; i < valor.length; i++) {
                if (numeros.indexOf(valor.charAt(i)) !== -1) {
                    tieneNumero = true;
                    break;
                }
            }

            if (tieneNumero) {
                document.getElementById('req_numero').className = 'req-valido';
                document.getElementById('ico_numero').className = 'icon ion-ios-checkmark';
            } else {
                document.getElementById('req_numero').className = '';
                document.getElementById('ico_numero').className = 'icon ion-ios-circle-outline';
            }

            var caracteresEspeciales = "!@#$%^&*(),.?\":{}|<>_+-[]\\/";
            var tieneEspecial = false;
            for (var j = 0; j < valor.length; j++) {
                if (caracteresEspeciales.indexOf(valor.charAt(j)) !== -1) {
                    tieneEspecial = true;
                    break;
                }
            }

            if (tieneEspecial) {
                document.getElementById('req_especial').className = 'req-valido';
                document.getElementById('ico_especial').className = 'icon ion-ios-checkmark';
            } else {
                document.getElementById('req_especial').className = '';
                document.getElementById('ico_especial').className = 'icon ion-ios-circle-outline';
            }
        };

        function actualizarBotonFoto() {
            var archivo = document.getElementById('u_foto');
            var txtFoto = document.getElementById('txt_foto');
            if (archivo.value !== "") {
                txtFoto.innerHTML = "¡Foto cargada!";
            } else {
                txtFoto.innerHTML = "Agregar foto";
            }
        }

        function validarAntesDeEnviar() {
            var valorPassword = pswInput.value;
            var valorCorreo = document.getElementById('u_correo').value;

            var tieneLongitud = valorPassword.length >= 8;

            var tieneNumero = false;
            var numeros = "0123456789";
            for (var i = 0; i < valorPassword.length; i++) {
                if (numeros.indexOf(valorPassword.charAt(i)) !== -1) {
                    tieneNumero = true;
                    break;
                }
            }

            var caracteresEspeciales = "!@#$%^&*(),.?\":{}|<>_+-[]\\/";
            var tieneEspecial = false;
            for (var j = 0; j < valorPassword.length; j++) {
                if (caracteresEspeciales.indexOf(valorPassword.charAt(j)) !== -1) {
                    tieneEspecial = true;
                    break;
                }
            }

            if (tieneLongitud == false || tieneNumero == false || tieneEspecial == false) {
                alert("Por favor, cumple con todos los requisitos de la contraseña.");
                return false;
            }

            var extensionesValidas = [".com", ".net", ".org", ".edu", ".gob", ".mx", ".info", ".biz"];
            var correoValido = false;
            for (var k = 0; k < extensionesValidas.length; k++) {
                if (valorCorreo.toLowerCase().endsWith(extensionesValidas[k])) {
                    correoValido = true;
                    break;
                }
            }

            if (correoValido == false) {
                alert("El correo electrónico debe terminar con una extensión válida (ej: .com, .mx)");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>