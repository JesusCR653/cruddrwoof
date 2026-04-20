function renderizarMenuPerros() {
    const contenedor = document.getElementById('listaPerrosDinamica');
    if (!contenedor) return;

    // Estos son los perros del dueño (Axel)
    const perros = JSON.parse(localStorage.getItem('pacientes_DRWOOF')) || [];
    let html = '';

    perros.forEach(perro => {
        html += `
        <a href="#" class="br-menu-link with-sub">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-paw tx-22"></i>
            <span class="menu-item-label">${perro.nombre}</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div>
        </a>
        <ul class="br-menu-sub nav flex-column">
          <li class="nav-item"><a href="perro-info.html?nombre=${perro.nombre}" class="nav-link">Información canina</a></li>
          <li class="nav-item"><a href="historial-medico.html?nombre=${perro.nombre}" class="nav-link">Historial médico</a></li>
          <li class="nav-item"><a href="generar-qr.html?nombre=${perro.nombre}" class="nav-link">Generar QR</a></li>
          <li class="nav-item"><a href="galeria.html?nombre=${perro.nombre}" class="nav-link">Galería de fotos</a></li>
        </ul>`;
    });
    contenedor.innerHTML = html;

    $('.with-sub').off('click').on('click', function(e){
        e.preventDefault();
        $(this).next().slideToggle();
        $(this).toggleClass('show-sub');
    });
}

$(document).ready(function() {
    renderizarMenuPerros();
});