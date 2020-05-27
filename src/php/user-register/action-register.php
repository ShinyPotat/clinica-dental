<?php
	
	session_start();
	
	require_once("../gestionBD.php");
	require_once("gestion-usuario.php");

	if (isset($_SESSION["nuevoUsuario"])) {
		$nuevoUsuario = $_SESSION["nuevoUsuario"];
		$_SESSION["nuevoUsuario"] = null;
		$_SESSION["errores"] = null;
	}
	else{
		Header("Location: form-register.php");	
	}

	$conexion = crearConexionBD();
	$excepcion = alta_usuario($conexion, $nuevoUsuario["nombre"],$nuevoUsuario["apellidos"],$nuevoUsuario["perfil"],$nuevoUsuario["correo"],$nuevoUsuario["user"],$nuevoUsuario["pass"]);
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