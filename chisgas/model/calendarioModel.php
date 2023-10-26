<?php
include_once '../conexion/db_connection.php';
function ver_calendario() {
    global $conn;  // Asegúrate de que tu conexión se llama $conn

    $query = "
        SELECT 
            o.fecha_entrega,
            COUNT(DISTINCT p.id_cliente) AS numero_clientes,
            SUM(p.tiempo_estimado) AS tiempo_estimado_total
        FROM 
            ordenes o
        JOIN 
            prendas p ON o.id = p.id_orden
        GROUP BY 
            o.fecha_entrega
        ORDER BY 
            o.fecha_entrega
    ";

    $result = $conn->query($query);

    // Verificar si la consulta devuelve resultados
    if ($result->num_rows > 0) {
        $data = [];
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } else {
        return false;  // O podrías devolver un array vacío dependiendo de lo que necesites
    }
}
function ver_dia($fecha) {
    global $conn;  // Asegúrate de que tu conexión se llama $conn

    $query = "
        SELECT 
            o.id AS id_orden,
            c.nombre AS nombre_cliente,
            o.total_prendas AS total_prendas_por_orden
        FROM 
            ordenes o
        LEFT JOIN 
            prendas p ON p.id_orden = o.id
        LEFT JOIN 
            clientes c ON c.id = p.id_cliente 
        WHERE 
            o.fecha_entrega = ?
        GROUP BY 
            o.id, c.nombre, o.total_prendas;
    ";

    // Preparar la consulta y vincular el parámetro
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $fecha); // "s" significa que es una cadena (string)

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->get_result();

    // Verificar si la consulta devuelve resultados
    if ($result->num_rows > 0) {
        $data = [];
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } else {
        return false;  // O podrías devolver un array vacío dependiendo de lo que necesites
    }

    // Cerrar el statement y la conexión
    $stmt->close();
}

function actualizar_prenda($prenda_id, $estado) {
    global $conn;  // Asegúrate de que tu conexión se llama $conn

    // Query de actualización
    $query = "
        UPDATE prendas 
        SET estado = ?
        WHERE id = ?
    ";

    // Preparar la consulta y vincular los parámetros
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $estado, $prenda_id);  // Dos "i" porque ambos son enteros

    // Ejecutar la consulta
    $result = $stmt->execute();

    // Cerrar el statement y verificar si la actualización tuvo éxito
    $stmt->close();

    // $result será TRUE si la consulta se ejecutó correctamente, y FALSE si hubo un error
    return $result;
}

function editar_prenda($prenda_id, $nombre_prenda, $prendas_numero, $descripcion_arreglo, $valor, $asignado) {
    global $conn;  // Asegúrate de que tu conexión se llama $conn

    $query = "
    UPDATE prendas
    SET nombre_ropa = ?, descripcion_arreglo = ?, valor = ?, prendas_numero = ?,  	id_asignacion = ?
    WHERE id = ?
";

    // Preparar la consulta y vincular los parámetros
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisii", $nombre_prenda, $descripcion_arreglo, $valor, $prendas_numero, $asignado, $prenda_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $stmt->close();
        return true;  // Devuelve true si la actualización fue exitosa
    } else {
        $stmt->close();
        return false;  // Devuelve false si hay un error
    }
}

function editar_estado_prenda($prenda_id, $estado) {
    global $conn; // Asegúrate de que tu conexión se llama $conn

    $query = "
        UPDATE prendas
        SET estado = ?
        WHERE id = ?
    ";

    // Preparar la consulta y vincular los parámetros
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $estado, $prenda_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $stmt->close();
        return true;  // Devuelve true si la actualización fue exitosa
    } else {
        $stmt->close();
        return false;  // Devuelve false si hay un error
    }
}


?>