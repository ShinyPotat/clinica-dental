<?php	
	session_start();	
	
	if (isset($_SESSION["pedido"])) {
		$pedido = $_SESSION["pedido"];
		unset($_SESSION["pedido"]);
		
		require_once("../../gestionBD.php");
		require_once("gestionarPedidos.php");
		
		// CREAR LA CONEXIÓN A LA BASE DE DATOS
		$conexion = crearConexionBD();
		// INVOCAR "MODIFICAR_PEDIDO" EN GESTIONPEDIDO
		$excepcion = modificar_pedido($conexion,$pedido["OID_PD"],$pedido["Fecha_Solicitud"],$pedido["Fecha_entrega"],$pedido["cantidad"],$pedido["material"]);
		// CERRAR LA CONEXIÓN
		cerrarConexionBD($conexion);
		
		// SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
		if($excepcion<>""){
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"]= "Consultas_eliminaciones_modificaciones/pedidos/consulta_pedidos.php";
			header("Location: ../../excepcion.php");
		}else{// EN OTRO CASO, VOLVER A "CONSULTA_PEDIDOS.PHP"
			header("Location: consulta_pedidos.php");
		}
	} 
	else // Se ha tratado de acceder directamente a este PHP 
		Header("Location: consulta_pedidos.php"); 
?>