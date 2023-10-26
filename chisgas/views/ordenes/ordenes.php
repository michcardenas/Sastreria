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
<div class="p_centrar">
<div class="centrar">
  <form class="form card ff" action="../../controllers/clientesController.php" method="POST">
    <div class="card_header">
      <h1 class="form_heading">Crear o buscar cliente</h1>
    </div>
    <div class="field">
      <label for="nombre_cliente">Nombre</label>
      <input class="input" name="nombre_cliente" type="text" placeholder="nombre" id="nombre_cliente">
    </div>
    <div class="field">
      <label for="telefono_cliente">Telefono</label>
      <input class="input" name="telefono_cliente" type="number" placeholder="telefono" id="telefono_cliente">
    </div>
    <div class="field_boton">
      <button type="submit" name="action" value="crear" class="button spacing">Crear</button>
      <button name="action" value="buscar" class="button button-buscar spacing">Buscar</button>
    </div>
 
    </form>
    



</div>

</div>
<div id="resultados" >
  <!-- Aquí es donde se insertará la tabla generada por jQuery -->
</div>
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