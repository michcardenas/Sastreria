<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../views/css/style.css">
    <title><?php echo $title ?? 'Chisgas'; ?></title>
</head>
<body>

<?php 
  

    if (isset($_SESSION['username']) && $_SESSION['username'] == true) {
        echo '<nav class="image-nav">
        <img src="img/chisgas_fondo_blanco.png" alt="Chisgas logo" class="center-image">
        <a href="login/cerrar_sesion.php" class="logout-link">Cerrar sesión</a>

    </nav>
    ';
    } 
    ?>
   