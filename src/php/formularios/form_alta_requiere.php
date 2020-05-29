<!DOCTYPE HTML>  
<html>
<head>
    <meta charset="UTF-8" lang="es">
    <title>Alta requiere</title>
    <link rel="stylesheet", type="text/css", href="../../css/formClinicas.css">
    <script src="../../js/validacion_cliente_alta_requiere.js" text="text/javascript"></script>
</head>
<body>  

<?php
if(!isset($_SESSION["login"])){
  header("../login.php");
}
$cantidadErr = "";
$cantidad =  "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["cantidad"])) {
      $cantidadErr = "Este campo es obligatorio";
    } else {
      $cantidad = test_input($_POST["cantidad"]);
      if ($_POST["cantidad"] < 0) {
        $cantidadErr = "El valor debe de ser mayor o igual que 0";
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
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
          <p><span class="error"> &emsp;* campo requerido</span></p>
        <br>
          &emsp;
          Cantidad: &emsp; <input required placeholder="Cantidad" type="number" name="cantidad" id="cantidad" value="<?php echo $cantidad;?>" min="0">
          <span id="errorCantidad" class="error"> <?php echo $cantidadErr;?></span>
        <br>    
        <input type="submit" name="submit" value="Enviar" class="enviar">
	      <a href="../../html/listaPDP.html" class="buttonAtras">Atrás</a>
      </form>
      <div class="results">
          <?php
          echo "<h2>Datos introducidos:</h2>";
          echo $cantidad;
          ?>
        </div>
    </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
  
</body>
