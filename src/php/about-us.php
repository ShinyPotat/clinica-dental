<?php
session_start();

	if(!isset($_SESSION["login"])){
		header("login.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" lang="es">
    <title>Inicio</title>
    <link rel="stylesheet" type="text/css" href="../css/about-us.css">
</head>

<body>
    
    <?php include_once ("cabeceraR.php"); ?>

    <img class="mascota" src="../../images/mascota.png" alt="mascota.png" width=35% height=45%>

    <div class="bloqueIzquierda">
        <pre class="texto">Somos el grupo IS-G3-JMCV-Clínica dental 10, formado por: 
        José Luis Alonso Rocha        joseluisalro20@gmail.com
        Javier Pacheco Marquez        pachecomarquezjavier@gmail.com
        Jaime Ramos Lara              j23rl07@gmail.com
        Alberto Antonio Tokos Matas   belatm12@gmail.com</pre>
        
    </div>
    <script src="../js/hora.js"></script>
</body>