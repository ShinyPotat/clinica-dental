<?php
    session_start();

    if (isset($_REQUEST["OID_C"])) {
        $clinica["OID_C"] = $_REQUEST["OID_C"];
        $clinica["NOMBRE"] = $_REQUEST["NOMBRE"];
        $clinica["LOCALIZACIÓN"] = $_REQUEST["LOCALIZACIÓN"];
        $clinica["TLF_CONTACTO"] = $_REQUEST["TLF_CONTACTO"];
        $clinica["MOROSO"] = $_REQUEST["MOROSO"];
        $clinica["NOMBRE_DUEÑO"] = $_REQUEST["NOMBRE_DUEÑO"];
        $clinica["NUM_COLEGIADO"] = $_REQUEST["NUM_COLEGIADO"];
        $_SESSION["clinica"] = $clinica;

        if (isset($_REQUEST["Editar"]))
            Header("Location: consulta_clinica.php");
        else if (isset($_REQUEST["Guardar"]))
            Header("Location: accion_modificar_clinica.php");
        else if (isset($_REQUEST["Borrar"]))
            Header("Location: accion_borrar_clinica.php");
    } else {
        Header("Location: consulta_clinica.php");
    }
    
?>