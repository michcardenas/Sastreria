<?php 

session_start();
$usuario= $_SESSION['usuario'];
if(!isset($usuario)){
    header("location: login/login.php");

}else {


?>
<!DOCTYPE html>
<html lang="en">
<head>
     <!-- Required meta tags -->
     <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/stylechisgas.css">

    <!-- Bootstrap CSS -->

    <title>Inicio</title>
</head>
<body >
    <nav class="nav-index">
    <h3 class="inicio" >Hola  <?php echo $usuario; ?></h3>
    <a class="inicio" href="login/salirlogin.php">salir</a>
    </nav>
   
		   <!-- HTML !-->
        <div class="contenedor">
       <div class="container">
       <a href="orden/orden.php" class="button-27" role="button">Nueva orden </a>
       <a class="button-27" role="button">Buscar</a>
       <a class="button-27" role="button">Estadisticas</a>
       </div>
       </div>
</body>
</html>

<?php } ?>