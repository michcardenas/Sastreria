<?php
// clientesController.php

// Aquí podrías incluir el modelo
include '../model/clienteModel.php';

// Comprobar el tipo de acción que se va a realizar (crear o buscar)
$action = $_REQUEST['action'];


if ($action == 'crear') {
    $nombre_cliente = isset($_POST['nombre_cliente']) ? $_POST['nombre_cliente'] : null;
    $telefono_cliente = isset($_POST['telefono_cliente']) ? $_POST['telefono_cliente'] : null;

    // Verificar que al menos uno de los campos no esté vacío
    if (empty($nombre_cliente) && empty($telefono_cliente)) {
        // Ambos campos están vacíos, redirige al usuario con un mensaje de error
        header('Location: ../views/error.php?error=Por favor, llene al menos uno de los campos.');
        exit();
    }

    try {
        // Llamada al modelo para crear el cliente
        $resultado = crearCliente($nombre_cliente, $telefono_cliente);
     
        // Si todo va bien, redirige a la página de crear orden
        if ($resultado) {
            header('Location: ../views/ordenes/recibir_orden.php?cliente=' . $resultado);
        } else {
            header('Location: ../views/error.php');
        }

    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            // Error de duplicado. Redirige al usuario con un mensaje de error
            header('Location: ../views/error.php?error=El número de teléfono ya está registrado.');
        } else {
            // Otros errores, redirige al usuario a una página genérica de error
            header('Location: ../views/error.php');
        }
    }
}

elseif ($action == 'buscar') {
    $telefono = isset($_POST['telefono_cliente']) ? $_POST['telefono_cliente'] : '';
    $nombre = isset($_POST['nombre_cliente']) ? $_POST['nombre_cliente'] : '';

    $clientes = buscarCliente($telefono, $nombre);
    header('Content-Type: application/json');
    echo json_encode($clientes);
   }


   elseif ($action == 'consultar') {
    $cliente = $_GET['cliente'];
   
    $cliente_consultar = consultarCliente($cliente);
 
    header('Location: ../views/ordenes/editar_cliente.php?nombre=' . urlencode($cliente_consultar['nombre']) . '&telefono=' . urlencode($cliente_consultar['telefono']) . '&id=' . urlencode($cliente_consultar['id']));
}
elseif ($action == 'consultar_orden') {
    $cliente = $_GET['cliente'];
    
    $cliente_consultar = consultarCliente($cliente);
   
 
    header('Location: ../views/ordenes/crear_orden.php?nombre=' . urlencode($cliente_consultar['nombre']) . '&telefono=' . urlencode($cliente_consultar['telefono']) . '&id=' . urlencode($cliente_consultar['id']));
}

elseif ($action == 'editar') {
    $telefono = $_POST['telefono_cliente'];
    $nombre = $_POST['nombre_cliente'];
    $clienteId = $_POST['cliente_id'];

    $resultado = editarCliente($clienteId, $nombre, $telefono);

    if ($resultado) {
        echo json_encode(['status' => 'success', 'message' => 'Cliente editado exitosamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Hubo un error al editar el cliente']);
    }
    exit;  // Finalizar el script para asegurarse de que no se ejecuta más código
}


elseif ($action == 'borrar') {
    $clienteId = $_POST['cliente_id'];  // Recibimos el cliente_id desde la petición AJAX

    $resultado = borrarCliente($clienteId);  // Aquí se asume que tienes una función borrarCliente()

    if ($resultado) {
        echo json_encode(['status' => 'success', 'message' => 'Cliente borrado exitosamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Hubo un error al borrar el cliente']);
    }
    exit;  // Finalizar el script para asegurarse de que no se ejecuta más código
}