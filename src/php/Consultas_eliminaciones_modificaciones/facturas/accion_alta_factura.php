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
		
	$errores = validation($factura);

	if(isset($errores) && count($errores)>0) {
		$_SESSION["errores"] = $errores;
		$_SESSION["Ffactura"] = $factura;
		Header("Location: ../../formularios/form_alta_facturas.php");
		die;
	}

	$conexion = crearConexionBD(); 

    $excepcion = crear_Factura($conexion, $factura["fechaCobro"], $factura["fechaVencimiento"], $factura["fechaFactura"], $factura["precioTotal"]);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "formularios/form_alta_factura.php";
		header("Location: ../../excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_FACTURAS.PHP"
		header("Location: consulta_facturas.php");
	}

	cerrarConexionBD($conexion);

	function validation($factura){

		$errores = [];

		$now = new DateTime();
		$fechaCobro = date_create($factura["fechaCobro"]);
		$fechaVencimiento = date_create($factura["fechaVencimiento"]);
		$fechaFactura = date_create($factura["fechaFactura"]);

		$var1 = date_diff($now,$fechaCobro);
		$var2 = date_diff($now,$fechaVencimiento);
		$var3 = date_diff($now,$fechaFactura);
		$var4 = date_diff($fechaCobro,$fechaFactura);

		if ($var1->format("%r%a") > 0) {
			$errores[] = "<p>La fecha de cobro no puede ser después del día de hoy</p>";
		}
			  
		if ($var2->format("%r%a") < 0) {
			$errores[] = "<p>La fecha de vencimiento no puede ser antes del día de hoy</p>";
		}
		
		if ($var3->format("%r%a") > 0) {
			$errores[] = "<p>La fecha de factura no puede ser después del día de hoy</p>";
		}else if ($var4->format("%r%a") > 0) {
			$errores[] = "<p>La fecha de factura debe ser antes de la de cobro</p>";
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