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
    <link rel="stylesheet" href="../style/stylechisgas.css">

    <!-- Bootstrap CSS -->

    <title>Inicio</title>
</head>
<body >
    <nav class="nav-index">
    <h3 class="inicio" >Hola  <?php echo $usuario; ?></h3>
    <a class="inicio" href="../login/salirlogin.php">salir</a>
    </nav>
   
		   <!-- HTML !-->
       <div class="container">
      <div class="container-orden">
       <form action="/">
        <div class="info">
          <input class="input"  type="text" name="name" placeholder="Nombre">
          <input class="input" type="number"  name="celular" placeholder="Numero celular">
        
         
        </div>
        <div class="contenedor-botones">
        <button href="/" class="button-siguiente">Siguiente</button>
        <button href="/" class="button-buscar">Buscar</button>
        </div>
      </form>
      </div>
    </div>
</body>
</html>

<?php } ?>