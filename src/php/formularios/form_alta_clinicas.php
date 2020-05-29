<?php 

  session_start();

if(!isset($_SESSION["login"])){
  header("Location: ../login.php");
}

$nameErr = $localErr = $phoneErr = $morosoErr = $nameDErr = $nColErr ="";
$name = $local = $phone = $moroso = $nameD = $nCol ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
      $nameErr = "Este campo es obligatorio";
    } else {
      $name = test_input($_POST["name"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $nameErr = "Solo puedes introducir espacios y letras";
      }
    }

    if (empty($_POST["local"])) {
        $local = "";
      } else {
        $local = test_input($_POST["local"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$local)) {
            $localErr = "Solo puedes introducir espacios y letras";
          }
        }

    if (empty($_POST["phone"])) {
         $phone = "";
        } else {
        $phone = test_input($_POST["phone"]);
        if (!preg_match("^[0-9]{9}^",$phone)) {
            $phoneErr = "Escribe un número adecuado";
             }
        }
    }

    if (empty($_POST["nameD"])) {
        $nameDErr = "";
      } else {
        $nameD = test_input($_POST["nameD"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$nameD)) {
          $nameDErr = "Solo puedes introducir espacios y letras";
        }
      }

      if (empty($_POST["nCol"])) {
        $nCol = "";
       } else {
       $nCol = test_input($_POST["nCol"]);
       if (!preg_match("^[0-9]{4}^",$nCol)) {
           $nColErr = "Escribe un número adecuado";
            }
       }
   function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
<!DOCTYPE HTML>  
<html>
<head>
    <meta charset="UTF-8" lang="es">
    <title>Alta clínicas</title>
    <link rel="stylesheet", type="text/css", href="../../css/formClinicas.css">
    <script src="../../js/validacion_cliente_alta_clinica.js" type="text/javascript"></script>
</head>
<body>

<a href="../../html/log.html" ><img class="imagen" src="../../../images/logo.png" alt="logo.png" width=23% height=23%></a>
    <div class="block">
        <a href="../../html/about-us.html" class="acerca">Acerca de nosotros</a>
        <!-- Estos bloques definen las id que se usan para el js de la hora -->
        <div id="box">
            <div id="box-date"></div>
            <div id="box-time"></div>
        </div>
        
        <img class="calendario" src="../../../images/calendario.png" width="1%" height="11%">
        <img class="reloj" src="../../../images/reloj.png" width="1%" height="11%">
        
        <img class="usuario" src="../../../images/user.png" width="1.5%" height="13%">
        
        <img class="flechaA" src="../../../images/flechaA.png" width="20" height="20">
        
        <select class="botonUsuario">
            <option value="1">Usuario</option>
            <option value="2">Opcion 2</option>
            <option value="3">Opcion 3</option>
        </select>
    </div>
    <div class="bloque">
        <form method="post" action="../Consultas_eliminaciones_modificaciones/clinica/accion_alta_clinica.php">  
          <p><span class="error"> &emsp;* campo requerido</span></p>
      <p>
        &emsp;
        Nombre: &emsp; <input placeholder="Nombre" class=name type="text" name="name" id="name" value="<?php echo $name;?>"
                              onkeyup="document.getElementById('errorName').innerHTML = lettersValidation(document.getElementById('name').value);">
        <span id="errorName" class="error"> <?php echo $nameErr;?></span>
      </p>
        &emsp;
        Localización: &emsp;<input placeholder="Localizacion" class=local type="text" name="local" id="local" value="<?php echo $local;?>"
                                  onkeyup="document.getElementById('errorLocal').innerHTML = lettersValidation(document.getElementById('local').value);">
        <span id="errorLocal" class="error"> <?php echo $localErr;?></span> 
      <p>
       &emsp;
      Telefono de contacto: &emsp;<input id="phone" class=phone name="phone" id="phone" type="text" maxlength="9" placeholder="123456789" value="<?php echo $phone;?>"
                                         onkeyup="document.getElementById('errorNum').innerHTML = numberValidation(document.getElementById('phone').value);">
      <span id="errorNum" class="error"> <?php echo $phoneErr;?></span>
      </p>
          <input id="moroso" name ="moroso" type="hidden" value="N">
      <p>
      &emsp;
      Nombre Dueño: &emsp;<input placeholder="Nombre del dueño" class="nameD" type="text" id="nameD" name="nameD" value="<?php echo $nameD;?>"
                                onkeyup="document.getElementById('errorNameD').innerHTML = lettersValidation(document.getElementById('nameD').value);">
        <span id="errorNameD" class="error"> <?php echo $nameDErr;?></span>
      </p>
      &emsp;
        Numero de colegiado:&emsp;<input id="nCol" class="nCol" name="nCol" id="nCol" type="text" maxlength="4" placeholder="1234" value="<?php echo $nCol;?>"
                                      onkeyup="document.getElementById('errorNumCol').innerHTML = nColValidation(document.getElementById('nCol').value);">
        <span id="errorNumCol" class="error"> <?php echo $nColErr;?></span>
      <br>
      <input type="submit" name="submit" value="Enviar" class="enviar">
	    <a href="../../html/listaPDP.html" class="buttonAtras">Atrás</a> 

      </form>
      <div class="results">
        <?php
          echo "<h2>Datos introducidos:</h2>";
          echo $name;
          echo "<br>";
          echo $local;
          echo "<br>";  
          echo $phone;
          echo"<br>";
          echo $moroso;
          echo "<br>";
          echo $nameD;
          echo "<br>";
          echo $nCol;
          ?>
        </div>
    </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
  
</body>