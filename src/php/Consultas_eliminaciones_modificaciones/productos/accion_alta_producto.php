<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionar_producto.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_REQUEST["name"])) {
        $producto["nombre"] = $_REQUEST["name"];
		$producto["precio"] = $_REQUEST["precio"];
		$producto["cantidad"] = $_REQUEST["cantidad"];
		$producto["material"] = $_REQUEST["materialPR"];
		$producto["encargo"] = $_REQUEST["encargoPR"];
		$_SESSION["producto"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../formularios/form_alta_producto.php");
	}  
	$errores = validation($producto);

	if(isset($errores) && count($errores)>0) {
		$_SESSION["errores"] = $errores;
		Header("Location: ../../formularios/form_alta_producto.php");
		die;
	}

	$conexion = crearConexionBD(); 

    $excepcion = crear_producto($conexion, $producto["nombre"], $producto["precio"], $producto["cantidad"], $producto["material"], $producto["encargo"]);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "formularios/form_alta_producto.php";
		header("Location: ../../excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_CLINICAS.PHP"
	    header("Location: consulta_producto.php");
	}

	cerrarConexionBD($conexion);
	
	function validation($producto) {
		
		$erroresF=[];

		if (isset($producto["nombre"])) {
		  	$name = test_input($producto["nombre"]);
		  	if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
				$erroresF[]= "<p>Solo puedes introducir espacios y letras en el nombre</p>";
		  	}
		}
	
		if (isset($producto["precio"])) {
			$precio = test_input($producto["precio"]);
			if ($producto["precio"] <= 0) {
				$erroresF[] = "<p>Introduce un precio adecuado</p>";
			}
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