<?php
    session_start();

    if (isset($_SESSION["clinica"])){
        $clinica = $_SESSION["clinica"];
        unset($_SESSION["clinica"]);

        require_once("../../gestionBD.php");
        require_once("gestionar_clinica.php");

        $conexion = crearConexionBD();
        $excepcion = modificar_clinica($conexion,$clinica["OID_C"],$clinica["NOMBRE"],$clinica["LOCALIZACIÓN"],$clinica["TLF_CONTACTO"],$clinica["NOMBRE_DUEÑO"],$clinica["NUM_COLEGIADO"]);

        cerrarConexionBD($conexion);

        if ($excepcion<>""){
            $_SESSION["excepcion"] = $excepcion;
            $_SESSION["destino"] = "Consultas_eliminaciones_modificaciones/clinica/consulta_clinica.php";
            Header("Location: ../../excepcion.php");
        }else{
            Header("Location: consulta_clinica.php");
        }
    }else {
        Header("Location: consulta_clinica.php");
    }
?>