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
			
	$errores = validarDatosClinicasF($paciente);

	if(isset($errores) && count($errores)>0) {
		$_SESSION["Fclinica"] = $clinica;
		$_SESSION["errores"] = $errores;
		Header("Location: ../../formularios/form_alta_clinicas.php");
		die;
	}

	$conexion = crearConexionBD(); 

    $excepcion = crear_clinica($conexion, $clinica["name"], $clinica["local"], $clinica["phone"], $clinica["moroso"], $clinica["nameD"], $clinica["nCol"]);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "formularios/form_alta_clinica.php";
		header("Location: ../../excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_CLINICAS.PHP"
	    header("Location: consulta_clinica.php");
	}

	cerrarConexionBD($conexion);

	function validarDatosClinicasF($paciente) {

		$errores = [];

		if (empty($clinica["name"])) {
			$errores[] = "Este campo es obligatorio";
		} else {
			$name = test_input($clinica["name"]);
			if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
				$errores[] = "Solo puedes introducir espacios y letras";
			}
		}
		if (empty($clinica["local"])) {
			$errores[] = "";
		} else {
			$local = test_input($clinica["local"]);
			if (!preg_match("/^[a-zA-Z ]*$/",$local)) {
				$errores[] = "Solo puedes introducir espacios y letras";
			}
		}
		if (empty($clinica["phone"])) {
			$errores[] = "";
		} else {
			$phone = test_input($clinica["phone"]);
			if (!preg_match("^[0-9]{9}^",$phone)) {
				$errores[] = "Escribe un número adecuado";
			}
		}
		if (empty($clinica["nameD"])) {
			$errores[] = "";
		} else {
			$nameD = test_input($clinica["nameD"]);
			if (!preg_match("/^[a-zA-Z ]*$/",$nameD)) {
				$errores[] = "Solo puedes introducir espacios y letras";
			}
		}
		
		if (empty($clinica["nCol"])) {
			$errores[] = "";
		} else {
			$nCol = test_input($clinica["nCol"]);
			if (!preg_match("^[0-9]{4}^",$nCol)) {
				$errores[] = "Escribe un número adecuado";
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