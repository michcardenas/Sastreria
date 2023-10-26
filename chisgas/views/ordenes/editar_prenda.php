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
$id_cliente = isset($_GET['cliente']) ? htmlspecialchars($_GET['cliente']) : '';

if(isset($_SESSION['editar_prenda'])) {
  $editar_prenda = $_SESSION['editar_prenda'];

  $nombre_ropa = isset($editar_prenda['nombre_ropa']) ? $editar_prenda['nombre_ropa'] : '';
  $id = isset($editar_prenda['id']) ? $editar_prenda['id'] : '';
  $tiempo_estimado = isset($editar_prenda['tiempo_estimado']) ? $editar_prenda['tiempo_estimado'] : '';
  $valor = isset($editar_prenda['valor']) ? $editar_prenda['valor'] : '';
  $prendas_numero = isset($editar_prenda['prendas_numero']) ? $editar_prenda['prendas_numero'] : '';
  $estado = isset($editar_prenda['estado']) ? $editar_prenda['estado'] : '';
  $descripcion_arreglo = isset($editar_prenda['descripcion_arreglo']) ? $editar_prenda['descripcion_arreglo'] : '';
  $id_cliente = isset($editar_prenda['id_cliente']) ? $editar_prenda['id_cliente'] : '';
  $id_prenda = isset($editar_prenda['prenda_id']) ? $editar_prenda['prenda_id'] : '';
}

$valor_formateado = isset($valor) ? number_format($valor, 0, '.', ',') : '';



?>

<div class="p_centrar">

<div class="centrar">




  <form class="form card_2" >

    <div class="card_header">
   
      <h1 class="form_heading">Crear orden de Arreglo</h1>
      <input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo isset($id_cliente) ? htmlspecialchars($id_cliente) : ''; ?>">
      <input type="hidden" name="id_prenda" id="id_prenda" value="<?php echo isset($id_prenda) ? htmlspecialchars($id_prenda ) : ''; ?>">

    </div>
    <div class="field flex">
  <label for="nombre_cliente_select">Prenda</label>
  <select class="input" name="nombre_prenda" id="nombre_prenda">
    <option value="" <?php echo (isset($nombre_ropa) && $nombre_ropa == '') ? 'selected' : ''; ?>>Seleccione</option>
    <option value="Camisa" <?php echo (isset($nombre_ropa) && $nombre_ropa == 'Camisa') ? 'selected' : ''; ?>>Camisa</option>
    <option value="Camiseta" <?php echo (isset($nombre_ropa) && $nombre_ropa == 'Camiseta') ? 'selected' : ''; ?>>Camiseta</option>
    <option value="Blusa" <?php echo (isset($nombre_ropa) && $nombre_ropa == 'Blusa') ? 'selected' : ''; ?>>Blusa</option>
    <option value="Pantalon" <?php echo (isset($nombre_ropa) && $nombre_ropa == 'Pantalon') ? 'selected' : ''; ?>>Pantalon</option>
    <option value="Chaqueta" <?php echo (isset($nombre_ropa) && $nombre_ropa == 'Chaqueta') ? 'selected' : ''; ?>>Chaqueta</option>
    <option value="Saco" <?php echo (isset($nombre_ropa) && $nombre_ropa == 'Saco') ? 'selected' : ''; ?>>Saco</option>
    <option value="Sueter" <?php echo (isset($nombre_ropa) && $nombre_ropa == 'Sueter') ? 'selected' : ''; ?>>Sueter</option>
    <option value="Falda" <?php echo (isset($nombre_ropa) && $nombre_ropa == 'Falda') ? 'selected' : ''; ?>>Falda</option>
    <option value="Vestido" <?php echo (isset($nombre_ropa) && $nombre_ropa == 'Vestido') ? 'selected' : ''; ?>>Vestido</option>
    <option value="Otro" <?php echo (isset($nombre_ropa) && $nombre_ropa == 'Otro') ? 'selected' : ''; ?>>Otro</option>
</select>

  <label for="telefono_cliente"># de prendas</label>
  <input class="input" name="prendas_numero" type="number" placeholder="# prendas" id="prendas_numero" value="<?php echo isset($prendas_numero) ? $prendas_numero : ''; ?>">
</div>
<input type="hidden" name="estado" id="estado" value="creado">

<div class="field">
  <label for="descripcion_arreglo">Descripcion del Arreglo</label>
  <textarea class="input" name="descripcion_arreglo" placeholder="Escribe la descripción aquí..." id="descripcion_arreglo">
    <?php echo $descripcion_arreglo; ?>
</textarea></div>
<div class="field flex">
<label for="telefono_cliente">Tiempo estimado</label>
<input class="input" name="tiempo_estimado" type="number" placeholder="Tiempo estimado" id="tiempo_estimado" 
       value="<?php echo isset($tiempo_estimado) ? $tiempo_estimado : ''; ?>">

<label for="valor_prenda">Valor Total</label>
<input class="input" name="valor_prenda" type="text" data-real-value="" placeholder="$" id="valor_prenda" value="<?php echo $valor_formateado; ?>">


    </div>  
   

  
    </form> 
    <div class=" flex">
      <button value="editar_prenda" id="editar_prenda"  class="button">Editar ✏️</button>
      <button class="button" onclick="goBack()">Atras</button>
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