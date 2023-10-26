<?php
session_start();

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

include_once '../../conexion/db_connection.php';

$statement = $conn->prepare('SELECT * FROM usuarios WHERE login = ?');

if (!$statement) {
    // Log the error
    die("Database query failed.");
}

$statement->bind_param('s', $username);
$statement->execute();
$result = $statement->get_result();

if ($result->num_rows === 0) {
    // Log the error
    header("Location: ../login/login.php?error=1");
    exit();
}

$user = $result->fetch_assoc();

if ($password === $user['contrasena']) {
    $_SESSION['username'] = $username;
    $_SESSION['grupo_usuario'] = $user['grupo_usuario'];
    header('Location: ../menu.php');
    exit();
} else {
    header("Location: ../login/login.php?error=2");
    exit();
}
?>
