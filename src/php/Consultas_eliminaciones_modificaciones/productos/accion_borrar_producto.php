<?php
    session_start();

    if (isset($_SESSION["producto"])){
        $producto = $_SESSION["producto"];
        unset($_SESSION["producto"]);

        require_once("../../gestionBD.php");
        require_once("gestionar_producto.php");

        $conexion = crearConexionBD();
        $excepcion = quitar_producto($conexion,$producto["OID_P"]);

        cerrarConexionBD($conexion);

        if ($excepcion<>"") {
            $_SESSION["excepcion"] = $excepcion;
            $_SESSION["destino"] = "Consultas_eliminaciones_modificaciones/productos/consulta_producto.php";
            Header("Location: ../../excepcion.php");
        } else {
            Header("Location: consulta_producto.php");
        }
        
    }else{
        Header("Location: consulta_producto.php");
    }
?>