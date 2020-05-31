var imported = document.createElement('script');
imported.src = '../../js/dates.js';
document.head.appendChild(imported);

function dniValidate(inputdni) {

    var dni = inputdni.value;

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
    inputdni.setCustomValidity(error);
    return error;
}

function dateValidation(inputfechaNac) {
    
    var date = new Date(inputfechaNac.value);
    var now = new Date();

    if (dates.compare(date,now) == 1) {
        console.error("Fecha inválida");
        var error = "Fecha no válida";
    } else {
        var error = "";
    }
    inputfechaNac.setCustomValidity(error);
    return error;
}
