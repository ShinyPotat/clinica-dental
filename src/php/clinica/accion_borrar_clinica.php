<?php
    session_start();

    if (isset($_SESSION["clinica"])){
        $clinica = $_SESSION["clinica"];
        unset($_SESSION["clinica"]);

        require_once("../gestionBD.php");
        require_once("gestionar_clinica.php");

        $conexion = crearConexionBD();
        $excepcion = quitar_material($conexion,$clinica["OID_C"]);

        cerrarConexionBD($conexion);

        if ($excepcion<>"") {
            $_SESSION["exception"] = $excepcion;
            $_SESSION["destino"] = "consulta_clinica.php";
            Header("Location: exception.php");
        } else {
            Header("Location: consulta_clinica.php");
        }
        
    }else{
        Header("Location: consulta_clinica.php");
    }
?>