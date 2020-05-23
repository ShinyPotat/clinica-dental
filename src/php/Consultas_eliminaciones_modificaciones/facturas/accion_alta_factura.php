<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionarFacturas.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_REQUEST["fechaFactura"])) {
        $factura["fechaCobro"] = $_REQUEST["fechaCobro"];
        $factura["fechaVencimiento"] = $_REQUEST["fechaVencimiento"];
        $factura["fechaFactura"] = $_REQUEST["fechaFactura"];
        $factura["precioTotal"] = $_REQUEST["precioTotal"];
		$_SESSION["factura"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../formularios/form_alta_factura.php");
	} 
			

	$conexion = crearConexionBD(); 

    $excepcion = crear_Factura($conexion, $factura["fechaCobro"], $factura["fechaVencimiento"], $factura["fechaFactura"], $factura["precioTotal"]);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "consulta_facturas.php";
		header("Location: ../../excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_FACTURAS.PHP"
		header("Location: consulta_facturas.php");
	}

	cerrarConexionBD($conexion);
?>