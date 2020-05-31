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
    session_start();
    
    if(!isset($_SESSION["login"])){
      header("Location: ../login.php");
    }
    if (!isset($_SESSION["Fmaterial"])) {
      $Fmaterial["name"] = "";
      $Fmaterial["categoria"] = "Alambre";
      $Fmaterial["stockInicial"] = "";
      $Fmaterial["stockMin"] = "";
      $Fmaterial["stockCrit"] = "";
      $Fmaterial["unidad"] = "m";
    
      $_SESSION["Fmaterial"] = $Fmaterial;
    }else{
      $Fmaterial = $_SESSION["Fmaterial"];
      unset($_SESSION["Fmaterial"]);
    }
    
    if(isset($_SESSION["errores"])) {
      $errores=$_SESSION["errores"];
      unset($_SESSION["errores"]);
    }
    
    if (isset($errores) && count($errores)>0) { 
      echo "<div id=\"div_errores\" class=\"error\">";
      echo "<h4> Errores en el formulario:</h4>";
      foreach($errores as $error){
        echo $error;
    } 
      echo "</div>";
    }
          include_once ("../cabecera.php");
    ?>
    
    <div class="bloque">
      <form method="post" action="../Consultas_eliminaciones_modificaciones/materiales/accion_alta_material.php">  
          <p><span class="error">&emsp;* campo requerido</span></p>
                
                    <p>
                    &emsp;
                    Nombre: &emsp; <input required placeholder="Nombre" class = name type="text" id="name" name="name" value="<?php echo $Fmaterial["name"];?>"
                                          onkeyup="document.getElementById('errorName').innerHTML = lettersValidation(document.getElementById('name').value)">
                    <span id="errorName" class="error"></span>
                    </p>

                    <label for="categoria">&emsp; Categoría:</label>
                    <select required name="categoria" id="categoria" oninput="putUnitElements(document.getElementById('categoria').value)" value="<?php echo $Fmaterial["categoria"];?>">
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
                    <span class="error"></span>
                    <p>
                        &emsp;
                        Stock Inicial*: &emsp;<input required placeholder="Stock Inicial" type="number" name="stockInicial" id="stockInicial" value="<?php echo $Fmaterial["stockInicial"];?>" min="0">
                        <span id="errorStockInicial" class="error"></span> 
                    </p>
                    <p>
                        &emsp;
                        Stock Mínimo*: &emsp;<input  required placeholder="Stock Mínimo" type="number" name="stockMin" id="stockMin" value="<?php echo $Fmaterial["stockMin"];?>" min="0">
                        <span id="errorStockMin" class="error"></span> 
                    </p>
                    <p>
                        &emsp;
                        Stock Crítico*: &emsp;<input required placeholder="Stock Crítico" type="number" name="stockCrit" id="stockCrit" value="<?php echo $Fmaterial["stockCrit"];?>" min="0"
                                                      oninput="document.getElementById('errorStockCrit').innerHTML = critValidation(document.getElementById('stockMin').value,document.getElementById('stockCrit').value)">
                        <span id="errorStockCrit" class="error"></span> 
                    </p>
                    <p>
                        &emsp;
                        Unidad*: &emsp;<select required name="unidad" id="unidad" value="<?php echo $Fmaterial["unidad"];?>" >
                        </select>
                        <span id="errorUnidad" class="error"></span> 
                    </p>
                <input type="submit" name="submit" value="Enviar" class="enviar">
                <a href="../Consultas_eliminaciones_modificaciones/materiales/consulta_materiales.php" class="buttonAtras">Atrás</a>
            </form>
        </div>
        <img src= "../../../images/elementoAdd.png" class="elementoAdd" width="10%" height="18%">
        <script src="../../js/hora.js"></script>
    </body>
</html>