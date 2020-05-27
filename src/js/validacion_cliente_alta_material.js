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

function putUnitElements(categoria) {
    /*'Alambre','Dientes','Empress','Ferula','Metal Ceramica','Metal',
        'Resina','Revestimiento','Ceramica Zirconio'*/
    console.log('Creando unidades para la categoria ' + categoria);
    const unidadList = document.getElementById('unidad');
    unidadList.innerHTML = '';
    
    var longitudArray = ['Alambre']; 
    var pesoArray = ['Dientes','Empress','Metal Ceramica','Metal','Revestimiento','Ceramica Zirconio','Resina'];
    var unidadesArray = ['Dientes','Ferula'] 

    //<option value="Ceramica Zirconio">Ceramica Zirconio</option>
    if (longitudArray.includes(categoria)) {
        var longitudes = ['m','cm','mm'];
        longitudes.forEach(element => {
            unidadList.innerHTML += '<option value=\''+element+'\'>'+element+'</option>'
        });
    }
    if(pesoArray.includes(categoria)){
        var pesos = ['g','cg','mg'];
        pesos.forEach(element => {
            unidadList.innerHTML += '<option value=\''+element+'\'>'+element+'</option>'
        });
    }
    if(unidadesArray.includes(categoria)){
        unidadList.innerHTML += '<option value=\'Unidades\'>Unidades</option>';
    }
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
