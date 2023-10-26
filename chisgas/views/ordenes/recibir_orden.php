<?php
// Iniciar la sesión
session_start();
$id_cliente = isset($_GET['cliente']) ? htmlspecialchars($_GET['cliente']) : '';

if (!empty($id_cliente)) {
    header('Location: ../../controllers/clientesController.php?action=consultar_orden&cliente=' . urlencode($id_cliente));
    exit(); // Asegúrate de llamar a exit() para que el script de PHP se detenga aquí
} else {
    // Manejar el caso en que $id_cliente esté vacío, si es necesario
}

?>

