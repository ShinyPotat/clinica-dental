<?php	
	session_start();
	
	if (isset($_REQUEST["OID_PR"])) {
		$proveedor["OID_PR"] = $_REQUEST["OID_PR"];
		$proveedor["NOMBRE"] = $_REQUEST["NOMBRE"];
		$proveedor["LOCALIZACIÓN"] = $_REQUEST["LOCALIZACIÓN"];
		$proveedor["TLF_CONTACTO"] = $_REQUEST["TLF_CONTACTO"];
		
		$_SESSION["proveedor"] = $proveedor;
			
		if (isset($_REQUEST["Editar"])) Header("Location: consulta_proveedores.php"); 
		else if (isset($_REQUEST["Guardar"])) Header("Location: accion_modificar_proveedor.php");
		else if (isset($_REQUEST["Borrar"])) Header("Location: accion_borrar_proveedor.php"); 
	}
	else 
		Header("Location: consulta_proveedores.php");
	
?>