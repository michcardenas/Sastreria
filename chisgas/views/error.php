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
    $ruta_css = 'css/style.css';
d    $ruta_image = "img/chisgas_fondo_blanco.png";
    include $ruta;
} else {
    echo "El archivo $ruta no existe.";
}

$error = isset($_REQUEST['error']) ? $_REQUEST['error'] : null;

?>
<div class="p_centrar">
<div class="centrar">
<h1 class="form_heading"><?php echo $error; ?> </h1>
<button class="button" onclick="goBack()">Atras</button>
</div>
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