<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionarFacturas.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_SESSION["Ffactura"])) {
		$nuevaFactura = $_SESSION["Ffactura"];
		$_SESSION["Ffactura"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../formularios/form_alta_facturas.php");
    } 
			

	$conexion = crearConexionBD(); 

    alta_usuario($conexion, $nuevaFactura);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "consulta_facturas.php";
		header("Location: excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_MATERIALES.PHP"
	    header("Location: consulta_facturas.php");
	}

	cerrarConexionBD($conexion);
?>