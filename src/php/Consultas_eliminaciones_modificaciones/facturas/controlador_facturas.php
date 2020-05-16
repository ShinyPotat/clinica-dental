<?php	
	session_start();
	
	if (isset($_REQUEST["OID_F"])) {
		$factura["OID_F"] = $_REQUEST["OID_F"];
		$factura["FECHA_COBRO"] = $_REQUEST["FECHA_COBRO"];
		$factura["FECHA_VENCIMIENTO"] = $_REQUEST["FECHA_VENCIMIENTO"];
        $factura["FECHA_FACTURA"] = $_REQUEST["FECHA_FACTURA"];
        $factura["PRECIO_TOTAL"] = $_REQUEST["PRECIO_TOTAL"];
		
		$_SESSION["factura"] = $factura;
			
		if (isset($_REQUEST["Editar"])) Header("Location: consulta_facturas.php"); 
		else if (isset($_REQUEST["Guardar"])) Header("Location: accion_modificar_factura.php");
		else if (isset($_REQUEST["Borrar"])) Header("Location: accion_borrar_factura.php"); 
	}
	else 
		Header("Location: consulta_facturas.php");
	
?>