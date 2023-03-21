<?php 
include("../conexion/database.php");
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
    <link rel="shortcut icon" href="../img/taylor.png">
    <!-- Bootstrap CSS -->

    <title>Inicio</title>
</head>
<body >
    <nav class="nav-index">
    <h3 class="inicio" > Crea o busca a tu cliente </h3>
    <a class="inicio" href="../login/salirlogin.php">salir</a>
    </nav>
   
		   <!-- HTML !-->
       
       <div class="container">
       
      <div class="container-orden">
       <form id="form" method="POST" action="../callbacks/clientes.php">
        <div class="info">
          <input class="input"  type="text" name="txtname" id="txtname" placeholder="Nombre">
          <input class="input" type="number"  id="txttel"  name="txttel" placeholder="Numero celular">
        
         
        </div>

        <div id="contenido" >
          
        </div>
        <div class="contenedor-botones">
        <button type="button" name="crear" id="crear" class="button-siguiente">Crear</button>
        <button type="button"  id="search" class="button-buscar">Buscar</button>
        </div>
      </form>
      </div>
        
      </div>
    </div>
    <div class="tabla-clientes">
    <div class="container">
      
        <button class="loading" ></button >
        <a id="mostrar_mensaje"></a>
        <a id="mostrar_mensaje1" ></a>
        <a id="mostrar_mensaje_error" ></a>
     </div>
     </div>
    <div class="tabla-clientes">
  
 
  
  <script
    src="https://code.jquery.com/jquery-3.6.1.js"
    integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
    crossorigin="anonymous">
    
  </script>
  <script src="../js/app.js" ></script>
  

</body>

</html>

<?php  }?>