<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionarEncargo.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_REQUEST["fechaFactura"])) {
        $encargo["fechaEntrada"] = $_REQUEST["fechaEntrada"];
        $encargo["fechaEntrega"] = $_REQUEST["fechaEntrega"];
        $encargo["Acciones"] = $_REQUEST["Acciones"];
        $encargo["OID_PC"] = $_REQUEST["OID_PC"];
        $encargo["OID_F"] = $_REQUEST["OID_F"];
		$_SESSION["encargo"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../formularios/form_alta_encargo.php");
	} 
			

	$conexion = crearConexionBD(); 

    $excepcion = crear_encargo($conexion, $encargo["fechaEntrada"], $encargo["fechaEntrega"], $encargo["Acciones"], $encargo["OID_PC"], $encargo["OID_F"]);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "formularios/form_alta_encargo.php";
		header("Location: ../../excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_ENCARGOS.PHP"
		header("Location: consulta_encargos.php");
	}

	cerrarConexionBD($conexion);
?>