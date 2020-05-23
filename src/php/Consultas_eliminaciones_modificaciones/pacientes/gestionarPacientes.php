<?php
    function consultarTodosPacientes($conexion){
        $consulta = "SELECT * FROM pacientes ORDER BY OID_PC";
        return $conexion->query($consulta);
    }

    function total_consulta($conexion){
	    try {
	    	$total_consulta = "SELECT COUNT(*) AS TOTAL FROM pacientes";

	    	$stmt = $conexion->query($total_consulta);
	    	$result = $stmt->fetch();
	    	$total = $result['TOTAL'];
	    	return  $total;
	    }
	    catch ( PDOException $e ) {
            return $e->getMessage();
	    }
    } 

    function consulta_paginada( $conn, $pag_num, $pag_size ){
	    try {
	    	$primera = ( $pag_num - 1 ) * $pag_size + 1;
	    	$ultima  = $pag_num * $pag_size;
	    	$consulta_paginada = 
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM pacientes ORDER BY OID_PC ) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";

	    	$stmt = $conn->prepare( $consulta_paginada );
	    	$stmt->bindParam( ':primera', $primera );
	    	$stmt->bindParam( ':ultima',  $ultima  );
	    	$stmt->execute();
	    	return $stmt;
	    }	
	    catch ( PDOException $e ) {
            return $e->getMessage();
	    }
    } 

    function quitar_paciente($conexion,$oidPaciente){
        try{
            $stmt=$conexion->prepare('CALL eliminar_paciente(:oidPaciente)');
            $stmt->bindParam(':oidPaciente',$oidPaciente);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    function getFechaFormateada($fecha){
		return date('d/m/Y', strtotime($fecha));
	}

    function modificar_paciente($conexion,$oidPaciente,$DNI,$fechaNacimiento,$Sexo){
        try{
            $stmt=$conexion->prepare('CALL modifica_paciente(:oidPaciente,:DNI,:fechaNacimiento,:Sexo)');
            $stmt->bindParam(':oidMaterial',$oidPaciente);
            $stmt->bindParam(':DNI',$DNI);
            $stmt->bindParam(':fechaNacimiento',getFechaFormateada($fechaNacimiento));
            $stmt->bindParam(':Sexo',$Sexo);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    function crear_paciente($conexion,$DNI,$fecha_nacimiento,$sexo,$oid_c){
        try{
            $stmt=$conexion->prepare('CALL crear_paciente(:DNI,:fecha_nacimiento,:sexo,:oid_c)');
            $stmt->bindParam(':DNI',$DNI);
            $stmt->bindParam(':fecha_nacimiento',getFechaFormateada($fecha_nacimiento));
            $stmt->bindParam(':sexo',$sexo);
            $stmt->bindParam(':oid_c',$oid_c);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

?>