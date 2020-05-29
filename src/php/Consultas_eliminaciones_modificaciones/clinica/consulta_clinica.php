<?php
    session_start();

    if(!isset($_SESSION["login"])){
        header("Location: ../../login.php");
    }

    require_once("../../gestionBD.php");
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
    <link rel="stylesheet" href="../../../css/consultaPDP.css">
</head>
<body>
<body>
    <?php include_once ("../../cabecera.php"); ?>

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
                                                <input type="hidden" name="MOROSO" id="MOROSO" required value="<?php echo $fila["MOROSO"];?>">
                                                <?php
                                                    if (isset($clinica) and ($clinica["OID_C"] == $fila["OID_C"])) { ?>
                                                        <tr>
                                                            <td><input type="text" name="NOMBRE" id="NOMBRE" value="<?php echo $fila["NOMBRE"];?>"></td>
                                                            <td><input type="text" name="LOCALIZACIÓN" id="LOCALIZACIÓN" value="<?php echo $fila["LOCALIZACIÓN"];?>"></td>
                                                            <td><input type="text" name="TLF_CONTACTO" id="TLF_CONTACTO" value="<?php echo $fila["TLF_CONTACTO"];?>"></td>
                                                            <td><?php echo $fila["MOROSO"];?></td>
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