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

		if (!isset($proveedor["NOMBRE"]) || $proveedor["NOMBRE"]=="") {
			$errores[] = "<p>el campo nombre es obligatorio</p>";
		} else {
			$name = test_input($proveedor["NOMBRE"]);
			if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
			  $errores[] = "<p>Solo puedes introducir espacios y letras en el nombre</p>";
			}
		}

		if (isset($proveedor["LOCALIZACIÓN"])) {
			$local = test_input($proveedor["LOCALIZACIÓN"]);
			if (!preg_match("/^[a-zA-Z ]*$/",$local)) {
				$errores[] = "<p>Solo puedes introducir espacios y letras en localizacion.</p>";
			}
		}

		if (isset($proveedor["TLF_CONTACTO"])) {
			$phone = test_input($proveedor["TLF_CONTACTO"]);
			if (!preg_match("^[0-9]{9}^",$phone)) {
				$errores[] = "<p>Escriba un número de telefono adecuado</p>";
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