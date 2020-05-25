<?php 
	session_start();
	
	$excepcion = $_SESSION["excepcion"];
	unset($_SESSION["excepcion"]);
	
	if (isset ($_SESSION["destino"])) {
		$destino = $_SESSION["destino"];
		unset($_SESSION["destino"]);	
	} else 
		$destino = "";
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/excepcion.css" />
	<title>Clínica Dental: ¡Se ha producido un problema!</title>
	
</head>
<body>	
	<a href="../html/log.html" ><img class="imagen" src="../../images/logo.png" alt="logo.png" width=23% height=23%></a>

	<div class="block">
		<a href="../html/about-us.html" class="acerca">Acerca de nosotros</a>
		<!-- Estos bloques definen las id que se usan para el js de la hora -->
		<div id="box">
			<div id="box-date"></div>
			<div id="box-time"></div>
		</div>
		<p class="tError">¡Error!</p>
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
	<img src="../../images/mascotaExcepcion.png" class="mascotaE">
	<div class=error>
		<h2>¡Ups!</h2>
		<?php if ($destino<>"") { ?>
		<p>Ocurrió un problema durante el procesado de los datos. Pulse <a href="<?php echo $destino ?>">aquí</a> para volver a la página principal.</p>
		<p><?php echo $excepcion?></p>
		<?php } else { ?>
		<p>Ocurrió un problema para acceder a la base de datos. </p>
		<?php }?>
	</div>
	
	<div class='excepcion'>	
		<?php echo "Información relativa al problema: $excepcion;" ?>
	</div>

</body>
<script src="../js/hora.js"></script>
</html>