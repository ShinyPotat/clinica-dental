<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionarProveedor.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_REQUEST["name"])) {
        $proveedor["name"] = $_REQUEST["name"];
        $proveedor["local"] = $_REQUEST["local"];
        $proveedor["phone"] = $_REQUEST["phone"];
		$_SESSION["proveedor"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../formularios/form_alta_proveedor.php");
	} 
	
	$errores = validation($proveedor);

	if(isset($errores) && count($errores)>0) {
		$_SESSION["errores"] = $errores;
		Header("Location: ../../formularios/form_alta_paciente.php");
		die;
	}

	$conexion = crearConexionBD(); 

    $excepcion = crear_proveedor($conexion, $proveedor["name"], $proveedor["local"], $proveedor["phone"]);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "formularios/form_alta_proveedor.php";
		header("Location: ../../excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_PROVEEDORES.PHP"
	    header("Location: consulta_proveedores.php");
	}

	cerrarConexionBD($conexion);

	function validation($proveedor){

		$errores = [];

		if (empty($proveedor["name"])) {
			$nameErr = "Este campo es obligatorio";
		} else {
			$name = test_input($proveedor["name"]);
			if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
			  $nameErr = "Solo puedes introducir espacios y letras";
			}
		}
	  
		if (empty($proveedor["local"])) {
			  $local = "";
		} else {
			$local = test_input($proveedor["local"]);
			if (!preg_match("/^[a-zA-Z ]*$/",$local)) {
				$localErr = "Solo puedes introducir espacios y letras";
			}
		}
	  
		if (empty($proveedor["phone"])) {
			$phone = "";
		} else {
			$phone = test_input($proveedor["phone"]);
			if (!preg_match("^[0-9]{9}^",$phone)) {
				$phoneErr = "Escribe un número adecuado";
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