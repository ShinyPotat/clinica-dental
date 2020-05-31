<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionarPedidos.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_REQUEST["fechaSolicitud"])) {
        $pedido["fechaSolicitud"] = $_REQUEST["fechaSolicitud"];
		$pedido["fechaEntrega"] = $_REQUEST["fechaEntrega"];
		$pedido["cantidad"] = $_REQUEST["cantidad"];
		$pedido["material"] = $_REQUEST["materialPD"];
        $pedido["OID_PR"] = $_REQUEST["proveedorPD"];
        $pedido["OID_F"] = $_REQUEST["FacturaPD"];
		$_SESSION["pedido"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../../formularios/form_alta_pedido.php");
	} 

	$errores = validation($pedido);

	if(isset($errores) && count($errores)>0) {
		$_SESSION["errores"] = $errores;
		$_SESSION["Fpedido"] = $pedido;
		Header("Location: ../../formularios/form_alta_pedido.php");
		die;
	}

	$conexion = crearConexionBD(); 

    $excepcion = crear_pedido($conexion, $pedido["fechaSolicitud"],$pedido["fechaEntrega"],$pedido["cantidad"],$pedido["OID_PR"],$pedido["material"],$pedido["OID_F"]);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "formularios/form_alta_pedido.php";
		header("Location: ../../excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_PEDIDOS.PHP"
	    header("Location: consulta_pedidos.php");
	}

	cerrarConexionBD($conexion);

	function validation($pedido){
		
		$errores = [];

		$now = new DateTime();
		if(isset($pedido["fechaSolicitud"])){
			$fechaSolicitud = date_create($factura["fechaSolicitud"]);
			$var1 = date_diff($now,$fechaSolicitud);
			if ($var1->format("%r%a") < 0) {
				$errores[] = "<p>La fecha de solicitud no puede ser antes del día de hoy</p>";
			}
		}

		if(isset($pedido["fechaEntrega"])){
			$fechaEntrega = date_create($factura["fechaEntrega"]);
			$var2 = date_diff($now,$fechaEntrega);
			if ($var2->format("%r%a") < 0) {
				$errores[] = "<p>La fecha de entrega no puede ser antes del día de hoy</p>";
			}
		}
		
		if(isset($pedido["fechaEntrega"]) && isset($factura["fechaSolicitud"])){
			$fechaEntrega2 = date_create($pedido["fechaEntrega"]);
			$fechaSolicitud2 = date_create($pedido["fechaSolicitud"]);
			$var4 = date_diff($fechaEntrega2,$fechaSolicitud2);
			if ($var4->format("%r%a") > 0) {
				$errores[] = "<p>La fecha de Solicitud debe ser antes de la de entrega</p>";
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