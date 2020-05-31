<?php 

session_start();

if(!isset($_SESSION["login"])){
  header("Location: ../login.php");
}
if (!isset($_SESSION["Fclinica"])) {
  $Fclinica["name"] = "";
  $Fclinica["local"] = "";
  $Fclinica["phone"] = "";
  $Fclinica["nameD"] = "";
  $Fclinica["nCol"] = "";

  $_SESSION["Fclinica"] = $Fclinica;
}else{
  $Fclinica = $_SESSION["Fclinica"];
  unset($_SESSION["Fclinica"]);
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
<!DOCTYPE HTML>  
<html>
<head>
    <meta charset="UTF-8" lang="es">
    <title>Alta clínicas</title>
    <link rel="stylesheet", type="text/css", href="../../css/formClinicas.css">
    <script src="../../js/validacion_cliente_alta_clinica.js" type="text/javascript"></script>
</head>
<body>

    <div class="bloque">
        <form method="post" action="../Consultas_eliminaciones_modificaciones/clinica/accion_alta_clinica.php">  
          <p><span class="error"> &emsp;* campo requerido</span></p>
      <p>
        &emsp;
        Nombre: &emsp; <input placeholder="Nombre" class=name type="text" name="name" id="name" value="<?php echo $Fclinica["name"];?>"
                              onkeyup="document.getElementById('errorName').innerHTML = lettersValidation(document.getElementById('name').value);">
        <span id="errorName" class="error"></span>
      </p>
        &emsp;
        Localización: &emsp;<input placeholder="Localizacion" class=local type="text" name="local" id="local" value="<?php echo $Fclinica["local"];?>"
                                  onkeyup="document.getElementById('errorLocal').innerHTML = lettersValidation(document.getElementById('local').value);">
        <span id="errorLocal" class="error"></span> 
      <p>
       &emsp;
      Telefono de contacto: &emsp;<input id="phone" class=phone name="phone" id="phone" type="text" maxlength="9" placeholder="123456789" value="<?php echo $Fclinica["phone"];?>"
                                         onkeyup="document.getElementById('errorNum').innerHTML = numberValidation(document.getElementById('phone').value);">
      <span id="errorNum" class="error"></span>
      </p>
          <input id="moroso" name ="moroso" type="hidden" value="N">
      <p>
      &emsp;
      Nombre Dueño: &emsp;<input placeholder="Nombre del dueño" class="nameD" type="text" id="nameD" name="nameD" value="<?php echo $Fclinica["nameD"];?>"
                                onkeyup="document.getElementById('errorNameD').innerHTML = lettersValidation(document.getElementById('nameD').value);">
        <span id="errorNameD" class="error"></span>
      </p>
      &emsp;
        Numero de colegiado:&emsp;<input id="nCol" class="nCol" name="nCol" id="nCol" type="text" maxlength="4" placeholder="1234" value="<?php echo $Fclinica["nCol"];?>"
                                      onkeyup="document.getElementById('errorNumCol').innerHTML = nColValidation(document.getElementById('nCol').value);">
        <span id="errorNumCol" class="error"></span>
      <br>
      <input type="submit" name="submit" value="Enviar" class="enviar">
	    <a href="../Consultas_eliminaciones_modificaciones/clinica/consulta_clinica.php" class="buttonAtras">Atrás</a> 

      </form>
    </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
  
</body>