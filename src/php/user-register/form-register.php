<?php
    session_start();

    if(!isset($_SESSION["user"])){
        $user["name"]="";
        $user["lastname"]="";
        $user["perfil"]="clinica";
        $user["correo"]="";
        $user["user"]="";
        $user["pass"]="";
        $_SESSION["user"] = $user; 
    }else{
        $user = $_SESSION["user"];
    }
	
	if(isset($_SESSION["errores"])){
		$errores=$_SESSION["errores"];
	}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" lang="es">
        <title>Sign in</title>
        <link rel="stylesheet" type="text/css" href="../../css/register.css">
        <script src="../../js/validacion_cliente_alta_usuario.js" type="text/javascript"></script>
    </head>
    <body>
        <img src="../../../images/logo.png" class="logo"  >
        <img src="../../../images/mascota.png" class="mascota">
        
    	<div class="dev_errores">
			<?php 
			if (isset($errores) && !empty($errores)){
		        foreach($errores as $error){
		            print("<div class='error'>");
		            print("$error");
		            print("</div>");
		        }
	    	}
			?>
		</div>
    	
        <p class="encabezado">Registro</p>
        <div class="bloque">
        
            <form id="altaUsuario" name="altaUsuario" action="validation-register.php" method="post" class="formulario" onsubmit="return lettersValidation(document.getElementById('name')) && lettersValidation(document.getElementById('lastname'))">
                    
                    <p><input id="name" class="user" name="name" type="text" value="<?php echo $user['name'];?>" maxlength="40" placeholder="Nombre" required></p>
                    <img src="../../../images/user.png" class="usuario">
                    <p><input id="lastname" name="lastname" class="user" value="<?php echo $user['lastname'];?>" type="text" placeholder="Apellidos" maxlength="80"></p>
                    <img src="../../../images/apellido.png" class="apellido">
                    <p>&emsp;&emsp;&emsp;
                        &emsp;&emsp;<input type="radio" id="clinica" name="perfil" <?php if($user['perfil']=='clinica') echo ' checked ';?> value="clinica"> Director de Clinica
                        <input type="radio" id="proveedor" name="perfil" <?php if($user['perfil']=='proveedor') echo ' checked ';?> value="proveedor"> Proveedor
                    </p>
                    <p><input id="correo" class="user" name="correo" value="<?php echo $user['correo'];?>" type="email" placeholder="Correo electronico" required> </p>
                    <img src="../../../images/correo.png" class="correo">
                    <p><input id="user" name="user" class="user"type="text" value="<?php echo $user['user'];?>" placeholder="Nombre de Usuario" required></p>
                    <img src="../../../images/user.png" class="usuario2">
                    <p><input id="pass" name="pass" class="pass" type="password" value="<?php echo $user['pass'];?>" placeholder="Contraseña" oninput="passwordValidation();" required></p>
                    <img src="../../../images/restringido.png" class="rest">
                    <p><input id="passConf" name="passConf" class="pass" type="password" placeholder="Confirmar contraseña" oninput="passwordConfirm();" required></p>              
                    <img src="../../../images/correcto.png" class="correcto">
                    <img src="../../../images/restringido.png" class="contraseña">
        
        <input type="submit" value="Registrarse">
        <a href="../login.php" class="newUser">Volver a la pantalla de login</a>       
            </form>
        </div>
 
    </body>
</html>