<div class="br-mainpanel" style="background-color: #cdebf7 !important; min-height: 100vh;">
  <div class="br-pagebody" style="padding: 0 30px 30px 30px !important;">
    <div class="br-section-wrapper" style="background-color: #ffffff !important; border-radius: 0 0 40px 40px !important; padding: 60px 40px !important; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: none !important; min-height: 85vh; margin-top: 0 !important;">
      
      <h6 class="title-section-custom mg-b-40" style="color: #1e3a8a !important; font-weight: bold; text-transform: uppercase; text-align: center; font-size: 16px; letter-spacing: 0.5px;">
          Respaldo y Restauración de Base de Datos
      </h6>

      <div class="row justify-content-center gap-4" style="display: flex; flex-wrap: wrap; justify-content: center;">
          
          <div class="col-md-5 mg-b-20" style="flex: 1; max-width: 400px;">
              <div class="box-oval-container" style="background-color: #dcdcdc !important; color: #333333 !important; border-radius: 25px !important; padding: 30px !important; text-align: center; font-weight: bold;">
                  <i class="fa fa-download" style="font-size: 80px; color: #1e3a8a !important; display: block; margin-bottom: 15px;"></i>
                  <h5 class="mg-b-15" style="color: #1e3a8a !important; font-weight: bold;">Generar Respaldo</h5>
                  <p class="text-muted tx-13 mg-b-20" style="font-weight: normal; font-size: 13px; color: #666666 !important;">Descarga una copia completa de la base de datos actual (.sql) con todas las tablas del sistema.</p>
                  <button type="button" class="btn-custom-respaldar" id="btnRespaldar" style="background-color: #92bc5c !important; color: #ffffff !important; border: none !important; border-radius: 25px !important; padding: 12px 40px !important; font-size: 15px !important; font-weight: bold; cursor: pointer;">Respaldar BD</button>
              </div>
          </div>

          <div class="col-md-5 mg-b-20" style="flex: 1; max-width: 400px; margin-left: 20px;">
              <div class="box-oval-container" style="background-color: #dcdcdc !important; color: #333333 !important; border-radius: 25px !important; padding: 30px !important; text-align: center; font-weight: bold;">
                  <i class="fa fa-upload" style="font-size: 80px; color: #1e3a8a !important; display: block; margin-bottom: 15px;"></i>
                  <h5 class="mg-b-15" style="color: #1e3a8a !important; font-weight: bold;">Restaurar Sistema</h5>
                  <p class="text-muted tx-13 mg-b-20" style="font-weight: normal; font-size: 13px; color: #666666 !important;">Sube un archivo de respaldo previo (.sql) para restaurar la información de la base de datos.</p>
                  <div class="form-group" style="margin-bottom: 15px;">
                      <input type="file" id="archivo_sql" class="form-control-custom-file" accept=".sql" style="background-color: #ffffff !important; color: #333333 !important; border: 2px solid #34b5e5 !important; border-radius: 25px !important; padding: 8px 20px !important; font-weight: bold; font-size: 14px; width: 100%; max-width: 250px; text-align: center;">
                  </div>
                  <button type="button" class="btn-custom-restaurar" id="btnRestaurar" style="background-color: #1e3a8a !important; color: #ffffff !important; border: none !important; border-radius: 25px !important; padding: 12px 40px !important; font-size: 15px !important; font-weight: bold; cursor: pointer;">Restaurar BD</button>
              </div>
          </div>

      </div>

      <div class="mg-t-50 text-center" style="text-align: center; margin-top: 40px;">
        <button type="button" class="btn-custom-regresar" id="btnSalirMantenimiento" style="background-color: #34b5e5 !important; color: #ffffff !important; border: none !important; border-radius: 25px !important; padding: 12px 45px !important; font-size: 15px !important; font-weight: bold; cursor: pointer;">Regresar</button>
      </div>

    </div>
  </div>
</div>

<script>
    var btnRespaldar = document.getElementById("btnRespaldar");
    btnRespaldar.onclick = function() {
        if (confirm("¿Deseas descargar el respaldo de la base de datos?") == false) {
            return;
        }
        window.location.href = "views/bd/crudmantenimiento/procesar_respaldo.php";
    };

    var btnRestaurar = document.getElementById("btnRestaurar");
    btnRestaurar.onclick = function() {
        var archivoInput = document.getElementById("archivo_sql");
        if (archivoInput.value == "") {
            alert("Por favor, selecciona un archivo .sql válido.");
            return;
        }

        if (confirm("¡Atención! Restaurar la base de datos reemplazará los datos actuales. ¿Continuar?") == false) {
            return;
        }

        var ajax = new XMLHttpRequest();
        ajax.open("POST", "views/bd/crudmantenimiento/procesar_restauracion.php", true);

        var datos = new FormData();
        datos.append("respaldo", archivoInput.files[0]);

        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(ajax.responseText);
                alert(respuesta.message);
                if (respuesta.status == "success") {
                    window.location.reload();
                }
            }
        };

        ajax.send(datos);
    };

    var btnSalir = document.getElementById("btnSalirMantenimiento");
    btnSalir.onclick = function() {
        window.history.back();
    };
</script>