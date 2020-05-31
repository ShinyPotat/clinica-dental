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
        var error = "Introduce un dni adecuado"
    } else {
        var error = "";
    }
    document.getElementById('dni').setCustomValidity(error);
    return error;
}

function dateValidation(fechaNac) {
    
    var date = new Date(fechaNac);
    var now = new Date();

    if (dates.compare(fechaNac,now) == 1) {
        console.error("Fecha inválida");
        var error = "Fecha no válida";
    } else {
        var error = "";
    }
    document.getElementById('fechaNacimiento').setCustomValidity(error);
    return error;
}
