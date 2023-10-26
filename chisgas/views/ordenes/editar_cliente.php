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
    $ruta_image_menu = '';

    $ruta_image = "../img/chisgas_fondo_blanco.png";

    include $ruta;
} else {
    echo "El archivo $ruta no existe.";
}
?>

<div class="p_centrar">

<div class="centrar">

  <form class="form card" >
    <div class="card_header">
      <h1 class="form_heading">Edita aqui tu cliente</h1>
      <input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">

    </div>
    <div class="field">
      <label for="nombre_cliente">Nombre</label>
      <input class="input" name="nombre_cliente" type="text" placeholder="nombre" id="nombre_cliente" value="<?php echo isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : ''; ?>">
    </div>
    <div class="field">
      <label for="telefono_cliente">Telefono</label>
      <input class="input" name="telefono_cliente" type="number" placeholder="telefono" id="telefono_cliente" value="<?php echo isset($_GET['telefono']) ? htmlspecialchars($_GET['telefono']) : ''; ?>">
    </div>
   
  </form>
  <h1 class="form_heading" id="resultado_editar"></h1>

  <div class="card field_boton_editar">
  <h1 class="form_heading">¿Que deseas hacer?</h1>
      <button value="editar" id="editar"  class="button">Editar</button>
      <button value="borrar" id="borrar"  class="button borrar">Borrar</button>
      
      <button  onclick="goBack()"  class="button atras">Atras</button>

    </div>
</div>
</div>
<?php 
$ruta_footer = '../footer.php';

if (file_exists($ruta)) {
   
    $ruta_js = "../js/main.js";

    include $ruta_footer;
} else {
    echo "El archivo $ruta no existe.";
}

?>