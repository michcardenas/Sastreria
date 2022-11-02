<?php
 

  require '../conexion/database.php';

  if (isset($_SESSION['username'])) {
    $records = $conn->prepare('SELECT id, usuario, password FROM usuarios WHERE id = :id');
    $records->bindParam(':id', $_SESSION['username']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
      $user = $results;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <title>Index</title>
</head>
<body>
    <div class="container text-center ">
    <h1  class="display-3" >Por favor ingrese con su <br> username y contraseña</h1>
    <a href="login.php">Ingrese</a>
    </div>
</body>
</html>