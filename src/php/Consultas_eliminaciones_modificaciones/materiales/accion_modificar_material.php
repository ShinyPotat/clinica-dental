<?php	
	session_start();	
	
	if (isset($_SESSION["material"])) {
		$material = $_SESSION["material"];
		unset($_SESSION["material"]);
		
		require_once("../../gestionBD.php");
		require_once("gestionarMateriales.php");
		
		// CREAR LA CONEXIÓN A LA BASE DE DATOS
		$conexion = crearConexionBD();
		// INVOCAR "MODIFICAR_MATERIAL" EN GESTIONMATERIAL
		$excepcion = modificar_material($conexion,$material["OID_M"],$material["STOCK"],$material["STOCK_MIN"],$material["STOCK_CRITICO"],$material["UNIDAD"]);
		// CERRAR LA CONEXIÓN
		cerrarConexionBD($conexion);
		
		// SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
		if($excepcion<>""){
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"]= "Consultas_eliminaciones_modificaciones/materiales/consulta_materiales.php";
			header("Location: ../../excepcion.php");
		}else{// EN OTRO CASO, VOLVER A "CONSULTA_MATERIALES.PHP"
			header("Location: consulta_materiales.php");
		}
	} 
	else // Se ha tratado de acceder directamente a este PHP 
		Header("Location: consulta_materiales.php"); 
?>