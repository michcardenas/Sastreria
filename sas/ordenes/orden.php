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
        $id_orden = isset ($_REQUEST['id_orden'])?$_REQUEST['id_orden']:"";
       
        // $id = $_REQUEST['mode'];
        if($id_orden!= "" || $id_orden!= "NULL"){
         
            $sql1 = mysqli_query($conexion, "SELECT * FROM ordenes where id='$id_orden'");
      
        
            /* ¿La consulta se ejecutó bien? */
            if ($sql1) {
                $valore['existe'] = 0;
                while ($consulta = mysqli_fetch_array($sql1)) {
                  
                    $valore['existe'] = 1;
                    $id_orden = $consulta['id'];
                    $descripcion_arreglo = $consulta['descripcion_arreglo'];
                    $valor = $consulta['valor'];
                   
                    
                }
            } else {
                echo mysqli_error($conexion);   
            }
        }
       
    
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
        <div class="container">
        
        <div class="container-orden orden">
        <h3 class="subtitulos_cards">Adicionar prenda</h3>
            <div class="info">
                
               
                <select class="select_prenda" id="select_prenda" name="select_prenda">
                <option value="">Seleccione prenda</option>
                <option value="blusa">Blusa</option>
                <option value="buzo">Buzo</option>
                <option value="camisa">Camisa</option>
                <option value="camiseta">Camiseta</option>
                <option value="chaqueta">Chaqueta</option>
                <option value="falda">Falda</option>
                <option value="pantalon">Pantalón</option>
                <option value="otros">Otros</option>
                </select>

                <input class="input" type="text" id="otro" name="otro" placeholder="Que prenda es?" style="visibility: hidden;">
                <input class="input" type="number" id="cantidad" name="cantidad" placeholder="cantidad?" oninput="if(value.length>3)value=value.slice(0,3)" autocomplete="off">
                    <textarea class="textarea" id="descripcion_arreglo" placeholder="Descripción del arreglo" maxlength="480"><?php 
                    $descripcion_arreglo = isset($descripcion_arreglo) ? $descripcion_arreglo : 'null';
                    if ($descripcion_arreglo !== 'null') {
                        echo $descripcion_arreglo;
                    } 
                ?></textarea>

                <div class="valor_center">
                <img id="billete" src="../img/tiempo.png" alt=""> 
                <input class="input valor" type="number" id="estimacion_min" name="estimacion_min" placeholder="Estimacion en min" oninput="if(value.length>3)value=value.slice(0,3)" autocomplete="off">
                </div>
                <!-- <select class="franja">
                <option value="">franja horaria</option>
                <option value="blusa">AM</option>
                <option value="otros">PM</option>
                </select> -->
                <div class="valor_center">
               <img id="billete" src="../img/billete.png" alt=""> <input class="input valor" type="text" id="valor" value="<?php $des_valor = isset ($valor)? $valor:"";  echo $des_valor; ?>" name="valor" placeholder="valor" >
               </div>


                


            
                
            </div>
          
        </div>
        <button >
                <span class="button_top" id="guardarorden"> Guardar
                </span>
                </button>
            <button  onclick="javascript:window.history.go(-1); return false;" >
                <span class="button_top" > Regresar
                </span>
                </button>
                <button >
                <span class="button_top" id="guardarorden"><a href="../ordenes/total.php?id=<?php echo $id; ?>">Terminar</a> 
                </span>
                </button>
        </div>
      
     
       
    
        <div id="dialog-confirm" title="Desea agregar otra prenda">
            
        </div>
    
  
    <script src="../js/app.js" ></script>
    <script>
        const select = document.querySelector('.select_prenda');
    const input = document.querySelector('#otro');
    
    select.addEventListener('change', () => {
        if (select.value === 'otros') {
        input.style.visibility = 'visible';
        } else {
        input.style.visibility = 'hidden';
        }
    });



    </script>
    

    </body>

    </html>

    <?php  }
    ?>

