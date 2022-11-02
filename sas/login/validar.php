<?php
require('../conexion/database.php');

$usuario=$_POST['usuario'];
$contraseña=$_POST['contraseña'];
$status = session_status();
if($status == PHP_SESSION_NONE){
    //There is no active session
    session_start();

}else
if($status == PHP_SESSION_DISABLED){
    //Sessions are not available
}else
if($status == PHP_SESSION_ACTIVE){
    //Destroy current and start new one
    session_destroy();
    session_start();
}
$_SESSION['usuario']=$usuario;



$consulta="SELECT*FROM usuarios where usuario='$usuario' and contraseña='$contraseña'";
$resultado=mysqli_query($conexion,$consulta);
if(!empty($resultado) && mysqli_num_rows($resultado) > 0){ 
$filas=mysqli_num_rows($resultado);

}else{
    $filas = 0;
}

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