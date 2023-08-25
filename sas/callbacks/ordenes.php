<?php  
require('../conexion/database.php');
date_default_timezone_set('America/Bogota');
$fecha_actual = date("Y-m-d");
$mode = isset ($_POST['mode'])?$_POST['mode']:"";
switch($_REQUEST["mode"]){
 
  case 'guardarorden':
        $nombre                 = $_POST['nombre'];
        $tel                    = $_POST['tel'];
        $prenda                 = $_POST['prenda'];
        $otro                   = $_POST['otro'];
        $descripcion_arreglo    = $_REQUEST['descripcion_arreglo'];
        $valor                  = $_POST['valor'];
        $id                     = $_POST['id'];
        $estimacion_min         = $_POST['estimacion_min'];
        $cantidad               = $_POST['cantidad'];

        // Remover signo de dólar y punto
        $valor = preg_replace('/[^0-9]/', '', $valor);
        $valor = intval($valor);
        
        
        
      
        

    
                
        function insertarOrden($id, $prenda, $otro, $descripcion_arreglo, $valor,$cantidad) {
            // Obtener la conexión a la base de datos desde el archivo de conexión
            require '../conexion/database.php';
            global $estimacion_min;
            $fecha_actual = date('Y-m-d H:i:s');
            // Construir la consulta SQL para insertar un registro en la tabla "ordenes"
            $sql = "INSERT INTO ordenes (id_cliente, prenda, otro, descripcion_arreglo, valor, estimacion,fecha_llegada_prenda,cantidad) VALUES ('$id', '$prenda', '$otro', '$descripcion_arreglo', '$valor','$estimacion_min','$fecha_actual','$cantidad')";
       
            // Ejecutar la consulta SQL
            global $conexion;
            if (mysqli_query($conexion, $sql)) {
              echo 1;
          } else {
              echo "Error: " . mysqli_error($conexion);
          }
          
            
            // Cerrar la conexión a la base de datos
            mysqli_close($conexion);
          }
          
          
          insertarOrden($id, $prenda, $otro, $descripcion_arreglo, $valor,$cantidad);

        break;

        case 'borrar_prenda':
          
            $id                  = $_POST['id'];
          
    
            function borrar_orden($id) {
                // Obtener la conexión a la base de datos desde el archivo de conexión
                require '../conexion/database.php';
                
                // Construir la consulta SQL para eliminar un registro en la tabla "ordenes"
                $sql = "DELETE FROM ordenes WHERE id = $id";
                
                // Ejecutar la consulta SQL
                global $conexion;
                if (mysqli_query($conexion, $sql)) {
                  echo 1;
                } else {
                  echo 0;
                }
                
                // Cerrar la conexión a la base de datos
                mysqli_close($conexion);
            }
            
              borrar_orden($id);
              
         
    
            break;
            case 'guardar_factura':
          
              $id_cliente                = $_POST['id'];
              $id_factura                  = $_POST['id_factura'];
              $fecha_entrega                  = $_POST['fecha_entrega'];
              $franja_horaria                  = $_POST['franja_horaria'];
              $estimacion_total                  = $_POST['estimacion_total'];
              $factura_orden                  = $_POST['factura_orden'];
              $tipo_pago                  = $_POST['tipo_pago'];
              $cantidad                  = $_POST['cantidad'];
              $abono = $_POST['abono'];
              $valor_total = $_POST['valor_total'];
              $sub_total = $_POST['sub_total'];
            // Remover signo de dólar y punto
                $abono = preg_replace('/[^0-9]/', '', $abono);
                $abono = intval($abono);
                $valor_total = preg_replace('/[^0-9]/', '', $valor_total);
                $valor_total = intval($valor_total);

                $sub_total = preg_replace('/[^0-9]/', '', $sub_total);
                $sub_total = intval($sub_total);


                $hoy= date('Y-m-d H:i:s');

      
              function guardar_orden( $id_cliente,$id_factura, $sub_total,$fecha_entrega,$franja_horaria,$valor_total, $estimacion_total, $abono,$tipo_pago,$fecha_actual,$cantidad) {
                  // Obtener la conexión a la base de datos desde el archivo de conexión
                  require '../conexion/database.php';
                  $fecha_actual = date('Y-m-d');
                  // Construir la consulta SQL para eliminar un registro en la tabla "ordenes"
                  $sql = "INSERT INTO factura (id_cliente, id_factura, sub_total, fecha_entrega, franja_horaria, total, estimacion_total, abono,tipo_abono,fecha_abono,numero_prendas)
                  VALUES ('$id_cliente', '$id_factura', '$sub_total', '$fecha_entrega', '$franja_horaria', '$valor_total', '$estimacion_total', '$abono','$tipo_pago','$fecha_actual',$cantidad)";
     
                   $sql1 = "UPDATE ordenes SET factura = '$id_factura' WHERE id_cliente = '$id_cliente' AND factura < 1 AND fecha_llegada_prenda >= DATE_SUB('$fecha_actual', INTERVAL 1 HOUR);
                   ";
                   $sql2 = "INSERT INTO caja (abono,id_orden,fecha)
                   VALUES ('$abono', '$id_factura', '$fecha_actual');
                     ";
           

                  
                  // Ejecutar la consulta SQL
                  global $conexion;
                  if (mysqli_query($conexion, $sql) && mysqli_query($conexion, $sql1) && mysqli_query($conexion, $sql2)) {
                    
                    echo 1;
                  } else {
                    echo 0;
                  }
                  
                  // Cerrar la conexión a la base de datos
                  mysqli_close($conexion);
              }
              
              guardar_orden($id_cliente,$id_factura, $sub_total,$fecha_entrega,$franja_horaria,$valor_total, $estimacion_total, $abono,$tipo_pago,$fecha_actual,$cantidad);
                
           
      
              break;
              case 'actualizar_factura':
          
                $id_factura = $_POST['id_factura'];
                $sub_total = $_POST['sub_total'];
                $abono = $_POST['abono'];
                $total = $_POST['total'];
                $hoy =date('Y-m-d H:i:s');
                $estado_factura = $_POST['estado_factura'];
          
               
                
              
        
                function actualizar_orden(  $id_factura,$sub_total, $abono,$total,$hoy, $estado_factura) {
                    // Obtener la conexión a la base de datos desde el archivo de conexión
                    require '../conexion/database.php';
                    
                     $sql1 = "UPDATE factura SET sub_total = '$sub_total',abono = '$abono',estado = '$estado_factura',total = '$total'WHERE id = '$id_factura';
                     ";
                       $sql2 = "UPDATE caja SET abono = '$abono',fecha = '$hoy'WHERE id_orden = '$id_factura';
                       ";
                     
                   
  
                
                    
                    // Ejecutar la consulta SQL
                    global $conexion;
                    if ( mysqli_query($conexion, $sql1) && mysqli_query($conexion, $sql2)) {
                      
                      echo 1;
                    } else {
                      echo 0;
                    }
                    
                    // Cerrar la conexión a la base de datos
                    mysqli_close($conexion);
                }
                
                actualizar_orden($id_factura,$sub_total, $abono,$total,$hoy, $estado_factura);
                  
             
        
                break;
                case 'entregar':
          
                  $id_factura = $_POST['id_factura'];
                  $fecha_actual = $_POST['fecha_actual'];
                  $saldo = intval($_POST['saldo']);
                
            
                 
                
          
                  function actualizar_orden(  $id_factura,$fecha_actual,$saldo) {
                      // Obtener la conexión a la base de datos desde el archivo de conexión
                      require '../conexion/database.php';
                      
                       $sql1 = "UPDATE factura SET estado = 2,fecha_facturacion = '$fecha_actual' WHERE id = '$id_factura';
                       ";
                       $sql2 = "UPDATE ordenes SET estado = 2,fecha_entrega = '$fecha_actual' WHERE id = '$id_factura';
                       ";
                       $sql3 = "UPDATE caja SET saldo = '$saldo',fecha_saldo = '$fecha_actual' WHERE id_orden = '$id_factura';
                       ";
                     
                     

                     
    
                      
                      // Ejecutar la consulta SQL
                      global $conexion;
                      if ( mysqli_query($conexion, $sql1) && mysqli_query($conexion, $sql2) && mysqli_query($conexion, $sql3) ) {
                        
                        echo 1;
                      } else {
                        echo 0;
                      }
                      
                      // Cerrar la conexión a la base de datos
                      mysqli_close($conexion);
                  }
                  
                  actualizar_orden($id_factura,$fecha_actual,$saldo);
                    
               
          
                  break;
                case 'actualizar_prenda':
          
                  $prenda_id = $_POST['prenda_id'];
                  $descripcion_arreglo = $_POST['descripcion_arreglo'];
                  $valor = $_POST['valor'];
                  $estimacion = $_POST['estimacion'];
                  $estado = $_POST['estado']; 
                  $estado_factura = $_POST['estado_factura']; 
                  $factura = $_POST['factura']; 

            
                 
                  
                
          
                  function actualizar_orden(  $prenda_id,$descripcion_arreglo, $valor,$estimacion,$estado,$estado_factura,$factura) {
                      // Obtener la conexión a la base de datos desde el archivo de conexión
                      require '../conexion/database.php';
                      
                       $sql1 = "UPDATE ordenes SET descripcion_arreglo = '$descripcion_arreglo',valor = '$valor',estimacion = '$estimacion',estado = '$estado' WHERE id = '$prenda_id';
                       ";
                     
                     $sql2 = "UPDATE factura SET estado = '$estado_factura' WHERE id = '$factura';
                     ";
                   
                     
    
                      
                      // Ejecutar la consulta SQL
                      global $conexion;
                      if ( mysqli_query($conexion, $sql1) && mysqli_query($conexion, $sql2)) {
                        
                        echo 1;
                      } else {
                        echo 0;
                      }
                      
                      // Cerrar la conexión a la base de datos
                      mysqli_close($conexion);
                  }
                  
                  actualizar_orden($prenda_id,$descripcion_arreglo, $valor,$estimacion,$estado,$estado_factura,$factura);
                    
            
          
                  break;
                 
                    case 'facturar':
              
                      $id_facturaa = $_POST['id_facturaa'];
                      $tipo_pago = $_POST['tipo_pago'];
           
                

                      
                    
              
                      function facturar( $id_facturaa,$tipo_pago,$fecha_actual) {
                          // Obtener la conexión a la base de datos desde el archivo de conexión
                          require '../conexion/database.php';
                          
                           $sql1 = "UPDATE factura SET estado = 2 ,tipo_facturacion = '$tipo_pago',fecha_facturacion = '$fecha_actual'  WHERE id = '$id_facturaa';
                           ";
                         
        
                         
        
                          
                          // Ejecutar la consulta SQL
                          global $conexion;
                          if ( mysqli_query($conexion, $sql1)) {
                            
                            echo 1;
                          } else {
                            echo 0;
                          }
                          
                          // Cerrar la conexión a la base de datos
                          mysqli_close($conexion);
                      }
                      
                      facturar($id_facturaa,$tipo_pago,$fecha_actual);
                        
                   
              
                      break;
}


?>