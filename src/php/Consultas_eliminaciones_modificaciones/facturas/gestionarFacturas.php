<?php
    function consultarTodasFacturas($conexion){
        $consulta = "SELECT * FROM FACTURAS ORDER BY OID_F";
        return $conexion->query($consulta);
    }

    function total_consulta($conexion){
	    try {
	    	$total_consulta = "SELECT COUNT(*) AS TOTAL FROM FACTURAS";

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
            if($tipo=="PrecioMayor"){
                $total_consulta = "SELECT COUNT(*) AS TOTAL FROM facturas WHERE precio_total >= ".$param;
            }else{
                $total_consulta = "SELECT COUNT(*) AS TOTAL FROM facturas WHERE precio_total <= ".$param;
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
            return $e->getMessage();
	    }
    }
    
    function consulta_paginada_filtrado( $conn,$tipo,$param, $pag_num, $pag_size ){
	    try {
	    	$primera = ( $pag_num - 1 ) * $pag_size + 1;
            $ultima  = $pag_num * $pag_size;
            if ($tipo=="PrecioMayor") {
                $consulta_paginada = 
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM facturas WHERE precio_total >= ".$param." ORDER BY precio_total) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";
            } else {
                $consulta_paginada = 
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM facturas WHERE precio_total <= ".$param." ORDER BY precio_total) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";
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
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM FACTURAS ORDER BY OID_F ) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";

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

    function quitar_factura($conexion,$oidFactura){
        try{
            $stmt=$conexion->prepare('CALL eliminar_factura(:oidFactura)');
            $stmt->bindParam(':OidFactura',$oidFactura);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    function getFechaFormateada($fecha){
		return date('d/m/Y', strtotime($fecha));
	}

    function modificar_factura($conexion,$oidFactura,$fecha_cobro,$fecha_vencimiento,$fecha_factura,$precio_total){
        try{
            $stmt=$conexion->prepare('CALL Modifica_factura(:oidFactura,:fecha_cobro,:fecha_vencimiento,:fecha_factura,:precio_total)');
            $stmt->bindParam(':oidFactura',$oidFactura);
            $stmt->bindParam(':fecha_cobro',getFechaFormateada($fecha_cobro));
            $stmt->bindParam(':fecha_vencimiento',getFechaFormateada($fecha_vencimiento));
            $stmt->bindParam(':fecha_factura',getFechaFormateada($fecha_factura));
            $stmt->bindParam(':precio_total',$precio_total);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    function crear_Factura($conexion,$fecha_cobro,$fecha_vencimiento,$fecha_factura,$precio_total){
        try{
            $stmt=$conexion->prepare('CALL crear_Factura(:fecha_cobro,:fecha_vencimiento,:fecha_factura,:precio_total)');
            $stmt->bindParam(':fecha_cobro',getFechaFormateada($fecha_cobro));
            $stmt->bindParam(':fecha_vencimiento',getFechaFormateada($fecha_vencimiento));
            $stmt->bindParam(':fecha_factura',getFechaFormateada($fecha_factura));
            $stmt->bindParam(':precio_total',$precio_total);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

?>