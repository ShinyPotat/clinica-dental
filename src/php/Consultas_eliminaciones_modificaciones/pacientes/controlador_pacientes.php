<?php	
	session_start();
	
	if (isset($_REQUEST["OID_PC"])) {
		$paciente["OID_PC"] = $_REQUEST["OID_PC"];
		$paciente["DNI"] = $_REQUEST["DNI"];
		$paciente["FECHA_NACIMIENTO"] = $_REQUEST["FECHA_NACIMIENTO"];
		$paciente["E_SEXO"] = $_REQUEST["E_SEXO"];
		$paciente["OID_C"] = $_REQUEST["OID_C"];
		
		$_SESSION["paciente"] = $paciente;
		
		$error = validarDatosPaciente($paciente);

		if($error !="") {
			$_SESSION["errores"] = $error;
			Header("Location: consulta_pacientes.php");
		}

		if (isset($_REQUEST["Editar"])) Header("Location: consulta_pacientes.php"); 
		else if (isset($_REQUEST["Guardar"])) Header("Location: accion_modificar_paciente.php");
		else if (isset($_REQUEST["Borrar"])) Header("Location: accion_borrar_paciente.php"); 
	}
	else 
		Header("Location: consulta_pacientes.php");

	function validarDatosPaciente($paciente) {
		$error="";

		if(!preg_match("/^[0-9]{8}[A-Z]$/",$paciente["DNI"]) {
			$error .= "<p>El NIF ". $paciente["DNI"] . "es incorrecto. Debe reescribirlo.</p>";
		}

		if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$paciente["FECHA_NACIMIENTO"])) {
			$error .= "<p>La fecha introducida no tiene un formato adecuado</p>";
		}

		if(empty($paciente["E_SEXO"])) {
			$error .= "<p>Debe de indicar el sexo</p>";
		}
	}
?>
