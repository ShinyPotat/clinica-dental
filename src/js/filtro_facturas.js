function auto(tipo) {
    
    const div = document.getElementById('filterValueDiv');
    const form = document.getElementById('filterForm');

    div.innerHTML = '';
    if(tipo==""){
        form.submit();    
    }else {
        div.innerHTML += "<input class=\"filterValue\" maxlength=\"1\" type=\"number\" required min=\"0\" name=\"filterValue\" id=\"filterValue\"></input>";
        div.innerHTML += "<input class=\"filterButton\" type=\"submit\" value=\"FILTRAR\">";
    }
}