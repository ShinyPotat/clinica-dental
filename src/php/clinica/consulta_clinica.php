<?php
    session_start();

    require_once("../gestionBD.php");
    require_once("gestionar_clinica.php");

    if (isset($_SESSION["clinica"])) {
        $clinica = $_SESSION["clinica"];
        unset($_SESSION["clinica"]);
    }

    if (isset($_SESSION["PAG_CLI"]))
        $paginacion = $_SESSION["PAG_CLI"];
    
    $pagina_seleccionada = isset($_GET["PAG_NUMM"])? (int)$_GET["PAG_NUMM"]:
        (isset($paginacion)? (int)$paginacion["PAG_NUMM"]: 1);
    $pag_tam = isset($_GET["PAG_TAMM"])? (int)$_GET["PAG_TAMM"]:
        (isset($paginacion)? (int)$paginacion["PAG_TAMM"]: 10);
    
    if ($pagina_seleccionada < 1) 
        $pagina_seleccionada = 1;
    if ($pag_tam < 1) 
        $pag_tam = 10;

    unset($_SESSION["PAG_CLI"]);

    $conexion = crearConexionBD();

    $total_registros = total_consulta($conexion);
    $total_paginas = (int) ($total_registros / $pag_tam);
    if ($total_registros % $pag_tam > 0)
        $total_paginas++;
    if ($pagina_seleccionada > $total_paginas)
        $pagina_seleccionada = $total_paginas;
    $paginacion["PAG_NUMM"] = $pagina_seleccionada;
    $paginacion["PAG_TAMM"] = $pag_tam;
    $_SESSION["PAG_CLI"] = $paginacion;

    $filas = consulta_paginada($conexion,$pagina_seleccionada,$pag_tam);

    cerrarConexionBD($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de clínicas</title>
    <link rel="stylesheet" href="">
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

    <a href="../../../php/formularios/form_alta_pedido.php" class="botonNuevoPedido">Nuevo Pedido</a>
    <a href= "../../../php/formularios/form_alta_material.php" class="botonNuevoMaterial">Nuevo Material</a>
    <a href="../../../php/formularios/form_alta_proveedor.php" class="botonNuevoProveedor">Nuevo Proveedor</a>
    <a href="#" class="botonPedidos">Pedidos</a>
    <a href= "#" class="botonMateriales">Materiales</a>
    <a href="#" class="botonProveedores">Proveedores</a>
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
                            <a href="consulta_clinica.php?PAG_NUMM=<?php echo $pagina;?>&PAG_TAMM=<?php echo $pag_tam;?>"><?php echo $pagina;?></a>
                 <?php  }
                    }
                ?>
            </div>

            <form class="formulario" action="consulta_clinica.php" method="get">
                    <input type="hidden" name="PAG_NUMM" id="PAG_NUMM" value="<?php echo $pagina_seleccionada;?>">
                    Mostrando
                    <input type="number" name="PAG_TAMM" id="PAG_TAMM" min="1" max="<?php echo $total_registros;?>" value="<?php echo $pag_tam;?>" autofocus="autofocus">
                    entradas de <?php echo $total_registros;?>
                    <input type="submit" value="Cambiar">
            </form>
        </nav>

        <table class="blueTable">
                    <thead>
                        <tr>
                            <th>nombre</th>
                            <th>localizacion</th>
                            <th>tlf_contacto</th>
                            <th>moroso</th>
                            <th>nombre_due</th>
                            <th>num_coleg</th>
                            <th>opciones</th>
                        </tr>
                    </thead>
                    <?php foreach($filas as $fila){ ?>
                                <article>
                                    <form action="controlador_clinicas.php" method="post">
                                        <div>
                                            <div>
                                                <input type="hidden" name="OID_C" id="OID_C" value="<?php echo $fila["OID_C"];?>">
                                                <input type="hidden" name="NOMBRE" id="NOMBRE" required value="<?php echo $fila["NOMBRE"];?>">
                                                <input type="hidden" name="LOCALIZACIÓN" id="LOCALIZACIÓN" required value="<?php echo $fila["LOCALIZACIÓN"];?>">
                                                <input type="hidden" name="TLF_CONTACTO" id="TLF_CONTACTO" required value="<?php echo $fila["TLF_CONTACTO"];?>">
                                                <input type="hidden" name="MOROSO" id="MOROSO" required value="<?php echo $fila["MOROSO"];?>">
                                                <input type="hidden" name="NOMBRE_DUEÑO" id="NOMBRE_DUEÑO" required value="<?php echo $fila["NOMBRE_DUEÑO"];?>">
                                                <input type="hidden" name="NUM_COLEGIADO" id="NUM_COLEGIADO" required value="<?php echo $fila["NUM_COLEGIADO"];?>">
                                                <?php
                                                    if (isset($clinica) and ($clinica["OID_C"] == $fila["OID_C"])) { ?>
                                                        <tr>
                                                            <td><input type="text" name="NOMBRE" id="NOMBRE" value="<?php echo $fila["NOMBRE"];?>"></td>
                                                            <td><input type="text" name="LOCALIZACIÓN" id="LOCALIZACIÓN" value="<?php echo $fila["LOCALIZACIÓN"];?>"></td>
                                                            <td><input type="text" name="TLF_CONTACTO" id="TLF_CONTACTO" value="<?php echo $fila["TLF_CONTACTO"];?>"></td>
                                                            <td>
                                                                <input type="radio" name="MOROSO" id="MOROSO" value="<?php echo $fila["MOROSO"];?>">Sí
                                                                <input type="radio" name="MOROSO" id="MOROSO" value="<?php echo $fila["MOROSO"];?>">No
                                                            </td>
                                                            <td><input type="text" name="NOMBRE_DUEÑO" id="NOMBRE_DUEÑO" value="<?php echo $fila["NOMBRE_DUEÑO"];?>"></td>
                                                            <td><input type="text" name="NUM_COLEGIADO" id="NUM_COLEGIADO" value="<?php echo $fila["NUM_COLEGIADO"];?>"></td>
                                              <?php } else { ?>
                                                        <input type="hidden" name="NOMBRE" id="NOMBRE" value="<?php echo $fila["NOMBRE"];?>">
                                                        <tr>
                                                            <td><?php echo $fila["NOMBRE"]?></td>
                                                            <td><?php echo $fila["LOCALIZACIÓN"]?></td>
                                                            <td><?php echo $fila["TLF_CONTACTO"]?></td>
                                                            <td><?php echo $fila["MOROSO"]?></td>
                                                            <td><?php echo $fila["NOMBRE_DUEÑO"]?></td>
                                                            <td><?php echo $fila["NUM_COLEGIADO"]?></td>
                                              <?php } ?>
                                            </div>
                                            <div>
                                                <td>
                                                    <?php if(isset($clinica) and ($clinica["OID_C"] == $fila["OID_C"])){ ?>
                                                                <button id="Guardar" name="Guardar" type="submit">Guardar</button>  
                                                    <?php }else{ ?>
                                                                <button id="Editar" name="Editar" type="submit">Editar</button>
                                                    <?php } ?>
                                                    <button id="Borrar" name="Borrar" type="submit">Borrar</button>
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