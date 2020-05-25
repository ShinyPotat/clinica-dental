<?php	
	session_start();	
	
	if (isset($_SESSION["encargo"])) {
		$encargo = $_SESSION["encargo"];
		unset($_SESSION["encargo"]);
		
		require_once("../../gestionBD.php");
		require_once("gestionarEncargos.php");
		
		// CREAR LA CONEXIÓN A LA BASE DE DATOS
		$conexion = crearConexionBD();
		// INVOCAR "QUITAR_ENCARGO"
		$excepcion=quitar_encargo($conexion,$encargo["OID_E"]);
		// CERRAR LA CONEXIÓN
		cerrarConexionBD($conexion);
		
		// SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
		if($excepcion<>""){
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"]= "Consultas_eliminaciones_modificaciones/encargos/consulta_encargos.php";
			header("Location: ../../excepcion.php");
		}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_ENCARGOS.PHP"
		header("Location: consulta_encargos.php");
		}

	}
	else // Se ha tratado de acceder directamente a este PHP 
		Header("Location: consulta_encargos.php"); 
?>