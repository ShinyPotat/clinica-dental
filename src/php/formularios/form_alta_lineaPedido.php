<!DOCTYPE HTML>  
<html>
<head>
<meta charset="UTF-8" lang="es">
    <title>Alta lineaPedido</title>
    <link rel="stylesheet", type="text/css", href="../../css/formLineaPedido.css">
    <script src="../../js/validacion_cliente_alta_lineaPedido.js" type="text/javascript"></script>
</head>
<body>  

<?php
if(!isset($_SESSION["login"])){
  header("Location: ../login.php");
}
$cantidadErr = $costeErr = "";
$cantidad = $coste = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["cantidad"])) {
      $cantidadErr = "Este campo es obligatorio";
    } else {
      $cantidad = test_input($_POST["cantidad"]);
      if ($_POST["cantidad"] < 0) {
        $cantidadErr = "El valor debe de ser mayor o igual que 0";
      }
    }

    if (empty($_POST["coste"])) {
        $costeErr = "Este campo es obligatorio";
      } else {
        $coste = test_input($_POST["coste"]);
        if ($_POST["coste"] < 0) {
          $costeErr = "El valor debe de ser mayor o igual que 0";
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
          <p><span class="error">&emsp;* campo requerido</span></p>
        <p>
        &emsp;
          Cantidad*:&emsp; <input placeholder="Cantidad" type="number" name="cantidad" id="cantidad" value="<?php echo $cantidad;?>" min="0">
          <span id="errorCantidad" class="error"> <?php echo $cantidadErr;?></span>
        </p>
        &emsp;
          Coste*: &emsp;<input  placeholder="Coste" type="number" name="coste" id="coste" value="<?php echo $coste;?>" min="0">
          <span id="errorCoste" class="error"> <?php echo $costeErr;?></span> 
        <p></p>         
        <input type="submit" name="submit" value="Enviar" class="enviar">
	      <a href="../../html/listaInventarioPedidos.html" class="buttonAtras">Atrás</a>
      </form>
      <div class="results">
        <?php
          echo "<h2>Datos introducidos:</h2>";
          echo $cantidad;
          echo "<br>";
          echo $coste;
          echo "<br>";
          ?>
        </div>
        
      </div>
      <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
      <script src="../../js/hora.js"></script>
      </body>