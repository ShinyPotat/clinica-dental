<?php	
	session_start();	
	
	if (isset($_SESSION["paciente"])) {
		$paciente = $_SESSION["paciente"];
		unset($_SESSION["paciente"]);
		
		require_once("../../gestionBD.php");
		require_once("gestionarPacientes.php");
		
		// CREAR LA CONEXIÓN A LA BASE DE DATOS
		$conexion = crearConexionBD();
		// INVOCAR "QUITAR_PACIENTE"
		$excepcion=quitar_paciente($conexion,$paciente["OID_PC"]);
		// CERRAR LA CONEXIÓN
		cerrarConexionBD($conexion);
		
		// SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
		if($excepcion<>""){
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"]= "Consultas_eliminaciones_modificaciones/pacientes/consulta_pacientes.php";
			header("Location: ../../excepcion.php");
		}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_pacientes.PHP"
		header("Location: consulta_pacientes.php");
		}

	}
	else // Se ha tratado de acceder directamente a este PHP 
		Header("Location: consulta_pacientes.php"); 
?>