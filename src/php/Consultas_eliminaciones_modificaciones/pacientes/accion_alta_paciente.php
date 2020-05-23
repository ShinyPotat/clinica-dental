<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionarPacientes.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_REQUEST["DNI"])) {
        $paciente["DNI"] = $_REQUEST["DNI"];
        $paciente["FECHA_NACIMIENTO"] = $_REQUEST["FECHA_NACIMIENTO"];
        $paciente["E_SEXO"] = $_REQUEST["E_SEXO"];
        $paciente["OID_C"] = $_REQUEST["OID_C"];
		$_SESSION["paciente"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../formularios/form_alta_paciente.php");
	} 

	$conexion = crearConexionBD(); 

    $excepcion = crear_paciente($conexion, $paciente["DNI"],$paciente["FECHA_NACIMIENTO"],$paciente["E_SEXO"],$paciente["OID_C"]);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "consulta_pacientes.php";
		header("Location: ../../excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_PACIENTES.PHP"
	    header("Location: consulta_pacientes.php");
	}

	cerrarConexionBD($conexion);
?>