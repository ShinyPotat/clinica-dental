<?php
    function consultarTodosMateriales($conexion){
        $consulta = "SELECT * FROM materiales ORDER BY OID_M";
        return $conexion->query($consulta);
    }

    function total_consulta($conexion){
	    try {
	    	$total_consulta = "SELECT COUNT(*) AS TOTAL FROM materiales";

	    	$stmt = $conexion->query($total_consulta);
	    	$result = $stmt->fetch();
	    	$total = $result['TOTAL'];
	    	return  $total;
	    }
	    catch ( PDOException $e ) {
	    	/*$_SESSION['excepcion'] = $e->GetMessage();
            header("Location: excepcion.php");*/
            return $e->getMessage();
	    }
    } 

    function consulta_paginada( $conn, $pag_num, $pag_size ){
	    try {
	    	$primera = ( $pag_num - 1 ) * $pag_size + 1;
	    	$ultima  = $pag_num * $pag_size;
	    	$consulta_paginada = 
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM materiales ORDER BY OID_M ) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";

	    	$stmt = $conn->prepare( $consulta_paginada );
	    	$stmt->bindParam( ':primera', $primera );
	    	$stmt->bindParam( ':ultima',  $ultima  );
	    	$stmt->execute();
	    	return $stmt;
	    }	
	    catch ( PDOException $e ) {
	    	/*$_SESSION['excepcion'] = $e->GetMessage();
            header("Location: excepcion.php");*/
            return $e->getMessage();
	    }
    } 

    function quitar_material($conexion,$oidMaterial){
        try{
            $stmt=$conexion->prepare('CALL eliminar_material(:oidMaterial)');
            $stmt->bindParam(':OidMaterial',$oidMaterial);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            /*$_SESSION['excepcion'] = $e->GetMessage();
            header("Location: excepcion.php");*/
            return $e->getMessage();
        }
    }

    function modificar_material($conexion,$oidMaterial,$stock,$stockMinimo,$stockCritico){
        try{
            $stmt=$conexion->prepare('CALL Modifica_material(:oidMaterial,:stock,:stockMinimo,:stockCritico)');
            $stmt->bindParam(':oidMaterial',$oidMaterial);
            $stmt->bindParam(':stock',$stock);
            $stmt->bindParam(':stockMinimo',$stockMinimo);
            $stmt->bindParam(':stockCritico',$stockCritico);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            /*$_SESSION['excepcion'] = $e->GetMessage();
            header("Location: excepcion.php");*/
            return $e->getMessage();
        }
    }

?>
