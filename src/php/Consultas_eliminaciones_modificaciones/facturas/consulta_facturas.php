<?php
    session_start();

	require_once("../../gestionBD.php");
	require_once("gestionarFacturas.php");
	
	if (isset($_SESSION["factura"])){
		$factura = $_SESSION["factura"];
		unset($_SESSION["factura"]);
    }
    
    if (isset($_SESSION["PAG_FAC"])) $paginacion = $_SESSION["PAG_FAC"]; 
		$pagina_seleccionada = isset($_GET["PAG_NUMF"])? (int)$_GET["PAG_NUMMF"]:
													(isset($paginacion)? (int)$paginacion["PAG_NUMF"]: 1);
		$pag_tam = isset($_GET["PAG_TAMF"])? (int)$_GET["PAG_TAMF"]:
											(isset($paginacion)? (int)$paginacion["PAG_TAMF"]: 10);
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 10;
	
	unset($_SESSION["PAG_FAC"]);

	$conexion = crearConexionBD();
    
    $total_registros = total_consulta($conexion);
	$total_paginas = (int) ($total_registros / $pag_tam);
	if ($total_registros % $pag_tam > 0) $total_paginas++; 
	if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;
	$paginacion["PAG_NUMF"] = $pagina_seleccionada;
	$paginacion["PAG_TAMF"] = $pag_tam;
	$_SESSION["PAG_FAC"] = $paginacion;
	
	$filas = consulta_paginada($conexion,$pagina_seleccionada,$pag_tam);

	cerrarConexionBD($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gestión de inventario</title>
    <link rel="stylesheet", type="text/css", href="../../../css/consultaFacturas.css">
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
    
    <a href= "../../formularios/form_alta_facturas.php" class="botonNuevaFactura">Nueva factura</a>
    <a href= "../facturas/consulta_facturas.php" class="botonFactura">Facturas</a>
    
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
    </main>
</body>
</html>