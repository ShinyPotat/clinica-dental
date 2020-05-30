<?php	
	session_start();
	
	if (isset($_REQUEST["OID_PR"])) {
		$proveedor["OID_PR"] = $_REQUEST["OID_PR"];
		$proveedor["NOMBRE"] = $_REQUEST["NOMBRE"];
		$proveedor["LOCALIZACIÓN"] = $_REQUEST["LOCALIZACIÓN"];
		$proveedor["TLF_CONTACTO"] = $_REQUEST["TLF_CONTACTO"];
		
		if (isset($_REQUEST["Guardar"])) {

			$errores = validarDatosProveedor($proveedor);

			if(count($errores)>0) {
				$_SESSION["errores"] = $errores;
				Header("Location: consulta_proveedores.php");
				die;
			}
			
		}
		
		$_SESSION["proveedor"] = $proveedor;
		
		if (isset($_REQUEST["Editar"])) Header("Location: consulta_proveedores.php"); 
		else if (isset($_REQUEST["Guardar"])) Header("Location: accion_modificar_proveedor.php");
		else if (isset($_REQUEST["Borrar"])) Header("Location: accion_borrar_proveedor.php"); 
	}
	else 
		Header("Location: consulta_proveedores.php");

	function validarDatosProveedor($proveedor) {
		
		$errores = [];

		if(empty($proveedor["NOMBRE"])) {
			$errores[] = "<p>Debe de introducir un nombre</p>";
		}

		if(!preg_match("/^[a-zA-Z]*$/",$proveedor["LOCALIZACIÓN"])) {
			$errores[] = "<p>Introduce una localizacion adecuada</p>";
		}

		if (!preg_match("^[0-9]{9}^",$proveedor["TLF_CONTACTO"])){
			$errores[]= "<p>Introduce un telefono adecuado";

		}

		return $errores;
	}
?>