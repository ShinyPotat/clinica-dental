<!DOCTYPE HTML>  
<html>
<head>
    <meta charset="UTF-8" lang="es">
    <title>Alta facturas</title>
    <link rel="stylesheet", type="text/css", href="../../css/formFacturas.css">
    <script src="../../js/validacion_cliente_alta_factura.js" type="text/javascript"></script>
</head>
<body>  

<?php
if(!isset($_SESSION["login"])){
  header("../login.php");
}
$fechaCobroErr = $fechaVencimientoErr = $fechaFacturaErr = $precioTotalErr = "";
$fechaCobro = $fechaVencimiento = $fechaFactura = $precioTotal = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["fechaCobro"])) {
        $fechaCobroErr = "";
      } else {
        $fechaCobro = test_input($_POST["fechaCobro"]);
        }
      }

      if (empty($_POST["fechaVencimiento"])) {
        $fechaVencimientoErr = "";
      } else {
        $fechaVencimiento = test_input($_POST["fechaVencimiento"]);
        }

      if (empty($_POST["fechaFactura"])) {
        $fechaFacturaErr = "";
      } else {
        $fechaFactura = test_input($_POST["fechaFactura"]);
        }

      if (empty($_POST["precioTotal"])) {
        $precioTotalErr = "";
      } else {
        $precioTotal = test_input($_POST["precioTotal"]);
        if ($_POST["precioTotal"] < 0) {
          $precioTotalErr = "El valor debe de ser mayor o igual que 0";
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

    </div>
    <div class="bloque">
      <form method="post" action="../Consultas_eliminaciones_modificaciones/facturas/accion_alta_factura.php">  
          <p><span class="error">&emsp;* campo requerido</span></p>
        <p>
          &emsp;
          Fecha de cobro: <input placeholder="dd/mm/yyyy" maxlength="10" type="date" name="fechaCobro" id="fechaCobro" value="<?php echo $fechaCobro;?>">
          <span class="error"> <?php echo $fechaCobroErr;?></span>
        </p>
          &emsp;
          Fecha de vencimiento: <input placeholder="dd/mm/yyyy" maxlength="10" type="date" name="fechaVencimiento" id="fechaVencimiento" value="<?php echo $fechaVencimiento;?>">
          <span class="error"> <?php echo $fechaVencimientoErr;?></span>
        <p>
          &emsp;
          Fecha de factura: <input placeholder="dd/mm/yyyy" maxlength="10" type="date" name="fechaFactura" id="fechaFactura" value="<?php echo $fechaFactura;?>"
                                    oninput="document.getElementById('errorFecha').innerHTML = dateValidation(
                                      document.getElementById('fechaCobro').value,
                                      document.getElementById('fechaVencimiento').value,
                                      document.getElementById('fechaFactura').value);">
          <span id="errorFecha" class="error"> <?php echo $fechaFacturaErr;?></span>
        </p>
          &emsp;
          Precio total: <input required placeholder="Precio total" type="number" id="precioTotal" name="precioTotal" value="<?php echo $precioTotal;?>" min="0">
          <span id="errorPrecio" class="error"> <?php echo $precioTotalErr;?></span> 
        <br>         
        <input type="submit" name="submit" value="Enviar" class="enviar">
        <a href="../../html/listaFacturas.html" class="buttonAtras">Atrás</a>
      </form>
      <div class="results">
        <?php
        echo "<h2>Datos introducidos:</h2>";
        echo $fechaCobro;
        echo "<br>";
        echo $fechaVencimiento;
        echo "<br>";  
        echo $fechaFactura;
        echo"<br>";
        echo $precioTotal;
        ?>
        </div>
    </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
  
</body>