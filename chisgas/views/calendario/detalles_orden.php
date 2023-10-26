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
$client_id = isset($_GET['cliente']) ? htmlspecialchars($_GET['cliente']) : '';


$client_id = (int)$client_id;
$ordenes = obtener_info_ordenes($client_id);
?>
<div class="p_centrar">
    <div class="centrar">
        <table border="1">
            <thead>
                <tr>
                    <th>Fecha de Entrega</th>
                    <th>Estado</th>
                    <th>Prendas</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($ordenes !== false) : ?>
                    <?php foreach ($ordenes as $orden) : ?>
                        <tr>
                            <td>
                                <a href="ver_arreglos.php?id_orden=<?php echo $orden['id']; ?>">
                                    <?php echo $orden['fecha_entrega']; ?>
                                </a>
                            </td>
                            <td><?php echo $orden['estado']; ?></td>
                            <td><?php echo $orden['total_prendas']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3">No se encontraron órdenes.</td>
                    </tr>
                <?php endif; ?>
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