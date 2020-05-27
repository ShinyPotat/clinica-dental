<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionarEncargos.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_REQUEST["fechaEntrada"])) {
        $encargo["FECHAENTRADA"] = $_REQUEST["fechaEntrada"];
        $encargo["FECHAENTREGA"] = $_REQUEST["fechaEntrega"];
        $encargo["ACCIONES"] = $_REQUEST["Acciones"];
        $encargo["OID_PC"] = $_REQUEST["PacienteE"];
        $encargo["OID_F"] = $_REQUEST["FacturaE"];
		$_SESSION["encargo"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../../formularios/form_alta_encargo.php");
	} 
			

	$conexion = crearConexionBD(); 

    $excepcion = crear_encargo($conexion, $encargo["FECHAENTRADA"], $encargo["FECHAENTREGA"], $encargo["ACCIONES"], $encargo["OID_PC"], $encargo["OID_F"]);

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