<?php
	session_start();

	require_once("../../gestionBD.php");
	require_once("gestionarMateriales.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_REQUEST["name"])) {
        $material["name"] = $_REQUEST["name"];
        $material["categoria"] = $_REQUEST["categoria"];
        $material["stockInicial"] = $_REQUEST["stockInicial"];
        $material["stockMin"] = $_REQUEST["stockMin"];
        $material["stockCrit"] = $_REQUEST["stockCrit"];
        $material["unidad"] = $_REQUEST["unidad"];
		$_SESSION["material"] = null;
		$_SESSION["errores"] = null;
	}
	else{
        Header("Location: ../formularios/form_alta_material.php");
	} 

	$errores = validarDatosMaterialesF($material);

	if(isset($errores) && count($errores)>0) {
		$_SESSION["Fmaterial"] = $material;
		$_SESSION["errores"] = $errores;
		Header("Location: ../../formularios/form_alta_material.php");
		die;
	}

	$conexion = crearConexionBD(); 

    $excepcion = crear_material($conexion, $material["name"],$material["categoria"],$material["stockInicial"],$material["stockMin"],$material["stockCrit"],$material["unidad"]);

    // SI LA FUNCIÓN RETORNÓ UN MENSAJE DE EXCEPCIÓN, ENTONCES REDIRIGIR A "EXCEPCION.PHP"
	if($excepcion<>""){
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"]= "formularios/form_alta_material.php";
		header("Location: ../../excepcion.php");
	}else{
		// EN OTRO CASO, VOLVER A "CONSULTA_MATERIALES.PHP"
	    header("Location: consulta_materiales.php");
	}

	cerrarConexionBD($conexion);

	function validarDatosMaterialesF($material) {
		$errores = [];

    	if (empty($material["name"])) {
        	$errores[] = "<p>El Nombre es obligatorio</p>";
        } else {
          	$name = test_input($material["name"]);
        	if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            	$errores[] = "<p>Solo puedes introducir espacios y letras en el nombre</p>";
          	}
        }

        if (!isset($material["categoria"])) {
            $errores[] = "<p>La categoria es necesaria</p>";
        }

        if (isset($material["stockInicial"])) {
            $stockInicial = test_input($material["stockInicial"]);
            if ($stockInicial < 0) {
              	$errores[] = "<p>El stock debe de ser mayor o igual que 0</p>";
            }
        }

        if (isset($material["stockMin"])) {
            $stockMin = test_input($material["stockMin"]);
            if ($stockMin < 0) {
              	$errores[] = "<p>El stockminimo debe de ser mayor o igual que 0</p>";
            }
        }
        if (isset($material["stockCrit"])) {
            $stockCrit = test_input($material["stockCrit"]);
            if ($stockCrit < 0) {
              	$errores = "<p>El stockcritico debe de ser mayor o igual que 0</p>";
            }
		}
		return $errores;
	}
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>