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
$fechaEntregaErr = $fechaEntradaErr = $accionesErr ="";
$fechaEntrega = $fechaEntrada = $acciones ="";

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
      <form id="formEncargo" method="post" action="../Consultas_eliminaciones_modificaciones/encargos/accion_alta_encargo.php">  
          <p><span class="error">&emsp;* campo requerido</span></p>
          <p>
          &emsp;
          Fecha de entrada: <input placeholder="dd/mm/yyyy" maxlength="10" type="date" name="fechaEntrada" id="fechaEntrada" value="<?php echo $fechaEntrada;?>"
                                    oninput="document.getElementById('errorEntrada').innerHTML = entradaValidation(document.getElementById('fechaEntrada').value)">
          <span id="errorEntrada" class="error"> <?php echo $fechaEntradaErr;?></span>
          </p>
          <p>
          &emsp;
          Fecha de entrega: <input placeholder="dd/mm/yyyy" maxlength="10" type="date" name="fechaEntrega" id="fechaEntrega" value="<?php echo $fechaEntrega;?>" 
              oninput="document.getElementById('entregaError').innerHTML = dateValidation(document.getElementById('fechaEntrada').value,document.getElementById('fechaEntrega').value);">
          <span id="entregaError" class="error"> <?php echo $fechaEntregaErr;?></span> 
          </p>
          <p>
          Acciones: <input placeholder="Acciones" type="text" name="Acciones" id="Acciones" value="<?php echo $acciones;?>">
          </p>
          <p>
          <?php 
              require_once("../gestionBD.php");
              $conexion = crearConexionBD();
              $query = "SELECT OID_PC, DNI FROM Pacientes ORDER BY DNI ASC";
              $pacientes = $conexion->query($query);
              cerrarConexionBD($conexion);
          ?>
          <div>Paciente: <select id="PacienteE" name="PacienteE">
              <option value="">Seleccionar paciente</option>
              <?php foreach($pacientes as $fila){ ?>
                <option value="<?php echo $fila["OID_PC"]; ?>"><?php echo $fila["DNI"]; ?></option>
              <?php } ?>
            </select>
          </div>
        </p><br>
        <p>
          <?php 
              require_once("../gestionBD.php");
              $conexion = crearConexionBD();
              $query = "SELECT OID_F, FECHA_FACTURA FROM Facturas ORDER BY OID_F ASC";
              $facturas = $conexion->query($query);
              cerrarConexionBD($conexion);
          ?>
          <div>Factura: <select id="FacturaE" name="FacturaE">
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

