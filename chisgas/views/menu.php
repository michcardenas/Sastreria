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
    $ruta_css = '../views/css/style.css';
    $ruta_icon = '../views/img/aguja.png';
    $ruta_cerrar_sesion ='login/cerrar_sesion.php';
    $ruta_image_menu ='';
    $ruta_image = "img/chisgas_fondo_blanco.png";
    include $ruta;
} else {
    echo "El archivo $ruta no existe.";
}

?>
<div class="centrar_botones_menu">
<a href="ordenes/ordenes.php"><button class="button2">
    Ordenes
    <img src="img/factura.png" alt="Icono de Ordenes" class="button-image">
</button></a>

<a id='calendario'><button class="button2">
    Calendario
    <img src="img/calendario.png" alt="Icono de Ordenes" class="button-image">

</button></a>
<button class="button2">
    caja
    <img src="img/cajero-automatico.png" alt="Icono de Ordenes" class="button-image">

</button>
</div>
<?php 
$ruta_footer = 'footer.php';

if (file_exists($ruta)) {
   
    $ruta_js = "js/main.js";

    include $ruta_footer;
} else {
    echo "El archivo $ruta no existe.";
}

?>