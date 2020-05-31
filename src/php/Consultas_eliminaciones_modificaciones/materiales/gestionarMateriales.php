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
            return $e->getMessage();
	    }
    } 

    function total_consulta_filtrada($conexion,$tipo,$param){
	    try {
            if($tipo=="CATEGORIA"){
                $total_consulta = "SELECT COUNT(*) AS TOTAL FROM materiales WHERE ".$tipo." = '".$param."'";
            }else{
                $total_consulta = "SELECT COUNT(*) AS TOTAL FROM materiales WHERE stock < ".$tipo;
            }
                 
            $stmt = $conexion->query($total_consulta);
	    	$result = $stmt->fetch();
	    	$total = $result['TOTAL'];
            //$stmt->bindParam(':tipo',$tipo);
            //$stmt->bindParam(':para',$param);
	    	//$result = $stmt->execute();
	    	//$total = $result['TOTAL'];
	    	return  $total;
	    }
	    catch ( PDOException $e ) {
            return "error del sistema";
            //return $e->getMessage();
	    }
    }

    function consulta_paginada_filtrado( $conn,$tipo,$param, $pag_num, $pag_size ){
	    try {
	    	$primera = ( $pag_num - 1 ) * $pag_size + 1;
            $ultima  = $pag_num * $pag_size;
            if ($tipo=="CATEGORIA") {
                $consulta_paginada = 
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM materiales WHERE ".$tipo." = '".$param."' ORDER BY OID_M) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";
            } else {
                $consulta_paginada = 
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM materiales WHERE stock < ".$tipo." ORDER BY OID_M) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";
            }

	    	$stmt = $conn->prepare( $consulta_paginada );
	    	$stmt->bindParam( ':primera', $primera );
            $stmt->bindParam( ':ultima',  $ultima );
	    	$stmt->execute();
	    	return $stmt;
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
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM materiales ORDER BY OID_M ) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";

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

    function quitar_material($conexion,$oidMaterial){
        try{
            $stmt=$conexion->prepare('CALL eliminar_material(:oidMaterial)');
            $stmt->bindParam(':OidMaterial',$oidMaterial);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
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
            return $e->getMessage();
        }
    }

    function crear_material($conexion,$nombre,$categoria,$stock,$stockMinimo,$stockCritico,$unidad){
        try{
            $stmt=$conexion->prepare('CALL crear_material(:nombre,:categoria,:stock,:stockMinimo,:stockCritico,:unidad)');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':categoria',$categoria);
            $stmt->bindParam(':stock',$stock);
            $stmt->bindParam(':stockMinimo',$stockMinimo);
            $stmt->bindParam(':stockCritico',$stockCritico);
            $stmt->bindParam(':unidad',$unidad);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

?>
