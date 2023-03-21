
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="shortcut icon" href="../img/taylor.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Login sastreria</title>
  </head>
  <body>
  


  <div class="sidenav">
 
         <div class="login-main-text">
            <h2>Gestiona <br> tu sasteria</h2>
            <p>Escribe tu username y contraseña</p>
            <div><img id="imagen_fondo" src="../img/chisgas_fondo_blanco.png" alt=""></div>
          
         </div>
      </div>
      <div class="main">
         <div class="col-md-4 col-sm-12">
            <div class="login-form">
               <form action="validar.php" method="POST">
                  <div class="form-group">
                     <label>Usuario</label>
                     <input type="text" name="usuario"class="form-control" placeholder="usuario">
                  </div>
                  <div class="form-group">
                     <label>Contraseña</label>
                     <input type="password" name="contraseña" class="form-control" placeholder="Password">
                  </div>
                
                  <button type="submit" class="btn btn-secondary">Ingresar</button>
               </form>
            </div>
         </div>
      </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>