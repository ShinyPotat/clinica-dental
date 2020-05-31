<?php
    require_once("../gestionBD.php");
	require_once("gestion-usuario.php");

    session_start();
    
    if (isset($_SESSION['login'])){
        $conexion = crearConexionBD();
        $login = $_SESSION['login'];
        $excepcion = borrarUsuario($conexion, $login["user"]);
        cerrarConexionBD($conexion);
        if($excepcion<>""){							
            $_SESSION["excepcion"] = $excepcion;
            $_SESSION["destino"]= "accesorapido.php";
            header("Location: ../excepcion.php");
        } else {  
            unset($_SESSION['login']);
            Header("Location: ../login.php");
        }
    }
?>