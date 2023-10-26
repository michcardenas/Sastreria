<?php
// Iniciar la sesión
session_start();
include '../../model/funciones.php';

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

if (isset($_GET['fecha_entrega'])) {
    $fecha_entrega = $_GET['fecha_entrega'];

    // Ahora puedes usar la variable $fecha_entrega en tus operaciones.
    echo $fecha_entrega; // Esto imprimirá: 2023-09-25
} else {
    // Aquí manejas el caso en que no se envió la fecha.
    echo "Fecha no proporcionada.";
}
$id_orden = isset($_GET['id_orden']) ? htmlspecialchars($_GET['id_orden']) : '';
// Este es tu código para obtener los datos
$arreglos_prendas = prendas_por_orden_con_cliente($id_orden);





?>
<div class="p_centrar">
<div class="centrar">
<form class="form card">
    <div class="card_header">
        <h1 class="form_heading">Detalle cliente</h1>
    </div>
    
    <?php
    // Asumimos que $arreglos_prendas tiene al menos un resultado
    if (isset($arreglos_prendas[0])) {
        $primer_resultado = $arreglos_prendas[0];
    ?>
        <input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo htmlspecialchars($primer_resultado['id']); ?>">
        <input type="hidden" name="id_orden" id="id_orden" value="<?php echo $id_orden; ?>">

        <div class="field">
            <label for="nombre_cliente">Nombre</label>
            <input class="input" readonly name="nombre_cliente" type="text" placeholder="nombre" id="nombre_cliente" value="<?php echo htmlspecialchars($primer_resultado['nombre_cliente']); ?>">
        </div>
        <div class="field">
            <label for="telefono_cliente">Telefono</label>
            <input class="input" readonly name="telefono_cliente" type="number" placeholder="telefono" id="telefono_cliente" value="<?php echo htmlspecialchars($primer_resultado['telefono_cliente']); ?>">
        </div>
        
    <?php } else { ?>
        <p>No se encontraron resultados para este cliente.</p>
    <?php } ?>

    <div class="content_loader">
        <div class="loader"></div>
    </div>
    <h1 class="form_heading" id="resultado_editar"></h1>
</form>

<table>
    <thead>
        <tr>
            <th>Prenda</th>
            <th>Tiempo estimado</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($arreglos_prendas as $prenda) {
        ?>
        <tr>
            <td>
                <a href="detalle_arreglo.php?id=<?php echo htmlspecialchars($prenda['id']); ?>">
                    <?php echo htmlspecialchars($prenda['nombre_ropa']); ?>
                </a>
            </td>
            <td><?php echo htmlspecialchars($prenda['tiempo_estimado']); ?> minutos</td>
            <td>

            <select class="estado-select" data-prenda-id="<?php echo htmlspecialchars($prenda['id']); ?>">
                <option value="1" <?php if($prenda['estado'] == 1 || $prenda['estado'] == 3) echo 'selected'; ?>>Ingresado</option>
                <option value="4" <?php echo $prenda['estado'] == 4 ? 'selected' : ''; ?>>En proceso</option>
                <option value="5" <?php echo $prenda['estado'] == 5 ? 'selected' : ''; ?>>Arreglado</option>

            </select>

            </td>
        </tr>
        <?php 
        } 
        ?>
    </tbody>
</table>
<div class=" flex">
        <button id="editar_arreglo_estado"  class="button">Guardar</button>
        <button id="entregar"  class="button">Entregar &#128722;</button>
</div>


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