var imported = document.createElement('script');
imported.src = '../../js/dates.js';
document.head.appendChild(imported);

function dniValidate(dni) {
    var valid = true;

    valid = valid && dni.length==9;
    
    var hasNumber = /^[0-9]{8}/;
    var hasLetter = /[A-Z]{1}/;

    valid = valid && hasNumber.test(dni) && hasLetter.test(dni);

    if (!valid) {
        console.error("DNI no válido");
        var error = "&emsp;Introduce un dni adecuado"
    } else {
        var error = "";
    }
    return error;
}

function dateValidation(fechaNac) {
    
    var date = new Date(fechaNac);
    var now = new Date();

    if (dates.compare(fechaNac,now) == 1) {
        console.error("Fecha inválida");
        var error = "&emsp;Fecha no válida";
    } else {
        var error = "";
    }
    
    return error;
}

function ageValidation(fechaNac) {
    
    var date = new Date(fechaNac);
    var now = new Date();
    if(now.getFullYear()-date.getFullYear()<5){
        console.error("Paciente no válido");
        var error = "&emsp; La edad mínima es de 5 años;
    } else {
        var error = "";
    }
    
    return error;
}
