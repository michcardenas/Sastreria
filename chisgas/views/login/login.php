<?php

$error = isset($_GET['error']) ? $_GET['error'] : null;
if ($error == 1) {
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
    echo "<div class='alert alert-danger' role='alert'>
    Usuario o contraseña incorrectos
  </div>";
}elseif($error == 2){
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
    echo "<div class='alert alert-danger' role='alert'>
    Usuario o contraseña incorrectos
  </div>";
}else{

    $ruta = '../views/template.php';

    if (file_exists($ruta)) {
        $ruta_css = '../views/css/style.css';
        $ruta_icon = '../views/img/aguja.png';
        
    
    
        include $ruta;
    } else {
        echo "El archivo $ruta no existe.";
    }


?>
<div class="formulario-login">

<form action="../views/login/validar.php" method="POST" class="form_main">

    <p class="heading">Gestion Sastreria</p>
    
    <div class="inputContainer">
        &#128105;
        <input type="text" name="username" class="inputField" id="username" placeholder="Ingrese su usuario">
    </div>
    
    <div class="inputContainer">
        <svg class="inputIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#2e2e2e" viewBox="0 0 16 16">
            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
        </svg>
        <input type="password" name="password" class="inputField" id="password" placeholder="Ingrese su contraseña">
    </div>
              
    <button type="submit" class="button">
    <span class="button-content">Entrar </span>
    </button>

    <!-- <a class="forgotLink" href="#">Forgot your password?</a> -->
</form>

</div>

<?php
}
?>