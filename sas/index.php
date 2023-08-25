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
    <link rel="shortcut icon" href="img/taylor.png">
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
       <a href="clientes/clientes.php" class="button-27" role="button"><img src="img/factura.png" class="factura" alt=""><br> Nueva orden </a>
       <a href="calendario/calendario.php" class="button-27" role="button"><img src="img/calendario.png" class="factura" alt=""><br> Calendario </a>
       <a href="caja/caja.php" class="button-27" role="button"><img src="img/caja-registradora.png" class="factura" alt=""><br> Caja </a>
       <!-- <a href="caja/estadistica.php" class="button-27" role="button"><img src="img/estadistica.png" class="factura" alt=""><br> Estadistica </a>  -->

       </div>
       </div>
</body>
</html>

<?php } ?>