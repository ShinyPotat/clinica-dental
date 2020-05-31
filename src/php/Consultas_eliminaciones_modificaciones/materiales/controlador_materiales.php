<?php	
	session_start();
	
	if (isset($_REQUEST["OID_M"])) {
		$material["OID_M"] = $_REQUEST["OID_M"];
		$material["NOMBRE"] = $_REQUEST["NOMBRE"];
		$material["CATEGORIA"] = $_REQUEST["CATEGORIA"];
		$material["STOCK"] = $_REQUEST["STOCK"];
		$material["STOCK_MIN"] = $_REQUEST["STOCK_MIN"];
        $material["STOCK_CRITICO"] = $_REQUEST["STOCK_CRITICO"];
        $material["UNIDAD"] = $_REQUEST["UNIDAD"];
		
		$_SESSION["material"] = $material;

		if (isset($_REQUEST["Guardar"])) {

			$errores = validarDatosMateriales($material);

			if(count($errores)>0) {
				$_SESSION["errores"] = $errores;
				Header("Location: consulta_materiales.php");
				die;
			}
		}
			
		if (isset($_REQUEST["Editar"])) Header("Location: consulta_materiales.php"); 
		else if (isset($_REQUEST["Guardar"])) Header("Location: accion_modificar_material.php");
		else if (isset($_REQUEST["Borrar"])) Header("Location: accion_borrar_material.php"); 
	}
	else 
		Header("Location: consulta_materiales.php");
	
	function validarDatosMateriales($material) {
		$errores = [];

		if (isset($material["STOCK"])) {
			$stockInicial = test_input($material["STOCK"]);
			if ($stockInicial < 0) {
				$errores[] = "<p>El stock debe de ser mayor o igual que 0</p>";
			}
		}
	
		if (isset($material["STOCK_MIN"])) {
			$stockMin = test_input($material["STOCK_MIN"]);
			if ($stockMin < 0) {
				$errores[] = "<p>El stockminimo debe de ser mayor o igual que 0</p>";
			}
		}
		if (isset($material["STOCK_CRITICO"])) {
			$stockCrit = test_input($material["STOCK_CRITICO"]);
			if ($stockCrit < 0) {
				$errores = "<p>El stockcritico debe de ser mayor o igual que 0</p>";
			}
		}
		if (isset($material["STOCK_CRITICO"]) && isset($material["STOCK_MIN"])) {
			$stockCrit = test_input($material["STOCK_CRITICO"]);
			$stockMin = test_input($material["STOCK_MIN"]);
            if ($stockCrit > $stockMin) {
              	$errores = "<p>El stockcritico debe de ser menor o igual que el stock minimo</p>";
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