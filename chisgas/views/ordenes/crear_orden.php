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
    $ruta_image_menu = "../menu.php";

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
      <h1 class="form_heading">Detalle cliente</h1>
      <input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">

    </div>
    <div class="field">
      <label for="nombre_cliente">Nombre</label>
      <input class="input" readonly name="nombre_cliente" type="text" placeholder="nombre" id="nombre_cliente" value="<?php echo isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : ''; ?>">
    </div>
    <div class="field">
      <label for="telefono_cliente">Telefono</label>
      <input class="input" readonly name="telefono_cliente" type="number" placeholder="telefono" id="telefono_cliente" value="<?php echo isset($_GET['telefono']) ? htmlspecialchars($_GET['telefono']) : ''; ?>">
    </div>

    <div class="content_loader"><div class="loader"></div></div>
    <h1 class="form_heading" id="resultado_editar"></h1>

  </form>

  <form class="form card_2" >

    <div class="card_header">
   
      <h1 class="form_heading">Crear orden de Arreglo</h1>

    </div>
    <div class="field flex">
  <label for="nombre_cliente_select">Prenda</label>
  <select class="input" name="nombre_prenda" id="nombre_prenda">
    <option value=""  selected>Seleccione</option>
    <option value="Camisa">Camisa</option>
    <option value="Camiseta">Camiseta</option>
    <option value="Blusa">Blusa</option>
    <option value="Pantalon">Pantalon</option>
    <option value="Chaqueta">Chaqueta</option>
    <option value="Saco">Saco</option>
    <option value="Sueter">Sueter</option>
    <option value="Falda">Falda</option>
    <option value="Vestido">Vestido</option>
    <option value="Otro">Otro</option>
  </select>
  <label for="telefono_cliente"># de prendas</label>
      <input class="input" name="prendas_numero" type="number" placeholder="# prendas" id="prendas_numero" >
</div>
<input type="hidden" name="estado" id="estado" value="creado">

<div class="field">
  <label for="descripcion_arreglo">Descripcion del Arreglo</label>
  <textarea class="input" name="descripcion_arreglo" placeholder="Escribe la descripción aquí..." id="descripcion_arreglo"></textarea>
</div>
<div class="field flex">
<label for="telefono_cliente">Tiempo estimado</label>
      <input class="input" name="tiempo_estimado" type="number" placeholder="Tiempo estimado" id="tiempo_estimado" >
      <label for="valor_prenda">Valor Total</label>
      <input class="input" name="valor_prenda" type="text" data-real-value="" placeholder="$" id="valor_prenda" >
    </div>  
   

  
    </form> 
    <div class=" flex">
      <button value="agregar_prenda" id="agregar_prenda"  class="button">Agregar &#10133;</button>
      <button id="agendar_orden_btn" class="button"> &#9986; Agendar Orden</button>
      </div> 
</div>
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