<?php
    session_start();

    if(!isset($_SESSION["login"])){
        header("Location: ../../login.php");
    }

	require_once("../../gestionBD.php");
	require_once("gestionarFacturas.php");
	
	if (isset($_SESSION["factura"])){
		$factura = $_SESSION["factura"];
		unset($_SESSION["factura"]);
    }

    if (isset($_REQUEST['filtro']) && $_REQUEST["filtro"]!="") {
        $_SESSION['filtro'] = $_REQUEST['filtro'];
        $_SESSION['filterValue'] = $_REQUEST['filterValue'];
    }else if(isset($_REQUEST['filtro']) && $_REQUEST['filtro']==""){
        unset($_SESSION['filtro']);
        unset($_SESSION['filterValue']);
    }
    
    if (isset($_SESSION["PAG_FAC"])) $paginacion = $_SESSION["PAG_FAC"]; 
		$pagina_seleccionada = isset($_GET["PAG_NUMF"])? (int)$_GET["PAG_NUMF"]:
													(isset($paginacion)? (int)$paginacion["PAG_NUMF"]: 1);
		$pag_tam = isset($_GET["PAG_TAMF"])? (int)$_GET["PAG_TAMF"]:
											(isset($paginacion)? (int)$paginacion["PAG_TAMF"]: 10);
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 10;
	
	unset($_SESSION["PAG_FAC"]);

    $conexion = crearConexionBD();
    
    if (isset($_SESSION['filtro']) && $_SESSION['filtro']!="") {
        $total_registros = total_consulta_filtrada($conexion,$_SESSION['filtro'],$_SESSION['filterValue']);
    } else {
        $total_registros = total_consulta($conexion);
    }
    
	$total_paginas = (int) ($total_registros / $pag_tam);
	if ($total_registros % $pag_tam > 0) $total_paginas++; 
	if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;
	$paginacion["PAG_NUMF"] = $pagina_seleccionada;
	$paginacion["PAG_TAMF"] = $pag_tam;
	$_SESSION["PAG_FAC"] = $paginacion;
	
	if(isset($_SESSION['filtro']) && $_SESSION['filtro']!=""){
        $filas = consulta_paginada_filtrado($conexion,$_SESSION['filtro'],$_SESSION['filterValue'],$pagina_seleccionada,$pag_tam);
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
    <link rel="stylesheet", type="text/css", href="../../../css/consultaFacturas.css">
    <script src="../../../js/filtro_facturas.js"></script>
</head>
<body>
    <?php include_once ("../../cabeceraC.php"); ?>
    
    <a href= "../../formularios/form_alta_facturas.php" class="botonNuevaFactura">Nueva factura</a>
    <a href= "../facturas/consulta_facturas.php" class="botonFactura">Facturas</a>
    
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
                        <a href="consulta_facturas.php?PAG_NUMF=<?php echo $pagina; ?> &PAG_TAMF=<?php echo $pag_tam; ?>"><?php echo $pagina ?> </a>
            <?php }} ?>
            </div>            <!-- fin enlaces -->
            
            <form class="formulario" method="get" action="consulta_facturas.php">        <!-- formulario para indicar numero de elemento en 1 magina quieres -->
                <input id="PAG_NUMF" name="PAG_NUMF" type="hidden" value="<?php echo $pagina_seleccionada?>"/>
                Mostrando 
                <input id="PAG_TAMF" name="PAG_TAMF" type="number" 
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
                <th>fecha cobro</th>
                <th>fecha vencimiento</th>
                <th>fecha factura</th>
                <th>precio total</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <?php
                foreach($filas as $fila){
            ?>

            <article>
                <form method="post" action="controlador_facturas.php">
                    <div>           <!-- datos de la tabla-->
                        <div>
                            <input id="OID_F" name="OID_F" type="hidden" value="<?php echo $fila["OID_F"]; ?>">
                            <input id="FECHA_COBRO" name="FECHA_COBRO" type="hidden" required value="<?php echo $fila["FECHA_COBRO"];?>">
                            <input name="FECHA_VENCIMIENTO" id="FECHA_VENCIMIENTO" type= "hidden" required value="<?php echo $fila["FECHA_VENCIMIENTO"];?>">
                            <input id="FECHA_FACTURA" name="FECHA_FACTURA" type="hidden" required value="<?php echo $fila["FECHA_FACTURA"];?>">
                            <input id="PRECIO_TOTAL" name="PRECIO_TOTAL" type="hidden" required value="<?php echo $fila["PRECIO_TOTAL"];?>">
                            <?php
                                if(isset($factura) and ($factura["OID_F"] == $fila["OID_F"])){ ?>
                                    <tr>                        <!-- filas de la tabla -->
                                        <td><input id="FECHA_COBRO" name="FECHA_COBRO" type="date" value="<?php echo $fila["FECHA_COBRO"];?>"></td>
                                        <td><input id="FECHA_VENCIMIENTO" name="FECHA_VENCIMIENTO" type="date" value="<?php echo $fila["FECHA_VENCIMIENTO"];?>"></td>
                                        <td><input id="FECHA_FACTURA" name="FECHA_FACTURA" type="date" value="<?php echo $fila["FECHA_FACTURA"];?>"></td>
                                        <td><input id="PRECIO_TOTAL" name="PRECIO_TOTAL" type="number" value="<?php echo $fila["PRECIO_TOTAL"];?>"></td>
                        <?php }else{ ?>
                                    <input id="FECHA_FACTURA" name="FECHA_FACTURA" type="hidden" value="<?php echo $fila["FECHA_FACTURA"];?>">
                                    <tr>
                                        <td><?php echo $fila["FECHA_COBRO"];?></td>              <!-- columnas -->
                                        <td><?php echo $fila["FECHA_VENCIMIENTO"];?></td>
                                        <td><?php echo $fila["FECHA_FACTURA"];?></td>
                                        <td><?php echo $fila["PRECIO_TOTAL"];?></td>
                        <?php } ?>
                        </div>          
                                        <div>       <!-- columna de los botones -->
                                            <td>
                                                <?php 
                                                if (isset($factura) and ($factura["OID_F"] == $fila["OID_F"])) { ?>
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
        <form id="filterForm" action="consulta_facturas.php" method="post">
            <select class="filtro" name="filtro" id="filtro" oninput="auto(document.getElementById('filtro').value)">
                <option value="" <?php if(isset($_SESSION['filtro']) && $_SESSION['filtro']==""){ echo "selected='selected'";}?>>---</option>
                <option value="PrecioMayor" <?php if(isset($_SESSION['filtro']) && $_SESSION['filtro']=="PrecioMayor"){ echo "selected='selected'";}?>>Precio mayor que</option>
                <option value="PrecioMenor" <?php if(isset($_SESSION['filtro']) && $_SESSION['filtro']=="PrecioMenor"){ echo "selected='selected'";}?>>Precio menor que</option>
            </select>
            <div id="filterValueDiv">
            <?php
                if(isset($_SESSION['filtro']) && $_SESSION['filtro']!=""){?>
                    <input class="filterValue" type="number" required min="0" name="filterValue" id="filterValue" value="<?php echo $_SESSION['filterValue'];?>">
                    <input class="filterButton" type="submit" value="FILTRAR">
           <?php  } ?>
            </div>
        </form>
    </main>
</body>
</html>