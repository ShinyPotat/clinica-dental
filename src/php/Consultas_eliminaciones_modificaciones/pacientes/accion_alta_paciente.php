<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionarPacientes.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_REQUEST["dni"])) {
        $paciente["DNI"] = $_REQUEST["dni"];
        $paciente["FECHA_NACIMIENTO"] = $_REQUEST["fechaNacimiento"];
        $paciente["E_SEXO"] = $_REQUEST["sexo"];
        $paciente["OID_C"] = $_REQUEST["clinicaP"];
		$_SESSION["paciente"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../formularios/form_alta_paciente.php");
	}
	
	$errores = validarDatosPacienteF($paciente);

	if(isset($errores) && count($errores)>0) {
		$_SESSION["errores"] = $errores;
		$_SESSION["Fpaciente"] = $paciente;
		Header("Location: ../../formularios/form_alta_paciente.php");
		die;
	}

	$conexion = crearConexionBD(); 

    $excepcion = crear_paciente($conexion, $paciente["DNI"],$paciente["FECHA_NACIMIENTO"],$paciente["E_SEXO"],$paciente["OID_C"]);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "formularios/form_alta_paciente.php";
		header("Location: ../../excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_PACIENTES.PHP"
	    header("Location: consulta_pacientes.php");
	}

	cerrarConexionBD($conexion);

	function validarDatosPacienteF($paciente) {
		$erroresF = [];

		if (!isset($paciente["DNI"]) || $paciente["DNI"]=="") {
			$erroresF[] = "<p>El campo dni es obligatorio</p>";
		} else {
			$dni = test_input($paciente["DNI"]);
			if (!preg_match("/^[0-9]{8,8}[A-Za-z]$/",$dni)) {
				$erroresF[] = "<p>Introduce un dni adecuado</p>";
			}
		}
		if (!isset($paciente["FECHA_NACIMIENTO"]) || $paciente["FECHA_NACIMIENTO"]=="") {
			$erroresF[] = "<p>El campo Fecha de Nacimiento es obligatorio</p>";
		} else {
			$fechaNacimiento = test_input($paciente["FECHA_NACIMIENTO"]);
			// nacimiento futuro?-------------------------------------------------------------
		}
		if (!isset($paciente["E_SEXO"]) || $paciente["E_SEXO"]=="") {
			$erroresF[] = "<p>El campo sexo es obligatorio</p>";
		} else {
			$sexo = test_input($paciente["E_SEXO"]);
		}
		if($paciente["OID_C"]==""){
			$erroresF[] = "<p>El campo clinica es obligatorio</p>";
		}
		return $erroresF;
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>