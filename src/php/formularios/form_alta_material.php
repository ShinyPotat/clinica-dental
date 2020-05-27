<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" lang="es">
        <title>Nuevo Material</title>
        <link rel="stylesheet" type="text/css" href="../../css/formMaterial.css">
        <script src="../../js/validacion_cliente_alta_material.js" type="text/javascript"></script>
    </head>

    <body>
    <?php 
    $nameErr = $categoriaErr = $stockInicialErr = $stockMinErr = $stockCritErr = $unidadErr = "";
    $name = $categoria = $stockInicial = $stockMin = $stockCrit = $unidad = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
          $nameErr = "Este campo es obligatorio";
        } else {
          $name = test_input($_POST["name"]);
          if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $nameErr = "Solo puedes introducir espacios y letras";
          }
        }

        if (empty($_POST["categoria"])) {
            $categoriaErr = "Es necesario marcar una opcion";
          } else {
            $categoria = test_input($_POST["categoria"]);
          }
        }

        if (empty($_POST["stockInicial"])) {
            $stockInicialErr = "";
          } else {
            $stockInicial = test_input($_POST["stockInicial"]);
            if ($_POST["stockInicial"] < 0) {
              $stockInicialErr = "El valor debe de ser mayor o igual que 0";
            }
          }

          if (empty($_POST["stockMin"])) {
            $stockMinErr = "";
          } else {
            $stockMin = test_input($_POST["stockMin"]);
            if ($_POST["stockMin"] < 0) {
              $stockMinErr = "El valor debe de ser mayor o igual que 0";
            }
          }
          if (empty($_POST["stockCrit"])) {
            $stockCritErr = "";
          } else {
            $stockCrit = test_input($_POST["stockCrit"]);
            if ($_POST["stockCrit"] < 0) {
              $stockCritErr = "El valor debe de ser mayor o igual que 0";
            }
          }
          if (empty($_POST["unidad"])) {
            $unidadErr = "";
          } else {
            $unidad = test_input($_POST["unidad"]);
            if ($_POST["unidad"] < 0) {
              $unidadErr = "errror de unidad";
            }
          }
        
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }
    ?>
    <a href="../../html/log.html" ><img class="imagen" src="../../../images/logo.png" alt="logo.png" width=23% height=23%></a>
    <div class="block">
        <a href="../../html/about-us.html" class="acerca">Acerca de nosotros</a>
        <!-- Estos bloques definen las id que se usan para el js de la hora -->
        <div id="box">
            <div id="box-date"></div>
            <div id="box-time"></div>
        </div>
        
        <img class="calendario" src="../../../images/calendario.png" width="1%" height="11%">
        <img class="reloj" src="../../../images/reloj.png" width="1%" height="11%">
        
        <img class="usuario" src="../../../images/user.png" width="1.5%" height="13%">
        
        <img class="flechaA" src="../../../images/flechaA.png" width="20" height="20">
        
        <select class="botonUsuario">
            <option value="1">Usuario</option>
            <option value="2">Opcion 2</option>
            <option value="3">Opcion 3</option>
        </select>
    </div>
    <!-- esto es php echo htmlspecialchars($_SERVER["../materiales/accion_alta_material.php"]); -->
    <div class="bloque">
      <form method="post" action="../Consultas_eliminaciones_modificaciones/materiales/accion_alta_material.php">  
          <p><span class="error">&emsp;* campo requerido</span></p>
                
                    <p>
                    &emsp;
                    Nombre: &emsp; <input required placeholder="Nombre" class = name type="text" id="name" name="name" value="<?php echo $name;?>"
                                          onkeyup="document.getElementById('errorName').innerHTML = lettersValidation(document.getElementById('name').value)">
                    <span id="errorName" class="error"> <?php echo $nameErr;?></span>
                    </p>

                    <label for="categoria">&emsp; Categoría:</label>
                    <select required name="categoria" id="categoria" oninput="putUnitElements(document.getElementById('categoria').value)" value="<?php echo $categoria;?>">
                        <option value="Alambre">Alambre</option>
                        <option value="Dientes">Dientes</option>
                        <option value="Empress">Empress</option>
                        <option value="Ferula">Ferula</option>
                        <option value="Metal Ceramica">Metal Ceramica</option>
                        <option value="Metal">Metal</option>
                        <option value="Resina">Resina</option>
                        <option value="Revestimiento">Revestimiento</option>
                        <option value="Ceramica Zirconio">Ceramica Zirconio</option>
                    </select>
                    <span class="error">* <?php echo $categoriaErr;?></span>
                    <p>
                        &emsp;
                        Stock Inicial*: &emsp;<input required placeholder="Stock Inicial" type="number" name="stockInicial" id="stockInicial" value="<?php echo $stockInicial;?>" min="0">
                        <span id="errorStockInicial" class="error"> <?php echo $stockInicialErr;?></span> 
                    </p>
                    <p>
                        &emsp;
                        Stock Mínimo*: &emsp;<input  required placeholder="Stock Mínimo" type="number" name="stockMin" id="stockMin" value="<?php echo $stockMin;?>" min="0">
                        <span id="errorStockMin" class="error"> <?php echo $stockMinErr;?></span> 
                    </p>
                    <p>
                        &emsp;
                        Stock Crítico*: &emsp;<input required placeholder="Stock Crítico" type="number" name="stockCrit" id="stockCrit" value="<?php echo $stockCrit;?>" min="0"
                                                      oninput="document.getElementById('errorStockCrit').innerHTML = critValidation(document.getElementById('stockMin').value,document.getElementById('stockCrit').value)">
                        <span id="errorStockCrit" class="error"> <?php echo $stockCritErr;?></span> 
                    </p>
                    <p>
                        &emsp;
                        Unidad*: &emsp;<select required name="unidad" id="unidad" value="<?php echo $unidad;?>" >
                        </select>
                        <span id="errorUnidad" class="error"> <?php echo $stockCritErr;?></span> 
                    </p>
                <input type="submit" name="submit" value="Enviar" class="enviar">
                <a href="../../html/listaInventarioPedidos.html" class="buttonAtras">Atrás</a>
            </form>
            <div class="results">
                <?php
                echo "<h2>Datos introducidos:</h2>";
                echo $name;
                echo "<br>";
                echo $categoria;
                echo "<br>";
                echo $stockInicial;
                echo "<br>";
                echo $stockMin;
                echo "<br>";
                echo $stockCrit;
                echo "<br>";
                echo $unidad;
                echo "<br>";

                ?>
            </div>
        </div>
        <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
        <script src="../../js/hora.js"></script>
    </body>
</html>