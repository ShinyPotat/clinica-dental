<?php
    session_start();

    if (isset($_REQUEST["OID_P"])) {
        $clinica["OID_P"] = $_REQUEST["OID_P"];
        $clinica["NOMBRE"] = $_REQUEST["NOMBRE"];
        $clinica["PRECIO"] = $_REQUEST["PRECIO"];;
        $clinica["OID_E"] = $_REQUEST["OID_E"];
        $_SESSION["producto"] = $producto;

        if (isset($_REQUEST["Editar"]))
            Header("Location: consulta_producto.php");
        else if (isset($_REQUEST["Guardar"]))
            Header("Location: accion_modificar_producto.php");
        else if (isset($_REQUEST["Borrar"]))
            Header("Location: accion_borrar_producto.php");
    } else {
        Header("Location: consulta_producto.php");
    }
    
?>