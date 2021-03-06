<?php	
	session_start();	
	
	if (isset($_SESSION["proveedor"])) {
		$proveedor = $_SESSION["proveedor"];
		unset($_SESSION["proveedor"]);
		
		require_once("../../gestionBD.php");
		require_once("gestionarProveedor.php");
		
		// CREAR LA CONEXIÓN A LA BASE DE DATOS
		$conexion = crearConexionBD();
		// INVOCAR "QUITAR_PROVEEDOR"
		$excepcion=quitar_proveedor($conexion,$proveedor["OID_PR"]);
		// CERRAR LA CONEXIÓN
		cerrarConexionBD($conexion);
		
		// SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
		if($excepcion<>""){
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"]= "Consultas_eliminaciones_modificaciones/proveedor/consulta_proveedores.php";
			header("Location: ../../excepcion.php");
		}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_PROVEEDOR.PHP"
        header("Location: consulta_proveedores.php");
		}

	}
	else // Se ha tratado de acceder directamente a este PHP 
		Header("Location: consulta_proveedores.php"); 
?>