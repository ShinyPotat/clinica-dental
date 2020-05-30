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
session_start();

if(!isset($_SESSION["login"])){
  header("../login.php");
}
if (!isset($_SESSION["Fencargo"])) {
  $Fencargo["FECHAENTRADA"] = "";
  $Fencargo["FECHAENTREGA"] = "";
  $Fencargo["ACCIONES"] = "";
  $Fencargo["OID_PC"] = "";
  $Fencargo["OID_F"] = "";

  $_SESSION["Fclinica"] = $Fencargo;
}else{
  $Fencargo = $_SESSION["Fencargo"];
  unset($_SESSION["Fencargo"]);
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
      <form id="formEncargo" method="post" action="../Consultas_eliminaciones_modificaciones/encargos/accion_alta_encargo.php">  
          <p><span class="error">&emsp;* campo requerido</span></p>
          <p>
          &emsp;
          Fecha de entrada: <input placeholder="dd/mm/yyyy" maxlength="10" type="date" name="fechaEntrada" id="fechaEntrada" value="<?php echo $Fencargo["FECHAENTRADA"];?>"
                                    oninput="document.getElementById('errorEntrada').innerHTML = entradaValidation(document.getElementById('fechaEntrada').value)">
          <span id="errorEntrada" class="error"></span>
          </p>
          <p>
          &emsp;
          Fecha de entrega: <input placeholder="dd/mm/yyyy" maxlength="10" type="date" name="fechaEntrega" id="fechaEntrega" value="<?php echo $Fencargo["FECHAENTREGA"];?>" 
              oninput="document.getElementById('entregaError').innerHTML = dateValidation(document.getElementById('fechaEntrada').value,document.getElementById('fechaEntrega').value);">
          <span id="entregaError" class="error"></span> 
          </p>
          <p>
          &emsp;
          Acciones: <input placeholder="Acciones" type="text" name="Acciones" id="Acciones" value="<?php echo $Fencargo["ACCIONES"];?>">
          </p>
          <p>
          <?php 
              require_once("../gestionBD.php");
              $conexion = crearConexionBD();
              $query = "SELECT OID_PC, DNI FROM Pacientes ORDER BY DNI ASC";
              $pacientes = $conexion->query($query);
              cerrarConexionBD($conexion);
          ?>
          <div>&emsp; Paciente: <select id="PacienteE" name="PacienteE">
              <option value="">Seleccionar paciente</option>
              <?php foreach($pacientes as $fila){ ?>
                <option value="<?php echo $fila["OID_PC"]; ?>"><?php echo $fila["DNI"]; ?></option>
              <?php } ?>
            </select>
          </div>
        </p>
        <p>
          <?php 
              require_once("../gestionBD.php");
              $conexion = crearConexionBD();
              $query = "SELECT OID_F, FECHA_FACTURA FROM Facturas ORDER BY OID_F ASC";
              $facturas = $conexion->query($query);
              cerrarConexionBD($conexion);
          ?>
          <div>&emsp; Factura: <select id="FacturaE" name="FacturaE">
              <option value="">Seleccionar factura</option>
              <?php foreach($facturas as $fila){ ?>
                <option value="<?php echo $fila["OID_F"]; ?>"><?php echo $fila["FECHA_FACTURA"]; ?></option>
              <?php } ?>
            </select>
          </div>
        </p><br>         
          <input type="submit" name="submit" value="Enviar" class="enviar">
          <a href="../../html/listaEncargosTrabajos.html" class="buttonAtras">Atrás</a>
          </p>
      </form>
    </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
    </body>

