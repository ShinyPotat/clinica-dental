function auto(tipo) {
    
    const div = document.getElementById('filterValueDiv');
    const form = document.getElementById('filterForm');

    div.innerHTML = '';
    if(tipo==""){
        form.submit();
    }else if(tipo=="Material"){
        div.innerHTML += "<select class=\"filterValue\" name=\"filterValue\" id=\"filterValue\"></select>";
        div.innerHTML += "<input class=\"filterButton\" type=\"submit\" value=\"FILTRAR\">";

        $.get("gestionar_producto.php", { filtro: $("#filtro").val()} ,function (data) {
            
            $("#filterValue").empty();
            
            $("#filterValue").append(data);
        });
     
    }else {
        div.innerHTML += "<input class=\"filterValue\" maxlength=\"1\" type=\"number\" required min=\"0\" name=\"filterValue\" id=\"filterValue\"></input>";
        div.innerHTML += "<input class=\"filterButton\" type=\"submit\" value=\"FILTRAR\">";
    }
}