<?php 

include_once("../conexion/database.php");

session_start();
$usuario= $_SESSION['usuario'];
if(!isset($usuario)){
    header("location: login/login.php");

}else {

    $id=$_REQUEST['prenda'];





    if($conexion){
                $sql=mysqli_query($conexion,"SELECT o.id,o.id_cliente,o.valor,o.estimacion,o.factura,o.prenda,o.otro,o.descripcion_arreglo,o.estado,c.nombre
                from ordenes o 
                join clientes c on o.id_cliente=c.id where o.id=$id;

            
                    ");
   
        while($row = mysqli_fetch_assoc($sql)) {
            $nombre = $row['nombre'];
            $prenda_id = $row['id'];
            $factura = $row['factura'];
            $prenda = $row['prenda'];
            $otro = $row['otro'];
            $descripcion_arreglo = $row['descripcion_arreglo'];
            $estimacion = $row['estimacion'];
            $estado = $row['estado'];
            $valor = $row['valor'];
            $id_cliente = $row['id_cliente'];
           

        }
        $consulta1 = "SELECT f.id_factura, f.sub_total, f.abono, f.total, f.franja_horaria, f.fecha_entrega, c.nombre, c.telefono,o.prenda,o.otro,o.descripcion_arreglo,o.valor,o.estimacion,o.estado,o.id
        FROM factura f
        JOIN clientes c ON f.id_cliente = c.id
        JOIN ordenes o ON o.factura = f.id_factura
        WHERE f.id = $factura";

        // Ejecutamos la consulta y almacenamos los resultados en una variable $resultado
        $resultado1 = mysqli_query($conexion, $consulta1);
        while($registro = mysqli_fetch_assoc($resultado1)) {
            $estados[] = $registro['estado'];
        }
       
        $estado_final = array_count_values($estados);

        $arreglado = (isset($estado_final[1]) ? $estado_final[1] : 0);
        $pendiente = (isset($estado_final[0]) ? $estado_final[0] : 0);
        $entregado = (isset($estado_final[2]) ? $estado_final[2] : 0);
        $estado_factura=0;
    if($arreglado != 0 && $pendiente == 0 && $entregado == 0 || $entregado > 0){
        $estado_factura=1;
    }
  
    if($arreglado == 0 && $pendiente == 0 && $entregado != 0){
        $estado_factura=2;
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
        echo $nombre;
        ?></h3>
        <a  href="../index.php" ><img style="width: 3rem;" id="imagen_nav" class="imagen_nav" src="../img/sasindex.png" alt="index"></a>

        <a class="inicio" href="../login/salirlogin.php">salir</a>
        </nav>
        <input class="input"  style="visibility: hidden;"  type="id"  id="id_cliente"  name="id_cliente" value="<?php echo $id_cliente; ?>">
        <input class="input"  style="visibility: hidden;"  type="id"  id="factura"  name="factura" value="<?php echo $factura; ?>">
        <input class="input"  style="visibility: hidden;"  type="id"  id="estado_factura"   value="<?php echo $estado_factura; ?>">


               <!-- HTML !-->
               <div  class="impresion">
<div class="container">
            <div class="container-factura">

<!-- Logo de la empresa -->
        <img class="logo" src="../img/sasindex.png" alt="Logo de la empresa">
        <div>

        <tr>
        <td> <h6>Numero de orden</h6></td>
        <td><input class="input readonly factura" readonly  type="text" name="prenda_id" id="prenda_id" value="<?php echo $prenda_id; ?>"></td>
        </tr>
        <tr>
        <td> <h6>Nombre</h6></td>
        <td><input class="input readonly" readonly  type="text" name="txtname" id="txtname" value="<?php echo $nombre; ?>"></td>
        </tr>
        <tr>
        <td> <h6>Prenda</h6></td>
        <td><input class="input readonly" readonly  type="text" name="txtname" id="txtname" value="<?php echo $prenda .'  '.$otro; ?>"></td>
        </tr>
        
      
    
        </div>
        </div>
 </div>

<div class="container">
<!-- Información de la factura -->
<div class="container-factura2">
<div class="container-factura-detalle">
<h6>Detalles arreglos/ alteraciones de ropa</h6>

<div>
        <textarea class="textarea" id="descripcion_arreglo"  placeholder="Descripción del arreglo"><?php echo $descripcion_arreglo; ?></textarea>


        <tr>
        <td> <h6>Valor $</h6></td>
        <td><input class="input  factura"   type="number"  id="valor" value="<?php echo $valor; ?>"></td>
        </tr>
        <tr>
        <td> <h6>Estimacion</h6></td>
        <td><input class="input factura"   type="number" id="estimacion" value="<?php echo $estimacion; ?>"></td>
        </tr>
      
        
        <select id="estado">
            <option value="0" <?php if ($estado == 0) { echo 'selected'; } ?>>Pendiente</option>
           <!-- <option value="3" <?php //if ($estado == 3) { echo 'selected'; } ?>>En Proceso</option> -->
            <option value="1" <?php if ($estado == 1) { echo 'selected'; } ?>>Arreglado</option>
            <option value="2" <?php if ($estado == 2) { echo 'selected'; } ?>>Entregado</option>
        </select>

            </tr>
        </div>
        </div>

<div><button  onclick="goBack()" style="margin-top:2rem;margin-left:2rem; " >
<span class="button_top" ><a >Atras</a> 
</span>
</button>

</div>
<div><button id="actualizar_prenda" style="margin-top:2rem;margin-left:2rem; " >
<span class="button_top" ><a  >Guardar</a> 
</span>
</button>

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