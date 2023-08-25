<?php
session_start();
include_once("../conexion/database.php");
$usuario= $_SESSION['usuario'];
$id_factura                = $_GET['id_factura'];



// Consulta a la base de datos
$consulta = "SELECT f.id_factura,f.estado, f.sub_total, f.abono, f.total, f.franja_horaria, f.fecha_entrega, c.nombre, c.telefono,o.prenda,o.otro,o.descripcion_arreglo,o.valor 
             FROM factura f
             JOIN clientes c ON f.id_cliente = c.id
             JOIN ordenes o ON o.factura = f.id_factura
             WHERE f.id_factura = $id_factura";
          

$resultado = mysqli_query($conexion, $consulta);


// Obtener los datos de la factura
$factura = mysqli_fetch_assoc($resultado);


// fecha actual
$fecha_actual = date('Y-m-d H:i:s');

// Cerrar la conexión a la base de datos


// Crear la factura en HTML
$html = '
<!DOCTYPE html>
<html>
<head>
<head>
        <!-- Required meta tags -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../style/stylechisgas.css">
        <link rel="shortcut icon" href="../img/taylor.png">
            <!-- Referencia a jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Referencia a jQuery UI -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/smoothness/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <!-- Bootstrap CSS -->
        <title>Inicio</title>
    </head>
</head>
<body>
<nav id="Guardar_fact" class="nav-index">
<h3 class="inicio" >Detalles de orden</h3>
<a  href="../index.php" ><img style="width: 3rem;" id="imagen_nav" class="imagen_nav" src="../img/sasindex.png" alt="index"></a>
<a class="inicio" href="../login/salirlogin.php">salir</a>
</nav>
<div  class="impresion">
<div class="container">
            <div class="container-factura">
<!-- Logo de la empresa -->
<img class="logo" src="../img/sasindex.png" alt="Logo de la empresa">
<div>

<tr>
<td> <h6>Numero de orden</h6></td>
<td><input class="input readonly factura" readonly  type="text" name="txtname" id="txtname" value="'.$factura['id_factura'].'"></td>
</tr>
<tr>
<td> <h6>Fecha</h6></td>
<td><input class="input readonly" readonly  type="text" name="txtname" id="txtname" value="'.$fecha_actual.'"></td>
</tr>
<tr>
<td> <h6>Nombre</h6></td>
<td><input class="input readonly" readonly  type="text" name="txtname" id="txtname" value="'.$factura['nombre'].'"></td>
</tr>
<tr>
<td> <h6>Telefono</h6></td>
<td><input class="input readonly" readonly  type="text" name="txtname" id="txtname" value="'.$factura['telefono'].'"></td>
</tr>
</div>
</div>
</div>

<div class="container">
<!-- Información de la factura -->
<div class="container-factura2">
<div class="container-factura-detalle">
<h6>Detalles arreglos/ alteraciones de ropa</h6>




';

// Imprimir la factura en el navegador
echo $html;
$consulta1 = "SELECT f.id_factura, f.sub_total, f.abono, f.total, f.franja_horaria, f.fecha_entrega, c.nombre, c.telefono,o.prenda,o.otro,o.descripcion_arreglo,o.valor,f.estado,o.cantidad,f.numero_prendas
             FROM factura f
             JOIN clientes c ON f.id_cliente = c.id
             JOIN ordenes o ON o.factura = f.id_factura
             WHERE f.id_factura = $id_factura";

// Ejecutamos la consulta y almacenamos los resultados en una variable $resultado
$resultado1 = mysqli_query($conexion, $consulta1);

// Comenzamos a construir el HTML de la tabla
$html1 = '<table style="width:5rem;">
    <thead>
        <tr>
            <th>Prenda</th>
            <th>cantidad</th>
            <th>Otro</th>
            <th>Descripcion Arreglo</th>
            <th>valor</th>
        </tr>
    </thead>
    <tbody>';

foreach ($resultado1 as $factura)
{
    $html1 .= '<tr>
        <td>' . $factura['prenda'] . '</td>
        <td>' . $factura['cantidad'] . '</td>
        <td>' . $factura['otro'] . '</td>
        <td>' . $factura['descripcion_arreglo'] . '</td>
        <td>$' .number_format( $factura['valor'], 0, '.', ',') . '</td>
    </tr>';
}

$html1 .= '

</tbody></table>

</div>
<div class="valores">
<table>
<tr>
<tr>

<td> <h6>Total prendas</h6><input class="input readonly total" readonly  type="text" name="txtname" id="txtname" value="'.$factura['numero_prendas'].'"></td>
</tr>
<td>
    <h6>sub-total</h6>
    <input class="input readonly total" readonly  type="text" name="txtname" id="txtname" value="$'.number_format($factura['sub_total'], 0, '.', ',').'">
</td>
</tr>
<tr>
    <td>
        <h6>Abono</h6>
        <input class="input readonly total" readonly  type="text" name="txtname" id="txtname" value="$'.number_format($factura['abono'], 0, '.', ',').'">
    </td>
</tr>
<tr>
    <td>
        <h6>Total</h6>
        <input class="input readonly total" readonly  type="text" name="txtname" id="txtname" value="$'.number_format($factura['total'], 0, '.', ',').'">
    </td>
</tr>

</tr>
</table>
</div>';

if ($factura['estado'] != 2) {
  $html1 .= '<div class="terminos">
  <tr class="fecha_entrega_real">
  <td> <h6>Fecha de entrega</h6></td>
  <td><input class="input readonly total" readonly  type="text" name="txtname" id="txtname" value="'.$fecha_sin_hora = date('Y-m-d', strtotime($factura['fecha_entrega'])).'/'.$factura['franja_horaria'].'"></td>
  </tr>
  <tr>
  <td> <h6>*Sus arreglos tienen garantia de 15 dias calendario a partir de la fecha de entrega (Segun terminos y condiciones)</h6</td>
  <td> <h6>*Despues de 30 dias a partir de la fecha de entrega no se responde por ropa que aun no se halla entregado</h6</td>
  </tr>
  </div>';
}

if ($factura['estado'] == 2) {
    $html1 .= '<div class="terminos">
    <tr class="fecha_entrega_real">
    <td> <h2 style="color:#9E4784;">CANCELADA</h2></td>
  
    </tr>
    
    </div>';
  }

$html1 .= '<button  style="margin-top:2rem;" >
<div id="Guardar_fact">
<span class="button_top"  ><a id="imprimir" >Guardar</a> 
</span>
</button>
<button  style="margin-top:2rem;" >
<span class="button_top" id="Guardar_fact" ><a target="_blank" id="enviar" href="https://api.whatsapp.com/send?phone=+57'.$factura['telefono'].'&text=Desde la sastrería Chisgas, le informamos que su prenda estára lista para ser recogida. Por favor, pase por nuestra tienda el '.$fecha_sin_hora = date('d-m-Y', strtotime($factura['fecha_entrega'])).' en el horario '.$factura['franja_horaria'].' para retirarla. ¡Le esperamos con su prenda lista para lucirla con estilo!.">Enviar mensaje</a>
</a> 
</span>
</button>
</div>
</div>
</div>
</div>';

echo $html1;


// Mostramos el HTML generado


// Cerramos la conexión a la base de datos

?>

<script>
var btnImprimir = document.getElementById("imprimir");
btnImprimir.addEventListener("click", function() {
  window.print();
});
  

</script>