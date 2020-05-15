<!DOCTYPE HTML>  
<html>
<head>
<meta charset="UTF-8" lang="es">
    <title>Alta Encargos</title>
    <link rel="stylesheet", type="text/css", href="../../css/formEncargo.css">
    <script src="../../js/validacion_cliente_alta_encargo.js" type="text/javascript"></script>
</head>
<body>  
<?php
$fechaEntregaErr = $fechaEntradaErr = "";
$fechaEntrega = $fechaEntrada = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["fechaEntrega"])) {
        $fechaEntregaErr = "";
      } else {
        $fechaEntrega = test_input($_POST["fechaEntrega"]);
        }
      }

      if (empty($_POST["fechaEntrada"])) {
        $fechaEntradaErr = "";
      } else {
        $fechaEntrada = test_input($_POST["fechaEntrada"]);
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
      <form id="formEncargo" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
          <p><span class="error">&emsp;* campo requerido</span></p>
          <p>
          &emsp;
          Fecha de entrada: <input placeholder="dd/mm/yyyy" maxlength="10" type="date" name="fechaEntrada" id="fechaEntrada" value="<?php echo $fechaEntrada;?>"
                                    oninput="document.getElementById('errorEntrada').innerHTML = entradaValidation(document.getElementById('fechaEntrada').value)">
          <span id="errorEntrada" class="error"> <?php echo $fechaEntradaErr;?></span>
          </p>
          &emsp;
          Fecha de entrega: <input placeholder="dd/mm/yyyy" maxlength="10" type="date" name="fechaEntrega" id="fechaEntrega" value="<?php echo $fechaEntrega;?>" 
              oninput="document.getElementById('entregaError').innerHTML = dateValidation(document.getElementById('fechaEntrada').value,document.getElementById('fechaEntrega').value);">
          <span id="entregaError" class="error"> <?php echo $fechaEntregaErr;?></span> 
          <p>         
          <input type="submit" name="submit" value="Enviar" class="enviar">
          <a href="../../html/listaEncargosTrabajos.html" class="buttonAtras">Atrás</a>
      </form>
      <div class="results">
        <?php
        echo "<h2>Datos introducidos:</h2>";
        echo $fechaEntrada;
        echo "<br>";
        echo $fechaEntrega;
        ?>
      </div>
    </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
    </body>

