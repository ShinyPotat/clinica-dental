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
session_start();

if(!isset($_SESSION["login"])){
  header("Location: ../login.php");
}

if(isset($_SESSION["errores"])) {
  $errores=$_SESSION["errores"];
  unset($_SESSION["errores"]);
}

if (!isset($_SESSION["Fproducto"])) {
  $Fproducto['NOMBRE'] = "";
  $Fproducto['PRECIO'] = "";
  

  $_SESSION["Fproducto"] = $Fproducto;
}else{
  $Fproducto = $_SESSION["Fproducto"];
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

    <div class="bloque">
      <form method="post" action="../Consultas_eliminaciones_modificaciones/productos/accion_alta_producto.php">  
          <p><span class="error">&emsp;* campo requerido</span></p>
        <p>
          &emsp;
          Nombre: &emsp; <input  placeholder="Nombre" type="text" name="name" id="name" value="<?php echo $Fproducto["NOMBRE"];?>"
                                    onkeyup="document.getElementById('errorName').innerHTML = lettersValidation(document.getElementById('name'))">
          <span id="errorName" class="error"></span>
        </p>
        <p>
          &emsp;
          Precio: &emsp; <input required placeholder="Precio" type="number" min="0" name="precio" id="precio" value="<?php echo $Fproducto["PRECIO"];?>" >
          <span id="errorPrecio" class="error"></span> 
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
	      <a href="../Consultas_eliminaciones_modificaciones/productos/consulta_producto.php" class="buttonAtras">Atrás</a>
      </form>
    </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
  
</body>

