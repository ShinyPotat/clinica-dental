<?php
    session_start();

    if(!isset($_SESSION["login"])){
        header("../login.php");
    }

	require_once("../../gestionBD.php");
	require_once("gestionarProveedor.php");
	
	if (isset($_SESSION["proveedor"])){
		$proveedor = $_SESSION["proveedor"];
		unset($_SESSION["proveedor"]);
    }
    
    if (isset($_SESSION["PAG_PRO"])) $paginacion = $_SESSION["PAG_PRO"]; 
		$pagina_seleccionada = isset($_GET["PAG_NUMM"])? (int)$_GET["PAG_NUMM"]:
													(isset($paginacion)? (int)$paginacion["PAG_NUMM"]: 1);
		$pag_tam = isset($_GET["PAG_TAMM"])? (int)$_GET["PAG_TAMM"]:
											(isset($paginacion)? (int)$paginacion["PAG_TAMM"]: 10);
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 10;
	
	unset($_SESSION["PAG_PRO"]);

	$conexion = crearConexionBD();
    
    $total_registros = total_consulta($conexion);
	$total_paginas = (int) ($total_registros / $pag_tam);
	if ($total_registros % $pag_tam > 0) $total_paginas++; 
	if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;
	$paginacion["PAG_NUMM"] = $pagina_seleccionada;
	$paginacion["PAG_TAMM"] = $pag_tam;
	$_SESSION["PAG_PRO"] = $paginacion;
	
	$filas = consulta_paginada($conexion,$pagina_seleccionada,$pag_tam);

	cerrarConexionBD($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gestión de proveedores</title>
    <link rel="stylesheet" href="../../../css/consultaMateriales.css">
    <script src="../../../js/validacion_cliente_alta_proveedor.js" type="text/javascript"></script>
</head>
<body>
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
                        <a href="consulta_proveedores.php?PAG_NUMM=<?php echo $pagina; ?> &PAG_TAMM=<?php echo $pag_tam; ?>"><?php echo $pagina ?> </a>
            <?php }} ?>
            </div>            <!-- fin enlaces -->

            <form class="formulario" method="get" action="consulta_proveedores.php">        <!-- formulario para indicar numero de elemento en 1 magina quieres -->
                <input id="PAG_NUMM" name="PAG_NUMM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>
                Mostrando 
                <input id="PAG_TAMM" name="PAG_TAMM" type="number" 
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
                //class: Sirve para enlazar el html con las hojas de estilo. 
                echo "<ul>";
                foreach($errores as $error){
                    echo "<li>".$error."</li>";
                }
                echo "</ul>";
                echo "</div>";
            }
            ?>                                                         <!-- fin de formulario -->
        </nav>

        <table class="blueTable">                  <!-- comienzo de la tabla -->
            <thead>
            <tr>                        <!-- primera linea de la tabla -->
                <th>nombre</th>
                <th>localizacion</th>
                <th>Teléfono</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <?php
                foreach($filas as $fila){
            ?>

            <article>
                <form method="post" action="controlador_proveedores.php">
                    <div>           <!-- datos de la tabla-->
                        <div>
                            <input id="OID_PR" name="OID_PR" type="hidden" value="<?php echo $fila["OID_PR"]; ?>">
                            <?php
                                if(isset($proveedor) and ($proveedor["OID_PR"] == $fila["OID_PR"])){ ?>
                                    <tr>                        <!-- filas de la tabla -->
                                        <td><input type="text" name="NOMBRE" id="NOMBRE" value="<?php echo $fila["NOMBRE"];?>"
                                        onkeyup="lettersValidation(document.getElementById('NOMBRE'))"></td>
                                        <td><input type="text" name="LOCALIZACIÓN" id="LOCALIZACIÓN" value="<?php echo $fila["LOCALIZACIÓN"];?>"
                                        onkeyup="lettersValidation(document.getElementById('LOCALIZACIÓN'))"></td>
                                        <td><input type="text" name="TLF_CONTACTO" maxlength=9 id="TLF_CONTACTO" value="<?php echo $fila["TLF_CONTACTO"];?>"
                                        onkeyup="numberValidation(document.getElementById('TLF_CONTACTO'))"></td>
                        <?php }else{ ?>
                                    <tr>
                                        <td><?php echo $fila["NOMBRE"];?></td>              <!-- columnas -->
                                        <td><?php echo $fila["LOCALIZACIÓN"];?></td>
                                        <td><?php echo $fila["TLF_CONTACTO"];?></td>
                        <?php } ?>
                        </div>          
                                        <div>       <!-- columna de los botones -->
                                            <td>
                                                <?php 
                                                if (isset($proveedor) and ($proveedor["OID_PR"] == $fila["OID_PR"])) { ?>
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
            <?php }?>
        </table>
    </main>
</body>
</html>