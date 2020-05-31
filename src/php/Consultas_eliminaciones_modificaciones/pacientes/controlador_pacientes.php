<?php	
	session_start();
	
	if (isset($_REQUEST["OID_PC"])) {
		$paciente["OID_PC"] = $_REQUEST["OID_PC"];
		$paciente["DNI"] = $_REQUEST["DNI"];
		$paciente["FECHA_NACIMIENTO"] = $_REQUEST["FECHA_NACIMIENTO"];
		$paciente["E_SEXO"] = $_REQUEST["E_SEXO"];
		$paciente["OID_C"] = $_REQUEST["OID_C"];
		$_SESSION["paciente"] = $paciente;

		if (isset($_REQUEST["Guardar"])) {

			$errores = validarDatosPaciente($paciente);

			if(count($errores)>0) {
				$_SESSION["errores"] = $errores;
				Header("Location: consulta_pacientes.php");
				die;
			}
			
		}
		
		if (isset($_REQUEST["Editar"])) Header("Location: consulta_pacientes.php"); 
		else if (isset($_REQUEST["Guardar"])) Header("Location: accion_modificar_paciente.php");
		else if (isset($_REQUEST["Borrar"])) Header("Location: accion_borrar_paciente.php"); 
	}
	else 
		Header("Location: consulta_pacientes.php");

	function validarDatosPaciente($paciente) {
		
		$errores = [];

		if(!isset($paciente["DNI"]) || $paciente["DNI"]=="") {
			$errores[] = "<p>El DNI es obligatorio";
		}else if(!preg_match("/^[0-9]{8}[A-Z]$/",$paciente["DNI"])){
			$errores[] = "<p>El NIF ". $paciente["DNI"] . " es incorrecto. Debe reescribirlo.</p>";
		}

		if (!isset($paciente["FECHA_NACIMIENTO"]) || $paciente["FECHA_NACIMIENTO"]=="") {
		} else {
			$now = new DateTime();
			$fechaCobro = date_create($factura["FECHA_NACIMIENTO"]);
			$var1 = date_diff($now,$fechaCobro);
			if ($var1->format("%r%a") > 0) {
				$errores[] = "<p>La fecha de nacimiento no puede ser despues del día de hoy</p>";
			}
		}

		return $errores;
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
