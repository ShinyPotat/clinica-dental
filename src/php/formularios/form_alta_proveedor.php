
<!DOCTYPE HTML>  
<html>
<head>
    <meta charset="UTF-8" lang="es">
    <title>Alta proveedor</title>
    <link rel="stylesheet", type="text/css", href="../../css/formProveedor.css">
    <script src="../../js/validacion_cliente_alta_proveedor.js" type="text/javascript"></script>
</head>
<body>  

<?php

    session_start();

    if(!isset($_SESSION["login"])){
      header("Location: ../login.php");
    }

    if(isset($_SESSION["errores"])) {
      $errores=$_SESSION["errores"];
      unset($_SESSION["errores"]);
    }

    if (!isset($_SESSION["Fproveedor"])) {
      $Fproveedor['NOMBRE'] = "";
      $Fproveedor['LOCALIZACIÓN'] = "";
      $Fproveedor['TLF_CONTACTO'] = "";
    
      $_SESSION["Fproveedor"] = $Fproveedor;
    }else{
      $Fproveedor = $_SESSION["Fproveedor"];
    }

    if (isset($errores) && count($errores)>0) { 
      echo "<div id=\"div_errores\" class=\"error\">";
      echo "<h4> Errores en el formulario:</h4>";
      foreach($errores as $error){
        echo $error;
    } 
      echo "</div>";
    }

    include_once ("../cabecera.php");
?>

    <div class="bloque">
      <form method="post" action="../Consultas_eliminaciones_modificaciones/proveedor/accion_alta_proveedor.php">  
          <p><span class="error">&emsp;* campo requerido</span></p>
        <p>
          &emsp;
          Nombre*:&emsp; <input required placeholder="Nombre" type="text" name="name" id="name" value="<?php echo $Fproveedor["NOMBRE"];?>"
                                  onkeyup="document.getElementById('errorName').innerHTML = lettersValidation(document.getElementById('name').value)">
          <span id="errorName" class="error"></span>
        </p>
          &emsp;
          Localización:&emsp; <input placeholder="Localizacion" type="text" name="local" id="local" value="<?php echo $Fproveedor["LOCALIZACIÓN"];?>"
                                      onkeyup="document.getElementById('errorLocal').innerHTML = lettersValidation(document.getElementById('local').value)">
          <span id="errorLocal" class="error"></span> 
        <p>
        &emsp;
          Telefono de contacto:&emsp;<input id="phone" name="phone" id="phone" type="text" maxlength="9" placeholder="123456789" value="<?php echo $Fproveedor["TLF_CONTACTO"];?>"
                                              onkeyup="document.getElementById('errorPhone').innerHTML = numberValidation(document.getElementById('phone').value)">
          <span id="errorPhone" class="error"></span>
        </p>
        <input type="submit" name="submit" value="Enviar" class="enviar">
	      <a href="../../html/listaInventarioPedidos.html" class="buttonAtras">Atrás</a>
      </form>
      </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
  
</body>
