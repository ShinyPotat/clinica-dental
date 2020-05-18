<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionar_clinica.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_REQUEST["name"])) {
        $clinica["name"] = $_REQUEST["name"];
        $clinica["local"] = $_REQUEST["local"];
        $clinica["phone"] = $_REQUEST["phone"];
        $clinica["moroso"] = $_REQUEST["moroso"];
        $clinica["nameD"] = $_REQUEST["nameD"];
        $clinica["nCol"] = $_REQUEST["nCol"];
		$_SESSION["clinica"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../formularios/form_alta_clinica.php");
	}  
			

	$conexion = crearConexionBD(); 

    crear_clinica($conexion, $clinica["name"], $clinica["local"], $clinica["phone"], $clinica["moroso"], $clinica["nameD"], $clinica["nCol"]);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "consulta_clinica.php";
		header("Location: excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_MATERIALES.PHP"
	    header("Location: consulta_clinica.php");
	}

	cerrarConexionBD($conexion);
?>