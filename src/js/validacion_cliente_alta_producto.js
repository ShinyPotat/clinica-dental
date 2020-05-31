function lettersValidation(inputname) {

    var name = inputname.value;

    var valid = true;

    var hasLetters = /^[a-zA-Z ]*$/;

    valid = valid && hasLetters.test(name);

    if (!valid) {
        console.error("Nombre no válido");
        var error = "Solo puedes introducir espacios y letras"
    } else {
        var error = "";
    }
    inputname.setCustomValidity(error);
    return error;
}
