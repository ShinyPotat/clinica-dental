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

    if (isset($_REQUEST['filtro']) && $_REQUEST["filtro"]!="") {
        $_SESSION['filtroMaterial'] = $_REQUEST['filtro'];
        $_SESSION['filterValueMaterial'] = $_REQUEST['filterValue'];
    }else if(isset($_REQUEST['filtro']) && $_REQUEST['filtro']==""){
        unset($_SESSION['filtroMaterial']);
        unset($_SESSION['filterValueMaterial']);
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
    
    if (isset($_SESSION['filtroMaterial']) && $_SESSION['filtroMaterial']!="") {
        $total_registros = total_consulta_filtrada($conexion,$_SESSION['filtroMaterial'],$_SESSION['filterValueMaterial']);
    } else {
        $total_registros = total_consulta($conexion);
    }
    
	$total_paginas = (int) ($total_registros / $pag_tam);
	if ($total_registros % $pag_tam > 0) $total_paginas++; 
	if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;
	$paginacion["PAG_NUMM"] = $pagina_seleccionada;
	$paginacion["PAG_TAMM"] = $pag_tam;
    $_SESSION["PAG_MAT"] = $paginacion;
    
    if(isset($_SESSION['filtroMaterial']) && $_SESSION['filtroMaterial']!=""){
        $filas = consulta_paginada_filtrado($conexion,$_SESSION['filtroMaterial'],$_SESSION['filterValueMaterial'],$pagina_seleccionada,$pag_tam);
    }else{
        $filas = consulta_paginada($conexion,$pagina_seleccionada,$pag_tam);
    }

	cerrarConexionBD($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gestión de inventario</title>
    <link rel="stylesheet", type="text/css", href="../../../css/consultaMateriales.css">
    <script src="../../../js/filtro_materiales.js"></script>
    <script src="../../../js/validacion_cliente_alta_material.js" type="text/javascript"></script>
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
        ?>
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
                                        <td><input id="STOCK"required name="STOCK" type="number" value="<?php echo $fila["STOCK"];?>" min="0"></td>
                                        <td><input id="STOCK_MIN" required name="STOCK_MIN" type="number" value="<?php echo $fila["STOCK_MIN"];?>" min="0"
                                        oninput="critValidation(document.getElementById('STOCK_MIN'),document.getElementById('STOCK_CRITICO'))"></td>
                                        <td><input id="STOCK_CRITICO" required name="STOCK_CRITICO" type="number" value="<?php echo $fila["STOCK_CRITICO"];?>" min="0"
                                        oninput="critValidation(document.getElementById('STOCK_MIN'),document.getElementById('STOCK_CRITICO'))"></td>
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
        <form id="filterForm" action="consulta_materiales.php" method="post">
            <select class="filtro" name="filtro" id="filtro" oninput="auto(document.getElementById('filtro').value)">
                <option value="" <?php if(isset($_SESSION['filtroMaterial']) && $_SESSION['filtroMaterial']==""){ echo "selected='selected'";}?>>---</option>
                <option value="STOCK_MIN" <?php if(isset($_SESSION['filtroMaterial']) && $_SESSION['filtroMaterial']=="STOCK_MIN"){ echo "selected='selected'";}?>>stock minimo</option>
                <option value="STOCK_CRITICO" <?php if(isset($_SESSION['filtroMaterial']) && $_SESSION['filtroMaterial']=="STOCK_CRITICO"){ echo "selected='selected'";}?>>stock crítico</option>
                <option value="CATEGORIA" <?php if(isset($_SESSION['filtroMaterial']) && $_SESSION['filtroMaterial']=="CATEGORIA"){ echo "selected='selected'";}?>>categoria</option>
            </select>
            <div id="filterValueDiv">
             <?php if(isset($_SESSION['filtroMaterial']) && $_SESSION['filtroMaterial']=="CATEGORIA"){ ?>
                        <select class="filterValue" name="filterValue" id="filterValue">
                            <option value="Alambre" <?php if(isset($_SESSION['filterValueMaterial']) && $_SESSION['filterValueMaterial']=="Alambre"){ echo "selected='selected'";}?>>Alambre</option>
                            <option value="Dientes" <?php if(isset($_SESSION['filterValueMaterial']) && $_SESSION['filterValueMaterial']=="Dientes"){ echo "selected='selected'";}?>>Dientes</option>
                            <option value="Empress" <?php if(isset($_SESSION['filterValueMaterial']) && $_SESSION['filterValueMaterial']=="Empress"){ echo "selected='selected'";}?>>Empress</option>
                            <option value="Ferula" <?php if(isset($_SESSION['filterValueMaterial']) && $_SESSION['filterValueMaterial']=="Ferula"){ echo "selected='selected'";}?>>Ferula</option>
                            <option value="Metal Ceramica" <?php if(isset($_SESSION['filterValueMaterial']) && $_SESSION['filterValueMaterial']=="Metal Ceramica"){ echo "selected='selected'";}?>>Metal Ceramica</option>
                            <option value="Metal" <?php if(isset($_SESSION['filterValueMaterial']) && $_SESSION['filterValueMaterial']=="Metal"){ echo "selected='selected'";}?>>Metal</option>
                            <option value="Resina" <?php if(isset($_SESSION['filterValueMaterial']) && $_SESSION['filterValueMaterial']=="Resina"){ echo "selected='selected'";}?>>Resina</option>
                            <option value="Revestimiento" <?php if(isset($_SESSION['filterValueMaterial']) && $_SESSION['filterValueMaterial']=="Revestimiento"){ echo "selected='selected'";}?>>Revestimiento</option>
                            <option value="Ceramica Zirconio" <?php if(isset($_SESSION['filterValueMaterial']) && $_SESSION['filterValueMaterial']=="Ceramica Zirconio"){ echo "selected='selected'";}?>>Ceramica Zirconio</option>
                        </select>
                        <input class="filterButton" type="submit" value="FILTRAR">
           <?php  } ?>
            </div>
        </form>
    </main>
</body>
</html>