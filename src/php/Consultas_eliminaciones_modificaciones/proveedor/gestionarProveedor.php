<?php
    function consultarTodosProveedores($conexion){
        $consulta = "SELECT * FROM proveedores ORDER BY OID_PR";
        return $conexion->query($consulta);
    }

    function total_consulta($conexion){
	    try {
	    	$total_consulta = "SELECT COUNT(*) AS TOTAL FROM proveedores";

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
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM proveedores ORDER BY OID_PR ) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";

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

    function quitar_proveedor($conexion,$oidProveedor){
        try{
            $stmt=$conexion->prepare('CALL eliminar_proveedor(:oidProveedor)');
            $stmt->bindParam(':oidProveedor',$oidProveedor);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            /*$_SESSION['excepcion'] = $e->GetMessage();
            header("Location: excepcion.php");*/
            return $e->getMessage();
        }
    }

    function modificar_proveedor($conexion,$oidProveedor,$nombre,$localizacion,$tlf_contacto){
        try{
            $stmt=$conexion->prepare('CALL modifica_proveedor(:oidProveedor,:nombre,:localización,:tlf_contacto)');
            $stmt->bindParam(':oidProveedor',$oidProveedor);
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':localización',$localizacion);
            $stmt->bindParam(':tlf_contacto',$tlf_contacto);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            /*$_SESSION['excepcion'] = $e->GetMessage();
            header("Location: excepcion.php");*/
            return $e->getMessage();
        }
    }

?>