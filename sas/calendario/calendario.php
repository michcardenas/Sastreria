<?php 

include_once("../conexion/database.php");

session_start();
$usuario= $_SESSION['usuario'];
if(!isset($usuario)){
    header("location: login/login.php");

}else {
  
    if($conexion){
                $sql=mysqli_query($conexion,"SELECT DATE(f.fecha_entrega) AS fecha, 
                COUNT(CASE WHEN f.estado IS NOT NULL THEN f.id_cliente END) AS total_clientes, 
                 COUNT(CASE WHEN f.estado = 2 THEN  f.id_cliente END) AS total_entregas,
                 COUNT(CASE WHEN f.estado = 1 THEN  f.id_cliente END) AS total_arreglados,
                  COUNT(CASE WHEN f.estado = 0 THEN  f.id_cliente END) AS total_pendientes,
                SUM(f.estimacion_total) AS total_estimaciones
         FROM factura f
         JOIN clientes c ON f.id_cliente = c.id
         GROUP BY DATE(f.fecha_entrega)
         HAVING COUNT(CASE WHEN f.estado IS NOT NULL THEN f.id_cliente END) > 0
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
        <h3 class="inicio" > Aqui podras gestionar tus arreglos </h3>
        <a  href="../index.php" ><img style="width: 3rem;" id="imagen_nav" class="imagen_nav" src="../img/sasindex.png" alt="index"></a>

        <a class="inicio" href="../login/salirlogin.php">salir</a>
        </nav>
        <div>
        <div>
            <h3 style="margin: 3rem;">El día de hoy es 
                <?php echo date('d-m-'); ?>
                <span style="opacity: 0.5; color: grey;">
                    <?php echo date('Y'); ?>
                </span>
            </h3>
        </div>

               <!-- HTML !-->
           
        <div class="container"> 
            <div class="container-ordenes">
            <?php if($sql){
                    echo "<table class='table-ordenes'>";
                    echo "<tr><th>Fecha de entrega</th><th> # Clientes</th><th>Estimacion</th><th>Pendientes</th></tr>";
                  

                    while($row = mysqli_fetch_array($sql)){
                        $fecha_entrega = $row['fecha'];
                        $fecha_formateada = date('m-d', strtotime($fecha_entrega));

                        $numero_clientes = $row['total_clientes'];
                        $total_minutos = $row['total_estimaciones'];
                        $total_entregas = $row['total_entregas'];
                        $total_arreglados = $row['total_arreglados'];
                        $total_pendientes = $row['total_pendientes'];
                        $style="";
                        if($numero_clientes== $total_entregas){
                            $style="style='color:green'";
                        }
                        $pendientes = $numero_clientes - ($total_arreglados +  $total_entregas );

                        $fecha_param = urlencode($fecha_entrega); // codificar la fecha como un parámetro GET
                        echo "<tr>";
                        echo "<td ><a ".$style." href='detalle_orden.php?fecha=".$fecha_param."'>". $fecha_formateada."</a></td>";
                        echo "<td>".$numero_clientes."</td>";
                        $horas = floor($total_minutos / 60);
                        $minutos = $total_minutos % 60;
                        echo "<td>".$horas.":".sprintf('%02d', $minutos)." Horas</td>";
                        echo "<td>". $pendientes ."</td>";

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