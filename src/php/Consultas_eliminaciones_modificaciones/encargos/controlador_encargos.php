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

			$now = new DateTime();
			if(isset($encargo["FECHA_ENTREGA"])){
				$fechaEntrega = date_create($encargo["FECHA_ENTREGA"]);
				$var2 = date_diff($now,$fechaEntrega);
				if ($var2->format("%r%a") < 0) {
					$errores[] = "<p>La fecha de entrega no puede ser antes del día de hoy</p>";
				}
			}
			
			if(isset($encargo["FECHA_ENTRADA"])){
				$fechaEntrada = date_create($encargo["FECHA_ENTRADA"]);
				$var1 = date_diff($now,$fechaEntrada);
				if ($var1->format("%r%a") < 0) {
					$errores[] = "<p>La fecha de entrada no puede ser antes del día de hoy</p>";
				}
			}

			if(isset($encargo["FECHA_ENTREGA"]) && isset($encargo["FECHA_ENTRADA"])){
				$fechaEntrega2 = date_create($encargo["FECHA_ENTREGA"]);
				$fechaEntrada2 = date_create($encargo["FECHA_ENTRADA"]);
				$var3 = date_diff($fechaEntrega2,$fechaEntrada2);
				if ($var3->format("%r%a") > 0) {
					$errores[] = "<p>La fecha de entrada debe ser antes de la de entrega</p>";
				}
			}
		}	
?>