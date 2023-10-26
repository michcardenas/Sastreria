<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(    $ruta_cerrar_sesion = '' ){
    $ruta_cerrar_sesion = '../login/cerrar_sesion.php';
}else{
    $ruta_cerrar_sesion = 'login/cerrar_sesion.php';
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $ruta_css; ?>">
    <link rel="icon" type="image/png" href="<?php echo $ruta_icon; ?>">


    <title><?php echo $title ?? 'Chisgas'; ?></title>
</head>
<body>

<?php 
  

    if (isset($_SESSION['username']) && $_SESSION['username'] == true) {
        echo '<nav class="image-nav">
        <a href="'.$ruta_image_menu.'">
        <img src="'.$ruta_image.'" alt="Chisgas logo" class="center-image">
        </a>
        <a href="../login/cerrar_sesion.php" class="logout-link">Cerrar sesión</a>

    </nav>
    ';
    } 
    ?>
   