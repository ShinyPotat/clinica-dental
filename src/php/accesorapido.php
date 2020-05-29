<?php
session_start();

if(!isset($_SESSION["login"])){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <meta charset="UTF-8" lang="es">
    <title>Acceso Rápido</title>
    <link rel="stylesheet" type="text/css" href="../css/accesorapido.css">
</head>
<body>
    
    <?php include_once ("cabeceraR.php"); ?>

    <p class="textAcc">Acceso rápido</p>
    <a class="textBack">Volver a Inicio</p>

    <div class="columna1">

        <a href="Consultas_eliminaciones_modificaciones/materiales/consulta_materiales.php" class="button">Inventario</a>

        <a href="Consultas_eliminaciones_modificaciones/encargos/consulta_encargos.php" class="button">Encargos</a>

        <a href="Consultas_eliminaciones_modificaciones/pedidos/consulta_pedidos.php" class="button">Pedidos</a>
    
        <a href="Consultas_eliminaciones_modificaciones/proveedores/consulta_proveedores.php" class="button">Proveedores</a>

    </div>

    <div class="columna3">
        <a href="Consultas_eliminaciones_modificaciones/clinicas/consulta_clinica.php" class="button">Clínicas</a>    

        <a href="Consultas_eliminaciones_modificaciones/pacientes/consulta_pacientes.php" class="button">Pacientes</a>

        <a href="Consultas_eliminaciones_modificaciones/facturas/consulta_facturas.php" class="button">Facturas</a>

        <a href="Consultas_eliminaciones_modificaciones/productos/consulta_producto.php" class="button">Productos</a>

    </div>

    <img src="../../images/mascotaD.png" class="mascota" width="20%" height="30%">
    <img src="../../images/textoMascota.png" class="textoMascota" width="30%" height="30%">
    <p class="comentario"> ¡Bienvenido al sistema!</p>
    <p class="comentario2">Elija una opción para continuar</p>
    <a href="log.html"  class="buttonAtras">«</a>
    <script src="../js/hora.js"></script>
</body>
</html>