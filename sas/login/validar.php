<?php
require('../conexion/database.php');

$usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_STRING);
$contraseña = filter_var($_POST['contraseña'], FILTER_SANITIZE_STRING);

$status = session_status();
if($status == PHP_SESSION_NONE){
    //There is no active session
    session_start();
    session_regenerate_id(true);

}else
if($status == PHP_SESSION_DISABLED){
    //Sessions are not available
}else
if($status == PHP_SESSION_ACTIVE){
    //Destroy current and start new one
    session_destroy();
    session_start();
    session_regenerate_id(true);
}
$_SESSION['usuario']=$usuario;


// Verificar la conexión



$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ? AND contraseña = ?");
$stmt->bind_param("ss", $usuario, $contraseña);
$stmt->execute();
$resultado = $stmt->get_result();

if(!empty($resultado) && mysqli_num_rows($resultado) > 0){ 
$filas=mysqli_num_rows($resultado);

}else{
    $filas = 0;
}
echo "entro";

if($filas!= 0){
    session_start();
    $_SESSION['usuario'] = $usuario;
    header("location: ../index.php");

}else{
   
    ?>
    <?php
    include("errorLogin.php");

  ?>
  <h1 class="bad">ERROR DE AUTENTIFICACION</h1>
  <?php
}
mysqli_free_result($resultado);
mysqli_close($conexion);