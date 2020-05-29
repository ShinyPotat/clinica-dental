// <input class="filterValue" maxlength="1" type="text" name="filterValue" id="filterValue" value="<?php if (isset($_SESSION['filtro'])) {echo $_SESSION['filterValue'];}?>">

function auto(tipo) {
    
    const div = document.getElementById('filterValueDiv');
    const form = document.getElementById('filterForm');

    div.innerHTML = '';
    if (tipo=='DNI') {
        div.innerHTML += '<input class=\"filterValue\" maxlength=\"1\" type=\"text\" name=\"filterValue\" id=\"filterValue\">'
        div.innerHTML += "<input class=\"filterButton\" type=\"submit\" value=\"FILTRAR\">";
    }else if(tipo=='E_Sexo'){
        div.innerHTML += "<select class=\"filterValue\" name=\"filterValue\" id=\"filterValue\"><option value=\"H\">H</option><option value=\"M\">M</option></select>";
        div.innerHTML += "<input class=\"filterButton\" type=\"submit\" value=\"FILTRAR\">";
    }else if(tipo==""){
        form.submit();
    }else if(tipo=="OID_C"){
        div.innerHTML += "<select class=\"filterValue\" name=\"filterValue\" id=\"filterValue\"></select>";
        div.innerHTML += "<input class=\"filterButton\" type=\"submit\" value=\"FILTRAR\">";

        $.get("gestionarPacientes.php", { filtro: $("#filtro").val()} ,function (data) {
            
            $("#filterValue").empty();
            
            $("#filterValue").append(data);
        });
    }
}