<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionarProveedor.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_SESSION["Fproveedor"])) {
		$nuevoUsuario = $_SESSION["Fproveedor"];
		$_SESSION["Fproveedor"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../formularios/form_alta_proveedor.php");
    } 
			

	$conexion = crearConexionBD(); 

    alta_usuario($conexion, $nuevoUsuario);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "consulta_proveedores.php";
		header("Location: excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_MATERIALES.PHP"
	    header("Location: consulta_proveedores.php");
	}

	cerrarConexionBD($conexion);
?>