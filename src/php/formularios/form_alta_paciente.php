<!DOCTYPE HTML>  
<html>
<head>
    <meta charset="UTF-8" lang="es">
    <title>Alta paciente</title>
    <link rel="stylesheet", type="text/css", href="../../css/formPaciente.css">
    <script src="../../js/validacion_cliente_alta_paciente.js" type="text/javascript"></script>
</head>
<body>  

<?php

session_start();

if(!isset($_SESSION["login"])){
  header("../login.php");
}
if (!isset($_SESSION["Fpaciente"])) {
  $Fpaciente['dni'] = "";
  $Fpaciente['fechaNacimiento'] = "";
  $Fpaciente['sexo'] = "";

  $_SESSION["Fpaciente"] = $Fpaciente;
}else{
  $Fpaciente = $_SESSION["Fpaciente"];
  unset($_SESSION["Fpaciente"]);
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

    <div class="bloque">
      <form method="post" action="../Consultas_eliminaciones_modificaciones/pacientes/accion_alta_paciente.php">  
        <p><span class="error">&emsp;* campo requerido</span></p>
      <p>
      &emsp;
        DNI*:&emsp; <input  required placeholder="DNI" maxlength="9" type="text" id="dni" name="dni" value="<?php echo $Fpaciente['DNI'];?>"
                            onkeyup="document.getElementById('errorDni').innerHTML = dniValidate(document.getElementById('dni').value);">
        <span id="errorDni" class="error"></span>
      </p>
      &emsp;
        Fecha de Nacimiento*:&emsp; <input placeholder="dd/mm/yyyy" maxlength="10" type="date" name="fechaNacimiento" required id="fechaNacimiento" value="<?php echo $Fpaciente['FECHA_NACIMIENTO'];?>" 
          oninput="document.getElementById('errorFechaNac').innerHTML = dateValidation(document.getElementById('fechaNacimiento').value);">
        <span id="errorFechaNac" class="error"></span>
      <p>
      &emsp;
        Sexo*:
        <input type="radio" name="sexo" <?php if (isset($Fpaciente['E_SEXO']) && $Fpaciente['E_SEXO']=="Hombre") echo "checked";?> value="H">Hombre
        <input type="radio" name="sexo" <?php if (isset($Fpaciente['E_SEXO']) && $Fpaciente['E_SEXO']=="Mujer") echo "checked";?> value="M">Mujer
        <span class="error"></span>
      </p>
      <p>
        <?php 
            require_once("../gestionBD.php");
            $conexion = crearConexionBD();
            $query = "SELECT OID_C, Nombre FROM Clinicas ORDER BY Nombre ASC";
            $clinicas = $conexion->query($query);
            cerrarConexionBD($conexion);
        ?>
        <div>&emsp; Clinica*: <select id="clinicaP" name="clinicaP">
            <option value="">Seleccionar clinica</option>
            <?php foreach($clinicas as $fila){ ?>
              <option value="<?php echo $fila["OID_C"]; ?>" <?php if(isset($Fpaciente['OID_C']) && $fila['OID_C']==$Fpaciente['OID_C']){ echo "selected='selected'";} ?>><?php echo $fila["NOMBRE"]; ?></option>

            <?php } ?>
          </select>
        </div>
      </p><br>
      &emsp;
        <input type="submit" name="submit" value="Enviar" class="enviar">
        <a href="../../html/listaPDP.html" class="buttonAtras">Atrás</a>
      </form>
    </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
  
</body>
