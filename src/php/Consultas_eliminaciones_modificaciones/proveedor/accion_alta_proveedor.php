<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionarProveedor.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_REQUEST["name"])) {
        $proveedor["name"] = $_REQUEST["name"];
        $proveedor["local"] = $_REQUEST["local"];
        $proveedor["phone"] = $_REQUEST["phone"];
		$_SESSION["proveedor"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../formularios/form_alta_proveedor.php");
	} 
			

	$conexion = crearConexionBD(); 

    $excepcion = crear_proveedor($conexion, $proveedor["name"], $proveedor["local"], $proveedor["phone"]);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "formularios/form_alta_proveedor.php";
		header("Location: ../../excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_PROVEEDORES.PHP"
	    header("Location: consulta_proveedores.php");
	}

	cerrarConexionBD($conexion);
?>