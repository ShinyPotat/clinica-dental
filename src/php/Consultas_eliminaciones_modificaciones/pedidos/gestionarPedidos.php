<?php
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

    function modificar_pedido($conexion,$oidPedido,$fecha_solicitud,$fecha_entrega){
        try{
            $stmt=$conexion->prepare('CALL Modifica_pedido(:oidPedido,:fecha_solicitud,:fecha_entrega)');
            $stmt->bindParam(':oidPedido',$oidPedido);
            $stmt->bindParam(':fecha_solicitud',$fecha_solicitud);
            $stmt->bindParam(':fecha_entrega',$fecha_entrega);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    function crear_pedido($conexion,$fecha_solicitud,$fecha_entrega){
        try{
            $stmt=$conexion->prepare('CALL crear_pedido(:fecha_solicitud,:fecha_entrega,:OID_PR,:OID_F)');
            $stmt->bindParam(':fecha_solicitud',$fecha_solicitud);
            $stmt->bindParam(':fecha_entrega',$fecha_entrega);
            $stmt->bindParam(':OID_PR',$OID_PR);
            $stmt->bindParam(':OID_F',$OID_F);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

?>
