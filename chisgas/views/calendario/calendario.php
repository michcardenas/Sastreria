<?php
// Iniciar la sesión
session_start();

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: login/login.php");
    exit();
}

$ruta = '../template.php';

if (file_exists($ruta)) {
    $ruta_css = '../css/style.css';
    $ruta_icon = '../img/aguja.png';
    $ruta_image_menu = '../menu.php';
    $ruta_image = "../img/chisgas_fondo_blanco.png";

    include $ruta;
} else {
    echo "El archivo $ruta no existe.";
}


?>
<form id="hiddenForm" action="calendario_vista.php" method="POST" style="display: none;">
    <input type="hidden" name="calendarioData" id="calendarioDataInput">
    <input type="submit" id="hiddenSubmit">
</form>

<script>
    const calendarioData = JSON.parse(sessionStorage.getItem('calendarioData'));
    if (calendarioData) {
        // Asigna los datos al input oculto
        document.getElementById('calendarioDataInput').value = JSON.stringify(calendarioData);

        // Envía el formulario
        document.getElementById('hiddenForm').submit();
    }
</script>

<?php 
$ruta_footer = '../footer.php';

if (file_exists($ruta)) {
    $ruta_css = '../css/style.css';
    $ruta_image = "../img/chisgas_fondo_blanco.png";
    $ruta_js = "../js/main.js";

    include $ruta_footer;
} else {
    echo "El archivo $ruta no existe.";
}

?>