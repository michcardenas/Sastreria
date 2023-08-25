    <?php 

    session_start();
    include_once("../conexion/database.php");
    $usuario= $_SESSION['usuario'];


    //directorio padre
    $currentDir = getcwd();
    chdir('..');
    $newDir = getcwd();
    $action_orden = "/actions/guardarorden.php";
    $ruta_guardar = $newDir.$action_orden;



    if(!isset($usuario)){
        header("location: login/login.php");

    }else {
    
        $id = isset ($_REQUEST['id'])?$_REQUEST['id']:"";
       
        // $id = $_REQUEST['mode'];
    
        if ($conexion) {
            $sql = mysqli_query($conexion, "SELECT * FROM clientes where id='$id'");
        
            /* ¿La consulta se ejecutó bien? */
            if ($sql) {
                $valore['existe'] = 0;
                while ($consulta = mysqli_fetch_array($sql)) {
                    $valore['existe'] = 1;
                    $id = $consulta['id'];
                    $nombre = $consulta['nombre'];
                    $telefono = $consulta['telefono'];
                }
            } else {
                echo mysqli_error($conexion);   
            }
        }
  
       
    
        include 'cabezera.php';
    ?>
 
    
            <!-- HTML !-->
        

   
    <div class="container">
            <div class="container-orden">
                <div class="info">
                <h3 class="subtitulos_cards">Informacion del cliente</h3>
                <input class="input readonly" readonly  type="text" name="txtname" id="txtname" value="<?php echo $nombre; ?>">
                <input class="input readonly" readonly type="number"  id="txttel"  name="txttel" value="<?php echo $telefono; ?>">
                <input class="input"  style="visibility: hidden;"  type="id"  id="id"  name="id" value="<?php echo $id; ?>">
                
                </div>

            </div>
                    
        </div>
        <div class="container orden">
            <h4>Detalle de orden</h4>
            <div class="table-responsive">
    <?php  
    date_default_timezone_set('America/Bogota');
    $fecha_actual = date("Y-m-d");
    $sql1 = mysqli_query($conexion, "SELECT * FROM ordenes 
    WHERE id_cliente='$id' 
    AND fecha_llegada_prenda >= DATE_SUB('$fecha_actual', INTERVAL 1 DAY) AND factura = 0 ;
    ");


    
$sql3 = mysqli_query($conexion, "SELECT SUM(cantidad) AS cantidad,SUM(estimacion) AS estimacion_total,SUM(valor) AS total_valor, COUNT(prenda) AS prenda_totales FROM ordenes WHERE id_cliente='$id' AND factura = 0 AND fecha_llegada_prenda >= DATE_SUB('$fecha_actual', INTERVAL 1 HOUR);");


    while($row = mysqli_fetch_array($sql3)){
        $valor_total     = $row['total_valor'];
        $prenda_totales     = $row['cantidad'];
        $estimacion_total     = $row['estimacion_total'];
        
        }

        $sql2 = mysqli_query($conexion, "SELECT MAX(id) AS ultimo_id FROM factura");

        while($row = mysqli_fetch_array($sql2)){
            $id_factura     = $row['ultimo_id'] + 1;
            
            
            
            }
    



    if ($sql1) {
        $valore['existe'] = 0;
        
       echo "<table class='responsive-table'>
              <tr>
                
                <th style='font-size: smaller;'>Prenda</th>
                <th style='font-size: smaller;'>Cantidad</th>
               
                <th style='font-size: smaller;'>Descripción</th>
                <th style='font-size: smaller;'>Valor</th>
                <th>Borrar</th>
              </tr>";
              
        while ($consulta = mysqli_fetch_array($sql1)) {
            $valore['existe'] = 1;
            $id = $consulta['id'];
            $cantidad = $consulta['cantidad'];
            $id_cliente = $consulta['id_cliente'];
            $prenda = $consulta['prenda'];
            $otro = $consulta['otro'];
            $descripcion_arreglo = $consulta['descripcion_arreglo'];
            $valor = $consulta['valor'];
            $factura_orden = $consulta['factura'];
            
            echo "<tr>
                   
                    <td>$prenda</td>
                    <td style='font-size: smaller;'>$cantidad</td>

                    
                    <td style='font-size: smaller;'style='white-space: pre-wrap;'>$descripcion_arreglo</td>
                    <td>$".number_format($valor, 0, '.', ',')."</td>
                    <td ><a  onclick='borrarRegistro($id)'><img class='basura' src='../img/basura.png' alt='basura'></a></td>
                  </tr>";
                   
        }
        
        echo "</table>";
    } else {
        echo mysqli_error($conexion);   
    }
?>
</div>
<input class="input" required type="text" id="estimacion_total" name="estimacion_total" value="<?php echo $estimacion_total; ?> " style="visibility: hidden;">
                    <input class="input" required type="text" id="estimacion_total" name="estimacion_total" value="<?php echo $factura_orden;  ?> " style="visibility: hidden;">
  <div class="container-orden factura">
        
                        
                    <h3 class="subtitulos_cards">Orden numero <?php echo $id_factura;  ?></h3>

                  <h6 class="subtitulos_factura"></h6>
                    
                  <div  class="input_orden">
                    <div class="input_total_individual" > <h6>Fecha de entrega</h6>   
                    <input required  type="date" name="fecha_entrega" id="fecha_entrega" >
                    </div>
                    <div class="input_total_individual" >
                    <h6>Prendas totales</h6>  
                    <input class="input" readonly type="number " required  id="prenda_totales"  name="prenda_totalesl" value="<?php echo $prenda_totales; ?>">
                    </div>
                    <div class="input_total_individual" >
                    <h6>Sub-total</h6>  
                    <input class="input" type="text " required  id="sub-total"  name="sub-total" value="<?php echo $valor_total; ?>">
                    </div>
                    <div class="input_total_individual" >
                    <h6>Franja horaria</h6>  
                    
                    <select required class="select_prenda" id="franja_horaria" name="franja_horaria">
                    <option value="">Seleccione</option>
                    <option value="AM">AM</option>
                    <option value="PM">PM</option>
                    
                    </select>
                    </div>
                    <div class="input_total_individual" >
                    <h6>Abono</h6>  
                    
                    <input class="input" type="text" placeholder="ingrese abono" id="abono"  name="abono" required>
                  
                <td> <h6>Tipo de pago</h6></td>

                <select  id="tipo_pago">
                <option value="" >---Seleccione---</option>

                    <option value="Efectivo" >Efectivo</option>
                    <option value="Nequi" >Nequi</option>
                    <option value="Daviplata">Daviplata</option>
                
                </select>
     
                    </div>
                    <div class="input_total_individual" >
                    <h6>Total</h6>  
                    
                    <input required class="input" type="text"  id="valor_total"  name="Total" >
                    </div>
                    
                    
                
                
                    
        </div>

                
                </div>
                </div>
                </div>

            <div class="botones_total">
            <button >
                <span class="button_top" id="guardar_factura"> Guardar
                </span>
                </button>
            <button  onclick="javascript:window.history.go(-1); return false;" >
                <span class="button_top" > Regresar
                </span>
                </button>
                </div>
        </div>
        
        </div>
        
     
       
    
    
        <input class="input" type="text" id="id_factura" name="otro" value="<?php echo $id_factura; ?>" style="visibility: hidden;">  
        <input class="input" type="text" id="id_cliente" name="otro" value="<?php echo $id_cliente;  ?>" style="visibility: hidden;">  
    <script src="../js/app.js" ></script>
    
    <script>
          function borrarRegistro(id) {
    if (confirm("¿Está seguro de que desea borrar este registro?")) {
        // Hacer la petición AJAX para borrar el registro
        $.ajax({
            url: "../callbacks/ordenes.php",
            type: "POST",
            data: "mode=borrar_prenda&id="+id,
            success: function(response) {
                if (response == 1) {
                    // Recargar la página para actualizar la tabla
                    location.reload();
                } else {
                    alert("Error al borrar el registro.");
                }
            }
        });
    }
}
$(document).ready(function() {
    $('#sub-total').each(function() {
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
    

    </body>

    </html>

    <?php  }
    ?>

