<?php

    require_once("../../gestionBD.php");

    if(isset($_GET['filtro']) && $_GET['filtro']=='Material'){
        $conexion = crearConexionBD();

        $query = "SELECT OID_M, Nombre FROM materiales ORDER BY Nombre ASC";
        $materiales = $conexion->query($query);

        if($materiales != NULL){
            // Para cada municipio del listado devuelto
            foreach($materiales as $material){
                // Creamos options con valores = oid_municipio y label = nombre del municipio
                echo "<option value='" . $material["OID_M"] . "'>" . $material["NOMBRE"] . "</option>";    
            }
        }

        cerrarConexionBD($conexion);
        unset($_GET['filtro']);
    }

    function consultarTodosPedidos($conexion){
        $consulta = "SELECT * FROM pedidos ORDER BY OID_PD";
        return $conexion->query($consulta);
    }

    function total_consulta($conexion){
	    try {
	    	$total_consulta = "SELECT COUNT(*) AS TOTAL FROM pedidos";

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

            if ($tipo=="CantidadMayor") {
                $total_consulta = "SELECT COUNT(*) AS TOTAL FROM pedidos WHERE cantidad >= ".$param;
            }elseif ($tipo=="CantidadMenor") {
                $total_consulta = "SELECT COUNT(*) AS TOTAL FROM pedidos WHERE cantidad <= ".$param;
            }else{
                $total_consulta = "SELECT COUNT(*) AS TOTAL FROM pedidos WHERE oid_m = ".$param;
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
            if ($tipo=="CantidadMayor") {
                $consulta_paginada = 
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM pedidos WHERE cantidad >= ".$param." ORDER BY cantidad) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";
            }elseif ($tipo=="CantidadMenor") {
                $consulta_paginada = 
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM pedidos WHERE cantidad <= ".$param." ORDER BY cantidad) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";
            }else{
                $consulta_paginada = 
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM pedidos WHERE oid_m = ".$param." ORDER BY OID_PD) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";
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
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM pedidos ORDER BY OID_PD ) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";

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

    function quitar_pedido($conexion,$oidPedido){
        try{
            $stmt=$conexion->prepare('CALL eliminar_pedido(:oidPedido)');
            $stmt->bindParam(':OidPedido',$oidPedido);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    function getFechaFormateada($fecha){
		return date('d/m/Y', strtotime($fecha));
	}

    function modificar_pedido($conexion,$oidPedido,$fecha_solicitud,$fecha_entrega,$cantidad,$material){
        try{
            $stmt=$conexion->prepare('CALL Modifica_pedido(:oidPedido,:fecha_solicitud,:fecha_entrega,:cantidad,:material)');
            $stmt->bindParam(':oidPedido',$oidPedido);
            $stmt->bindParam(':fecha_solicitud',getFechaFormateada($fecha_solicitud));
            $stmt->bindParam(':fecha_entrega',getFechaFormateada($fecha_entrega));
            $stmt->bindParam(':cantidad',$cantidad);
            $stmt->bindParam(':material',$material);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    function crear_pedido($conexion,$fecha_solicitud,$fecha_entrega,$cantidad,$OID_PR,$material,$OID_F){
        try{
            $stmt=$conexion->prepare('CALL crear_pedido(:fecha_solicitud,:fecha_entrega,:cantidad,:OID_PR,:material,:OID_F)');
            $stmt->bindParam(':fecha_solicitud',getFechaFormateada($fecha_solicitud));
            $stmt->bindParam(':fecha_entrega',getFechaFormateada($fecha_entrega));
            $stmt->bindParam(':cantidad',$cantidad);
            $stmt->bindParam(':OID_PR',$OID_PR);
            $stmt->bindParam(':material',$material);
            $stmt->bindParam(':OID_F',$OID_F);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

?>
