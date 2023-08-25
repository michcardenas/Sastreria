<?php
include_once("../conexion/database.php");



$cel = isset($_POST['inputTel']) ? $_POST['inputTel'] : '';
$nom = isset($_POST['inputName']) ? $_POST['inputName'] : '';



switch($_REQUEST["mode"]){

    case 'buscar':
    if($conexion){
       
        $sql=mysqli_query($conexion,"SELECT * FROM clientes WHERE telefono = $cel OR nombre = '$nom'");

        /* ¿La consulta se ejecutó bien? */
        if($sql){
            $valore['existe'] = 0;
            while($consulta = mysqli_fetch_array($sql))
            {
                $valore['existe'] = 1;
                $valore['id'] = $consulta['id'];
                $valore['nombre'] = $consulta['nombre'];
                $valore['telefono'] = $consulta['telefono'];
                
            }
            $valore = json_encode($valore);
            echo $valore;
        } else {
            echo mysqli_error($conexion);   
        }
        }
break;
case 'guardar':
        

    if($conexion){
        $sql=mysqli_query($conexion,"INSERT INTO clientes(telefono,nombre)VALUES($cel,'$nom')");
        /* ¿La consulta se ejecutó bien? */
            if($sql > 0){
               
                $mensaje =1;
                echo $mensaje;
                            
    
                }else{
                    echo 0;   
                }
        
            
            }else{
    
                echo "Error: La conexión no existe";
            }  
            
    break;
    case 'editar':
        $id = $_REQUEST['id'];
        $nom = $_REQUEST['txtname'];
        $cel = $_REQUEST['txttel'];

        if($conexion){
            $sql=mysqli_query($conexion,"UPDATE clientes SET nombre='$nom',telefono=$cel  WHERE id=$id ");
            /* ¿La consulta se ejecutó bien? */
                if($sql > 0){
                   $act="se ha acutalizado correctamente";
                    $mensaje =1;
                    if ($mensaje == 1) {
                        echo "Se ha actualizado con éxito";
                        header("Refresh: 1; URL=../ordenes/editar_cliente.php?id=$id&mensaje=$act");
                        exit();
                    }
                                
        
                    }else{
                        echo 0;   
                    }
            
                
                }else{
        
                    echo "Error: La conexión no existe";
                }  
                
        break;
    case 'buscar_factura':
        if ($conexion) {

            if ($cel == NULL){
                $cel = "NULL";
            }

            $consulta01 = "SELECT c.nombre nombre, f.id id, f.estado estado FROM clientes c JOIN factura f ON f.id_cliente = c.id WHERE   f.estado = 1 and telefono= $cel OR nombre='$nom'";

            $sql = mysqli_query($conexion, $consulta01);
            
            
        
            if ($sql) {
                $valores = array();
                while ($consulta = mysqli_fetch_assoc($sql)) {
                    $valores[] = array(
                        'nombre' => $consulta['nombre'],
                        'id' => $consulta['id'],
                        'estado' => $consulta['estado']
                    );
                }
                $respuesta = array('existe' => count($valores), 'valores' => $valores);
                echo json_encode($respuesta);
            } else {
                echo mysqli_error($conexion);
            }
        }
        break;
    
    
    default:
    echo "no ingreso a ningun lado";
    break;
        }