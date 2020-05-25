<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionarPedidos.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_REQUEST["fechaSolicitud"])) {
        $pedido["fechaSolicitud"] = $_REQUEST["fechaSolicitud"];
        $pedido["fechaEntrega"] = $_REQUEST["fechaEntrega"];
        $pedido["OID_PR"] = $_REQUEST["OID_PR"];
        $pedido["OID_F"] = $_REQUEST["OID_F"];
		$_SESSION["pedido"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../formularios/form_alta_pedido.php");
	} 

	$conexion = crearConexionBD(); 

    $excepcion = crear_pedido($conexion, $pedido["fechaSolicitud"],$pedido["fechaEntrega"],$pedido["OID_PR"],$pedido["OID_F"]);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "consulta_pedidos.php";
		header("Location: ../../excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_PEDIDOS.PHP"
	    header("Location: consulta_pedidos.php");
	}

	cerrarConexionBD($conexion);
?>