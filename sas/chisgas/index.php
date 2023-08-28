<?php
// index.php

session_start();

// Comprueba si el usuario está logueado
if(!isset($_SESSION['username'])) {
    // Si no está logueado, redirige al login
    header("Location: controllers/logincontroller.php");
    exit();
}
else{
       header("Location: views/template.php");
}

