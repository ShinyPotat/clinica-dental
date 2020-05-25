<?php	
	session_start();	
	
	if (isset($_SESSION["factura"])) {
		$factura = $_SESSION["factura"];
		unset($_SESSION["factura"]);
		
		require_once("../../gestionBD.php");
		require_once("gestionarFacturas.php");
		
		// CREAR LA CONEXIÓN A LA BASE DE DATOS
		$conexion = crearConexionBD();
		// INVOCAR "MODIFICAR_FACTURA" EN GESTIONFACTURA
		$excepcion = modificar_factura($conexion,$factura["OID_F"],$factura["FECHA_COBRO"],$factura["FECHA_VENCIMIENTO"],$factura["FECHA_FACTURA"],$factura["PRECIO_TOTAL"]);
		// CERRAR LA CONEXIÓN
		cerrarConexionBD($conexion);
		
		// SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
		if($excepcion<>""){
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"]= "Consultas_eliminaciones_modificaciones/facturas/consulta_facturas.php";
			header("Location: ../../excepcion.php");
		}else{// EN OTRO CASO, VOLVER A "CONSULTA_FACTURA.PHP"
			header("Location: consulta_facturas.php");
		}
	} 
	else // Se ha tratado de acceder directamente a este PHP 
		Header("Location: consulta_facturas.php"); 
?>