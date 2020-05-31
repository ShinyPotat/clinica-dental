var imported = document.createElement('script');
imported.src = '../../js/dates.js';
document.head.appendChild(imported);

function dateValidation(inputCobro, inputFactura) {

    fechaCobro = new Date(inputCobro.value);
    fechaFactura = new Date(inputFactura.value);
    var now = new Date();

    if (dates.compare(fechaFactura,now) == 1) {
        console.error("Fecha inválida");
        var error = "Fecha inválida";
    } else if (dates.compare(fechaCobro,fechaFactura)==-1) {
        console.error("Factura después de cobro");
        var error = "Factura después de cobro";
    } else {
        var error = "";
    }
    inputFactura.setCustomValidity(error);
    return error;
}

function cobroValidation(inputFecha) {
    
    var date = new Date(inputFecha.value);
    var now = new Date();

    if (dates.compare(date,now) == 1) {
        console.error("Fecha inválida");
        var error = "Fecha no válida";
    } else {
        var error = "";
    }
    inputFecha.setCustomValidity(error);
    return error;
}

function vencimientoValidation(inputFecha) {

    var date = new Date(inputFecha.value);
    var now = new Date();

    if (dates.compare(now,date) == 1) {
        console.error("Fecha inválida");
        var error = "Fecha no válida";
    } else {
        var error = "";
    }
    inputFecha.setCustomValidity(error);
    return error;
}
