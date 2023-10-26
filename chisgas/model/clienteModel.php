<?php
include_once '../conexion/db_connection.php';
function crearCliente($nombre, $telefono) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO clientes (nombre, telefono) VALUES (?, ?)");

    $stmt->bind_param("ss", $nombre, $telefono);

    $result = $stmt->execute();

    $newClientId = $conn->insert_id;

    $stmt->close();

    return $result ? $newClientId : false;
}


function buscarCliente($telefono, $nombre) {
    global $conn;
    
    $query = "SELECT * FROM clientes WHERE 1=1";
    $params = [];
    
    if (!empty($telefono)) {
        $query .= " AND telefono = ?";
        $params[] = $telefono;
    }
    
    if (!empty($nombre)) {
        $query .= " AND nombre LIKE ?";
        $params[] = "%$nombre%";
    }
    
    $stmt = $conn->prepare($query);
    
    // Sólo llamar a bind_param si hay parámetros para vincular
    if (!empty($params)) {
        $stmt->bind_param(str_repeat("s", count($params)), ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $clientes = [];
    
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
    
    return $clientes;
}
function consultarCliente($clienteId) {
    global $conn;
    
    $query = "SELECT * FROM clientes WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $clienteId);  // Suponiendo que el ID es un entero
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();  // Devuelve null si no hay resultados
}
function consultarClienteOrden($clienteId) {
    global $conn;
    
    $query = "SELECT 
                    c.id, 
                    c.nombre, 
                    c.telefono, 
                    COALESCE(SUM(p.prendas_numero), 0) as numero_de_prendas 
                FROM 
                    clientes c 
                LEFT JOIN 
                    prendas p ON p.id_cliente = c.id AND TIMESTAMPDIFF(MINUTE, p.fecha_hora, NOW()) <= 40
                WHERE 
                    c.id = ? and p.estado = 1
                GROUP BY 
                    c.id, c.nombre, c.telefono;";
                    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $clienteId);  // Suponiendo que el ID es un entero
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();  // Devuelve null si no hay resultados
}

function editarCliente($clienteId, $nombre, $telefono) {
    global $conn;
    
    $query = "UPDATE clientes SET nombre = ?, telefono = ? WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $nombre, $telefono, $clienteId);
    
    return $stmt->execute();  // Devolverá true si tiene éxito, false si falla
}


function borrarCliente($clienteId) {
    global $conn;  // Utilizar la conexión a la base de datos ya establecida
    
    $query = "DELETE FROM clientes WHERE id = ?";  // Consulta SQL para borrar el cliente
    
    $stmt = $conn->prepare($query);  // Preparar la consulta
    $stmt->bind_param("i", $clienteId);  // Vincular el parámetro (id del cliente)
    
    return $stmt->execute();  // Ejecutar la consulta y devolver true si tiene éxito, false si falla
}
