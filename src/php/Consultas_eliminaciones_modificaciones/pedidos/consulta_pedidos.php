<?php
    session_start();

    if(!isset($_SESSION["login"])){
        header("Location: ../../login.php");
    }

	require_once("../../gestionBD.php");
	require_once("gestionarPedidos.php");
	
	if (isset($_SESSION["pedido"])){
		$pedido = $_SESSION["pedido"];
		unset($_SESSION["pedido"]);
    }

    if (isset($_REQUEST['filtro']) && $_REQUEST["filtro"]!="") {
        $_SESSION['filtroPedido'] = $_REQUEST['filtro'];
        $_SESSION['filterValuePedido'] = $_REQUEST['filterValue'];
    }else if(isset($_REQUEST['filtro']) && $_REQUEST['filtro']==""){
        unset($_SESSION['filtroPedido']);
        unset($_SESSION['filterValuePedido']);
    }
    
    if (isset($_SESSION["PAG_PED"])) $paginacion = $_SESSION["PAG_PED"]; 
		$pagina_seleccionada = isset($_GET["PAG_NUMP"])? (int)$_GET["PAG_NUMP"]:
													(isset($paginacion)? (int)$paginacion["PAG_NUMP"]: 1);
		$pag_tam = isset($_GET["PAG_TAMP"])? (int)$_GET["PAG_TAMP"]:
											(isset($paginacion)? (int)$paginacion["PAG_TAMP"]: 10);
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 10;
	
	unset($_SESSION["PAG_PED"]);

	$conexion = crearConexionBD();
    
    if (isset($_SESSION['filtroPedido']) && $_SESSION['filtroPedido']!="") {
        $total_registros = total_consulta_filtrada($conexion,$_SESSION['filtroPedido'],$_SESSION['filterValuePedido']);
    } else {
        $total_registros = total_consulta($conexion);
    }

	$total_paginas = (int) ($total_registros / $pag_tam);
	if ($total_registros % $pag_tam > 0) $total_paginas++; 
	if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;
	$paginacion["PAG_NUMP"] = $pagina_seleccionada;
	$paginacion["PAG_TAMP"] = $pag_tam;
	$_SESSION["PAG_PED"] = $paginacion;
	
	if(isset($_SESSION['filtroPedido']) && $_SESSION['filtroPedido']!=""){
        $filas = consulta_paginada_filtrado($conexion,$_SESSION['filtroPedido'],$_SESSION['filterValuePedido'],$pagina_seleccionada,$pag_tam);
    }else{
        $filas = consulta_paginada($conexion,$pagina_seleccionada,$pag_tam);
    }

	cerrarConexionBD($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gestión de pedidos</title>
    <link rel="stylesheet", type="text/css", href="../../../css/consultaMateriales.css">
    <script src="../../../js/validacion_cliente_alta_pedido.js" type="text/javascript"></script>
    <script src="../../../js/dates.js" type="text/javascript"></script>
    <script src="../../../js/filtro_pedidos.js"></script>
    <script src="../../../js/jquery-3.1.1.min.js" type="text/javascript"></script>
</head>
<body>
    <?php include_once ("../../cabeceraC.php"); ?>

    <a href="../../formularios/form_alta_pedido.php" class="botonNuevoPedido">Nuevo Pedido</a>
    <a href= "../../formularios/form_alta_material.php" class="botonNuevoMaterial">Nuevo Material</a>
    <a href="../../formularios/form_alta_proveedor.php" class="botonNuevoProveedor">Nuevo Proveedor</a>
    
    <a href= "../pedidos/consulta_pedidos.php" class="botonPedidos">Pedidos</a>
    <a href= "../materiales/consulta_materiales.php" class="botonMateriales">Materiales</a>
    <a href="../proveedor/consulta_proveedores.php" class="botonProveedores">Proveedores</a>
    <script src="../../../js/hora.js"></script>
    <a href="../../accesorapido.php" class="buttonAtras">«</a> 
    <p class="volver">Volver</p>
    
    <main>
        <nav>
            <div class="enlaces">           <!-- enlaces a las paginas (1234567...)  -->
                <?php
                for($pagina=1; $pagina<=$total_paginas; $pagina++){
                    if($pagina == $pagina_seleccionada){	?>
                        <span><?php echo $pagina;?></span>
                    <?php }else{ ?>
                        <a href="consulta_pedidos.php?PAG_NUMP=<?php echo $pagina; ?> &PAG_TAMP=<?php echo $pag_tam; ?>"><?php echo $pagina ?> </a>
            <?php }} ?>
            </div>            <!-- fin enlaces -->
            
            <form class="formulario" method="get" action="consulta_pedidos.php">        <!-- formulario para indicar numero de elemento en 1 magina quieres -->
                <input id="PAG_NUMP" name="PAG_NUMP" type="hidden" value="<?php echo $pagina_seleccionada?>"/>
                Mostrando 
                <input id="PAG_TAMP" name="PAG_TAMP" type="number" 
                    min="1" max="<?php echo $total_registros;?>" 
                    value="<?php echo $pag_tam?>" autofocus="autofocus" /> 
                entradas de <?php echo $total_registros?>
                <input type="submit" value="Cambiar"/>
            </form>
            <?php
            if(isset($_SESSION["errores"])) {
                $errores=$_SESSION["errores"];
                unset($_SESSION["errores"]);
                echo "<div class='error'>";
                echo "<ul>";
                foreach($errores as $error){
                    echo "<li>".$error."</li>";
                }
                echo "</ul>";
                echo "</div>";
            }
            ?>                                                       <!-- fin de formulario -->
        </nav>
        <table class="blueTable">                  <!-- comienzo de la tabla -->
            <thead>
            <tr>                        <!-- primera linea de la tabla -->
                <th>fecha de solicitud</th>
                <th>fecha de entrega</th>
                <th>cantidad</th>
                <th>material</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <?php
                foreach($filas as $fila){
            ?>

            <article>
                <form method="post" action="controlador_pedidos.php">
                    <div>           <!-- datos de la tabla-->
                        <div>
                            <input id="OID_PD" name="OID_PD" type="hidden" value="<?php echo $fila["OID_PD"]; ?>">
                            <input id="OID_PR" name="OID_PR" type="hidden" required value="<?php echo $fila["OID_PR"];?>">
                            <input name="OID_F" id="OID_F" type= "hidden" required value="<?php echo $fila["OID_F"];?>">
                            <?php
                                if(isset($pedido) and ($pedido["OID_PD"] == $fila["OID_PD"])){ ?>
                                    <tr>                        <!-- filas de la tabla -->
                                        <td><input id="FECHA_SOLICITUD" name="FECHA_SOLICITUD" type="date" value="<?php echo $fila["FECHA_SOLICITUD"];?>"
                                        oninput="solicitudValidation(document.getElementById('FECHA_SOLICITUD'))"></td>
                                        <td><input id="FECHA_ENTREGA" name="FECHA_ENTREGA" type="date" value="<?php echo $fila["FECHA_ENTREGA"];?>"
                                        oninput="entregaValidation(document.getElementById('FECHA_ENTREGA'));"></td>
                                        <td><input required min="0" type="number" name="CANTIDAD" id="CANTIDAD" value="<?php echo $fila["CANTIDAD"];?>"></td>
                                        <td><?php 
                                                 require_once("../../gestionBD.php");
                                                $conexion = crearConexionBD();
                                                $query = "SELECT OID_M, NOMBRE FROM Materiales ORDER BY NOMBRE ASC";
                                                $materiales = $conexion->query($query);
                                                cerrarConexionBD($conexion);
                                            ?>
                                            <div><select id="MATERIAL" name="MATERIAL">
                                                <option value="">Seleccionar material</option>
                                                <?php foreach($materiales as $filam){ ?>
                                                    <option value="<?php echo $filam["OID_M"]; ?>" <?php if(isset($pedido) && $fila['OID_M']==$filam["OID_M"]){ echo "selected='selected'";}?>><?php echo $filam["NOMBRE"]; ?></option>

                                                <?php } ?>
                                                </select></td>
                        <?php }else{ ?>
                                    <tr>
                                        <td><?php echo $fila["FECHA_SOLICITUD"];?></td>              <!-- columnas -->
                                        <td><?php echo $fila["FECHA_ENTREGA"];?></td>
                                        <td><?php echo $fila["CANTIDAD"];?></td>
                                        <?php 
                                            require_once("../../gestionBD.php");
                                            $conexion = crearConexionBD();
                                            $query = "SELECT NOMBRE FROM Materiales WHERE oid_m = ". $fila["OID_M"];
                                            $material = $conexion->query($query);
                                            cerrarConexionBD($conexion);
                                        ?>
                                        <td><?php foreach($material as $filam){echo $filam["NOMBRE"];}?></td>
                        <?php } ?>
                        </div>          
                                        <div>       <!-- columna de los botones -->
                                            <td>
                                                <?php 
                                                if (isset($pedido) and ($pedido["OID_PD"] == $fila["OID_PD"])) { ?>
                                                    <button class="consulta" id="Guardar" name="Guardar" type="submit"><img src="http://icons.iconarchive.com/icons/custom-icon-design/pretty-office-7/16/Save-as-icon.png" alt="x" />Guardar</button>
                                        <?php }else{ ?>
                                                    <button class="consulta" id="Editar" name="Editar" type="submit"><img src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-1/16/edit-icon.png" alt="x" />Editar</button>
                                        <?php } ?>
                                                <button class="consulta" id="Borrar" name="Borrar" type="submit"><img src="https://aurea.es/demos/ico/delete.gif" alt="x" />Borrar
                                                </button>
                                            </td>
                                        </div>   <!-- fin de columna de botones -->
                                    </tr>
                    </div>              <!-- fin de datos de la tabla -->
                </form>
            </article>
                    <?php } ?>
        </table>
        <form id="filterForm" action="consulta_pedidos.php" method="post">
            <select class="filtro" name="filtro" id="filtro" style="left: 35%;" oninput="auto(document.getElementById('filtro').value)">
                <option value="" <?php if(isset($_SESSION['filtroPedido']) && $_SESSION['filtroPedido']==""){ echo "selected='selected'";}?>>---</option>
                <option value="CantidadMayor" <?php if(isset($_SESSION['filtroPedido']) && $_SESSION['filtroPedido']=="CantidadMayor"){ echo "selected='selected'";}?>>Cantidad mayor que</option>
                <option value="CantidadMenor" <?php if(isset($_SESSION['filtroPedido']) && $_SESSION['filtroPedido']=="CantidadMenor"){ echo "selected='selected'";}?>>Cantidad menor que</option>
                <option value="Material" <?php if(isset($_SESSION['filtroPedido']) && $_SESSION['filtroPedido']=="Material"){ echo "selected='selected'";}?>>Material</option>
            </select>
            <div id="filterValueDiv">
            <?php
                if(isset($_SESSION['filtroPedido']) && $_SESSION['filtroPedido']!="" && $_SESSION['filtroPedido']!="Material"){?>
                    <input class="filterValue" type="number" required min="0" name="filterValue" id="filterValue" value="<?php echo $_SESSION['filterValuePedido'];?>">
                    <input class="filterButton" type="submit" value="FILTRAR">
           <?php  }else if(isset($_SESSION['filtroPedido']) && $_SESSION['filtroPedido']=="Material"){
                        $conexion = crearConexionBD();
                        $query = "SELECT OID_M, Nombre FROM materiales ORDER BY Nombre ASC";
                        $materiales = $conexion->query($query);
                        cerrarConexionBD($conexion); ?>
                        <select class="filterValue" name="filterValue" id="filterValue">
                        <?php foreach ($materiales as $material) { ?>
                                <option value="<?php echo $material['OID_M'] ?>" <?php if($material['OID_M'] == $_SESSION['filterValuePedido']){echo "selected='selected'";} ?>><?php echo $material['NOMBRE']; ?></option>
                        <?php   } ?>
                        </select>
                        <input class="filterButton" type="submit" value="FILTRAR">
         <?php  } ?>
            </div>
        </form>
    </main>
</body>
</html>