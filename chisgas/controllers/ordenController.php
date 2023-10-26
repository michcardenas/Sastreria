<?php
// clientesController.php

// Aquí podrías incluir el modelo
include '../model/ordenModel.php';
session_start();

// Comprobar el tipo de acción que se va a realizar (crear o buscar)
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;



header('Content-Type: application/json');

if ($action == 'agregar_prenda') {
    $cliente_id = isset($_POST['cliente_id']) ? $_POST['cliente_id'] : null;
    $nombre_prenda = isset($_POST['nombre_prenda']) ? $_POST['nombre_prenda'] : null;
    $prendas_numero = isset($_POST['prendas_numero']) ? $_POST['prendas_numero'] : null;
    $descripcion_arreglo = isset($_POST['descripcion_arreglo']) ? $_POST['descripcion_arreglo'] : null;
    $tiempo_estimado = isset($_POST['tiempo_estimado']) ? $_POST['tiempo_estimado'] : null;
    $valor_prenda = isset($_POST['valor_prenda']) ? $_POST['valor_prenda'] : null;
    $estado = isset($_POST['estado']) ? $_POST['estado'] : null;

    $errorFields = [];

    if (empty($cliente_id)) {
        $errorFields[] = 'cliente_id';
    }
    if (empty($nombre_prenda)) {
        $errorFields[] = 'nombre_prenda';
    }
    if (empty($prendas_numero)) {
        $errorFields[] = 'prendas_numero';
    }
    if (empty($descripcion_arreglo)) {
        $errorFields[] = 'descripcion_arreglo';
    }
    if (empty($tiempo_estimado)) {
        $errorFields[] = 'tiempo_estimado';
    }
    if (empty($valor_prenda)) {
        $errorFields[] = 'valor_prenda';
    }
    if (empty($estado)) {
        $errorFields[] = 'estado';
    }
    
    if (!empty($errorFields)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Los siguientes campos están vacíos: ' . implode(", ", $errorFields)
        ]);
        exit();
    }
    
    try {
        // Llamada al modelo para agregar la prenda
        $resultado = agregarPrenda($cliente_id, $nombre_prenda, $prendas_numero, $descripcion_arreglo, $tiempo_estimado, $valor_prenda, $estado);
        
        // Si todo va bien, envía un mensaje de éxito
        if ($resultado) {
            echo json_encode(['status' => 'success', 'message' => 'Prenda agregada con éxito.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo agregar la prenda.']);
        }

    }catch (mysqli_sql_exception $e) {
        $error_message = $e->getMessage();
        if ($e->getCode() == 1062) {
            // Error de duplicado
            echo json_encode(['status' => 'error', 'message' => 'La prenda ya está registrada.', 'error' => $error_message]);
        } else {
            // Otros errores
            echo json_encode(['status' => 'error', 'message' => 'Ocurrió un error inesperado.', 'error' => $error_message]);
        }
    }
    
}
elseif($action == 'agendar_orden') {
    $cliente_id = $_GET['cliente_id'];
    $cliente_consultar = agendar_orden($cliente_id);


    // Almacenar datos en la variable de sesión
    $_SESSION['cliente_consultar'] = $cliente_consultar;
  
    
    header('Location: ../views/ordenes/agendar_orden.php');
}
elseif($action == 'delete') {
    $prenda_id = $_POST['id']; // Asegúrate de que 'id' sea realmente el ID de la prenda que quieres borrar
   
    $success = borrar_prenda($prenda_id); // Llama a la función para borrar la prenda

    if ($success) {
        echo json_encode(["success" => true, "message" => "Prenda eliminada exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar la prenda."]);
    }
}
elseif ($action == 'edit') {
    $prenda_id = $_POST['id'];
    $prenda_consultar = consultar_prenda($prenda_id);
    $_SESSION['editar_prenda'] = $prenda_consultar;
  
    echo json_encode(["success" => true, "message" => "Prenda encontrada"]); // Esto se enviará como respuesta
}

elseif ($_POST['action'] == 'edit_prenda') {
    $nombre_prenda = $_POST['nombre_prenda'];
    $prendas_numero = $_POST['prendas_numero'];
    $estado = $_POST['estado'];
    $descripcion_arreglo = $_POST['descripcion_arreglo'];
    $tiempo_estimado = $_POST['tiempo_estimado'];
    $valor_prenda = $_POST['valor_prenda'];
    $prenda_id = $_POST['prenda_id'];


    $success = editar_prenda($prenda_id, $nombre_prenda, $prendas_numero, $estado, $descripcion_arreglo, $tiempo_estimado, $valor_prenda);

    if ($success) {
        echo json_encode(["success" => true, "message" => "Prenda editada exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al editada la prenda."]);
    }
}
elseif (isset($_POST['action']) == 'generar_orden') {
    // Verificamos que todos los datos necesarios estén establecidos
    if (isset($_POST['prenda_ids'])) {
        // Obtener los datos del POST
        $fecha_entrega = $_POST['fecha_entrega'];
        $franja_horaria = $_POST['franja_horaria'];
        $total_prendas = $_POST['total_prendas'];
        $valor_total = $_POST['valor_total'];
        $abono = $_POST['abono'];
        $saldo = $_POST['saldo'];
        $prendas_ids = $_POST['prenda_ids'];
        $orden_id = generador_orden($fecha_entrega, $franja_horaria, $total_prendas, $valor_total, $abono, $saldo, $prendas_ids);

        if ($orden_id) {
            echo json_encode(["success" => true, "message" => "Orden generada y prendas actualizadas exitosamente.", "order_id" => $orden_id]);
        } else {
            echo json_encode(["success" => false, "message" => "Hubo un error al procesar la orden."]);
        }
    } else {
        // En caso de que algún dato no esté establecido, regresamos un mensaje de error.
        echo json_encode(["success" => false, "message" => "Datos incompletos."]);
    }
}

if (isset($_GET['order_id'])) { // Cambio aquí de $_POST a $_GET
    $order_id = $_GET['order_id']; 

    // Eliminar los datos anteriores de la sesión (si existen)
    if(isset($_SESSION['cliente_consultar'])){
        unset($_SESSION['orden_consultar']);
        unset($_SESSION['cliente_consultar']);
    }

    // Consultar los datos con la función consultar_factura
    $orden_data = consultar_factura($order_id);

    // Almacenar los datos en la variable de sesión
    $_SESSION['orden_consultar'] = $orden_data;

    // No redireccionamos aquí, sino que enviamos una respuesta que AJAX procesará
    header('Location: ../views/ordenes/orden_guardar.php');
    exit;
}

