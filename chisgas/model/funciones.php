<?php

include_once '../../conexion/db_connection.php';
function obtener_ordenes_del_dia($fecha_entrega) {
    global $conn;  // Asegúrate de que tu conexión se llama $conn

    $query = "
        SELECT
            o.id AS id_orden,
            c.nombre AS nombre_cliente,
            o.total_prendas AS total_prendas_por_orden,
            (
                CASE
                    WHEN SUM(CASE WHEN p.estado = 4 THEN 1 ELSE 0 END) > 0 THEN 'Pendiente'
                    WHEN SUM(CASE WHEN p.estado = 5 THEN 1 ELSE 0 END) = COUNT(p.id) THEN 'Arreglado'
                    WHEN SUM(CASE WHEN p.estado = 6 THEN 1 ELSE 0 END) = COUNT(p.id) THEN 'Entregadas'
                    ELSE 'Ingresada'
                END
            ) AS estado_general
        FROM
            ordenes o
        LEFT JOIN
            prendas p ON o.id = p.id_orden
        LEFT JOIN
            clientes c ON c.id = p.id_cliente
        WHERE
            o.fecha_entrega = ?
        GROUP BY
            o.id, c.nombre, o.total_prendas;
    ";

    // Preparar la consulta y vincular el parámetro
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $fecha_entrega); // "s" significa que es una cadena (string)

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
function prendas_por_orden_con_cliente($id_orden) {
    global $conn;  // Asegúrate de que tu conexión se llama $conn

    $query = "
        SELECT 
            p.nombre_ropa,
            p.tiempo_estimado,
            p.estado,
            p.id,
            c.nombre AS nombre_cliente,
            c.telefono AS telefono_cliente
        FROM 
            prendas p
        LEFT JOIN 
            clientes c ON c.id = p.id_cliente
        WHERE 
            p.id_orden = ?
    ";

    // Preparar la consulta y vincular el parámetro
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_orden); // "i" significa que es un entero (integer)

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
function ver_arreglo($prenda_id) {
    global $conn;  // Asegúrate de que tu conexión se llama $conn

    $query = "
        SELECT 
            p.nombre_ropa,
            p.tiempo_estimado,
            p.estado,
            p.id,
            p.valor,
            p.prendas_numero,
            p.descripcion_arreglo,
            p.id_orden,
            p.id_asignacion,
            u.login
        FROM 
            prendas p
        LEFT JOIN 
            usuarios u ON u.id = p.id_asignacion
        WHERE 
            p.id = ?
    ";

    // Preparar la consulta y vincular el parámetro
    $stmt = $conn->prepare($query); // LINE 116
    $stmt->bind_param("i", $prenda_id); // "i" significa que es un entero (integer)

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->get_result();

    // Verificar si la consulta devuelve resultados
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();  // Ya que es un solo registro, simplemente devuelve el primer registro
    } else {
        return false;  // O podrías devolver un array vacío dependiendo de lo que necesites
    }

    // Cerrar el statement y la conexión
    $stmt->close();
}

function obtener_usuarios() {
    global $conn;  // Asegúrate de que tu conexión se llama $conn

    $query = "
        SELECT 
            id,
            login
        FROM 
            usuarios
    ";

    // Preparar y ejecutar la consulta
    $result = $conn->query($query);

    // Verificar si la consulta devuelve resultados
    if ($result->num_rows > 0) {
        $usuarios = [];
        while($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
        return $usuarios;
    } else {
        return [];  // Devuelve un array vacío si no hay resultados
    }

    // Cerrar la conexión
    $conn->close();
}
function obtener_info_ordenes($cliente_id) {
    global $conn;  // Asegúrate de que tu conexión se llama $conn

    $query = "
    SELECT 
        o.id,
        o.fecha_creacion,
        o.fecha_entrega,
        o.franja_horaria,
        o.total_prendas,
        o.valor_total,
        o.abono,
        o.saldo,
        CASE
            WHEN COUNT(p.id) > 0 THEN 'Pendiente'
            ELSE 'Entregada'
        END AS estado
    FROM 
        ordenes o
    LEFT JOIN 
        prendas p ON p.id_orden = o.id
    WHERE 
        p.id_cliente = ?
    GROUP BY 
        o.id, o.fecha_creacion, o.fecha_entrega, o.franja_horaria, o.total_prendas, o.valor_total, o.abono, o.saldo
";



    // Preparar la consulta y vincular el parámetro
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $cliente_id); // "i" significa que es un entero (integer)

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
