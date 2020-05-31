<?php

function alta_usuario($conexion,$nombre,$apellidos,$email,$usuario,$pass,$perfil) {

	//NOMBRE,APELLIDOS,EMAIL,USER,PASS,PERFIL
	try{
		$stmt = $conexion->prepare("CALL INSERTAR_USUARIO(:nombre,:apellidos,:email,:usuario,:pass,:perfil)");
		$stmt->bindParam(":nombre",$nombre);
		$stmt->bindParam(":apellidos",$apellidos);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(":usuario",$usuario);
		$stmt->bindParam(":pass",$pass);
		$stmt->bindParam(":perfil",$perfil);
		$stmt->execute();
		return "";
	}catch(PDOException $e){
		return $e->getMessage();
	}
}

function consultarUsuario($conexion,$user,$pass) {
 	$consulta = "SELECT COUNT(*) AS TOTAL FROM USUARIOS WHERE USUARIO=:usuario AND PASS=:pass";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':usuario',$user);
	$stmt->bindParam(':pass',$pass);
	$stmt->execute();
	return $stmt->fetchColumn();
	
}

function borrarUsuario($conexion, $user){
	try{
		$stmt=$conexion->prepare('CALL eliminar_usuario(:usuario)');
		$stmt->bindParam(':usuario',$user);
		$stmt->execute();
		return "";
	}catch(PDOException $e) {
		return $e->getMessage();
	}
}

?>