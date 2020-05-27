<?php
	
	session_start();
	
	require_once("../gestionBD.php");
	require_once("gestion-usuario.php");

	if (isset($_SESSION["user"])) {
		$nuevoUsuario = $_SESSION["user"];
		$_SESSION["nuevoUsuario"] = null;
		$_SESSION["errores"] = null;
	}
	else{
		Header("Location: form-register.php");	
	}

	$conexion = crearConexionBD();
	$excepcion = alta_usuario($conexion, $nuevoUsuario["name"],$nuevoUsuario["lastname"],$nuevoUsuario["correo"],$nuevoUsuario["user"],$nuevoUsuario["pass"],$nuevoUsuario["perfil"]);
	cerrarConexionBD($conexion);

	if($excepcion<>""){							
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "user-register/form-register.php";
		header("Location: ../excepcion.php");
	} else {  
		$_SESSION['login'] = $nuevoUsuario;
		Header("Location: ../accion_login.php");
	}
?>