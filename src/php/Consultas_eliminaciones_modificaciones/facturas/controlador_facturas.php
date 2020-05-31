<?php	
	session_start();
	
	if (isset($_REQUEST["OID_F"])) {
		$factura["OID_F"] = $_REQUEST["OID_F"];
		$factura["FECHA_COBRO"] = $_REQUEST["FECHA_COBRO"];
		$factura["FECHA_VENCIMIENTO"] = $_REQUEST["FECHA_VENCIMIENTO"];
        $factura["FECHA_FACTURA"] = $_REQUEST["FECHA_FACTURA"];
        $factura["PRECIO_TOTAL"] = $_REQUEST["PRECIO_TOTAL"];
		
		$_SESSION["factura"] = $factura;

		if (isset($_REQUEST["Guardar"])) {

			$errores = validation($factura);

			if(count($errores)>0) {
				$_SESSION["errores"] = $errores;
				Header("Location: consulta_facturas.php");
				die;
			}
		}
			
		if (isset($_REQUEST["Editar"])) Header("Location: consulta_facturas.php"); 
		else if (isset($_REQUEST["Guardar"])) Header("Location: accion_modificar_factura.php");
		else if (isset($_REQUEST["Borrar"])) Header("Location: accion_borrar_factura.php"); 
	}
	else 
		Header("Location: consulta_facturas.php");
	
	function validation($factura){

		$errores = [];
	
		$now = new DateTime();
		if(isset($factura["FECHA_COBRO"])){
			$fechaCobro = date_create($factura["FECHA_COBRO"]);
			$var1 = date_diff($now,$fechaCobro);
			if ($var1->format("%r%a") > 0) {
				$errores[] = "<p>La fecha de cobro no puede ser despues del día de hoy</p>";
			}
		}
	
		if(isset($factura["FECHA_VENCIMIENTO"])){
			$fechaVencimiento = date_create($factura["FECHA_VENCIMIENTO"]);
			$var2 = date_diff($now,$fechaVencimiento);
			if ($var2->format("%r%a") < 0) {
				$errores[] = "<p>La fecha de vencimiento no puede ser antes del día de hoy</p>";
			}
		}
		
		if(isset($factura["FECHA_FACTURA"])){
			$fechaFactura = date_create($factura["FECHA_FACTURA"]);
			$var3 = date_diff($now,$fechaFactura);
			if ($var3->format("%r%a") > 0) {
				$errores[] = "<p>La fecha de factura no puede ser después del día de hoy</p>";
			}
		}
			
		if(isset($factura["FECHA_COBRO"]) && isset($factura["FECHA_FACTURA"])){
			$fechaCobro2 = date_create($factura["FECHA_COBRO"]);
			$fechaFactura2 = date_create($factura["FECHA_FACTURA"]);
			$var4 = date_diff($fechaCobro2,$fechaFactura2);
			if ($var4->format("%r%a") > 0) {
				$errores[] = "<p>La fecha de factura debe ser antes de la de cobro</p>";
			}
		}
		return $errores;	  
	}
?>