<?php 

include_once("../conexion/database.php");

session_start();
$usuario= $_SESSION['usuario'];
if(!isset($usuario)){
    header("location: login/login.php");

}else {

    $id=$_REQUEST['id'];
    $id_factura=$_REQUEST['id_factura'];




    if($conexion){
                $sql=mysqli_query($conexion,"SELECT n.nombre, f.franja_horaria, n.telefono,f.id_cliente,f.id,f.sub_total,f.abono,f.total,f.estado,f.fecha_entrega
                FROM factura f
                JOIN clientes n ON f.id_cliente = n.id
                WHERE f.id_factura = $id_factura
                ORDER BY CASE WHEN f.franja_horaria LIKE '%am' THEN 0 ELSE 1 END, f.franja_horaria;

            
                    ");
   
        while($row = mysqli_fetch_assoc($sql)) {
            $nombre = $row['nombre'];
            $franja_horaria = $row['franja_horaria'];
            $id = $row['id'];
            $telefono = $row['telefono'];
            $sub_total = $row['sub_total'];
            $abono = $row['abono'];
            $total = $row['total'];
            $estado = $row['estado'];
            $fecha_entrega = $row['fecha_entrega'];


        }
        $fecha_sin_hora = date('Y-m-d', strtotime($fecha_entrega));
        $consulta1 = "SELECT f.id_factura, f.sub_total, f.abono, f.total, f.franja_horaria, f.fecha_entrega, c.nombre, c.telefono,o.prenda,o.otro,o.descripcion_arreglo,o.valor,o.estimacion,o.estado,o.id
        FROM factura f
        JOIN clientes c ON f.id_cliente = c.id
        JOIN ordenes o ON o.factura = f.id_factura
        WHERE f.id_factura = $id_factura";

        // Ejecutamos la consulta y almacenamos los resultados en una variable $resultado
        $resultado1 = mysqli_query($conexion, $consulta1);
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
        echo $nombre;
        ?></h3>
        <a  href="../index.php" ><img style="width: 3rem;" id="imagen_nav" class="imagen_nav" src="../img/sasindex.png" alt="index"></a>

        <a class="inicio" href="../login/salirlogin.php">salir</a>
        </nav>
        <input class="input"  style="visibility: hidden;"  type="id"  id="fecha_sin_hora"  name="fecha_sin_hora" value="<?php echo $fecha_sin_hora; ?>">

               <!-- HTML !-->
               <div  class="impresion">
<div class="container">
            <div class="container-factura">
<!-- Logo de la empresa -->
        <img class="logo" src="../img/sasindex.png" alt="Logo de la empresa">
        <div>

        <tr>
        <td> <h6>Numero de orden</h6></td>
        <td><input class="input readonly factura" readonly  type="text" name="txtname" id="id_facturaa" value="<?php echo $id; ?>"></td>
        </tr>
        <tr>
        <td> <h6>Nombre</h6></td>
        <td><input class="input readonly" readonly  type="text" name="txtname" id="txtname" value="<?php echo $nombre; ?>"></td>
        </tr>
      
        <tr>
        <td> <h6>Telefono</h6></td>
        <td><input class="input readonly" readonly  type="text" name="txtname" id="txtname" value="<?php echo $telefono; ?>"></td>
        </tr>
        </div>
        </div>
 </div>

<div class="container">
<!-- Información de la factura -->
<div class="container-factura2">
<div class="container-factura-detalle">
<h6>Detalles arreglos/ alteraciones de ropa</h6>
<table>
    <thead>
        <tr>
            <th>Prenda</th>
            
            <th>Estimacion</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
<?php

foreach ($resultado1 as $factura) { 
    
    switch ($factura['estado']) {
        case '0':
            $estado_orden = "Pendiente";
            break;
        case '1':
            $estado_orden = "Arreglado";
            break;
        case '2':
            $estado_orden = "Entregado";
            break;
        case '3':
            $estado_orden = "En proceso";
            break;

        
        default:
        $estado_orden = "No definido";
            break;
    }
      ?>
   <tr>
    <td><a   href="detalle_prenda.php?prenda=<?php echo $factura['id']; ?>"><?php echo $factura['prenda']; ?></a></td>
    <td><?php echo $factura['estimacion']; ?> Min</td>
    <td><?php echo $estado_orden; ?></td>
</tr>

<?php } ?>

</tbody>
</table>
<div>

        <tr>
        <td> <h6>Sub Total</h6></td>
        <td><input class="input  factura"   type="number"  id="sub-total" value="<?php echo $sub_total; ?>"></td>
        </tr>
        <tr>
        <td> <h6>Abono</h6></td>
        <td><input class="input factura"   type="number" id="abono" value="<?php echo $abono; ?>"></td>
        </tr>
      
        <tr>
        <td> <h6>Total</h6></td>
        <td><input class="input factura"   type="number" id="valor_total" value="<?php echo $total; ?>"></td>
        </tr>
        <tr>
        <select id="estado">
            <option value="0" <?php if ($estado == 0) { echo 'selected'; } ?>>Pendiente</option>
            <option value="3" <?php if ($estado == 3) { echo 'selected'; } ?>>En Proceso</option>
            <option value="1" <?php if ($estado == 1) { echo 'selected'; } ?>>Arreglado</option>
            <option value="2" <?php if ($estado == 2) { echo 'selected'; } ?>>Entregado</option>
        </select>
            </tr>
        </div>
        </div>

<div><button  style="margin-top:2rem;margin-left:2rem; " >
<span class="button_top" ><a id="actualizar_factura" >Guardar</a> 
</span>
</button></div>
  <script
    src="https://code.jquery.com/jquery-3.6.1.js"
    integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
    crossorigin="anonymous">
    
  </script>
  <script src="../js/app.js" ></script>
  

</body>

</html>

<?php  }}  ?>