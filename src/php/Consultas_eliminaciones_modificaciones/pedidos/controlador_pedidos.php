<?php	
	session_start();
	
	if (isset($_REQUEST["OID_PD"])) {
		$pedido["OID_PD"] = $_REQUEST["OID_PD"];
		$pedido["Fecha_Solicitud"] = $_REQUEST["FECHA_SOLICITUD"];
		$pedido["Fecha_entrega"] = $_REQUEST["FECHA_ENTREGA"];
		$pedido["OID_PR"] = $_REQUEST["OID_PR"];
		$pedido["OID_F"] = $_REQUEST["OID_F"];
		
		$_SESSION["pedido"] = $pedido;
			
		if (isset($_REQUEST["Editar"])) Header("Location: consulta_pedidos.php"); 
		else if (isset($_REQUEST["Guardar"])) Header("Location: accion_modificar_pedido.php");
		else if (isset($_REQUEST["Borrar"])) Header("Location: accion_borrar_pedido.php"); 
	}
	else 
		Header("Location: consulta_pedidos.php");
	
?>