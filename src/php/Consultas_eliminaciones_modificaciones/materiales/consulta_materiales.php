<?php
    session_start();

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
</head>
<body>
    <main>
        <nav>
            <div>           <!-- enlaces a las paginas (1234567...)  -->
                <?php
                for($pagina=1; $pagina<=$total_paginas; $pagina++){
                    if($pagina == $pagina_seleccionada){	?>
                        <span><?php echo $pagina;?></span>
                    <?php }else{ ?>
                        <a href="consulta_materiales.php?PAG_NUMM=<?php echo $pagina; ?> &PAG_TAMM=<?php echo $pag_tam; ?>"><?php echo $pagina ?> </a>
            <?php }} ?>
            </div>            <!-- fin enlaces -->
            
            <form method="get" action="consulta_materiales.php">        <!-- formulario para indicar numero de elemento en 1 magina quieres -->
                <input id="PAG_NUMM" name="PAG_NUMM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>
                Mostrando 
                <input id="PAG_TAMM" name="PAG_TAMM" type="number" 
                    min="1" max="<?php echo $total_registros;?>" 
                    value="<?php echo $pag_tam?>" autofocus="autofocus" /> 
                entradas de <?php echo $total_registros?>
                <input type="submit" value="Cambiar"/>
            </form>                                                        <!-- fin de formulario -->
        </nav>
        <table>                  <!-- comienzo de la tabla -->
            <tr>                        <!-- primera linea de la tabla -->
                <th>nombre</th>
                <th>categoria</th>
                <th>stock</th>
                <th>stockMinimo</th>
                <th>stockCritico</th>
            </tr>
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
                        <?php }else{ ?>
                                    <input id="NOMBRE" name="NOMBRE" type="hidden" value="<?php echo $fila["NOMBRE"];?>">
                                    <tr>
                                        <td><?php echo $fila["NOMBRE"];?></td>              <!-- columnas -->
                                        <td><?php echo $fila["CATEGORIA"];?></td>
                                        <td><?php echo $fila["STOCK"];?></td>
                                        <td><?php echo $fila["STOCK_MIN"];?></td>
                                        <td><?php echo $fila["STOCK_CRITICO"];?></td>
                        <?php } ?>
                        </div>          
                                        <div>       <!-- columna de los botones -->
                                            <td>
                                                <?php 
                                                if (isset($material) and ($material["OID_M"] == $fila["OID_M"])) { ?>
                                                    <button id="Guardar" name="Guardar" type="submit">Guardar</button>
                                        <?php }else{ ?>
                                                    <button id="Editar" name="Editar" type="submit">Editar</button>
                                        <?php } ?>
                                                <button id="Borrar" name="Borrar" type="submit">Borrar
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