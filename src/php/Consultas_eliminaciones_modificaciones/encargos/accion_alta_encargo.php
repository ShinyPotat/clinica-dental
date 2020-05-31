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
			
	$errores = validarDatosEncargosF($encargo);

	if(isset($errores) && count($errores)>0) {
		$_SESSION["Fencargo"] = $encargo;
		$_SESSION["errores"] = $errores;
		Header("Location: ../../formularios/form_alta_encargo.php");
		die;
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

	function validarDatosEncargosF($encargo){
		$errores = [];

		$now = new DateTime();
		if(isset($encargo["FECHAENTREGA"])){
			$fechaEntrega = date_create($encargo["FECHAENTREGA"]);
			$var2 = date_diff($now,$fechaEntrega);
			if ($var2->format("%r%a") < 0) {
				$errores[] = "<p>La fecha de entrega no puede ser antes del día de hoy</p>";
			}
		}
		
		if(isset($encargo["FECHAENTRADA"])){
			$fechaEntrada = date_create($encargo["FECHAENTRADA"]);
			$var1 = date_diff($now,$fechaEntrada);
			if ($var1->format("%r%a") < 0) {
				$errores[] = "<p>La fecha de entrada no puede ser antes del día de hoy</p>";
			}
		}

		if(isset($encargo["FECHAENTREGA"]) && isset($encargo["FECHAENTRADA"])){
			$fechaEntrega2 = date_create($encargo["FECHAENTREGA"]);
			$fechaEntrada2 = date_create($encargo["FECHAENTRADA"]);
			$var3 = date_diff($fechaEntrega2,$fechaEntrada2);
			if ($var3->format("%r%a") > 0) {
				$errores[] = "<p>La fecha de entrada debe ser antes de la de entrega</p>";
			}
		}	
	}
?>