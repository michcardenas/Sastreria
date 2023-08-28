<?php
// Datos de la conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$contraseña = "Michcardenas1.";
$basedatos = "sastreriadb";

// Crear la conexión
$conn = new mysqli($servidor, $usuario, $contraseña, $basedatos);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>
