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

  session_start();

  if(!isset($_SESSION["login"])){
    header("../login.php");
  }

  if (!isset($_SESSION["Ffactura"])) {
    $factura["fechaCobro"] = "";
    $factura["fechaVencimiento"] = "";
    $factura["fechaFactura"] = "";
    $factura["precioTotal"] = "";
  } else {
    $factura = $_SESSION["Ffactura"];
    unset($_SESSION["Ffactura"]);
  }

  if(isset($_SESSION["errores"])) {
    $errores=$_SESSION["errores"];
    unset($_SESSION["errores"]);
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

    </div>
    <div class="bloque">
      <form method="post" action="../Consultas_eliminaciones_modificaciones/facturas/accion_alta_factura.php">  
          <p><span class="error">&emsp;* campo requerido</span></p>
        <p>
          &emsp;
          Fecha de cobro: <input placeholder="dd/mm/yyyy" maxlength="10" type="date" name="fechaCobro" id="fechaCobro" value="<?php echo $factura["fechaCobro"];?>"
                            oninput="document.getElementById('errorFechaCobro').innerHTML = cobroValidation(document.getElementById('fechaCobro').value);">
          <span class="error" id="errorFechaCobro"></span>
        </p>
          &emsp;
          Fecha de vencimiento: <input placeholder="dd/mm/yyyy" maxlength="10" type="date" name="fechaVencimiento" id="fechaVencimiento" value="<?php echo $factura["fechaVencimiento"];?>"
                              oninput="document.getElementById('errorVencimiento').innerHTML = vencimientoValidation(document.getElementById('fechaVencimiento').value);">
          <span class="error" id="errorVencimiento"></span>
        <p>
          &emsp;
          Fecha de factura: <input placeholder="dd/mm/yyyy" maxlength="10" type="date" name="fechaFactura" id="fechaFactura" value="<?php echo $factura["fechaFactura"];?>"
                                    oninput="document.getElementById('errorFecha').innerHTML = dateValidation(
                                      document.getElementById('fechaCobro').value,
                                      document.getElementById('fechaFactura').value);">
          <span id="errorFecha" class="error"></span>
        </p>
          &emsp;
          Precio total: <input required placeholder="Precio total" type="number" id="precioTotal" name="precioTotal" value="<?php echo $factura["precioTotal"];?>" min="0">
          <span id="errorPrecio" class="error"></span> 
        <br>         
        <input type="submit" name="submit" value="Enviar" class="enviar">
        <a href="../../html/listaFacturas.html" class="buttonAtras">Atrás</a>
      </form>
    </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
  
</body>