<?php
    session_start();
  	
    include_once("gestionBD.php");
    include_once("user-register/gestion-usuario.php");
  
  if (isset($_POST['submit'])){
      $email= $_POST['user'];
      $pass = $_POST['pass'];

      $conexion = crearConexionBD();
      $num_usuarios = consultarUsuario($conexion,$email,$pass);
      cerrarConexionBD($conexion);	
  
      if ($num_usuarios == 0)
          $login = "error";	
      else {
          $_SESSION['login'] = $user;
          Header("Location: ../html/accesorapido.html");
      }	
  }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" lang="es">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="../css/login.css">
    </head>
    <body>

        
    <img src="../../images/logo.png" class="logo"  >
    <img src="../../images/mascota.png" class="mascota">
        
        <div class=bloque>
            <form action="" method="POST" action="accion_login.php">
                <p class="encabezado">Inicio de sesión</p>
                <input id="user" class="user" type="text" placeholder="Nombre de Usuario" required></p>
                <img src="../../images/user.png" class="usuario">
                <input id="pass" class="pass" type="password" placeholder="Contraseña" minlength="8" required></p>
                <img src="../../images/restringido.png" class="rest">
                <input type="submit" name="logear" value="Acceder">
            </form>
            <div class="texto">
            <a href="user-register/form-register.php" class="newUser">¿Nuevo usuario? Crea una cuenta nueva</a>
            </div>
        </div>

    </body>
</html>