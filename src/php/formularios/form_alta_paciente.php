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
if(!isset($_SESSION["login"])){
  header("../login.php");
}
$dniErr = $fechaNacimientoErr = $sexoErr ="";
$dni = $fechaNacimiento = $sexo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["dni"])) {
        $dniErr = "Este campo es obligatorio";
      } else {
        $dni = test_input($_POST["dni"]);
        if (!preg_match("/^[0-9]{8,8}[A-Za-z]$/",$dni)) {
          $dniErr = "Introduce un dni adecuado";
        }
      }

      if (empty($_POST["fechaNacimiento"])) {
        $fechaNacimientoErr = "";
      } else {
        $fechaNacimiento = test_input($_POST["fechaNacimiento"]);
        }
      } 
      
      if (empty($_POST["sexo"])) {
        $sexoErr = "";
      } else {
        $sexo = test_input($_POST["sexo"]);
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
      <form method="post" action="../Consultas_eliminaciones_modificaciones/pacientes/accion_alta_paciente.php">  
        <p><span class="error">&emsp;* campo requerido</span></p>
      <p>
      &emsp;
        DNI*:&emsp; <input  required placeholder="DNI" maxlength="9" type="text" id="dni" name="dni" value="<?php echo $dni;?>"
                            onkeyup="document.getElementById('errorDni').innerHTML = dniValidate(document.getElementById('dni').value);">
        <span id="errorDni" class="error"> <?php echo $dniErr;?></span>
      </p>
      &emsp;
        Fecha de Nacimiento*:&emsp; <input placeholder="dd/mm/yyyy" maxlength="10" type="date" name="fechaNacimiento" required id="fechaNacimiento" value="<?php echo $fechaNacimiento;?>" 
          oninput="document.getElementById('errorFechaNac').innerHTML = dateValidation(document.getElementById('fechaNacimiento').value);">
        <span id="errorFechaNac" class="error"> <?php echo $fechaNacimientoErr;?></span>
      <p>
      &emsp;
        Sexo:
        <input type="radio" name="sexo" <?php if (isset($sexo) && $sexo=="Hombre") echo "checked";?> value="H">Hombre
        <input type="radio" name="sexo" <?php if (isset($sexo) && $sexo=="Mujer") echo "checked";?> value="M">Mujer
        <span class="error"> <?php echo $sexoErr;?></span>
      </p>
      <p>
        <?php 
            require_once("../gestionBD.php");
            $conexion = crearConexionBD();
            $query = "SELECT OID_C, Nombre FROM Clinicas ORDER BY Nombre ASC";
            $clinicas = $conexion->query($query);
            cerrarConexionBD($conexion);
        ?>
        <div>&emsp; Clinica: <select id="clinicaP" name="clinicaP">
            <option value="">Seleccionar clinica</option>
            <?php foreach($clinicas as $fila){ ?>
              <option value="<?php echo $fila["OID_C"]; ?>"><?php echo $fila["NOMBRE"]; ?></option>

            <?php } ?>
          </select>
        </div>
      </p><br>
      &emsp;
        <input type="submit" name="submit" value="Enviar" class="enviar">
        <a href="../../html/listaPDP.html" class="buttonAtras">Atrás</a>
      </form>

      <div class="results">
        <?php
        echo "<h2>Datos introducidos:</h2>";
        echo $dni;
        echo "<br>";
        echo $fechaNacimiento;
        echo "<br>";
        echo $sexo;
        echo"<br>";
        ?>
        </div>
    </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
  
</body>
