<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$menu = "bienvenida";
if (isset($_GET['menu'])) {
    $menu = $_GET['menu'];
}

$opc = "index";
if (isset($_GET['opc'])) {
    $opc = $_GET['opc'];
}

$paginas_publicas = array('bienvenida', 'sesion');

$es_publica = false;
for ($i = 0; $i < count($paginas_publicas); $i++) {
    if ($menu == $paginas_publicas[$i]) {
        $es_publica = true;
        break;
    }
}

if ($es_publica == false && isset($_SESSION['id_usuario']) == false) {
    header("Location: index.php?menu=sesion&opc=index");
    exit();
}

if ($menu == 'bienvenida') {
    include 'views/bienvenida.php';

} else if ($menu == 'sesion') {
    if ($opc == 'index') {
        include 'views/iniciarsesion/iniciarsesion.php';
    } else if ($opc == 'registro') {
        include 'views/iniciarsesion/registrousuario.php';
    } else if ($opc == 'validar') {
        include 'views/iniciarsesion/validar_sesion.php';
    } else if ($opc == 'cerrar') {
        session_destroy();
        header("Location: index.php?menu=bienvenida");
        exit();
    }

} else if ($menu == 'panel') {
    if ($opc == 'bienvenida') {
        include 'views/panel/bienvenida/index.php';
    }

} else if ($menu == 'mascotas') {
    if ($opc == 'registro') {
        include 'views/mascotas/registro-canino.php';
    } else if ($opc == 'info') {
        include 'views/mascotas/perro-info.php';
    } else if ($opc == 'qr') {
        include 'views/mascotas/generar-qr.php';
    } else if ($opc == 'galeria') {
        include 'views/mascotas/galeria-manchas.php';
    } else if ($opc == 'listado') {
        include 'views/mascotas/listado_mascotas.php';
    } else if ($opc == 'cartillamanchas') {
        include 'views/mascotas/cartilla-manchas.php';
    } else if ($opc == 'guardar') {
        include 'views/bd/crudmascotas/guardar.php';
    } else if ($opc == 'editar') {
        include 'views/bd/crudmascotas/editar.php';
    } else if ($opc == 'eliminar') {
        include 'views/bd/crudmascotas/eliminar.php';
    } else if ($opc == 'subir-galeria') {
        include 'views/bd/crudgaleria/guardarfoto.php';
    } else if ($opc == 'editar-foto') {
        include 'views/bd/crudgaleria/editarfoto.php';
    } else if ($opc == 'eliminar-foto') {
        include 'views/bd/crudgaleria/eliminarfoto.php';
    }

} else if ($menu == 'servicios') {
    if ($opc == 'historial') {
        include 'views/servicios/historial-manchas.php';
    } else if ($opc == 'agendam') {
        include 'views/servicios/citas-manchas.php';
    } else if ($opc == 'agendag') {
        include 'views/servicios/agenda.php';
    } else if ($opc == 'histom') {
        include 'views/servicios/historial-completo-manchas.php';
    } else if ($opc == 'listado_citas') {
        include 'views/servicios/listado_citas.php';
    } else if ($opc == 'recordatorios') {
        include 'views/servicios/recordatorios.php';
    } else if ($opc == 'listarecordatorios') {
        include 'views/servicios/lista-recordatorios.php';
    } else if ($opc == 'comentarios') {
        include 'views/servicios/comentarios.php';
    } else if ($opc == 'mis-comentarios') {
        include 'views/servicios/lista-comentarios.php';
    } else if ($opc == 'guardar-cita') {
        include 'views/bd/crudcitas/guardarcita.php';
    } else if ($opc == 'editar-cita') {
        include 'views/bd/crudcitas/editarcita.php';
    } else if ($opc == 'eliminar-cita') {
        include 'views/bd/crudcitas/eliminarcita.php';
    } else if ($opc == 'mantenimiento') {
        include 'views/mantenimiento/respaldo.php';
    }

} else if ($menu == 'personal') {
    if ($opc == 'perfil') {
        include 'views/informacionpersonal/perfil.php';
    } else if ($opc == 'editar-perfil') {
        include 'views/informacionpersonal/editar-perfil.php';
    } else if ($opc == 'actualizar') {
        include 'views/bd/crudusuarios/actualizar_usuario.php';
    } else if ($opc == 'eliminar') {
        include 'views/bd/crudusuarios/eliminar_usuario.php';
    }
}
?>