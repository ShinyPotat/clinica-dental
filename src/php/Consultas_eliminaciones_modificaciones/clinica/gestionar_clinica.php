<?php
    function consultarClinicas($conexion)
    {
        $consulta = "SELECT * FROM clinicas ORDER BY OID_C";
        return $conexion->query($consulta);
    }

    function total_consulta($conexion){
        try {
            $total_consulta = "SELECT COUNT(*) AS TOTAL FROM clinicas";

            $stmt = $conexion->query($total_consulta);
            $result = $stmt->fetch();
            $total = $result['TOTAL'];
            return $total;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function consulta_paginada($conexion, $pag_num, $pag_size){
        try {
            $primera = ($pag_num-1) * $pag_size + 1;
            $ultima = $pag_num * $pag_size;
            $consulta_paginada = "SELECT * FROM (SELECT ROWNUM RNUM, AUX.* FROM (SELECT * FROM clinicas ORDER BY OID_C) AUX WHERE ROWNUM <= :ultima) WHERE RNUM >= :primera";

            $stmt = $conexion->prepare($consulta_paginada);
            $stmt->bindParam(':primera', $primera);
            $stmt->bindParam(':ultima', $ultima);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function quitar_clinica($conexion, $oidClinica){
        try {
            $stmt = $conexion->prepare('CALL eliminar_clinica(:oidClinica)');
            $stmt->bindParam(':oidClinica', $oidClinica);
            $stmt->execute();
            return "";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function modificar_clinica($conexion, $oidClinica, $nombre, $localizacion, $tlf, $nombre_due, $num_col){
        try {
            $stmt = $conexion->prepare('CALL modifica_clinica(:oidClinica,:nombre,:localizacion,:tlf,:nombre_due,:num_col)');
            $stmt->bindParam(':oidClinica', $oidClinica);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':localizacion', $localizacion);
            $stmt->bindParam(':tlf', $tlf);
            $stmt->bindParam(':nombre_due', $nombre_due);
            $stmt->bindParam(':num_col', $num_col);
            $stmt->execute();
            return "";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function crear_clinica($conexion,$nombre,$localizacion,$tlf_contacto,$moroso,$nombre_dueño,$num_colegiado){
        try{
            $stmt=$conexion->prepare('CALL crear_clinica(:nombre,:localizacion,:tlf_contacto,:moroso,:nombre_dueño,:num_colegiado)');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':localizacion',$localizacion);
            $stmt->bindParam(':tlf_contacto',$tlf_contacto);
            $stmt->bindParam(':moroso',$moroso);
            $stmt->bindParam(':nombre_dueño',$nombre_dueño);
            $stmt->bindParam(':num_colegiado',$num_colegiado);
            $stmt->execute();
            return "";
        }catch(PDOException $e) {
            /*$_SESSION['excepcion'] = $e->GetMessage();
            header("Location: excepcion.php");*/
            return $e->getMessage();
        }
    }
?>