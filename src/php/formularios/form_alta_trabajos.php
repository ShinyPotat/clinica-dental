<!DOCTYPE HTML>  
<html>
<head>
    <meta charset="UTF-8" lang="es">
    <title>Alta trabajos</title>
    <link rel="stylesheet", type="text/css", href="../../css/formTrabajos.css">
</head>
<body>  

<?php
if(!isset($_SESSION["login"])){
  header("../login.php");
}
$fechaFinErr = $accionesErr = "";
$fechaFin = $acciones = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["fechaFin"])) {
        $fechaFinErr = "";
      } else {
        $fechaFin = test_input($_POST["fechaFin"]);
        }
      }
      
      if (empty($_POST["acciones"])) {
        $acciones = "";
      } else {
        $acciones = test_input($_POST["acciones"]);
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
          Fecha fin: &emsp;<input placeholder="dd/mm/yyyy" maxlength="10" type="text" name="fechaFin" value="<?php echo $fechaFin;?>">
          <span class="error"> <?php echo $fechaFinErr;?></span>
          </p><p>
          &emsp;
          Acciones: <textarea name="acciones" rows="5" cols="40"><?php echo $acciones;?></textarea>
          </p><br>
            <input type="submit" name="submit" value="Enviar" class="enviar">
            <a href="../../html/listaEncargosTrabajos.html" class="buttonAtras">Atrás</a>
      </form>
      <div class="results">
        <?php
        echo "<h2>Datos introducidos:</h2>";
        echo $fechaFin;
        echo "<br>";
        echo $acciones;
        ?>
        </div>
    </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
</body>
