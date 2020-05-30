<?php	
	session_start();
	
	if (isset($_REQUEST["OID_PD"])) {
		$pedido["OID_PD"] = $_REQUEST["OID_PD"];
		$pedido["Fecha_Solicitud"] = $_REQUEST["FECHA_SOLICITUD"];
		$pedido["Fecha_entrega"] = $_REQUEST["FECHA_ENTREGA"];
		$pedido["OID_PR"] = $_REQUEST["OID_PR"];
		$pedido["OID_F"] = $_REQUEST["OID_F"];
		
		if (isset($_REQUEST["Guardar"])) {

			$errores = validarDatosPedido($pedido);

			if(count($errores)>0) {
				$_SESSION["errores"] = $errores;
				Header("Location: consulta_pedidos.php");
				die;
			}
			
		}
		
		$_SESSION["pedido"] = $pedido;
		
		if (isset($_REQUEST["Editar"])) Header("Location: consulta_pedidos.php"); 
		else if (isset($_REQUEST["Guardar"])) Header("Location: accion_modificar_pedido.php");
		else if (isset($_REQUEST["Borrar"])) Header("Location: accion_borrar_pedido.php"); 
	}
	else 
		Header("Location: consulta_pedidos.php");

	function validarDatosPedido($pedido) {
		
		$errores = [];

		if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$pedido["FECHA_SOLICITUD"])) {
			$errores[] = "<p>La fecha introducida no tiene un formato adecuado</p>";
		}

		if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$pedido["FECHA_ENTREGA"])) {
			$errores[] = "<p>La fecha introducida no tiene un formato adecuado</p>";
		}

		return $errores;
	}
?>		