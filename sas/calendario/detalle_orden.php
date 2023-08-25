<?php 

include_once("../conexion/database.php");

session_start();
$usuario= $_SESSION['usuario'];
if(!isset($usuario)){
    header("location: login/login.php");

}else {

    $fecha=$_REQUEST['fecha'];
$fecha_formateada = date('Y-m-d H:i:s', strtotime($fecha));

    if($conexion){
                $sql=mysqli_query($conexion,"SELECT n.nombre, f.franja_horaria, f.estimacion_total,f.id_cliente,f.id,f.estado
                FROM factura f
                JOIN clientes n ON f.id_cliente = n.id
                WHERE f.fecha_entrega = '$fecha_formateada'
                ORDER BY CASE WHEN f.franja_horaria LIKE '%am' THEN 0 ELSE 1 END, f.franja_horaria;

            
                    ");
  
     function obtenerFechaFormateada($fecha) {
        // Convertir la fecha a un objeto DateTime
        $fecha_objeto = new DateTime($fecha);
    
        // Obtener el nombre del día de la semana en español
        $dias_semana = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
        $nombre_dia = $dias_semana[$fecha_objeto->format('w')];
    
        // Obtener el día del mes con el sufijo correspondiente
        $dia_mes = $fecha_objeto->format('j');
        switch ($dia_mes) {
            case 1:
            case 21:
            case 31:
                $sufijo = '';
                break;
            case 2:
            case 22:
                $sufijo = '';
                break;
            case 3:
            case 23:
                $sufijo = '';
                break;
            default:
                $sufijo = '';
                break;
        }
    
        // Obtener el nombre del mes en español
        $meses = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        $nombre_mes = $meses[$fecha_objeto->format('n') - 1];
    
        // Combinar el nombre del día, el día del mes y el nombre del mes en un solo string
        $fecha_formateada = $nombre_dia . ' ' . $dia_mes . $sufijo . ' de ' . $nombre_mes . ' de ' . $fecha_objeto->format('Y');
    
        // Devolver la fecha formateada
        return $fecha_formateada;
    }
      
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
    
        <title>Detalle fecha</title>
    </head>
    <body >
        <nav class="nav-index">
        <h3 class="inicio" > <?php 
 echo obtenerFechaFormateada($fecha);
 ?></h3>
        <a  href="../index.php" ><img style="width: 3rem;" id="imagen_nav" class="imagen_nav" src="../img/sasindex.png" alt="index"></a>

        <a class="inicio" href="../login/salirlogin.php">salir</a>
        </nav>
        <div class="centrar_estado">
        <div class="valor_center">
        <h3>Arreglado</h3>
        <img class="indicador_imagen" src="../img/arreglado.png" alt="Imagen arreglado">
        </div>

        <div class="valor_center">
        <h3>Entregado</h3>
        <img class="indicador_imagen" src="../img/entregado.png" alt="Imagen arreglado">
        </div>

        <div class="valor_center">
        <h3>Pendiente</h3>
        <img class="indicador_imagen" src="../img/noarreglado.png" alt="Imagen arreglado">
        </div>
        </div>
               <!-- HTML !-->
        <div class="container"> 
            <div class="container-ordenes">
            <?php if($sql){
                    echo "<table class='table-ordenes'>";
                    echo "<tr><th>Cliente</th><th> Franja</th><th>Estimacion</th></tr>";

                    while($row = mysqli_fetch_array($sql)){
                        $fecha_entrega = $row['nombre'];
                        $numero_clientes = $row['franja_horaria'];
                        $total_minutos = $row['estimacion_total'];
                        $id_cliente = $row['id_cliente'];
                        $id_factura = $row['id'];
                        $estado = $row['estado'];
                        $style_estado = "<img class='indicador_imagen' src='../img/noarreglado.png' alt='Imagen arreglado'>'";
                        if($estado == 2){
                            $style_estado = "<img class='indicador_imagen' src='../img/noarreglado.png' alt='Imagen arreglado'>'";
                        }
                        if($estado == 1){
                            $style_estado = "<img class='indicador_imagen' src='../img/arreglado.png' alt='Imagen arreglado'>'";

                        }
                        if($estado == 2){
                            $style_estado = "<img class='indicador_imagen' src='../img/entregado.png' alt='Imagen arreglado'>'";

                        }
                        $fecha_param = urlencode($fecha_entrega); // codificar la fecha como un parámetro GET
                        echo "<tr>";
                        echo "<td>".$style_estado."<a  href='detalle_cliente.php?id=".$id_cliente."&id_factura=".$id_factura."'>".$fecha_entrega."</a></td>";
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