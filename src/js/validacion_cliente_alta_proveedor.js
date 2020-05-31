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

function numberValidation(inputnumber) {

    var number = inputnumber.value;

    var valid = true;

    valid = valid && number.length==9;

    var hasNumber = /^[0-9]{9}/;

    valid = valid && hasNumber.test(number);

    if (!valid) {
        console.error("Número no válido");
        var error = "Escribe un número adecuado";
    } else {
        var error = "";
    }
    inputnumber.setCustomValidity(error);
    return error;
}