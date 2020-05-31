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


    function consultarClinicas($conexion)
    {
        $consulta = "SELECT * FROM productos ORDER BY OID_P";
        return $conexion->query($consulta);
    }

    function total_consulta($conexion){
        try {
            $total_consulta = "SELECT COUNT(*) AS TOTAL FROM productos";

            $stmt = $conexion->query($total_consulta);
            $result = $stmt->fetch();
            $total = $result['TOTAL'];
            return $total;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function total_consulta_filtrada($conexion,$tipo,$param){
	    try {
            if($tipo=="PrecioMayor"){
                $total_consulta = "SELECT COUNT(*) AS TOTAL FROM productos WHERE precio >= ".$param;
            }else if ($tipo=="PrecioMenor"){
                $total_consulta = "SELECT COUNT(*) AS TOTAL FROM productos WHERE precio <= ".$param;
            }elseif ($tipo=="CantidadMayor") {
                $total_consulta = "SELECT COUNT(*) AS TOTAL FROM productos WHERE cantidad >= ".$param;
            }elseif ($tipo=="CantidadMenor") {
                $total_consulta = "SELECT COUNT(*) AS TOTAL FROM productos WHERE cantidad <= ".$param;
            }else{
                $total_consulta = "SELECT COUNT(*) AS TOTAL FROM productos WHERE oid_m = ".$param;
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
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM productos WHERE precio >= ".$param." ORDER BY precio) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";
            } else if($tipo=="PrecioMenor"){
                $consulta_paginada = 
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM productos WHERE precio <= ".$param." ORDER BY precio) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";
            }elseif ($tipo=="CantidadMayor") {
                $consulta_paginada = 
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM productos WHERE cantidad >= ".$param." ORDER BY cantidad) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";
            }elseif ($tipo=="CantidadMenor") {
                $consulta_paginada = 
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM productos WHERE cantidad <= ".$param." ORDER BY cantidad) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";
            }else{
                $consulta_paginada = 
	    		 "SELECT * FROM ( SELECT ROWNUM RNUM, AUX.* FROM ( SELECT * FROM productos WHERE oid_m = ".$param." ORDER BY oid_p) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";
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

    function consulta_paginada($conexion, $pag_num, $pag_size){
        try {
            $primera = ($pag_num-1) * $pag_size + 1;
            $ultima = $pag_num * $pag_size;
            $consulta_paginada = "SELECT * FROM (SELECT ROWNUM RNUM, AUX.* FROM (SELECT * FROM productos ORDER BY OID_P) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";

            $stmt = $conexion->prepare($consulta_paginada);
            $stmt->bindParam(':primera', $primera);
            $stmt->bindParam(':ultima', $ultima);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function quitar_producto($conexion, $oidProducto){
        try {
            $stmt = $conexion->prepare('CALL eliminar_producto(:oidProducto)');
            $stmt->bindParam(':oidProducto', $oidProducto);
            $stmt->execute();
            return "";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function modificar_producto($conexion, $oidProducto, $nombre, $precio, $cantidad, $material){
        try {
            $stmt = $conexion->prepare('CALL modifica_producto(:oidProducto,:nombre, :precio, :cantidad, :material)');
            $stmt->bindParam(':oidProducto', $oidProducto);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->bindParam(':material', $material);
            $stmt->execute();
            return "";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function crear_producto($conexion,$nombre,$precio,$cantidad, $OID_M, $OID_E){
        try{
            $stmt=$conexion->prepare('CALL crear_producto(:nombre,:precio, :cantidad, :OID_M, :OID_E)');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':precio',$precio);
            $stmt->bindParam(':cantidad',$cantidad);
            $stmt->bindParam(':OID_M',$OID_M);
            $stmt->bindParam(':OID_E',$OID_E);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }
?>