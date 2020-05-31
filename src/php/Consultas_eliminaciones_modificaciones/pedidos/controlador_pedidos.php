<?php	
	session_start();
	
	if (isset($_REQUEST["OID_PD"])) {
		$pedido["OID_PD"] = $_REQUEST["OID_PD"];
		$pedido["Fecha_Solicitud"] = $_REQUEST["FECHA_SOLICITUD"];
		$pedido["Fecha_entrega"] = $_REQUEST["FECHA_ENTREGA"];
		$pedido["cantidad"] = $_REQUEST["CANTIDAD"];
		$pedido["material"] = $_REQUEST["MATERIAL"];
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

		$now = new DateTime();
		if(isset($pedido["FECHA_SOLICITUD"])){
			$fechaSolicitud = date_create($factura["FECHA_SOLICITUD"]);
			$var1 = date_diff($now,$fechaSolicitud);
			if ($var1->format("%r%a") < 0) {
				$errores[] = "<p>La fecha de solicitud no puede ser antes del día de hoy</p>";
			}
		}

		if(isset($pedido["FECHA_ENTREGA"])){
			$fechaEntrega = date_create($factura["FECHA_ENTREGA"]);
			$var2 = date_diff($now,$fechaEntrega);
			if ($var2->format("%r%a") < 0) {
				$errores[] = "<p>La fecha de entrega no puede ser antes del día de hoy</p>";
			}
		}
		
		if(isset($pedido["FECHA_ENTREGA"]) && isset($factura["FECHA_SOLICITUD"])){
			$fechaEntrega2 = date_create($pedido["FECHA_ENTREGA"]);
			$fechaSolicitud2 = date_create($pedido["FECHA_SOLICITUD"]);
			$var4 = date_diff($fechaEntrega2,$fechaSolicitud2);
			if ($var4->format("%r%a") > 0) {
				$errores[] = "<p>La fecha de Solicitud debe ser antes de la de entrega</p>";
			}
		}

		return $errores;
	}
?>		