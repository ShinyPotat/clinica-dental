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

  session_start();

  if(!isset($_SESSION["login"])){
    header("Location: ../login.php");
  }

  if (!isset($_SESSION["Fpedido"])) {
    $pedido["fechaSolicitud"] = "";
    $pedido["fechaEntrega"] = "";
    $pedido["cantidad"] = "";
    $pedido["materialPD"] = "";
    $pedido["proveedorPD"] = "";
    $pedido["facturaPD"] = "";
  }else{
    $pedido = $_SESSION["Fpedido"];
    unset($_SESSION["Fpedido"]);
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
      <form method="post" action="../Consultas_eliminaciones_modificaciones/pedidos/accion_alta_pedido.php">  
        <p><span class="error">&emsp;* campo requerido</span></p>
        <p>
        &emsp;
        Fecha de solicitud: &emsp; <input placeholder="dd/mm/yyyy" maxlength="10" type="date" id="fechaSolicitud" name="fechaSolicitud" value="<?php echo $pedido["fechaSolicitud"];?>"
                                            oninput="document.getElementById('errorSolicitud').innerHTML = solicitudValidation(document.getElementById('fechaSolicitud'))">
        <span id="errorSolicitud" class="error"></span>
        </p>
        <p>
        &emsp;
        Fecha de de entrega:&emsp; <input placeholder="dd/mm/yyyy" maxlength="10" type="date" id="fechaEntrega" name="fechaEntrega" value="<?php echo $pedido["fechaEntrega"];?>"
                                        oninput="document.getElementById('errorFecha').innerHTML = entregaValidation(document.getElementById('fechaEntrega'));">
        <span id="errorFecha" class="error"></span>
        </p>
        <p>
          &emsp;
          Cantidad: &emsp; <input required placeholder="Cantidad" type="number" min="0" name="cantidad" id="cantidad" value="<?php echo $Fproducto["CANTIDAD"];?>" >
          <span id="errorCantidad" class="error"></span> 
        </p>
        <p>
        <?php 
            require_once("../gestionBD.php");
            $conexion = crearConexionBD();
            $query = "SELECT OID_M, Nombre FROM materiales ORDER BY Nombre ASC";
            $material = $conexion->query($query);
            cerrarConexionBD($conexion);
        ?>
        <div>&emsp; Material: <select required id="materialPD" name="materialPD">
            <option value="">Seleccionar material</option>
            <?php foreach($material as $fila){ ?>
              <option value="<?php echo $fila["OID_M"]; ?>" <?php if($fila["OID_M"] == $pedido["materialPD"]){ echo "selected='selected'";} ?>><?php echo $fila["NOMBRE"]; ?></option>

            <?php } ?>
          </select>
        </div>
      </p>
        <p>
        <?php 
            require_once("../gestionBD.php");
            $conexion = crearConexionBD();
            $query = "SELECT OID_PR, Nombre FROM Proveedores ORDER BY Nombre ASC";
            $proveedor = $conexion->query($query);
            cerrarConexionBD($conexion);
        ?>
        <div>&emsp; Proveedor: <select required id="proveedorPD" name="proveedorPD">
            <option value="">Seleccionar proveedor</option>
            <?php foreach($proveedor as $fila){ ?>
              <option value="<?php echo $fila["OID_PR"]; ?>" <?php if($fila["OID_PR"] == $pedido["proveedorPD"]){ echo "selected='selected'";} ?>><?php echo $fila["NOMBRE"]; ?></option>

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
        <div>&emsp; Factura: <select required id="FacturaPD" name="FacturaPD">
            <option value="">Seleccionar factura</option>
            <?php foreach($facturas as $fila){ ?>
              <option value="<?php echo $fila["OID_F"]; ?>"<?php if($fila["OID_F"] == $pedido["facturaPD"]){ echo "selected='selected'";} ?>><?php echo $fila["FECHA_FACTURA"]; ?></option>

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
