<?php
// Iniciar la sesión
session_start();

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: login/login.php");
    exit();
}

$ruta = 'template.php';

if (file_exists($ruta)) {
    include $ruta;
} else {
    echo "El archivo $ruta no existe.";
}

?>
<div class="centrar_botones_menu">
<button class="button2">
    Ordenes
    <img src="img/factura.png" alt="Icono de Ordenes" class="button-image">
</button>

<button class="button2">
    Calendario
    <img src="img/calendario.png" alt="Icono de Ordenes" class="button-image">

</button>
<button class="button2">
    caja
    <img src="img/cajero-automatico.png" alt="Icono de Ordenes" class="button-image">

</button>
</div>