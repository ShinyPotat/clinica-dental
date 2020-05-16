<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionarMateriales.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_REQUEST["name"])) {
        $material = $_SESSION["name"];
        $material = $_REQUEST["categoria"];
        $material = $_REQUEST["stockInicial"];
        $material = $_REQUEST["stockMin"];
        $material = $_REQUEST["stockCrit"];
        $material = $_REQUEST["unidad"];
		$_SESSION["material"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../formularios/form_alta_material.php");
    } 
			

	$conexion = crearConexionBD(); 

    $excepcion = crear_material($conexion, $material["name"],$material["categoria"],$material["stockInicial"],$material["stockMin"],$material["stockCrit"],$material["unidad"]);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "consulta_materiales.php";
		header("Location: ../../excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_MATERIALES.PHP"
	    header("Location: consulta_materiales.php");
	}

	cerrarConexionBD($conexion);
?>