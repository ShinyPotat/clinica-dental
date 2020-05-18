function lettersValidation(name) {
    var valid = true;

    var hasLetters = /^[a-zA-Z ]*$/;

    valid = valid && hasLetters.test(name);

    if (!valid) {
        console.error("Nombre no válido");
        var error = "Solo puedes introducir espacios y letras"
    } else {
        var error = "";
    }

    return error;
}

function critValidation(stockMin,stockCrit) {
    
    if (stockMin<stockCrit) {
        console.error("El stock crítico debe ser menor que el stock mínimo");
        var error = "El stock crítico debe ser menor que el stock mínimo";
    } else {
        var error = "";        
    }
    return error;
}

/*function consultaStock(){
    var stock = document.getElementById("stock").value;
    var min = document.getElementById("stockMin").value;
    var crit = document.getElementById("stockCrit").value;
    var correctvalues = true;

    correctvalues = correctvalues && (crit<min) && (min<stock);
    if(!correctvalues){
        var error = "Please, select correct values! Initial stock can not be less than minimal or critical required";
    }else{
        var error = "";
    }
    stock.setCustomValidity(error);
    return error;
}*/
