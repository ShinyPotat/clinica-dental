<!DOCTYPE HTML>  
<html>
<head>
<head>
    <meta charset="UTF-8" lang="es">
    <title>Alta producto</title>
    <link rel="stylesheet", type="text/css", href="../../css/formProducto.css">
    <script src="../../js/validacion_cliente_alta_producto.js" type="text/javascript"></script>
</head>
<body>  

<?php
$nameErr = $precioErr = "";
$name = $precio = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
      $nameErr = "Este campo es obligatorio";
    } else {
      $name = test_input($_POST["name"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $nameErr = "Solo puedes introducir espacios y letras";
      }
    }

    if (empty($_POST["precio"])) {
        $precioErr = "Este campo es obligatorio";
      } else {
        $precio = test_input($_POST["precio"]);
        if ($_POST["precio"] < 0) {
          $precioErr = "El valor debe de ser mayor o igual que 0";
        }
      }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
?>
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
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
          <p><span class="error">&emsp;* campo requerido</span></p>
        <p>
          &emsp;
          Nombre*: &emsp; <input  placeholder="Nombre" type="text" name="name" id="name" value="<?php echo $name;?>"
                                    onkeyup="document.getElementById('errorName').innerHTML = lettersValidation(document.getElementById('name').value)">
          <span id="errorName" class="error"> <?php echo $nameErr;?></span>
        </p>
          &emsp;
          Precio*: &emsp; <input  placeholder="Precio" type="text" name="precio" id="precio" value="<?php echo $precio;?>"
                                    onkeyup="document.getElementById('errorPrecio').innerHTML = valueValidation(document.getElementById('precio').value)">
          <span id="errorPrecio" class="error"> <?php echo $precioErr;?></span> 
        <p>         
        <input type="submit" name="submit" value="Enviar" class="enviar">
	      <input type="submit" name="atrás" value="Atrás" class="atrás">
      </form>
      <div class="results">
              <?php
        echo "<h2>Datos introducidos:</h2>";
        echo $name;
        echo "<br>";
        echo $precio;
        echo "<br>";
        ?>
      </div>
    </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
  
</body>

