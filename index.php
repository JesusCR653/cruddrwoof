<?php
session_start();

$menu = $_GET['menu'] ?? 'bienvenida';
$opc  = $_GET['opc']  ?? 'index';

$paginas_publicas = ['bienvenida', 'sesion'];

if (!in_array($menu, $paginas_publicas) && !isset($_SESSION['id_usuario'])) {
    header("Location: index.php?menu=sesion&opc=index");
    exit();
}

if ($menu == 'bienvenida') {
    include 'views/bienvenida.php';

} elseif ($menu == 'sesion') {
    if ($opc == 'index') {
        include 'views/iniciarsesion/iniciarsesion.php';
    } elseif ($opc == 'registro') {
        include 'views/iniciarsesion/registrousuario.php';
    } elseif ($opc == 'validar') {
        include 'views/iniciarsesion/validar_sesion.php';
    } elseif ($opc == 'cerrar') {
        session_destroy();
        header("Location: index.php?menu=bienvenida");
        exit();
    }

} elseif ($menu == 'panel') {
    if ($opc == 'bienvenida') {
        include 'views/panel/bienvenida/index.php';
    }

} elseif ($menu == 'mascotas') {
    if ($opc == 'registro') {
        include 'views/mascotas/registro-canino.php';
    } elseif ($opc == 'info') {
        include 'views/mascotas/perro-info.php';
    } elseif ($opc == 'qr') {
        include 'views/mascotas/generar-qr.php';
    } elseif ($opc == 'galeria') {
        include 'views/mascotas/galeria-manchas.php';
    } elseif ($opc == 'listado') {
        include 'views/mascotas/listado_mascotas.php';
    } elseif ($opc == 'cartillamanchas') {
        include 'views/mascotas/cartilla-manchas.php';
    } elseif ($opc == 'guardar') {
        include 'views/bd/crudmascotas/guardar.php';
    } elseif ($opc == 'editar') {
        include 'views/bd/crudmascotas/editar.php';
    } elseif ($opc == 'eliminar') {
        include 'views/bd/crudmascotas/eliminar.php';
    } elseif ($opc == 'subir-galeria') {
        include 'views/bd/crudgaleria/guardarfoto.php';
    } elseif ($opc == 'editar-foto') {
        include 'views/bd/crudgaleria/editarfoto.php';
    } elseif ($opc == 'eliminar-foto') {
        include 'views/bd/crudgaleria/eliminarfoto.php';
    }
    

} elseif ($menu == 'servicios') {
    if ($opc == 'historial') {
        include 'views/servicios/historial-manchas.php';
    } elseif ($opc == 'agendam') {
        include 'views/servicios/citas-manchas.php';
    } elseif ($opc == 'agendag') {
        include 'views/servicios/agenda.php';
    }elseif ($opc == 'histom') {
        include 'views/servicios/historial-completo-manchas.php';
    } elseif ($opc == 'listado_citas') {
        include 'views/servicios/listado_citas.php';
    } elseif ($opc == 'recordatorios') {
        include 'views/servicios/recordatorios.php';
    } elseif ($opc == 'listarecordatorios') {
        include 'views/servicios/lista-recordatorios.php';
    } elseif ($opc == 'comentarios') {
        include 'views/servicios/comentarios.php';
    } elseif ($opc == 'mis-comentarios') {
        include 'views/servicios/lista-comentarios.php';
    } elseif ($opc == 'guardar-cita') {
        include 'views/bd/crudcitas/guardarcita.php';
    } elseif ($opc == 'editar-cita') {
        include 'views/bd/crudcitas/editarcita.php';
    } elseif ($opc == 'eliminar-cita') {
        include 'views/bd/crudcitas/eliminarcita.php';
    }


} elseif ($menu == 'personal') {
    if ($opc == 'perfil') {
        include 'views/informacionpersonal/perfil.php';
    } elseif ($opc == 'editar-perfil') {
        include 'views/informacionpersonal/editar-perfil.php';
    } elseif ($opc == 'actualizar') {
        include 'views/bd/crudusuarios/actualizar_usuario.php';
    } elseif ($opc == 'eliminar') {
        include 'views/bd/crudusuarios/eliminar_usuario.php';
    }
}
?>