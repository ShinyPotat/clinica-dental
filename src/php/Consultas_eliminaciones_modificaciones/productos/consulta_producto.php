<?php
    session_start();

    if(!isset($_SESSION["login"])){
        header("Location: ../../login.php");
    }

    require_once("../../gestionBD.php");
    require_once("gestionar_producto.php");

    if (isset($_SESSION["producto"])) {
        $producto = $_SESSION["producto"];
        unset($_SESSION["producto"]);
    }

    if (isset($_SESSION["PAG_PRO"]))
        $paginacion = $_SESSION["PAG_PRO"];
    
    $pagina_seleccionada = isset($_GET["PAG_NUMM"])? (int)$_GET["PAG_NUMM"]:
        (isset($paginacion)? (int)$paginacion["PAG_NUMM"]: 1);
    $pag_tam = isset($_GET["PAG_TAMM"])? (int)$_GET["PAG_TAMM"]:
        (isset($paginacion)? (int)$paginacion["PAG_TAMM"]: 10);
    
    if ($pagina_seleccionada < 1) 
        $pagina_seleccionada = 1;
    if ($pag_tam < 1) 
        $pag_tam = 10;

    unset($_SESSION["PAG_PRO"]);

    $conexion = crearConexionBD();

    $total_registros = total_consulta($conexion);
    $total_paginas = (int) ($total_registros / $pag_tam);
    if ($total_registros % $pag_tam > 0)
        $total_paginas++;
    if ($pagina_seleccionada > $total_paginas)
        $pagina_seleccionada = $total_paginas;
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de productos</title>
    <link rel="stylesheet" href="../../../css/consultaPDP.css">
</head>
<body>
<body>
    <?php include_once ("../../cabeceraC.php"); ?>
    
    <a href="../../formularios/form_alta_clinicas.php"class="botonNuevaClinica">Nueva Clinica</a>
    <a href="../../formularios/form_alta_paciente.php" class="botonNuevoPaciente">Nuevo Paciente</a>
    <a href="../../formularios/form_alta_producto.php" class="botonNuevoProducto">Nuevo Producto</a>
    <a href="../clinica/consulta_clinica.php" class="botonClinicas">Clinicas</a>
    <a href= "../pacientes/consulta_pacientes.php" class="botonPacientes">Pacientes</a>
    <a href="../productos/consulta_producto.php" class="botonProductos">Productos</a>
    <script src="../../../js/hora.js"></script>
    <a href="../../../html/accesorapido.html" class="buttonAtras">«</a> 
    <p class="volver">Volver</p>

    <main>
        <nav>
            <div class="enlaces">
                <?php
                    for($pagina=1; $pagina<=$total_paginas; $pagina++){
                        if($pagina == $pagina_seleccionada){ ?>
                            <span><?php echo $pagina;?></span>
                  <?php }else{ ?>
                            <a href="consulta_producto.php?PAG_NUMM=<?php echo $pagina;?>&PAG_TAMM=<?php echo $pag_tam;?>"><?php echo $pagina;?></a>
                 <?php  }
                    }
                ?>
            </div>

            <form class="formulario" action="consulta_producto.php" method="get">
                    <input type="hidden" name="PAG_NUMM" id="PAG_NUMM" value="<?php echo $pagina_seleccionada;?>">
                    Mostrando
                    <input type="number" name="PAG_TAMM" id="PAG_TAMM" min="1" max="<?php echo $total_registros;?>" value="<?php echo $pag_tam;?>" autofocus="autofocus">
                    entradas de <?php echo $total_registros;?>
                    <input type="submit" value="Cambiar">
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
            ?>
        </nav>

        <table class="blueTable">
                    <thead>
                        <tr>
                            <th>nombre</th>
                            <th>precio</th>
                            <th>opciones</th>
                        </tr>
                    </thead>
                    <?php foreach($filas as $fila){ ?>
                                <article>
                                    <form action="controlador_producto.php" method="post">
                                        <div>
                                            <div>
                                                <input type="hidden" name="OID_P" id="OID_P" value="<?php echo $fila["OID_P"];?>">
                                                <input type="hidden" name="OID_E" id="OID_E" value="<?php echo $fila["OID_E"];?>">
                                                <?php
                                                    if (isset($producto) and ($producto["OID_P"] == $fila["OID_P"])) { ?>
                                                        <tr>
                                                            <td><input type="text" name="NOMBRE" id="NOMBRE" value="<?php echo $fila["NOMBRE"];?>"></td>
                                                            <td><input type="text" name="PRECIO" id="PRECIO" value="<?php echo $fila["PRECIO"];?>"></td>
                                              <?php } else { ?>
                                                        <input type="hidden" name="NOMBRE" id="NOMBRE" value="<?php echo $fila["NOMBRE"];?>">
                                                        <tr>
                                                            <td><?php echo $fila["NOMBRE"]?></td>
                                                            <td><?php echo $fila["PRECIO"]?></td>
                                              <?php } ?>
                                            </div>
                                            <div>
                                                <td>
                                                    <?php if(isset($producto) and ($producto["OID_P"] == $fila["OID_P"])){ ?>
                                                                <button class="consulta" id="Guardar" name="Guardar" type="submit"><img src="http://icons.iconarchive.com/icons/custom-icon-design/pretty-office-7/16/Save-as-icon.png" alt="x" />Guardar</button>  
                                                    <?php }else{ ?>
                                                                <button class="consulta" id="Editar" name="Editar" type="submit"><img src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-1/16/edit-icon.png" alt="x" />Editar</button>
                                                    <?php } ?>
                                                    <button class="consulta" id="Borrar" name="Borrar" type="submit"><img src="https://aurea.es/demos/ico/delete.gif" alt="x" />Borrar
                                                    </button>
                                                </td>
                                            </div>
                                                        </tr>
                                        </div>
                                    </form>
                                </article>
                    <?php } ?>
        </table>
    </main>
</body>
</html>