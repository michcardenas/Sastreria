<?php  
require('../conexion/database.php');
$mode = isset ($_POST['mode'])?$_POST['mode']:"";
switch($_REQUEST["mode"]){
    case 'guardarorden':
        $nombre                 = $_POST['nombre'];
        $tel                    = $_POST['tel'];
        $prenda                 = $_POST['prenda'];
        $otro                   = $_POST['otro'];
        $descripcion_arreglo    = $_REQUEST['descripcion_arreglo'];
        $valor                  = $_POST['valor'];
        $id                  = $_POST['id'];
        $estimacion_min                  = $_POST['estimacion_min'];
        
        function insertarOrden($id, $prenda, $otro, $descripcion_arreglo, $valor) {
            // Obtener la conexión a la base de datos desde el archivo de conexión
            require '../conexion/database.php';
            global $estimacion_min;
            $fecha_actual = date('Y-m-d H:i:s');
            // Construir la consulta SQL para insertar un registro en la tabla "ordenes"
            $sql = "INSERT INTO ordenes (id_cliente, prenda, otro, descripcion_arreglo, valor, estimacion,fecha_llegada_prenda) VALUES ('$id', '$prenda', '$otro', '$descripcion_arreglo', '$valor','$estimacion_min','$fecha_actual')";
            
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
          
          
          insertarOrden($id, $prenda, $otro, $descripcion_arreglo, $valor);

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
              $sub_total                  = $_POST['sub_total'];
              $fecha_entrega                  = $_POST['fecha_entrega'];
              $franja_horaria                  = $_POST['franja_horaria'];
              $valor_total                  = $_POST['valor_total'];
              $estimacion_total                  = $_POST['estimacion_total'];
              $abono                  = $_POST['abono'];
              $factura_orden                  = $_POST['factura_orden'];
              
            
      
              function guardar_orden( $id_cliente,$id_factura, $sub_total,$fecha_entrega,$franja_horaria,$valor_total, $estimacion_total, $abono) {
                  // Obtener la conexión a la base de datos desde el archivo de conexión
                  require '../conexion/database.php';
                  $fecha_actual = date('Y-m-d');
                  // Construir la consulta SQL para eliminar un registro en la tabla "ordenes"
                  $sql = "INSERT INTO factura (id_cliente, id_factura, sub_total, fecha_entrega, franja_horaria, total, estimacion_total, abono)
                  VALUES ('$id_cliente', '$id_factura', '$sub_total', '$fecha_entrega', '$franja_horaria', '$valor_total', '$estimacion_total', '$abono')";
                   
                   $sql1 = "UPDATE ordenes SET factura = '$id_factura' WHERE id_cliente = '$id_cliente' AND factura < 1 AND fecha_llegada_prenda >= DATE_SUB('$fecha_actual', INTERVAL 1 HOUR);
                   ";
                 

                 

                  
                  // Ejecutar la consulta SQL
                  global $conexion;
                  if (mysqli_query($conexion, $sql) && mysqli_query($conexion, $sql1)) {
                    
                    echo 1;
                  } else {
                    echo 0;
                  }
                  
                  // Cerrar la conexión a la base de datos
                  mysqli_close($conexion);
              }
              
              guardar_orden($id_cliente,$id_factura, $sub_total,$fecha_entrega,$franja_horaria,$valor_total, $estimacion_total, $abono);
                
           
      
              break;
              case 'actualizar_factura':
          
                $id_factura = $_POST['id_factura'];
                $sub_total = $_POST['sub_total'];
                $abono = $_POST['abono'];
                $total = $_POST['total'];
                $estado = $_POST['estado']; 
          
               
                
              
        
                function actualizar_orden(  $id_factura,$sub_total, $abono,$total,$estado) {
                    // Obtener la conexión a la base de datos desde el archivo de conexión
                    require '../conexion/database.php';
                    
                     $sql1 = "UPDATE factura SET sub_total = '$sub_total',abono = '$abono',total = '$total',estado = '$estado' WHERE id = '$id_factura';
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
                
                actualizar_orden($id_factura,$sub_total, $abono,$total,$estado);
                  
             
        
                break;
                case 'actualizar_prenda':
          
                  $prenda_id = $_POST['prenda_id'];
                  $descripcion_arreglo = $_POST['descripcion_arreglo'];
                  $valor = $_POST['valor'];
                  $estimacion = $_POST['estimacion'];
                  $estado = $_POST['estado']; 
            
                 
                  
                
          
                  function actualizar_orden(  $prenda_id,$descripcion_arreglo, $valor,$estimacion,$estado) {
                      // Obtener la conexión a la base de datos desde el archivo de conexión
                      require '../conexion/database.php';
                      
                       $sql1 = "UPDATE ordenes SET descripcion_arreglo = '$descripcion_arreglo',valor = '$valor',estimacion = '$estimacion',estado = '$estado' WHERE id = '$prenda_id';
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
                  
                  actualizar_orden($prenda_id,$descripcion_arreglo, $valor,$estimacion,$estado);
                    
               
          
                  break;
}


?>