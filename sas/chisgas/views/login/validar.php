<?php
// Iniciar el sistema de sesiones
session_start();

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Conexión a la base de datos
include_once '../../conexion/db_connection.php';

// Comprobar si el usuario existe y si la contraseña es correcta
$statement = $conn->prepare('SELECT * FROM usuarios WHERE login = ?');

if (!$statement) {
    echo 'Error al preparar la consulta';
    exit();
}

// Vincular el parámetro
$statement->bind_param('s', $username);

// Ejecutar
$statement->execute();

// Obtener resultados
$result = $statement->get_result();

// Verificar si el usuario existe
if ($result->num_rows === 0) {
    echo 'Usuario no encontrado';
    exit();
}

// Obtener la fila del usuario
$user = $result->fetch_assoc();

// Verificar la contraseña
if ($password === $user['contrasena']) {
    // Guardar datos en la sesión
    $_SESSION['username'] = $username;
    $_SESSION['grupo_usuario'] = $user['grupo_usuario'];  // Asumiendo que 'grupo_usuario' es una columna en tu tabla

    // Redirigir a la página principal
    header('Location: ../menu.php');
    
    exit();
} else {
    echo 'Contraseña incorrecta';
}


?>
