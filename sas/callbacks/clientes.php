<?php
include_once("../conexion/database.php");



$cel = isset($_POST['inputTel']) ? $_POST['inputTel'] : '';
$nom = isset($_POST['inputName']) ? $_POST['inputName'] : '';


switch($_REQUEST["mode"]){

    case 'buscar':
    if($conexion){
        $sql=mysqli_query($conexion,"SELECT * FROM clientes where telefono='$cel' OR nombre='$nom'");

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
    default:
    echo "no ingreso a ningun lado";
    break;
        }