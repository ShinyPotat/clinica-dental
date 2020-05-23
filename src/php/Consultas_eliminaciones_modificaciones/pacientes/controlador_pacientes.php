<?php	
	session_start();
	
	if (isset($_REQUEST["OID_PC"])) {
		$paciente["OID_PC"] = $_REQUEST["OID_PC"];
		$paciente["DNI"] = $_REQUEST["DNI"];
		$paciente["FECHA_NACIMIENTO"] = $_REQUEST["FECHA_NACIMIENTO"];
		$paciente["E_SEXO"] = $_REQUEST["E_SEXO"];
		$paciente["OID_C"] = $_REQUEST["OID_C"];
		
		$_SESSION["paciente"] = $paciente;
			
		if (isset($_REQUEST["Editar"])) Header("Location: consulta_pacientes.php"); 
		else if (isset($_REQUEST["Guardar"])) Header("Location: accion_modificar_paciente.php");
		else if (isset($_REQUEST["Borrar"])) Header("Location: accion_borrar_paciente.php"); 
	}
	else 
		Header("Location: consulta_pacientes.php");
	
?>