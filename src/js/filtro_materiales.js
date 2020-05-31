function auto(tipo) {
    
    const div = document.getElementById('filterValueDiv');
    const form = document.getElementById('filterForm');

    div.innerHTML = '';
    if(tipo=="CATEGORIA"){
        div.innerHTML += "<select class=\"filterValue\" name=\"filterValue\" id=\"filterValue\"></select>";
        const select = document.getElementById('filterValue');
        select.innerHTML += "<option value=\"Alambre\">Alambre</option>";
        select.innerHTML += "<option value=\"Dientes\">Dientes</option>";
        select.innerHTML += "<option value=\"Empress\">Empress</option>";
        select.innerHTML += "<option value=\"Ferula\">Ferula</option>";
        select.innerHTML += "<option value=\"Metal Ceramica\">Metal Ceramica</option>";
        select.innerHTML += "<option value=\"Metal\">Metal</option>";
        select.innerHTML += "<option value=\"Resina\">Resina</option>";
        select.innerHTML += "<option value=\"Revestimiento\">Revestimiento</option>";
        select.innerHTML += "<option value=\"Ceramica Zirconio\">Ceramica Zirconio</option>";
        div.innerHTML += "<input class=\"filterButton\" type=\"submit\" value=\"FILTRAR\">";
    }else {
        form.submit();
    }
}