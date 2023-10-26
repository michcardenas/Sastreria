<?php
include_once '../conexion/db_connection.php';
function agregarPrenda($cliente_id, $nombre_prenda, $prendas_numero, $descripcion_arreglo, $tiempo_estimado, $valor_prenda, $estado) {
    global $conn;

    // Actualizar la consulta SQL para incluir las nuevas columnas
    $stmt = $conn->prepare("INSERT INTO prendas (id_cliente, nombre_ropa, prendas_numero, descripcion_arreglo, tiempo_estimado, valor, estado,fecha_hora) VALUES (?, ?, ?, ?, ?, ?, ?,?)");
    $estado = 1;
        // Configurar la zona horaria de Colombia
    date_default_timezone_set('America/Bogota');

    // Obtener la fecha y hora actual
    $fecha_actual = date("Y-m-d H:i:s");
    // Aquí asumo que cliente_id, prendas_numero, tiempo_estimado y valor_prenda son enteros (i) y las demás son strings (s)
    $stmt->bind_param("isisiiss", $cliente_id, $nombre_prenda, $prendas_numero, $descripcion_arreglo, $tiempo_estimado, $valor_prenda, $estado,$fecha_actual);

    $result = $stmt->execute();

    // Obtener el ID de la nueva prenda insertada
    $newPrendaId = $conn->insert_id;

    $stmt->close();

    // Devuelve el nuevo ID de la prenda si la inserción fu+e exitosa, de lo contrario devuelve falso
    return $result ? $newPrendaId : false;
}
function agendar_orden($cliente_id) {
    global $conn;
    
    // Prepare the SQL query. Note that we've added 'c.id' as 'cliente_id'
    $stmt = $conn->prepare("SELECT c.id AS cliente_id, c.nombre, c.telefono, p.id AS prenda_id, p.nombre_ropa, p.descripcion_arreglo, p.tiempo_estimado, p.valor, p.prendas_numero 
                            FROM clientes c  
                            LEFT JOIN prendas p ON p.id_cliente = c.id 
                            WHERE c.id = ? AND p.estado > 0 AND p.estado <= 2");
    
    // Bind the 'cliente_id' parameter. 'i' indicates that it's an integer.
    $stmt->bind_param("i", $cliente_id);

    // Execute the query
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($cliente_id, $nombre, $telefono, $prenda_id, $nombre_ropa, $descripcion_arreglo, $tiempo_estimado, $valor, $prendas_numero);

    // Fetch the result into the bound variables
    $results = [];
    while ($stmt->fetch()) {
        $results[] = [
            'cliente_id' => $cliente_id,  // Added this line
            'nombre' => $nombre,
            'telefono' => $telefono,
            'prenda_id' => $prenda_id,
            'nombre_ropa' => $nombre_ropa,
            'descripcion_arreglo' => $descripcion_arreglo,
            'tiempo_estimado' => $tiempo_estimado,
            'valor' => $valor,
            'prendas_numero' => $prendas_numero
        ];
    }

    // Close the statement
    $stmt->close();
    
    return $results;
}



function borrar_prenda($prenda_id) {
    global $conn;
    
    // Prepare the SQL query to delete the prenda
    $stmt = $conn->prepare("UPDATE prendas SET estado = 0 WHERE id = ?"); // Assuming 'estado = 0' marks it as deleted

    // Bind the 'prenda_id' parameter. 'i' indicates that it's an integer.
    $stmt->bind_param("i", $prenda_id);

    // Execute the query
    $success = $stmt->execute();

    // Close the statement
    $stmt->close();
    
    return $success;
}
function consultar_prenda($prenda_id) {
    global $conn;
    
    // Preparar la consulta SQL para obtener los detalles de una prenda específica
    $stmt = $conn->prepare("SELECT p.id AS prenda_id, p.nombre_ropa, p.descripcion_arreglo, p.tiempo_estimado, p.valor, p.prendas_numero, p.estado, p.id_cliente
                            FROM prendas p
                            WHERE p.id = ? AND p.estado > 0 and p.estado <=2"); // Asumiendo que las prendas eliminadas tienen estado = 0
    
    // Vincular el parámetro 'prenda_id'. 'i' indica que es un entero.
    $stmt->bind_param("i", $prenda_id);

    // Ejecutar la consulta
    $stmt->execute();

    // Vincular las variables de resultado
    $stmt->bind_result($prenda_id, $nombre_ropa, $descripcion_arreglo, $tiempo_estimado, $valor, $prendas_numero, $estado, $id_cliente);

    // Recuperar el resultado en las variables vinculadas
    $results = [];
    if ($stmt->fetch()) { // Suponiendo que solo hay un resultado
        $results = [
            'prenda_id' => $prenda_id,
            'nombre_ropa' => $nombre_ropa,
            'descripcion_arreglo' => $descripcion_arreglo,
            'tiempo_estimado' => $tiempo_estimado,
            'valor' => $valor,
            'prendas_numero' => $prendas_numero,
            'estado' => $estado,
            'id_cliente' => $id_cliente  // Aquí agregamos el id_cliente
        ];
    }

    // Cerrar la declaración
    $stmt->close();
    
    return $results;
}

function editar_prenda($prenda_id, $nombre_prenda, $prendas_numero, $estado, $descripcion_arreglo, $tiempo_estimado, $valor_prenda) {
    global $conn;
    $estado = 2;
    // Preparar la consulta SQL para actualizar los detalles de una prenda específica cuando el estado sea 1
    $stmt = $conn->prepare("UPDATE prendas SET nombre_ropa = ?, prendas_numero = ?, estado = ?, descripcion_arreglo = ?, tiempo_estimado = ?, valor = ? WHERE id = ?");

    // Vincular los parámetros a la consulta SQL
    $stmt->bind_param("sissidi", $nombre_prenda, $prendas_numero, $estado, $descripcion_arreglo, $tiempo_estimado, $valor_prenda, $prenda_id);

    // Ejecutar la consulta
    $result = $stmt->execute();

    // Cerrar la declaración
    $stmt->close();

    return $result;
}

function generador_orden($fecha_entrega, $franja_horaria, $total_prendas, $valor_total, $abono, $saldo, $prendas_ids) {
    global $conn;
    
    // Usando la función date para obtener la fecha y hora actual en formato 'Y-m-d H:i:s'
    $fecha_creacion = date('Y-m-d H:i:s');

    // Preparar la consulta SQL para insertar una nueva orden
    $stmt_orden = $conn->prepare("INSERT INTO ordenes (fecha_creacion, fecha_entrega, franja_horaria, total_prendas, valor_total, abono, saldo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    // Vincular los parámetros a la consulta SQL
    $stmt_orden->bind_param("sssisdd", $fecha_creacion, $fecha_entrega, $franja_horaria, $total_prendas, $valor_total, $abono, $saldo);

    // Ejecutar la consulta
    $result_orden = $stmt_orden->execute();

    // Obtener el ID de la última orden insertada
    $last_order_id = $conn->insert_id;

    // Cerrar la declaración de orden
    $stmt_orden->close();

    if ($result_orden && $last_order_id) {
        // Ahora, actualizar la tabla de prendas con el ID de la orden y el estado
        $ids_for_query = implode(',', $prendas_ids);
        $update_query = "UPDATE prendas SET id_orden = ?, estado = 3 WHERE id IN ($ids_for_query)";
        $stmt_prendas = $conn->prepare($update_query);
        
        // Vincular el parámetro al ID de la última orden insertada
        $stmt_prendas->bind_param("i", $last_order_id);
        
        // Ejecutar la consulta
        $result_prendas = $stmt_prendas->execute();

        // Cerrar la declaración de prendas
        $stmt_prendas->close();

        if ($result_orden && $result_prendas) {
            return $last_order_id;
        } else {
            return false;
        }
    }
    
    return false;
}

function consultar_factura($order_id) {
    global $conn;

    // Preparar la consulta SQL para obtener los detalles de una orden específica
    $stmt = $conn->prepare("SELECT 
                                c.nombre AS cliente_nombre,
                                c.telefono AS cliente_telefono,
                                o.fecha_creacion,
                                o.fecha_entrega,
                                o.franja_horaria,
                                o.total_prendas,
                                o.valor_total,
                                o.abono,
                                o.saldo,
                                p.nombre_ropa,
                                p.descripcion_arreglo,
                                p.tiempo_estimado,
                                p.valor,
                                p.estado,
                                p.prendas_numero,
                                o.id 
                            FROM ordenes o
                            LEFT JOIN prendas p ON o.id = p.id_orden
                            LEFT JOIN clientes c ON p.id_cliente = c.id
                            WHERE o.id = ?");

    // Vincular el parámetro 'order_id'. 'i' indica que es un entero.
    $stmt->bind_param("i", $order_id);

    // Ejecutar la consulta
    $stmt->execute();

    // Vincular las variables de resultado
// Vincular las variables de resultado
$stmt->bind_result($cliente_nombre, $cliente_telefono, $fecha_creacion, $fecha_entrega, $franja_horaria, $total_prendas, $valor_total, $abono, $saldo, $nombre_ropa, $descripcion_arreglo, $tiempo_estimado, $valor, $estado, $prendas_numero, $returned_order_id);

    // Recuperar el resultado en las variables vinculadas
    $results = [];
    while ($stmt->fetch()) {
        $results[] = [
            'cliente_nombre' => $cliente_nombre,
            'cliente_telefono' => $cliente_telefono,
            'fecha_creacion' => $fecha_creacion,
            'fecha_entrega' => $fecha_entrega,
            'franja_horaria' => $franja_horaria,
            'total_prendas' => $total_prendas,
            'valor_total' => $valor_total,
            'abono' => $abono,
            'saldo' => $saldo,
            'nombre_ropa' => $nombre_ropa,
            'descripcion_arreglo' => $descripcion_arreglo,
            'tiempo_estimado' => $tiempo_estimado,
            'valor' => $valor,
            'estado' => $estado,
            'prendas_numero' => $prendas_numero,
            'order_id' => $returned_order_id

        ];
    }

    // Cerrar la declaración
    $stmt->close();

    return $results;
}
