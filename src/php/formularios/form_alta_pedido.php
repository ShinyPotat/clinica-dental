<!DOCTYPE HTML>  
<html>
<head>
    <meta charset="UTF-8" lang="es">
    <title>Alta pedido</title>
    <link rel="stylesheet", type="text/css", href="../../css/formPedido.css">
    <script src="../../js/validacion_cliente_alta_pedido.js" type="text/javascript"></script>
</head>
<body>  

<?php

$fechaSolicitudErr = $fechaEntregaErr =  "";
$fechaSolicitud = $fechaEntrega = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["fechaSolicitud"])) {
        $fechaSolicitudErr = "";
      } else {
        $fechaSolicitud = test_input($_POST["fechaSolicitud"]);
        }
      }

      if (empty($_POST["fechaEntrega"])) {
        $fechaEntregaErr = "";
      } else {
        $fechaEntrega = test_input($_POST["fechaEntrega"]);
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
        Fecha de solicitud: &emsp; <input placeholder="dd/mm/yyyy" maxlength="10" type="date" id="fechaSolicitud" name="fechaSolicitud" value="<?php echo $fechaSolicitud;?>"
                                            oninput="document.getElementById('errorSolicitud').innerHTML = solicitudValidation(document.getElementById('fechaSolicitud').value)">
        <span id="errorSolicitud" class="error"> <?php echo $fechaSolicitudErr;?></span>
        </p>
        &emsp;
        Fecha de de entrega:&emsp; <input placeholder="dd/mm/yyyy" maxlength="10" type="date" id="fechaEntrega" name="fechaEntrega" value="<?php echo $fechaEntrega;?>"
                                        oninput="document.getElementById('errorFecha').innerHTML = dateValidation(
                                          document.getElementById('fechaSolicitud').value,
                                          document.getElementById('fechaEntrega').value);">
        <span id="errorFecha" class="error"> <?php echo $fechaEntregaErr;?></span>
        <br>
        <input type="submit" name="submit" value="Enviar" class="enviar">
        <a href="../../html/listaInventarioPedidos.html" class="buttonAtras">Atrás</a>
      </form>
      <div class="results">
        <?php
        echo "<h2>Datos introducidos:</h2>";
        echo $fechaSolicitud;
        echo "<br>";
        echo $fechaEntrega;
          ?>
        </div>
      </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
  
</body>
