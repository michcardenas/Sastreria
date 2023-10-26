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

$orden = $_SESSION['orden_consultar'][0];
?>

<div class="p_centrar">
    <div class="centrar">
    <form class="form card">
    <div class="card_header">
        <h1 class="form_heading">Detalle orden</h1>
        <input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
    </div>

    <div class="field">
        <label for="order_id">Número de orden</label>
        <input class="input" readonly name="order_id" type="text" id="order_id" value="<?php echo isset($orden['order_id']) ? $orden['order_id'] : ''; ?>">
    </div>

    <div class="field">
        <label for="nombre_cliente">Nombre</label>
        <input class="input" readonly name="nombre_cliente" type="text" placeholder="nombre" id="nombre_cliente" value="<?php echo isset($orden['cliente_nombre']) ? htmlspecialchars($orden['cliente_nombre']) : ''; ?>">
    </div>

    <div class="field">
        <label for="telefono_cliente">Telefono</label>
        <input class="input" readonly name="telefono_cliente" type="number" placeholder="telefono" id="telefono_cliente" value="<?php echo isset($orden['cliente_telefono']) ? htmlspecialchars($orden['cliente_telefono']) : ''; ?>">
    </div>

    <div class="field">
        <label for="total_prendas">Número de prendas</label>
        <input class="input" readonly name="total_prendas" type="text" id="total_prendas" value="<?php echo isset($orden['total_prendas']) ? $orden['total_prendas'] : ''; ?>">
    </div>

    <div class="field">
        <label for="valor">Valor total</label>
        <input class="input" readonly name="valor" type="text" id="valor" value="<?php echo isset($orden['valor_total']) ? "$ " . number_format($orden['valor_total'], 0, ',', '.') : ''; ?>">
    </div>

    <div class="field">
        <label for="abono">Abono</label>
        <input class="input" readonly name="abono" type="text" id="abono" value="<?php echo isset($orden['abono']) ? "$ " . number_format($orden['abono'], 0, ',', '.') : ''; ?>">
    </div>

    <div class="field">
        <label for="saldo">Saldo</label>
        <input class="input" readonly name="saldo" type="text" id="saldo" value="<?php echo isset($orden['saldo']) ? "$ " . number_format($orden['saldo'], 0, ',', '.') : ''; ?>">
    </div>

    <div class="field">
        <label for="fecha_entrega">Fecha de Entrega</label>
        <input class="input" readonly name="fecha_entrega" type="text" id="fecha_entrega" value="<?php echo isset($orden['fecha_entrega']) ? htmlspecialchars($orden['fecha_entrega']) : ''; ?>">
    </div>

</form>

        <table>
    <thead>
        <tr>
            <th>Nombre Ropa</th>
            <th>Descripción del arreglo</th>
            <th>Valor</th>
            <th>Número de prendas</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($_SESSION['orden_consultar'] as $orden): ?>
            <tr>
                <td><?php echo htmlspecialchars($orden['nombre_ropa']); ?></td>
                <td><?php echo htmlspecialchars($orden['descripcion_arreglo']); ?></td>
                <td><?php echo htmlspecialchars($orden['valor']); ?></td>
                <td><?php echo htmlspecialchars($orden['prendas_numero']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


        <h1 class="form_heading" id="resultado_editar"></h1>

        <div class="field_boton_editar">
        <button onclick="enviarAWhatsapp()" class="button">Enviar a WhatsApp</button>
        </div>
    </div>
</div>

<?php 
$ruta_footer = '../footer.php';
if (file_exists($ruta_footer)) {
    $ruta_js = "../js/main.js";
    include $ruta_footer;
} else {
    echo "El archivo $ruta_footer no existe.";
}
?>
