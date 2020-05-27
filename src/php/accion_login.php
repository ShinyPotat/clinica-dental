<?php
	session_start();
	
	require_once("../gestionBD.php");

	if (isset($_SESSION["user"])) {
		$nuevoUsuario = $_SESSION["user"];
		$_SESSION["user"] = null;
		$_SESSION["errores"] = null;
	}
	else{
		Header("Location: form-register.php");	
	}

	$conexion = crearConexionBD();
	$excepcion = alta_usuario($conexion, $nuevoUsuario);
	cerrarConexionBD($conexion);

	if($excepcion<>""){							
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "user-register/form-register.php";
		header("Location: ../excepcion.php");
	} else {  
		$_SESSION['login'] = $nuevoUsuario;
		header("../accesorapido.php");
	}
?>