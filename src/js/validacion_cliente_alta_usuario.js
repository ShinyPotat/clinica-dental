function passwordValidation(){
    var valid = true;

    var password = document.getElementById("pass");
    var pwd = password.value;

    valid = valid && pwd.length>7;

    var hasNumber = /\d/;
    var hasUpperCase = /[A-Z]/;
    var hasLowerCase = /[a-z]/;
    valid = valid && hasNumber.test(pwd) && hasUpperCase.test(pwd) && hasLowerCase.test(pwd);

    if (!valid) {
        var error = "Contraseña no válida. Mínimo 8 carácteres, 1 dígito, 1 minúscula y 1 mayúscula.";
    } else {
        var error = "";
    }
    password.setCustomValidity(error);
    return error;
}

function passwordConfirm() {
    var password = document.getElementById("pass");
    var pwd = password.value;

    var passConfirm = document.getElementById("passConf");
    var confirmation = passConfirm.value;

    if(pwd != confirmation){
        var error = "Las contraseñas no son las mismas!";
    }else{
        var error = "";
    }
    passConfirm.setCustomValidity(error);
    return error;
}

function lettersValidation(element) {

    const name = element.value;

    var valid = true;

    var hasLetters = /^[a-zA-Z ]*$/;

    valid = valid && hasLetters.test(name);

    if (!valid) {
        console.error("Nombre no válido");
        alert("Solo puedes introducir espacios y letras en " + element.name);
        return valid;
    }else{
        return valid;
    }
    
}