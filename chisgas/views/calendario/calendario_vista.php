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
if (isset($_POST['calendarioData'])) {
    $calendarioData = json_decode($_POST['calendarioData'], true);

    // Ahora puedes manipular $calendarioData como un array en PHP
}


function convertirMinutosAHoras($minutos) {
    $horas = floor($minutos / 60);
    $minRestantes = $minutos % 60;
    
    if ($horas > 0) {
        return "{$horas}h {$minRestantes}min";
    } else {
        return "{$minRestantes}min";
    }
}


?>

<div class="p_centrar">

<div class="centrar">
    <h4  class="form_heading">Busca tu cliente aqui!</h4>
<div class="search">
        <input placeholder="Buscar cliente..." type="text">
        <button class="button-buscar_orden">Buscar</button>
      </div>
      <div id="resultados" class="lista-nombres">
            <!-- Aquí se mostrará la lista de nombres -->
        </div><table border="1">
    <thead>
        <tr>
            <th>Fecha de Entrega</th>
            <th>Número de Clientes</th>
            <th>Tiempo Estimado</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($calendarioData as $index => $entry): ?>
        <tr>
            <!-- Añadiendo un enlace con un data-id al campo fecha_entrega -->
            <td><a href="#" class="fecha-link" data-fecha="<?php echo htmlspecialchars($entry["fecha_entrega"]); ?>"><?php echo htmlspecialchars($entry["fecha_entrega"]); ?></a></td>
            <td><?php echo htmlspecialchars($entry["numero_clientes"]); ?></td>
            <td><?php echo convertirMinutosAHoras($entry["tiempo_estimado_total"]); ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>

</table>


</div>
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