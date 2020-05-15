<?php
    session_start();

    if (isset($_SESSION["clinica"])){
        $clinica = $_SESSION["clinica"];
        unset($_SESSION["clinica"]);

        require_once("../gestionBD.php");
        require_once("gestionar_clinica.php");

        $conexion = crearConexionBD();
        $excepcion = modificar_clinica($conexion,$clinica["OID_C"],$clinica["LOCALIZACIÓN"],$clinica["TLF_CONTACTO"],$clinica["MOROSO"],$clinica["NOMBRE_DUEÑO"],$clinica["NUM_COLEGIADO"]);

        cerrarConexionBD($conexion);

        if ($excepcion<>""){
            $_SESSION["exception"] = $excepcion;
            $_SESSION["destino"] = "consulta_clinica.php";
            Header("Location: exception.php");
        }else{
            Header("Location: consulta_clinica.php");
        }
    }else {
        Header("Location: consulta_clinica.php");
    }
?>