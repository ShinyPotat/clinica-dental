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
if(!isset($_SESSION["login"])){
  header("../login.php");
}
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

      include_once ("../cabecera.php");
?>

    <div class="bloque">
      <form method="post" action="../Consultas_eliminaciones_modificaciones/productos/accion_alta_producto.php">  
          <p><span class="error">&emsp;* campo requerido</span></p>
        <p>
          &emsp;
          Nombre*: &emsp; <input  placeholder="Nombre" type="text" name="name" id="name" value="<?php echo $name;?>"
                                    onkeyup="document.getElementById('errorName').innerHTML = lettersValidation(document.getElementById('name').value)">
          <span id="errorName" class="error"> <?php echo $nameErr;?></span>
        </p>
        <p>
          &emsp;
          Precio*: &emsp; <input  placeholder="Precio" type="number" name="precio" id="precio" value="<?php echo $precio;?>" min="0">
          <span id="errorPrecio" class="error"> <?php echo $precioErr;?></span> 
        </p>
        <?php 
            require_once("../gestionBD.php");
            $conexion = crearConexionBD();
            $query = "SELECT OID_E, FECHA_ENTRADA FROM Encargos ORDER BY FECHA_ENTRADA ASC";
            $encargos = $conexion->query($query);
            cerrarConexionBD($conexion);
        ?>
        <div>&emsp; Encargo: <select id="encargoPR" name="encargoPR">
            <option value="">Seleccionar encargo</option>
            <?php foreach($encargos as $fila){ ?>
              <option value="<?php echo $fila["OID_E"]; ?>"><?php echo $fila["FECHA_ENTRADA"]; ?></option>

            <?php } ?>
          </select>
        </div>
      </p>
      <p>         
        <input type="submit" name="submit" value="Enviar" class="enviar">
	      <a href="../../html/listaPDP.html" class="buttonAtras">Atrás</a>
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

