<?php 

include_once("../conexion/database.php");

session_start();
$usuario= $_SESSION['usuario'];
if(!isset($usuario)){
    header("location: login/login.php");

}else {

    $id=$_REQUEST['id'];
    $id_factura=$_REQUEST['id_factura'];

    date_default_timezone_set('America/Bogota');
    $fecha_actual = date("Y-m-d H:i:s");



    if($conexion){

               $sql="SELECT n.nombre, f.franja_horaria, n.telefono,f.id_cliente,f.id,
               SUM(o.valor) sub_total,f.abono,f.total,f.estado,f.fecha_entrega
                     FROM factura f
                     JOIN clientes n ON f.id_cliente = n.id
                     JOIN ordenes o on o.factura = f.id 
                     WHERE f.id = $id_factura
      ORDER BY  CASE WHEN f.franja_horaria LIKE '%am' THEN 0 ELSE 1 END, f.franja_horaria";

$resultado = mysqli_query($conexion,$sql);

while($row = mysqli_fetch_assoc($resultado)) {
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
        WHERE f.id = $id_factura";

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
        
        
        // if($aux == 1) {
        //     $estado_final = 1;
        // } else {
        //     $estado_final = 0;
        // }
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
// Declara un array para contar cada caso
$contadores = [
    'Pendiente' => 0,
    'Arreglado' => 0,
    'Entregado' => 0,
    'En proceso' => 0,
    'No definido' => 0,
];
foreach ($resultado1 as $factura) { 
    
    switch ($factura['estado']) {
        case '0':
            $estado_orden = "Pendiente";
            $contadores[$estado_orden]++;  // Incrementa el contador para 'Pendiente'
            break;
        case '1':
            $estado_orden = "Arreglado";
            $contadores[$estado_orden]++;  // Incrementa el contador para 'Arreglado'
            break;
        case '2':
            $estado_orden = "Entregado";
            $contadores[$estado_orden]++;  // Incrementa el contador para 'Entregado'
            break;
        case '3':
            $estado_orden = "En proceso";
            $contadores[$estado_orden]++;  // Incrementa el contador para 'En proceso'
            break;
        default:
            $estado_orden = "No definido";
            $contadores[$estado_orden]++;  // Incrementa el contador para 'No definido'
            break;
    }
      ?>
   <tr>
    <td><a   href="detalle_prenda.php?prenda=<?php echo $factura['id']; ?>"><?php echo $factura['prenda']; ?></a></td>
    <td><?php echo $factura['estimacion']; ?> Min</td>
    <td><?php echo $estado_orden; ?></td>
</tr>

<?php } 
//conteo
$pendiente = $contadores['Pendiente'];
$arreglado = $contadores['Arreglado'];
$entregado = $contadores['Entregado'];
$enproceso = $contadores['En proceso'];
$no_definido = $contadores['No definido'];
$esconder = '';
$alert ='id="atras"';
$esconder_saldo = 'display: none;';
if($pendiente== 0 && $arreglado== 0 && $entregado > 0 ){
    $esconder = 'display: none;';
    $alert ='id="atras_confirm"';
    $esconder_saldo = '';
}
$saldo =$sub_total - $abono;
 ?>

</tbody>
</table>
<div>

        <tr>
        <td> <h3>Sub Total</h3></td>
        <td><input class="input  factura" readonly   type="text"  id="sub-total" value="<?php echo $sub_total; ?>"></td>
        </tr>
        <tr>
        <td> <h3>Abono</h3><p style="font-size:11px;color:blue;">Puedes aumentar este valor si se hizo otro abono</p></td>
        <td><input class="input factura"   type="text" id="abono_inicial" value="<?php echo $abono; ?>"></td>
        </tr>
        <tr>
        <td ><h3>Saldo</h3> <p style="font-size:11px;color:blue;">Ingresa solo si vas a entregar</p></td>
        <td ><input class="input factura" type="text"  id="saldo" value="0"></td>
       </tr>
        <tr>
        <tr>
        <td> <h3>Tipo de pago</h3></td>

        <select   id="tipo_pago">
            <option value="Efectivo" >Efectivo</option>
            <option value="Nequi" >Nequi</option>
            <option value="Daviplata">Daviplata</option>
          
        </select>
        </tr>
        <td> <h3>Total</h3></td>
        <td><input class="input factura"   type="text" id="valor_total" value="<?php echo $total; ?>"></td>
        </tr>
        <td><input class="input factura"  readonly type="text" id="fecha_actual" value="<?php echo $fecha_actual; ?>"></td>

      
        </div>
        </div>

<div><button  style="margin-top:2rem;margin-left:2rem; <?php  echo $esconder ?>  " >
<span class="button_top" ><a id="actualizar_factura" >Guardar</a> 
</span>
</button>

</div>
<div><button  <?php  echo $alert ?>    style="margin-top:2rem;margin-left:2rem; " >
<span class="button_top" ><a >Atras</a> </div></button>
<div><button  style="margin-top:2rem;margin-left:2rem; " >
<span class="button_top" ><a id="entregar">Entregar</a> </div>
  <script
    src="https://code.jquery.com/jquery-3.6.1.js"
    integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
    crossorigin="anonymous">
    
  </script>
  <script src="../js/app.js" ></script>
  

</body>

</html>

<?php  }}  ?>

<script>
    $(document).ready(function() {
    $('#sub-total,#abono_inicial,#valor_total').each(function() {
        // obtener el valor actual del campo
        var valor = $(this).val();

        // remover cualquier formato existente (puntos, comas y símbolo de moneda)
        valor = parseFloat(valor.replace(/[^0-9-.]/g, ''));

        // verificar si el valor es un número
        if (!isNaN(valor)) {
            // formatear el número
            valor = valor.toLocaleString('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 });

            // establecer el valor formateado de nuevo en el campo
            $(this).val(valor);
        }
    });
});
</script>