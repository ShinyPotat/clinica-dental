<?php	
	session_start();
	
	if (isset($_REQUEST["OID_E"])) {
		$encargo["OID_E"] = $_REQUEST["OID_E"];
		$encargo["FECHA_ENTRADA"] = $_REQUEST["FECHA_ENTRADA"];
		$encargo["FECHA_ENTREGA"] = $_REQUEST["FECHA_ENTREGA"];
		$encargo["Acciones"] = $_REQUEST["ACCIONES"];
		$encargo["OID_PC"] = $_REQUEST["OID_PC"];
        $encargo["OID_F"] = $_REQUEST["OID_F"];
		
		$_SESSION["encargo"] = $encargo;

		if (isset($_REQUEST["Guardar"])) {

			$errores = validarDatosEncargos($encargo);

			if(count($errores)>0) {
				$_SESSION["errores"] = $errores;
				Header("Location: consulta_encargos.php");
				die;
			}
		}
			
		if (isset($_REQUEST["Editar"])) Header("Location: consulta_encargos.php"); 
		else if (isset($_REQUEST["Guardar"])) Header("Location: accion_modificar_encargo.php");
		else if (isset($_REQUEST["Borrar"])) Header("Location: accion_borrar_encargo.php"); 
	}
	else 
		Header("Location: consulta_encargos.php");

		function validarDatosEncargos($encargo){
			$errores = [];
	
			if (isset($encargo["FECHA_ENTREGA"])) {
				$fechaEntrega = test_input($encargo["FECHA_ENTREGA"]);
			}
		
			if (isset($encargo["FECHA_ENTRADA"])) {
				$fechaEntrada = test_input($encargo["FECHA_ENTRADA"]);
			}
		}
		
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	
?>