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
    $fecha_actual = date('Y-m-d H:i:s');

    $sql1 = mysqli_query($conexion, "SELECT * FROM ordenes 
    WHERE id_cliente='$id' 
    AND fecha_llegada_prenda >= DATE_SUB('$fecha_actual', INTERVAL 1 HOUR) AND factura = 0 ;
    ");


    
$sql3 = mysqli_query($conexion, "SELECT SUM(estimacion) AS estimacion_total,SUM(valor) AS total_valor, COUNT(prenda) AS prenda_totales FROM ordenes WHERE id_cliente='$id' AND factura = 0 AND fecha_llegada_prenda >= DATE_SUB('$fecha_actual', INTERVAL 1 HOUR);");


    while($row = mysqli_fetch_array($sql3)){
        $valor_total     = $row['total_valor'];
        $prenda_totales     = $row['prenda_totales'];
        $estimacion_total     = $row['estimacion_total'];
        
        }

        $sql2 = mysqli_query($conexion, "SELECT MAX(id) AS ultimo_id FROM factura");

        while($row = mysqli_fetch_array($sql2)){
            $id_factura     = $row['ultimo_id'] + 1;
            
            
            
            }
    



    if ($sql1) {
        $valore['existe'] = 0;
        
       echo "<table>
              <tr>
                
                <th>Prenda</th>
               
                <th>Descripción</th>
                <th>Valor</th>
                <th>Borrar</th>
              </tr>";
              
        while ($consulta = mysqli_fetch_array($sql1)) {
            $valore['existe'] = 1;
            $id = $consulta['id'];
            $id_cliente = $consulta['id_cliente'];
            $prenda = $consulta['prenda'];
            $otro = $consulta['otro'];
            $descripcion_arreglo = $consulta['descripcion_arreglo'];
            $valor = $consulta['valor'];
            $factura_orden = $consulta['factura'];
            
            echo "<tr>
                   
                    <td>$prenda</td>
                    
                    <td style='white-space: pre-wrap;'>$descripcion_arreglo</td>
                    <td>$valor</td>
                    <td><a  onclick='borrarRegistro($id)'><img class='basura' src='../img/basura.png' alt='basura'></a></td>
                  </tr>";
                   
        }
        
        echo "</table>";
    } else {
        echo mysqli_error($conexion);   
    }
?>
</div>
  <div class="container-orden factura">
                    <div class="info">
                    <h3 class="subtitulos_cards">Confirmacion de factura</h3>
                    <h6 class="subtitulos_factura">Factura numero <?php echo $id_factura;  ?></h6>
                    <h6 class="subtitulos_factura">Prendas totales <?php echo $prenda_totales;   ?></h6>
                    <div class="input_total" >
                    <input class="input" type="text" id="estimacion_total" name="estimacion_total" value="<?php echo $estimacion_total; ?> " style="visibility: hidden;">
                    <input class="input" type="text" id="estimacion_total" name="estimacion_total" value="<?php echo $factura_orden;  var_dump($factura_orden)?> " style="visibility: hidden;">
                    <div class="input_total_individual" > <h6>Fecha de entrega</h6>   
                    <input   type="date" name="fecha_entrega" id="fecha_entrega" >
                    </div>
                    <div class="input_total_individual" >
                    <h6>Sub-total</h6>  
                    <input class="input" type="number"  id="sub-total"  name="sub-total" value="<?php echo $valor_total; ?>">
                    </div>
                    <div class="input_total_individual" >
                    <h6>Franja horaria</h6>  
                    
                    <select class="select_prenda" id="franja_horaria" name="franja_horaria">
                    <option value="">Seleccione</option>
                    <option value="AM">AM</option>
                    <option value="PM">PM</option>
                    
                    </select>
                    </div>
                    <div class="input_total_individual" >
                    <h6>Abono</h6>  
                    
                    <input class="input" type="number"  id="abono"  name="abono" required>
                    </div>
                    <div class="input_total_individual" >
                    <h6>Total</h6>  
                    
                    <input class="input" type="number"  id="valor_total"  name="Total" >
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

    </script>
    

    </body>

    </html>

    <?php  }
    ?>

