function lettersValidation(input) {

    var name = input.value;

    var valid = true;

    var hasLetters = /^[a-zA-Z ]*$/;

    valid = valid && hasLetters.test(name);

    if (!valid) {
        console.error("Nombre no válido");
        var error = "Solo puedes introducir espacios y letras"
    } else {
        var error = "";
    }
    input.setCustomValidity(error);
    return error;
}

function numberValidation(number) {

    const input = document.getElementById('phone');

    var valid = true;

    valid = valid && number.length==9;

    var hasNumber = /^[0-9]{9}/;

    valid = valid && hasNumber.test(number);

    if (!valid) {
        console.error("Número no válido");
        var error = "Escribe un número adecuado"
    } else {
        var error = "";
    }
    input.setCustomValidity(error);
    return error;
}

function tlfValidation(input) {

    var number = input.value;

    var valid = true;

    valid = valid && number.length==9;

    var hasNumber = /^[0-9]{9}/;

    valid = valid && hasNumber.test(number);

    if (!valid) {
        console.error("Número no válido");
        var error = "Escribe un número adecuado"
    } else {
        var error = "";
    }
    input.setCustomValidity(error);
    return error;
}

function numColValidation(input) {

    var number = input.value;

    var valid = true;

    valid = valid && number.length==4;

    var hasNumber = /^[0-9]{4}/;

    valid = valid && hasNumber.test(number);

    if (!valid) {
        console.error("Número no válido");
        var error = "Escribe un número adecuado"
    } else {
        var error = "";
    }
    input.setCustomValidity(error);
    return error;
}

function nColValidation(number) {

    const input = document.getElementById('nCol');

    var valid = true;

    valid = valid && number.length==4;

    var hasNumber = /^[0-9]{4}/;

    valid = valid && hasNumber.test(number);

    if (!valid) {
        console.error("Número no válido");
        var error = "Escribe un número adecuado"
    } else {
        var error = "";
    }
    input.setCustomValidity(error);
    return error;
}
