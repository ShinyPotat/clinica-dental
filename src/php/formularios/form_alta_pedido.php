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
if(!isset($_SESSION["login"])){
  header("../login.php");
}
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

          include_once ("../cabecera.php");
    ?>

    <div class="bloque">
      <form method="post" action="../Consultas_eliminaciones_modificaciones/pedidos/accion_alta_pedido.php">  
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
        <p>
        <?php 
            require_once("../gestionBD.php");
            $conexion = crearConexionBD();
            $query = "SELECT OID_PR, Nombre FROM Proveedores ORDER BY Nombre ASC";
            $proveedor = $conexion->query($query);
            cerrarConexionBD($conexion);
        ?>
        <div>&emsp; Proveedor: <select id="proveedorPD" name="proveedorPD">
            <option value="">Seleccionar proveedor</option>
            <?php foreach($proveedor as $fila){ ?>
              <option value="<?php echo $fila["OID_PR"]; ?>"><?php echo $fila["NOMBRE"]; ?></option>

            <?php } ?>
          </select>
        </div>
      </p>
      <p>
        <?php 
            require_once("../gestionBD.php");
            $conexion = crearConexionBD();
            $query = "SELECT OID_F, Fecha_Factura FROM Facturas ORDER BY Fecha_Factura ASC";
            $facturas = $conexion->query($query);
            cerrarConexionBD($conexion);
        ?>
        <div>&emsp; Factura: <select id="FacturaPD" name="FacturaPD">
            <option value="">Seleccionar factura</option>
            <?php foreach($facturas as $fila){ ?>
              <option value="<?php echo $fila["OID_F"]; ?>"><?php echo $fila["FECHA_FACTURA"]; ?></option>

            <?php } ?>
          </select>
        </div>
      </p><br>
        <br>
        <input type="submit" name="submit" value="Enviar" class="enviar">
        <a href="../Consultas_eliminaciones_modificaciones/pedidos/consulta_pedidos.php" class="buttonAtras">Atrás</a>
      </form>
      </div>
    <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
    <script src="../../js/hora.js"></script>
  
</body>
