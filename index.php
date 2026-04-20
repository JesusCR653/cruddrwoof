<?php
$menu = $_GET['menu'] ?? 'bienvenida';
$opc = $_GET['opc'] ?? 'index';

if ($menu == 'bienvenida') {
    include 'views/bienvenida.php';
} elseif ($menu == 'sesion') {
    if ($opc == 'index') {
        include 'views/iniciarsesion/iniciarsesion.php';
    } elseif ($opc == 'registro') {
        include 'views/iniciarsesion/registrousuario.php';
    }

} elseif ($menu == 'panel') {
    if ($opc == 'bienvenida') {
        include 'views/panel/bienvenida/index.php';
    }

} elseif ($menu == 'mascotas') {
    if ($opc == 'registro') {
        include 'views/mascotas/registro-canino.php';
    } 

    elseif ($opc == 'info') {
        include 'views/mascotas/perro-info.php';
    } elseif ($opc == 'qr') {
        include 'views/mascotas/generar-qr.php';
    } elseif ($opc == 'galeria') { 
        include 'views/mascotas/galeria-manchas.php';
    }

    elseif ($opc == 'huesos-info') {
        include 'views/mascotas/huesos-info.php';
    } elseif ($opc == 'huesos-qr') {
        include 'views/mascotas/huesos-qr.php';
    } elseif ($opc == 'huesos-galeria') { 
        include 'views/mascotas/huesos-galeria.php';
    }

} elseif ($menu == 'servicios') {
    if ($opc == 'historial') {
        include 'views/servicios/historial-manchas.php';
    } elseif ($opc == 'agendam') {
        include 'views/servicios/citas-manchas.php';
    }
    elseif ($opc == 'huesos-historial') {
        include 'views/servicios/huesos-historial.php';
    } elseif ($opc == 'huesos-agenda') {
        include 'views/servicios/huesos-citas.php';
    } 
    elseif ($opc == 'agendag') {
        include 'views/servicios/agenda.php';
    } elseif ($opc == 'recordatorios') {
        include 'views/servicios/recordatorios.php';
    } elseif ($opc == 'comentarios') {
        include 'views/servicios/comentarios.php';
    } elseif ($opc == 'histom') {
        include 'views/servicios/historial-completo-manchas.php'; 
    } elseif ($opc == 'histoh') {
        include 'views/servicios/huesos-historial-completo.php'; 
    }

} elseif ($menu == 'personal') {
    if ($opc == 'perfil') {
        include 'views/informacionpersonal/perfil.php';
    }
} elseif ($menu == 'per') {
    if ($opc == 'perfil') {
        include 'views/informacionpersonal/perfil.php';
    } elseif ($menu == 'per'){
        include 'views/bienvenida.php';
    }
} 
?>