<?php 

include_once("../conexion/database.php");

session_start();
$usuario= $_SESSION['usuario'];
if(!isset($usuario)){
    header("location: login/login.php");

}else {
  
    if($conexion){
                $sql=mysqli_query($conexion,"SELECT DATE(fecha_unificada) AS fecha_unificada,
                SUM(total_abonos) AS total_abonos,
                SUM(cuenta_abonos) AS cuenta_abonos,
                SUM(total_saldos) AS total_saldos,
                SUM(cuenta_saldos) AS cuenta_saldos,
                SUM(total_abonos) + SUM(total_saldos) AS suma_total
         FROM (
             -- Subconsulta para abonos
             SELECT fecha AS fecha_unificada,
                    SUM(abono) AS total_abonos,
                    COUNT(CASE WHEN abono != 0 THEN 1 ELSE NULL END) AS cuenta_abonos,
                    0 AS total_saldos, -- valor ficticio
                    0 AS cuenta_saldos  -- valor ficticio
             FROM caja
             GROUP BY DATE(fecha)
     
             UNION ALL
     
             -- Subconsulta para saldos
             SELECT fecha_saldo AS fecha_unificada,
                    0 AS total_abonos, -- valor ficticio
                    0 AS cuenta_abonos,  -- valor ficticio
                    SUM(saldo) AS total_saldos,
                    COUNT(CASE WHEN saldo != 0 THEN 1 ELSE NULL END) AS cuenta_saldos
             FROM caja
             GROUP BY DATE(fecha_saldo)
         ) AS combined
         GROUP BY DATE(fecha_unificada)
         ORDER BY fecha_unificada;
                
         
         
            
                    ");
     if (!$sql) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }
    
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
                    echo "<tr><th>Fecha</th><th># Pagos</th><th>Total</th></tr>";
                  

                    while($row = mysqli_fetch_array($sql)){
                        $fecha_entrega = $row['fecha_unificada'];
                        $fecha_formateada_url = date('Y-m-d', strtotime($fecha_entrega));
                        $fecha_formateada = date('m-d', strtotime($fecha_entrega));

                        $suma_total = $row['suma_total'];
                        $cuenta_abonos = $row['cuenta_abonos'];
                        $cuenta_saldos = $row['cuenta_saldos'];
                        $numero_registros_totales = $cuenta_abonos + $cuenta_saldos;
                      
                       
                  

                        $fecha_param = urlencode($fecha_entrega); // codificar la fecha como un parámetro GET
                        echo "<tr>";
                        echo "<td ><a href='estadistica.php?fecha=". $fecha_formateada_url."'>". $fecha_formateada."</a></td>";
                        echo "<td>".$numero_registros_totales."</td>";

                        echo "<td>$".number_format($suma_total, 0, '.', ',')."</td>";

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