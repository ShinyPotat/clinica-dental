<?php
    session_start();

    if(!isset($_SESSION["login"])){
        header("../login.php");
    }

	require_once("../../gestionBD.php");
	require_once("gestionarMateriales.php");
	
	if (isset($_SESSION["material"])){
		$material = $_SESSION["material"];
		unset($_SESSION["material"]);
    }
    
    if (isset($_SESSION["PAG_MAT"])) $paginacion = $_SESSION["PAG_MAT"]; 
		$pagina_seleccionada = isset($_GET["PAG_NUMM"])? (int)$_GET["PAG_NUMM"]:
													(isset($paginacion)? (int)$paginacion["PAG_NUMM"]: 1);
		$pag_tam = isset($_GET["PAG_TAMM"])? (int)$_GET["PAG_TAMM"]:
											(isset($paginacion)? (int)$paginacion["PAG_TAMM"]: 10);
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 10;
	
	unset($_SESSION["PAG_MAT"]);

	$conexion = crearConexionBD();
    //$filas = consultarTodosMateriales($conexion);
    
    $total_registros = total_consulta($conexion);
	$total_paginas = (int) ($total_registros / $pag_tam);
	if ($total_registros % $pag_tam > 0) $total_paginas++; 
	if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;
	$paginacion["PAG_NUMM"] = $pagina_seleccionada;
	$paginacion["PAG_TAMM"] = $pag_tam;
	$_SESSION["PAG_MAT"] = $paginacion;
	
	$filas = consulta_paginada($conexion,$pagina_seleccionada,$pag_tam);

	cerrarConexionBD($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gestión de inventario</title>
    <link rel="stylesheet", type="text/css", href="../../../css/consultaMateriales.css">
    
</head>
<body>

    <a href="../../../html/log.html" ><img class="imagen" src="../../../../images/logo.png" alt="logo.png" width=23% height=23%></a>

    <div class="block">
        <a href="../../../html/about-us.html" class="acerca">Acerca de nosotros</a>
        <!-- Estos bloques definen las id que se usan para el js de la hora -->
        <div id="box">
            <div id="box-date"></div>
            <div id="box-time"></div>
        </div>
        
        <img class="calendario" src="../../../../images/calendario.png" width="1%" height="11%">
        <img class="reloj" src="../../../../images/reloj.png" width="1%" height="11%">
        
        <img class="usuario" src="../../../../images/user.png" width="1.5%" height="13%">
        
        <img class="flechaA" src="../../../images/flechaA.png" width="20" height="20">
        
        <select class="botonUsuario">
            <option value="1">Usuario</option>
            <option value="2">Opcion 2</option>
            <option value="3">Opcion 3</option>
        </select>
    </div>
    <a href="../../formularios/form_alta_pedido.php" class="botonNuevoPedido">Nuevo Pedido</a>
    <a href= "../../formularios/form_alta_material.php" class="botonNuevoMaterial">Nuevo Material</a>
    <a href="../../formularios/form_alta_proveedor.php" class="botonNuevoProveedor">Nuevo Proveedor</a>
    
    <a href= "../pedidos/consulta_pedidos.php" class="botonPedidos">Pedidos</a>
    <a href= "../materiales/consulta_materiales.php" class="botonMateriales">Materiales</a>
    <a href="../proveedor/consulta_proveedores.php" class="botonProveedores">Proveedores</a>
    <script src="../../../js/hora.js"></script>
    <a href="../../../html/accesorapido.html" class="buttonAtras">«</a> 
    <p class="volver">Volver</p>
    
    <main>
        <nav>
            <div class="enlaces">           <!-- enlaces a las paginas (1234567...)  -->
                <?php
                for($pagina=1; $pagina<=$total_paginas; $pagina++){
                    if($pagina == $pagina_seleccionada){	?>
                        <span><?php echo $pagina;?></span>
                    <?php }else{ ?>
                        <a href="consulta_materiales.php?PAG_NUMM=<?php echo $pagina; ?> &PAG_TAMM=<?php echo $pag_tam; ?>"><?php echo $pagina ?> </a>
            <?php }} ?>
            </div>            <!-- fin enlaces -->
            
            <form class="formulario" method="get" action="consulta_materiales.php">        <!-- formulario para indicar numero de elemento en 1 magina quieres -->
                <input id="PAG_NUMM" name="PAG_NUMM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>
                Mostrando 
                <input id="PAG_TAMM" name="PAG_TAMM" type="number" 
                    min="1" max="<?php echo $total_registros;?>" 
                    value="<?php echo $pag_tam?>" autofocus="autofocus" /> 
                entradas de <?php echo $total_registros?>
                <input type="submit" value="Cambiar"/>
            </form>                                                        <!-- fin de formulario -->
        </nav>
        <table class="blueTable">                  <!-- comienzo de la tabla -->
            <thead>
            <tr>                        <!-- primera linea de la tabla -->
                <th>nombre</th>
                <th>categoria</th>
                <th>stock</th>
                <th>stockMinimo</th>
                <th>stockCritico</th>
                <th>unidad</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <?php
                foreach($filas as $fila){
            ?>

            <article>
                <form method="post" action="controlador_materiales.php">
                    <div>           <!-- datos de la tabla-->
                        <div>
                            <input id="OID_M" name="OID_M" type="hidden" value="<?php echo $fila["OID_M"]; ?>">
                            <input id="NOMBRE" name="NOMBRE" type="hidden" required value="<?php echo $fila["NOMBRE"];?>">
                            <input name="CATEGORIA" id="CATEGORIA" type= "hidden" required value="<?php echo $fila["CATEGORIA"];?>">
                            <input id="UNIDAD" name="UNIDAD" type="hidden" required value="<?php echo $fila["UNIDAD"];?>">
                            <?php
                                if(isset($material) and ($material["OID_M"] == $fila["OID_M"])){ ?>
                                    <tr>                        <!-- filas de la tabla -->
                                        <td><?php echo $fila["NOMBRE"];?></td>
                                        <td><?php echo $fila["CATEGORIA"];?></td>
                                        <td><input id="STOCK" name="STOCK" type="number" value="<?php echo $fila["STOCK"];?>"></td>
                                        <td><input id="STOCK_MIN" name="STOCK_MIN" type="number" value="<?php echo $fila["STOCK_MIN"];?>"></td>
                                        <td><input id="STOCK_CRITICO" name="STOCK_CRITICO" type="number" value="<?php echo $fila["STOCK_CRITICO"];?>"></td>
                                        <td><?php echo $fila["UNIDAD"];?></td>
                        <?php }else{ ?>
                                    <input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $fila["NOMBRE"];?>">
                                    <tr>
                                        <td><?php echo $fila["NOMBRE"];?></td>              <!-- columnas -->
                                        <td><?php echo $fila["CATEGORIA"];?></td>
                                        <td><?php echo $fila["STOCK"];?></td>
                                        <td><?php echo $fila["STOCK_MIN"];?></td>
                                        <td><?php echo $fila["STOCK_CRITICO"];?></td>
                                        <td><?php echo $fila["UNIDAD"];?></td>
                        <?php } ?>
                        </div>          
                                        <div>       <!-- columna de los botones -->
                                            <td>
                                                <?php 
                                                if (isset($material) and ($material["OID_M"] == $fila["OID_M"])) { ?>
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
    </main>
</body>
</html>