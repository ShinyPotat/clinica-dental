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
    
    <a href="log.html" ><img class="imagen" src="../../images/logo.png" alt="logo.png" width=23% height=23%></a>

    <div class="block">
        <a href="about-us.html" class="acerca">Acerca de nosotros</a>
        <!-- Estos bloques definen las id que se usan para el js de la hora -->
        <div id="box">
            <div id="box-date"></div>
            <div id="box-time"></div>
        </div>
        
        <img class="calendario" src="../../images/calendario.png" width="1%" height="11%">
        <img class="reloj" src="../../images/reloj.png" width="1%" height="11%">
        
        <img class="usuario" src="../../images/user.png" width="1.5%" height="13%">
        
        <img class="flechaA" src="../../images/flechaA.png" width="20" height="20">
        
        <select class="botonUsuario">
            <option value="1">Usuario</option>
            <option value="2">Opcion 2</option>
            <option value="3">Opcion 3</option>
        </select>
    </div>

    <p class="textAcc">Acceso rápido</p>
    <a class="textBack">Volver a Inicio</p>

    <div class="columna1">

        <a href="listaInventarioPedidos.html" class="button">Inventario</a>

        <a href="listaEncargosTrabajos.html" class="button">Encargos</a>

        <a href="listaInventarioPedidos.html" class="button">Pedidos</a>
    
        <a href="listaInventarioPedidos.html" class="button">Proveedores</a>

    </div>

    <div class="columna3">
        <a href="listaPDP.html" class="button">Clínicas</a>    

        <a href="listaPDP.html" class="button">Pacientes</a>

        <a href="listaFacturas.html" class="button">Facturas</a>

        <a href="listaPDP.html" class="button">Productos</a>

    </div>

    <img src="../../images/mascotaD.png" class="mascota" width="20%" height="30%">
    <img src="../../images/textoMascota.png" class="textoMascota" width="30%" height="30%">
    <p class="comentario"> ¡Bienvenido al sistema!</p>
    <p class="comentario2">Elija una opción para continuar</p>
    <a href="log.html"  class="buttonAtras">«</a>
    <script src="../js/hora.js"></script>
</body>
</html>