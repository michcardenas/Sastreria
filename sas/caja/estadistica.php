<?php 

include_once("../conexion/database.php");

session_start();
$usuario= $_SESSION['usuario'];
if(!isset($usuario)){
    header("location: login/login.php");

}else {
  $fecha_query = $_REQUEST['fecha'];
    if($conexion){
                $sql=mysqli_query($conexion,"SELECT c.abono, 
                c.id_orden, 
                c.saldo, 
                cl.nombre, 
                c.fecha, 
                c.fecha_saldo 
         FROM caja c
         LEFT JOIN factura f ON c.id_orden = f.id 
         LEFT JOIN clientes cl ON cl.id = f.id_cliente 
         WHERE DATE(c.fecha) = '$fecha_query' OR DATE(c.fecha_saldo) = '$fecha_query';
         
         
            
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
        <h3 class="inicio" > Gestion de caja </h3>
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
                    echo "<tr><th>Nombre</th><th># Pago</th><th>Fecha y hora</th></tr>";
                  
                    $total_suma_total = 0;
                    while($row = mysqli_fetch_array($sql)){
                        $fecha_entrega = $row['fecha'];
                        $fecha_formateada_url = date('Y-m-d', strtotime($fecha_entrega));
                        $fecha_formateada = date('m-d', strtotime($fecha_entrega));

                        $nombre = $row['nombre'];
                        $id_orden = $row['id_orden'];
                        $abono = $row['abono'];
                        $saldo = $row['saldo'];
                        $fecha = $row['fecha']; //$fecha = 2023-08-09 10:39:17
                        $fecha_saldo = $row['fecha_saldo'];    //$fecha_saldo= 2023-08-11 10:39:24
                        $fecha_obj = DateTime::createFromFormat('Y-m-d H:i:s', $fecha);
                        $fecha_formateada = $fecha_obj->format('Y-m-d');
                        
                        
                        if ($fecha_query == $fecha_formateada) {
                            $suma_total = $abono;
                            $fecha_pago =  $fecha ;
                        } else {
                            $suma_total = $saldo;
                            $fecha_pago =  $fecha_saldo ;
                        }
                        $total_suma_total += $suma_total; 
                                          echo "<tr>";
                        echo "<td ><a >". $nombre."</a></td>";
                        echo "<td>$".number_format($suma_total, 0, '.', ',')."</td>";

                        echo "<td>".$fecha_pago."</td>";

                        echo "</tr>";
                    }
                    echo "</table>";
                }
                echo "Total dia: $" . number_format($total_suma_total, 0, '.', ',');
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