<?php
    session_start();

    if(!isset($_SESSION["login"])){
        header("Location: ../../login.php");
    }

	require_once("../../gestionBD.php");
	require_once("gestionarPacientes.php");
	
	if (isset($_SESSION["paciente"])){
		$paciente = $_SESSION["paciente"];
		unset($_SESSION["paciente"]);
    }

    if (isset($_REQUEST['filtro']) && $_REQUEST["filtro"]!="") {
        $_SESSION['filtro'] = $_REQUEST['filtro'];
        $_SESSION['filterValue'] = $_REQUEST['filterValue'];
    }else if(isset($_REQUEST['filtro']) && $_REQUEST['filtro']==""){
        unset($_SESSION['filtro']);
        unset($_SESSION['filterValue']);
    }
    
    if (isset($_SESSION["PAG_PAC"])) $paginacion = $_SESSION["PAG_PAC"]; 
		$pagina_seleccionada = isset($_GET["PAG_NUMPC"])? (int)$_GET["PAG_NUMPC"]:
													(isset($paginacion)? (int)$paginacion["PAG_NUMPC"]: 1);
		$pag_tam = isset($_GET["PAG_TAMPC"])? (int)$_GET["PAG_TAMPC"]:
											(isset($paginacion)? (int)$paginacion["PAG_TAMPC"]: 10);
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 10;
	
	unset($_SESSION["PAG_PAC"]);

    $conexion = crearConexionBD();
    
    if (isset($_SESSION['filtro']) && $_SESSION['filtro']!="") {
        $total_registros = total_consulta_filtrada($conexion,$_SESSION['filtro'],$_SESSION['filterValue']);
    } else {
        $total_registros = total_consulta($conexion);
    }   
    
	$total_paginas = (int) ($total_registros / $pag_tam);
	if ($total_registros % $pag_tam > 0) $total_paginas++; 
	if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;
	$paginacion["PAG_NUMPC"] = $pagina_seleccionada;
	$paginacion["PAG_TAMPC"] = $pag_tam;
    $_SESSION["PAG_PAC"] = $paginacion;
    
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
    <title>Gestión de Pacientes</title>
    <link rel="stylesheet", type="text/css", href="../../../css/consultaPDP.css">
    <script src="../../../js/filtro_pacientes.js"></script>
    <script src="../../../js/jquery-3.1.1.min.js" type="text/javascript"></script>
</head>
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
            <div class="enlaces">           <!-- enlaces a las paginas (1234567...)  -->
                <?php
                for($pagina=1; $pagina<=$total_paginas; $pagina++){
                    if($pagina == $pagina_seleccionada){	?>
                        <span><?php echo $pagina;?></span>
                    <?php }else{ ?>
                        <a href="consulta_pacientes.php?PAG_NUMPC=<?php echo $pagina; ?> &PAG_TAMPC=<?php echo $pag_tam; ?>"><?php echo $pagina ?> </a>
            <?php }} ?>
            </div>            <!-- fin enlaces -->
            
            <form class="formulario" method="get" action="consulta_pacientes.php">        <!-- formulario para indicar numero de elemento en 1 magina quieres -->
                <input id="PAG_NUMPC" name="PAG_NUMPC" type="hidden" value="<?php echo $pagina_seleccionada?>"/>
                Mostrando 
                <input id="PAG_TAMPC" name="PAG_TAMPC" type="number" 
                    min="1" max="<?php echo $total_registros;?>" 
                    value="<?php echo $pag_tam?>" autofocus="autofocus" /> 
                entradas de <?php echo $total_registros?>
                <input type="submit" value="Cambiar"/>
            </form>                                                        <!-- fin de formulario -->
        </nav>
        <table class="blueTable">                  <!-- comienzo de la tabla -->
            <thead>
            <tr>                        <!-- primera linea de la tabla -->
                <th>DNI</th>
                <th>Fecha de nacimiento</th>
                <th>Sexo</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <?php
                foreach($filas as $fila){
            ?>

            <article>
                <form method="post" action="controlador_pacientes.php">
                    <div>           <!-- datos de la tabla-->
                        <div>
                            <input id="OID_PC" name="OID_PC" type="hidden" value="<?php echo $fila["OID_PC"]; ?>">
                            <input id="OID_C" name="OID_C" type="hidden" required value="<?php echo $fila["OID_C"];?>">
                            <?php
                                if(isset($paciente) and ($paciente["OID_PC"] == $fila["OID_PC"])){ ?>
                                    <tr>                        <!-- filas de la tabla -->
                                        <td><input id="DNI" name="DNI" type="text" maxlength="9" value="<?php echo $fila["DNI"];?>"></td>
                                        <td><input id="FECHA_NACIMIENTO" name="FECHA_NACIMIENTO" type="date" value="<?php echo $fila["FECHA_NACIMIENTO"];?>"></td>
                                        <td>Sexo:
                                            <input type="radio" name="E_SEXO" id="E_SEXO" <?php if (isset($fila["E_SEXO"]) && $fila["E_SEXO"]=="Hombre") echo "checked";?> value="H">Hombre
                                            <input type="radio" name="E_SEXO" id="E_SEXO" <?php if (isset($fila["E_SEXO"]) && $fila["E_SEXO"]=="Mujer") echo "checked";?> value="M">Mujer
                        <?php }else{ ?>
                                    <input id="DNI" name="DNI" type="hidden" value="<?php echo $fila["DNI"];?>">
                                    <tr>
                                        <td><?php echo $fila["DNI"];?></td>              <!-- columnas -->
                                        <td><?php echo $fila["FECHA_NACIMIENTO"];?></td>
                                        <td><?php echo $fila["E_SEXO"];?></td>
                        <?php } ?>
                        </div>          
                                        <div>       <!-- columna de los botones -->
                                            <td>
                                                <?php 
                                                if (isset($paciente) and ($paciente["OID_PC"] == $fila["OID_PC"])) { ?>
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
        <form id="filterForm" action="consulta_pacientes.php" method="post">
            <select class="filtro" name="filtro" id="filtro"" oninput="auto(document.getElementById('filtro').value)">
                <option value="" <?php if(isset($_SESSION['filtro']) && $_SESSION['filtro']==""){ echo "selected='selected'";}?>>---</option>
                <option value="DNI" <?php if(isset($_SESSION['filtro']) && $_SESSION['filtro']=="DNI"){ echo "selected='selected'";}?>>DNI</option>
                <option value="E_Sexo" <?php if(isset($_SESSION['filtro']) && $_SESSION['filtro']=="E_Sexo"){ echo "selected='selected'";}?>>Sexo</option>
                <option value="OID_C" <?php if(isset($_SESSION['filtro']) && $_SESSION['filtro']=="OID_C"){ echo "selected='selected'";}?>>Clinica</option>
            </select>
            <div id="filterValueDiv">
            Filtrado de la consulta:
            <?php
                if(isset($_SESSION['filtro']) && $_SESSION['filtro']=="DNI"){?>
                    <input class="filterValue" maxlength="1" type="text" name="filterValue" id="filterValue" value="<?php echo $_SESSION['filterValue'];?>">
                    <input class="filterButton" type="submit" value="FILTRAR">
              <?php  }else if(isset($_SESSION['filtro']) && $_SESSION['filtro']=="E_Sexo") { ?>
                <select class="filterValue" name="filterValue" id="filterValue">
                    <option value="H" <?php if(isset($_SESSION['filterValue']) && $_SESSION['filterValue']=="H"){ echo "selected='selected'";}?>>H</option>
                    <option value="M" <?php if(isset($_SESSION['filterValue']) && $_SESSION['filterValue']=="M"){ echo "selected='selected'";}?>>M</option>
                </select>
                <input class="filterButton" type="submit" value="FILTRAR">
             <?php }else if(isset($_SESSION['filtro']) && $_SESSION['filtro']=="OID_C"){ 

                        $conexion = crearConexionBD();
                        $query = "SELECT OID_C, Nombre FROM Clinicas ORDER BY Nombre ASC";
                        $clinicas = $conexion->query($query);
                        cerrarConexionBD($conexion);
                 ?>
                 <select class="filterValue" name="filterValue" id="filterValue">
                     <?php foreach ($clinicas as $clinica) { ?>
                         <option value="<?php echo $clinica['OID_C'] ?>" <?php if($clinica['OID_C'] == $_SESSION['filterValue']){echo "selected='selected'";} ?>><?php echo $clinica['NOMBRE']; ?></option>
                  <?php   } ?>
                 </select>
                 <input class="filterButton" type="submit" value="FILTRAR">
           <?php  } ?>
            </div>
        </form>
    </main>
</body>
</html>