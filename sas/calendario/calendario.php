<?php 

include_once("../conexion/database.php");

session_start();
$usuario= $_SESSION['usuario'];
if(!isset($usuario)){
    header("location: login/login.php");

}else {
  
    if($conexion){
                $sql=mysqli_query($conexion,"SELECT 
                DATE(f.fecha_entrega) AS fecha, 
                COUNT(f.id_cliente) AS total_clientes, 
                SUM(f.estimacion_total) AS total_estimaciones
            FROM factura f
            JOIN clientes c ON f.id_cliente = c.id
            WHERE f.estado = 0
            GROUP BY DATE(f.fecha_entrega)
            ORDER BY DATE(f.fecha_entrega);
            
                    ");
     
        /* ¿La consulta se ejecutó bien? */
      
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
        <h3 class="inicio" > Calendario </h3>
        <a  href="../index.php" ><img style="width: 3rem;" id="imagen_nav" class="imagen_nav" src="../img/sasindex.png" alt="index"></a>

        <a class="inicio" href="../login/salirlogin.php">salir</a>
        </nav>
       
               <!-- HTML !-->
           
        <div class="container"> 
            <div class="container-ordenes">
            <?php if($sql){
                    echo "<table class='table-ordenes'>";
                    echo "<tr><th>Fecha de entrega</th><th> # Clientes</th><th>Estimacion</th></tr>";

                    while($row = mysqli_fetch_array($sql)){
                        $fecha_entrega = $row['fecha'];
                        $numero_clientes = $row['total_clientes'];
                        $total_minutos = $row['total_estimaciones'];
                        $fecha_param = urlencode($fecha_entrega); // codificar la fecha como un parámetro GET
                        echo "<tr>";
                        echo "<td><a href='detalle_orden.php?fecha=".$fecha_param."'>".$fecha_entrega."</a></td>";
                        echo "<td>".$numero_clientes."</td>";
                        $horas = floor($total_minutos / 60);
                        $minutos = $total_minutos % 60;
                        echo "<td>".$horas.":".sprintf('%02d', $minutos)." Horas</td>";

                        echo "</tr>";
                    }
                    echo "</table>";
                }
                ?>

    
            </div>
        </div> 
  
  
 
  
  <script
    src="https://code.jquery.com/jquery-3.6.1.js"
    integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
    crossorigin="anonymous">
    
  </script>
  <script src="../js/app.js" ></script>
  

</body>

</html>

<?php  }}  ?>