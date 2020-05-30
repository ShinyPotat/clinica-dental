<?php
    session_start();

    if (isset($_REQUEST["OID_C"])) {
        $clinica["OID_C"] = $_REQUEST["OID_C"];
        $clinica["NOMBRE"] = $_REQUEST["NOMBRE"];
        $clinica["LOCALIZACIÓN"] = $_REQUEST["LOCALIZACIÓN"];
        $clinica["TLF_CONTACTO"] = $_REQUEST["TLF_CONTACTO"];
        $clinica["MOROSO"] = $_REQUEST["MOROSO"];
        $clinica["NOMBRE_DUEÑO"] = $_REQUEST["NOMBRE_DUEÑO"];
        $clinica["NUM_COLEGIADO"] = $_REQUEST["NUM_COLEGIADO"];
        $_SESSION["clinica"] = $clinica;

        if (isset($_REQUEST["Guardar"])) {

			$errores = validarDatosClinica($clinica);

			if(count($errores)>0) {
				$_SESSION["errores"] = $errores;
				Header("Location: consulta_clinica.php");
				die;
			}
			
		}

        if (isset($_REQUEST["Editar"]))
            Header("Location: consulta_clinica.php");
        else if (isset($_REQUEST["Guardar"]))
            Header("Location: accion_modificar_clinica.php");
        else if (isset($_REQUEST["Borrar"]))
            Header("Location: accion_borrar_clinica.php");
    } else {
        Header("Location: consulta_clinica.php");
    }

    function validarDatosClinica($clinica) {
		
		$errores = [];

		if (empty($clinica["NOMBRE"])) {
			$errores[] = "Nombre campo es obligatorio";
		}
		if (empty($clinica["LOCALIZACIÓN"])) {
		} else {
			$local = test_input($clinica["LOCALIZACIÓN"]);
			if (!preg_match("/^[a-zA-Z ]*$/",$local)) {
				$errores[] = "Solo puedes introducir espacios y letras";
			}
		}
		if (empty($clinica["TLF_CONTACTO"])) {
		} else {
			$phone = test_input($clinica["TLF_CONTACTO"]);
			if (!preg_match("^[0-9]{9}^",$phone)) {
				$errores[] = "Escribe un número de telefono adecuado";
			}
		}
		if (empty($clinica["NOMBRE_DUEÑO"])) {
		} else {
			$nameD = test_input($clinica["NOMBRE_DUEÑO"]);
			if (!preg_match("/^[a-zA-Z ]*$/",$nameD)) {
				$errores[] = "Solo puedes introducir espacios y letras en el nombre del dueño";
			}
		}
		
		if (empty($clinica["NUM_COLEGIADO"])) {
		} else {
			$nCol = test_input($clinica["NUM_COLEGIADO"]);
			if (!preg_match("^[0-9]{4}^",$nCol)) {
				$errores[] = "Escribe un número de colegiado adecuado";
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