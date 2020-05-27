<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionar_producto.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_REQUEST["name"])) {
        $producto["nombre"] = $_REQUEST["name"];
        $producto["precio"] = $_REQUEST["precio"];
		$_SESSION["producto"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../formularios/form_alta_producto.php");
	}  
			

	$conexion = crearConexionBD(); 

    $excepcion = crear_producto($conexion, $producto["nombre"], $producto["precio"]);

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
?>