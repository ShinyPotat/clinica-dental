<?php

require_once '../gestionBD.php';
require_once 'gestion-usuario.php';

session_start();

if(isset($_SESSION["user"])){
	
	$nuevoUsuario["name"] = $_REQUEST["name"];
	$nuevoUsuario["lastname"] = $_REQUEST["lastname"];
	$nuevoUsuario["perfil"] = $_REQUEST["perfil"];
	$nuevoUsuario["correo"] = $_REQUEST["correo"];
	$nuevoUsuario["user"] = $_REQUEST["user"];
	$nuevoUsuario["pass"] = $_REQUEST["pass"];
	$nuevoUsuario["passConf"] = $_REQUEST["passConf"];

}else{
	Header("Location: form-register.php");
}
	
	$_SESSION['user'] = $nuevoUsuario;

	$errores = validarDatosUsuario($nuevoUsuario);
	
	if(count($errores)>0){
		$_SESSION["errores"] = $errores;
		Header("Location: form-register.php");
	}else{
		Header("Location: action-register.php");
	}
	


function validarDatosUsuario($nuevoUsuario){

	$errores = [];

	if($nuevoUsuario["name"]==""){
		$errores[]="<p>El nombre no puede estar vacío</p>";
	}else if (!preg_match("/[a-z]+[A-z]+/", $nuevoUsuario["name"])){
		$errores[]="<p>El nombre solo puede tener letras</p>";
	}
	
	if($nuevoUsuario["correo"]==""){
		$errores[]="<p>El email no puede estar vacío<p>";
	}else if(!filter_var($nuevoUsuario["correo"], FILTER_VALIDATE_EMAIL)){
		$errores[]="<p>El formato del email es incorrecto<p>";
	}
	
	if($nuevoUsuario["perfil"]!="clinica" && $nuevoUsuario["perfil"]!="proveedor"){
		$errores[]="<p>El perfil debe corresponder a una de las posibilidades<p>";
	}
	
	if($nuevoUsuario["pass"]==""){
		$errores[]="<p>La contraseña no puede estar vacía<p>";
	}elseif(!preg_match("/[a-z]+/", $nuevoUsuario["pass"]) || 
			!preg_match("/[A-Z]+/", $nuevoUsuario["pass"]) ||
			!preg_match("/[0-9]+/", $nuevoUsuario["pass"]) || 
			strlen($nuevoUsuario["pass"]) < 8){
		$errores[]="<p>La contraseña debe tener al menos 8 caracteres, con al menos un dígito y letras mayúsculas y minúsculas<p>".$nuevoUsuario['pass'];
	}
	
	if($nuevoUsuario["passConf"]!=$nuevoUsuario["pass"]){
		$errores[]="<p>La confirmación de la contraseña debe coincidir con la contraseña<p>";
	}
	
	return $errores;
}

?>