<?php
    function consultarTodosMateriales($conexion){
        $consulta = "SELECT * FROM encargos ORDER BY OID_E";
        return $conexion->query($consulta);
    }

    function total_consulta($conexion){
	    try {
	    	$total_consulta = "SELECT COUNT(*) AS TOTAL FROM encargos";

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
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM encargos ORDER BY OID_E ) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";

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

    function quitar_encargo($conexion,$oidEncargo){
        try{
            $stmt=$conexion->prepare('CALL eliminar_encargo(:oidEncargo)');
            $stmt->bindParam(':oidEncargo',$oidEncargo);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    function getFechaFormateada($fecha){
		return date('d/m/Y', strtotime($fecha));
	}
    
    function modificar_encargo($conexion,$oidEncargo,$fecha_entrada,$fecha_entrega,$Acciones){
        try{
            $stmt=$conexion->prepare('CALL Modifica_encargo(:oidEncargo,:fecha_entrada,:fecha_entrega,:Acciones)');
            $stmt->bindParam(':oidEncargo',$oidEncargo);
            $stmt->bindParam(':fecha_entrada',getFechaFormateada($fecha_entrada));
            $stmt->bindParam(':fecha_entrega',getFechaFormateada($fecha_entrega));
            $stmt->bindParam(':Acciones',$Acciones);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    function crear_encargo($conexion,$fecha_entrada,$fecha_entrega,$Acciones,$OID_PC,$OID_F){
        try{
            $stmt=$conexion->prepare('CALL crear_encargo(:fecha_entrada,:fecha_entrega,:Acciones,:OID_PC,:OID_F)');
            $stmt->bindParam(':fecha_entrada',getFechaFormateada($fecha_entrada));
            $stmt->bindParam(':fecha_entrega',getFechaFormateada($fecha_entrega));
            $stmt->bindParam(':Acciones',$Acciones);
            $stmt->bindParam(':OID_PC',$OID_PC);
            $stmt->bindParam(':OID_F',$OID_F);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

?>